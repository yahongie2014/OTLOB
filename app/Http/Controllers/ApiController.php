<?php

namespace App\Http\Controllers;

use App;
use App\info;
use App\Availibility;
use Illuminate\Http\Request;
/*use LaravelPayfort\Facades\Payfort;*/
use Mail;
use Input;
use Twilio;
use Event;
use Session;
use Carbon;
use Validator;
use Hash;
use JWTAuth;
use Tymon\JWTAuth\JWTException;
use App\Http\Requests;
use App\Cart;
use App\User;
use App\Times;
use \Datetime;
use App\Area;
use App\Brand;
use App\About;
use App\Category;
use App\Town;
use App\Currency;
use App\ProductAvailibility;
use DB;
use App\Feeds;
use App\Country;
use App\Order;
use App\BankAccount;
use App\Nations;
use App\Payment;
use App\Product;
use App\ItemsOrder;
use App\Bookmark;
use App\Notification;
use Illuminate\Support\Collection;
use Exception;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite as Socialite;
use Illuminate\Auth\Events\Registered;
use Helpers;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use LaravelFCM\Message\Topics;
use App\Jobs\SendReminderEmail;
use App\ProductExeption;
use App\Promo;
/*use LaravelPayfort\Traits\PayfortResponse as PayfortResponse;*/


class ApiController extends Controller
{
    /*use PayfortResponse;*/


    public function __construct(JWTAuth $jwt, Request $request)
    {
        $this->jwt = $jwt;

        $this->lang = $request->server('HTTP_ACCEPT_LANGUAGE');
        // $this->lang = $request->server('Accept_Language');
        if(!$this->lang || $this->lang == '' || ($this->lang != 'en' && $this->lang !='ar')){
            $this->lang = 'ar';
        }
        App::setLocale($this->lang);
    }

    public function appendValue($data, $type, $element)
    {
        foreach ($data as $key => & $item) {
            $item[$element] = $type;
        }
        return $data;

    }

    public function sms()
    {
        $phone = input::get('phone');

        $sms_try = $this->SendSms("$phone",'welcome in Ratb.li' );

        return response()->json(['success' => true]);

    }


    public function currency(Request $request){
        $currency = Currency::select('currency.id as currency_id','currency_name', 'currency_code');

        if($this->lang == 'en')
            $currency = $currency->addSelect('currency_name_en as currency_name');

        $currency = $currency->orderBy('id')
            ->get();
        return response()->json(['result' => $currency, 'success' => true]);
    }

    public function Products(Request $request)
    {
        $input = $request->all();


        $device_id = $request->device_id;
        $device_type = $request->device_type;

        $city  = isset($input['city'])?$input['city']:null;
        $token = isset($input['token'])?$input['token']:null;
        $category_id = isset($input['category_id'])?$input['category_id']:null;

        // get curent user identity
        if(Input::has('token')){
            if($currentUser = JWTAuth::toUser(Input::get('token'))){
                $user_id     = $currentUser->id;
            }
            else
                $user_id = 0;
        }
        else
            $user_id = 0;

        $products = Product::with('Images')
            ->leftjoin('users', 'products.user_id', '=', 'users.id')
            ->join('user_category', function ($join) use ($user_id){
                $join->on('user_category.user_id', '=', 'products.cat_id')
                    ->on('user_category.cat_id', '=', 'products.user_id');
            })
            ->leftjoin('category', 'category.id', '=', 'user_category.user_id')
            ->leftjoin('nations', 'nations.id', '=', 'users.nation_id')
            ->leftjoin('order_items','products.id','=','order_items.product_id')
            /*->leftjoin('bookmark', function ($join) use ($user_id){
                $join->on('bookmark.product_id', '=', 'products.id')
                    ->where('bookmark.user_id', '=', $user_id);
            })*/
            ->groupBy( 'products.id','bookmark.user_id')
            ->leftjoin('feed_back', 'products.id', '=', 'feed_back.prod_id')
            ->select('products.id as product_id', 'products.id', 'products.user_id','bookmark.product_id as product_is_fav',
                'products.views as product_viewer', 'products.name as product_name', 'users.user_name as products_user',
                'order_items.product_id as product_counter',
                'feed_back.rate as products_rate', 'users.pic as products_user_pic', 'category.name as products_cat_name',
                'products.desc as product_desc', 'products.prepration_time as product_time',
                'products.requirement as product_requirement', 'products.img as product_pic', DB::raw('CONCAT(products.price, " ", nations.currency_code) AS product_price'),
                'products.created_at as product_created',
                DB::raw(" IFNULL(avg(feed_back.rate),0) AS average"),
                DB::raw(" IFNULL(avg(feed_back.rate),0) AS products_rate"),
                DB::raw(" IF(bookmark.product_id,1,0) AS product_is_fav"),
                DB::raw(" IF(bookmark.id,1,0) AS is_bookmark")
            );

        if(isset($currentUser->id)){
            $products = $products->leftjoin('bookmark', function ($join) use ($currentUser){
                $join->on('bookmark.product_id', '=', 'products.id')
                    ->where('bookmark.user_id', '=', $currentUser->id);
            });
        }
        else{
            $products = $products->leftjoin('bookmark', function ($join) use ($device_id, $device_type){
                $join->on('bookmark.product_id', '=', 'products.id')
                    ->where('bookmark.device_id', '=', $device_id)
                    ->where('bookmark.device_type', '=', $device_type);
            });    
        }

        if(isset($city) && !empty($city) && !is_null($city)){
            $products = $products->where('users.country', $city);
        }

        if(isset($category_id) && !empty($category_id) && !is_null($category_id)){
            $products = $products->where('category.id', $category_id);
            $category_search = "&category_id=" . $category_id;
        }

        if(isset($user_id) && $user_id != 0){
            $products = $products->where('users.nation_id', $currentUser->nation_id);
        }
        elseif(isset($nation_id) && $nation_id != 0){
            $products = $products->where('users.nation_id', 1);
        }

        $products = $products->where('users.verified', 1)->where('category.published',1)->where('products.status',1)->orderBy('id', 'desc')->paginate(5);

        if(empty($products))
            $temp = [];
        else{
            $temp = $products->toArray();
            $temp['next_page'] = intval($temp['current_page']) == intval($temp['last_page']) ? null : intval($temp['current_page']) + 1;
            $temp['next_page_url'] = $temp['next_page_url'] . @$category_search;
        }
            return response()->json(['result' => $temp, 'success' => true]);
    }

    public function Single_Product(Request $request)
    {
        $rules = array(
            'pro_id' => 'required|integer|exists:mysql.products,id',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => 55, 'errors' => $validator->errors()->all()])->setStatusCode(400);
        }

        $input = $request->all();

        $pro_id = e(Input::get('pro_id'));

        if ($pro_id == '') {
            return response()->json(['error' => 44,'message' => trans('api.product_is_required')])->setStatusCode(400);
        }
        if (!$pro_id && $pro_id == '') return Response::json(array())->setStatusCode(400);

        $single_post = Product::find($pro_id);

        $date = date('Y-m-d');

        if ($single_post) {
            $products_ = Product::with('Images')
                ->leftjoin('category', 'products.cat_id', '=', 'category.id')
                ->leftjoin('users', 'products.user_id', '=', 'users.id')
                ->leftjoin('bookmark', function ($join){
                    $join->on('bookmark.product_id', '=', 'products.id');
                    $join->on('bookmark.user_id', '=', 'users.id');
                })
                ->leftjoin('feed_back', 'products.id', '=', 'feed_back.prod_id')
                ->select('products.id as product_id', 'products.id', 'products.views as product_viewer',
                    'products.is_product as product_is_product',
                    'products.name as product_name', 'users.user_name as products_user',
                    'users.pic as products_user_pic',
                    'category.id as products_cat_id', 'category.name as products_cat_name',
                    'products.desc as product_desc', 'products.prepration_time as product_time',
                    'products.requirement as product_requirement',
                    'products.img as product_pic', 'products.price as product_price',
                    'products.created_at as product_created','products.gender as product_gender','products.max_num as product_number',
                    DB::raw(" IFNULL(avg(feed_back.rate),0) AS average"),DB::raw(" IFNULL((bookmark.user_id),0) AS is_bookmark") )
                ->where('products.id', $pro_id)
                ->orderBy('id', 'desc')
                ->first();
                $row = ItemsOrder::select('date')->where('product_id', '=', $pro_id)->get();

                // $periods[] = new \stdClass();
                $periods =  ['مساء', 'ظهرا', 'صباحا'];
                // $periods =  ['افطار', 'عشاء', 'سحور'];
            
                $pp['periods'] = $periods;

                $obj= new \stdClass();
                foreach ($periods as $k=> $v) {
                    $obj->{$k} = $v;
                }
                $pp_object['periods'] = $obj;
                $pp_object['count'] = 3;
                $pp['count'] = 3;

                /*$endDate = new \DateTime();
                $period = new \DatePeriod(
                    new \DateTime(),
                    new \DateInterval('P1D'),
                    $endDate->add(new \DateInterval('P30D'))
                );

                foreach ($period as $day){
                    //echo $day->format('Y-m-d') . "<br/>";
                    $periods = ItemsOrder::select('time',DB::raw('sum(amount) as itemtotal'))->where('product_id', '=', $pro_id)->where('date', '=', $day->format('Y-m-d'))->groupBy('time')->get();


                }
                dd($period);*/
                for ($i=0; $i <= 30; $i++) { 
                    $tomorrow = date('Y-m-d',strtotime($date . "+".$i." days"));
                    $tomorrow_m = date('M',strtotime($date . "+".$i." days"));
                    $tomorrow_no = date('m',strtotime($date . "+".$i." days"));
                    $tomorrow_d = date('d',strtotime($date . "+".$i." days"));
                    $tomorrow_D = date('l',strtotime($date . "+".$i." days"));
                    $dates[] = array('status' => true, 'date' => $tomorrow, 'month' => $tomorrow_m, 'month_no' => $tomorrow_no, 
                        'day' => $tomorrow_d, 'day_name' => $tomorrow_D, 'period' =>  $pp_object);
                }
                foreach ($row as $key => $value) {
                    foreach ($dates as $k => $date) {
                        if($value['date'] == $date['date']){
                            // $basic_periods = $pp['periods'];
                            $periods = ItemsOrder::select('time')->where('product_id', '=', $pro_id)->where('date', '=', $date['date'])->get();

                            $final_period = array();
                            $period = array();
                            $count = 3;
                            foreach ($periods as $p) {
                                $final_period[] = $p->time;
                                $count--;
                            }

                            $period['periods'] = (object) array_diff($pp['periods'], $final_period);
                            $period['count'] = $count;
                            
                            $dates[$k] = array(
                                        'status' => ($count == 0)?false:true, 
                                        'date' => $date['date'], 
                                        'month' =>  date('M',strtotime($date['date'])), 
                                        'day' => date('d',strtotime($date['date'])),
                                        'day_name' => date('l',strtotime($date['date'])),
                                        'period' => $period);
                            
                            unset($final_period);
                            unset($period);
                            
                            break;
                        }
                    }
                }
        }else{
            return response()->json(['error' => 45,'message' => trans('api.product_not_found')])->setStatusCode(400);
        }
        $count = Product::find($single_post->id);
        $count->views = $single_post->views + 1;
        $count->save();


        return response()->json(['result' => $products_, 'dates' => $dates, 'success' => true]);

    }

    public function Single_ProductEX(Request $request)
    {
        $rules = array(
            'pro_id' => 'required|integer|exists:mysql.products,id',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $errores = $validator->errors();
            $error_string = '';
            foreach ($errores->messages() as $key=>$value){
                $error_string .= $value[0];
            }
            return response()->json(['error' => 55, 'message' => $error_string])->setStatusCode(400);
        }
        //        if ($validator->fails()) {
        //            return response()->json(['error' => 55, 'message' => $validator->errors()->all()])->setStatusCode(400);
        //        }

        $input = $request->all();

        $pro_id = e(Input::get('pro_id'));

        if ($pro_id == '') {
            return response()->json(['error' => 44,'message' => trans('api.product_is_required')])->setStatusCode(400);
        }
        if (!$pro_id && $pro_id == '') return Response::json(array())->setStatusCode(400);

        $single_post = Product::find($pro_id);

        $date = date('Y-m-d');

        if ($single_post) {
            $products_ = Product::with('Images')
                ->leftjoin('category', 'products.cat_id', '=', 'category.id')
                ->leftjoin('users', 'products.user_id', '=', 'users.id')
                ->leftjoin('nations', 'nations.id', '=', 'users.nation_id')
                ->leftjoin('bookmark', function ($join){
                    $join->on('bookmark.product_id', '=', 'products.id');
                    $join->on('bookmark.user_id', '=', 'users.id');
                })
                ->leftjoin('feed_back', 'products.id', '=', 'feed_back.prod_id')
                ->select('products.id as product_id', 'products.id', 'products.views as product_viewer',
                    'products.is_product as product_is_product',
                    'products.name as product_name', 'users.user_name as products_user',
                    'users.pic as products_user_pic',
                    'category.id as products_cat_id', 'category.name as products_cat_name',
                    'products.desc as product_desc', 'products.prepration_time as product_time',
                    'products.requirement as product_requirement',
                    'products.img as product_pic', DB::raw('CONCAT(products.price, " ", nations.currency_code) AS product_price'),
                    DB::raw('products.price AS numeric_price'),DB::raw('nations.currency_code AS currency_code'),
                    'products.created_at as product_created','products.gender as product_gender','products.max_num as product_number',
                    DB::raw(" IFNULL(avg(feed_back.rate),0) AS average"),DB::raw("IFNULL((bookmark.id),0) AS is_bookmark") )
                ->where('products.id', $pro_id)

                ->first();
            $row = ItemsOrder::select('date')->where('product_id', '=', $pro_id)->orderBy('order_id')->get();

            // $periods[] = new \stdClass();
            // $periods =  ['افطار', 'عشاء', 'سحور'];
            $periods =  ['مساء', 'ظهرا', 'صباحا'];

            $pp['periods'] = $periods;

            $obj= new \stdClass();
            foreach ($periods as $k=> $v) {
                $obj->{$k} = $v;
            }
            $pp_object['periods'] = $obj;
            $pp_object['count'] = 3;
            $pp['count'] = 3;

            $endDate = new \DateTime();
            $monthDuration = new \DatePeriod(
                new \DateTime('+1 day'),
                new \DateInterval('P1D'),
                $endDate->add(new \DateInterval('P31D'))
            );

            // $dayPeriods = [1 => "افطار" , 2 => "عشاء" , 3 => "سحور"];
            $dayPeriods = [1 => "صباحا" , 2 => "ظهرا" , 3 => "مساء"];
            $genders = [
                1 => "male",
                2 => "female",
                3 => "nogeder"
            ];

            $availablePeriodes = ProductAvailibility::where("product_id",$pro_id)->get();

            $availablePeriodesProduct = [];
            foreach ($availablePeriodes as $v){
                $availablePeriodesProduct[$v->day_no]['quantity'][$v->period][$genders[$v->gender]] = $v->quantity;

                if(isset($availablePeriodesProduct[$v->day_no]['status']))
                    $availablePeriodesProduct[$v->day_no]['status'] += $v->quantity;
                else
                    $availablePeriodesProduct[$v->day_no]['status'] = $v->quantity;
            }

            $empty_periodes = [
                1 => [
                    "male" => 0,
                    "female" => 0,
                    "nogeder" => 0
                ],
                2 => [
                    "male" => 0,
                    "female" => 0,
                    "nogeder" => 0
                ],
                3 => [
                    "male" => 0,
                    "female" => 0,
                    "nogeder" => 0
                ]
            ];
            $exception_date = ProductExeption::where('product_id' , $pro_id)->pluck('date')->toArray();
            //dd($exception_date);
            if(count($availablePeriodesProduct) == 0){
                $dates = [];
            }else{
                foreach ($monthDuration as $day){
                    //echo $day->format('Y-m-d') . "<br/>";
                    $oldOrders = ItemsOrder::select('time','gender',DB::raw('sum(amount) as itemtotal'))->where('product_id', '=', $pro_id)->where('date', '=', $day->format('Y-m-d'))->groupBy('time','gender')->get();
                    $selectedDateAvailability = [
                        'status' => false,
                        'date' => $day->format('Y-m-d'),
                        'month' =>  $day->format('M'),
                        'day' => $day->format('d'),
                        'day_name' => $day->format('l'),
                        'period' => $availablePeriodesProduct[$day->format('w')]['quantity'],
                        'count' => $availablePeriodesProduct[$day->format('w')]['status']
                    ];
                    //dd($availablePeriodesProduct);

                    if(in_array($day->format('Y-m-d'), $exception_date)){
                        $selectedDateAvailability['count'] = 0;
                        $selectedDateAvailability['period'] = $empty_periodes;
                    }else{
                        if(count($oldOrders) > 0) {
                            //dd($oldOrders->toArray());
                            //                        if($day->format('Y-m-d') == "2018-01-06")
                            //                        dd($oldOrders->toArray());
                            foreach ($oldOrders as $k => $v) {
                                //                        dd($day->format('w'));
                                $checkOldOrders = $selectedDateAvailability['period'][array_search($v->time, $dayPeriods)][$v->gender] - $v->itemtotal;
                                //$selectedDateAvailability['period'][array_search($v->time, $dayPeriods)][$v->gender] = $checkOldOrders >= 0 ? $checkOldOrders : 0 ;
                                if($checkOldOrders >= 0){
                                    $selectedDateAvailability['period'][array_search($v->time, $dayPeriods)][$v->gender] = $checkOldOrders ;
                                }else{
                                    $selectedDateAvailability['period'][array_search($v->time, $dayPeriods)][$v->gender] = 0 ;
                                }
                                $selectedDateAvailability['count'] -= $v->itemtotal;

                            }
                        }

                        if($selectedDateAvailability['count'] > 0 )
                            $selectedDateAvailability['status'] = true;

                    }

                    $dates[] = $selectedDateAvailability;
                }

            }
        //dd($availablePeriodesProduct);

        }else {
            return response()->json(['error' => 45,'message' => trans('api.product_not_found')])->setStatusCode(400);
        }
        $count = Product::find($single_post->id);
        $count->views = $single_post->views + 1;
        $count->save();


        return response()->json(['result' => $products_, 'dates' => $dates, 'success' => true]);

    }


    public function Category_products(Request $request)
    {
        $rules = array(
            'cat_id' => 'required|integer|exists:mysql.category,id',
        );

        if($request->has('provider_id')){
            $rules['provider_id'] = 'required|integer|exists:users,id';
        }

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => 55, 'errors' => $validator->errors()->all()])->setStatusCode(400);
        }

        $input = $request->all();
        $cat  = isset($input['cat_id'])?$input['cat_id']:null;
        $token = isset($input['token'])?$input['token']:null;

        // get curent user identity
        if(Input::has('token')){
            if($currentUser = JWTAuth::toUser($input['token'])){
                $user_id     = $currentUser->id;
            }
            else
                $user_id = 0;
        }
        else
            $user_id = 0;

        $products = Product::with('Images')
            ->leftjoin('users', 'products.user_id', '=', 'users.id')
            ->join('user_category', function ($join) use ($user_id){
                $join->on('user_category.user_id', '=', 'products.cat_id')
                    ->on('user_category.cat_id', '=', 'products.user_id');
            })
            ->leftjoin('category', 'category.id', '=', 'user_category.user_id')
            ->leftjoin('nations', 'nations.id', '=', 'users.nation_id')
            ->leftjoin('bookmark', function ($join) use ($user_id){
                $join->on('bookmark.product_id', '=', 'products.id')
                    ->where('bookmark.user_id', '=', $user_id);
            })
            ->groupBy( 'products.id','bookmark.user_id' )
            ->leftjoin('feed_back', 'products.id', '=', 'feed_back.prod_id')
            ->select('products.id as product_id', 'products.id', 'products.user_id','bookmark.product_id as product_is_fav',
                'products.views as product_viewer', 'products.name as product_name', 'users.user_name as products_user',
                'feed_back.rate as products_rate', 'users.pic as products_user_pic', 'category.name as products_cat_name',
                'products.desc as product_desc', 'products.prepration_time as product_time',
                'products.requirement as product_requirement', 'products.img as product_pic', DB::raw('CONCAT(products.price, " ", nations.currency_code) AS product_price'),
                'products.created_at as product_created',
                DB::raw(" IFNULL(avg(feed_back.rate),0) AS average"),
                DB::raw(" IF(bookmark.id,1,0) AS is_bookmark")
            )
            ->where('products.cat_id', $cat)
            ->where('products.status', 1)
            ->where('category.published', 1)
            ->orderBy('products.id', 'desc');
            if(isset($user_id) && $user_id != 0){
                $products = $products->addSelect('products.gender as product_gender','products.max_num as product_number');
            }
            if(isset($user_id) && $user_id != 0){
                $products = $products->where('users.nation_id', $currentUser->nation_id);
            }
            if($request->has('provider_id')){
                $products = $products->where('users.id', $request->provider_id);
            }
            $products = $products->where('users.verified', 1)->paginate(5);
            $temp = $products->toArray();
            $temp['next_page'] = intval($temp['current_page']) == intval($temp['last_page']) ? null : intval($temp['current_page']) + 1;
            $temp['next_page_url'] = ($temp['next_page_url'])?$temp['next_page_url'] . '&cat_id='. @$cat:'';
        return response()->json(['result' => $temp, 'success' => true]);

        try {
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getCode(), 'message' => trans('api.product_not_found')])->setStatusCode(400);
        }

        return response()->json(['error' => 47,'message' => trans('api.category_not_found')])->setStatusCode(400);
    }

    public function Category_vendors(Request $request)
    {
        $input = $request->all();
        $vendor  = isset($input['user_id'])?$input['user_id']:null;
        $token = isset($input['token'])?$input['token']:null;

        $device_id = $request->device_id;
        $device_type = $request->device_type;
        // dd($device_id);

        // get curent user identity
        if($token != null ){
            $currentUser = JWTAuth::toUser($input['token']);
            $user_id     = $currentUser->id;
        }
        else
            $user_id = 0;

        if ($vendor == '') {
            return response()->json(['error' => 46,'message' => 'user id Required'])->setStatusCode(400);
        }
        if (!$vendor && $vendor == '') return Response::json(array(), 400);

        if ($vendor != null && $token != null) {
            $vendor_product = Product::with('Images')
                ->leftjoin('category', 'products.cat_id', '=', 'category.id')
                ->leftjoin('users', 'products.user_id', '=', 'users.id')
                ->leftjoin('nations', 'nations.id', '=', 'users.nation_id')
                ->groupBy( 'products.id','bookmark.user_id' )
                ->leftjoin('feed_back', 'products.id', '=', 'feed_back.prod_id')
                ->select('products.id as product_id', 'products.id', 'bookmark.user_id','bookmark.product_id as product_is_fav',
                    'products.views as product_viewer', 'products.name as product_name', 'users.user_name as products_user',
                    'feed_back.rate as products_rate', 'users.pic as products_user_pic', 'category.name as products_cat_name',
                    'products.desc as product_desc', 'products.prepration_time as product_time',
                    'products.requirement as product_requirement', 'products.img as product_pic',
                    'products.created_at as product_created','products.gender as product_gender','products.max_num as product_number',
                    DB::raw(" IFNULL(avg(feed_back.rate),0) AS average"),
                    DB::raw(" IF(bookmark.id,1,0) AS is_bookmark"),
                    DB::raw('CONCAT(products.price, " ", nations.currency_code) AS product_price')
                )
                ->where('products.user_id', $vendor)
                ->where('category.published', 1)
                ->orderBy('id', 'desc');
                if(isset($currentUser->id)){
                    $vendor_product = $vendor_product->leftjoin('bookmark', function ($join) use ($user_id){
                        $join->on('bookmark.product_id', '=', 'products.id')
                            ->where('bookmark.user_id', '=', $user_id);
                    });
                }
                else{
                    $vendor_product = $vendor_product->leftjoin('bookmark', function ($join) use ($device_id, $device_type){
                        $join->on('bookmark.product_id', '=', 'products.id')
                            ->where('bookmark.device_id', '=', $device_id)
                            ->where('bookmark.device_type', '=', $device_type);
                    });
                }
                $vendor_product = $vendor_product->get();
            return response()->json(['result' => $vendor_product, 'success' => true]);

            try {
            } catch (Exception $exception) {
                return response()->json(['error' => $exception->getCode(), 'message' => 'product not found'])->setStatusCode(400);
            }
        }else{
            $vendor_product_untoken = Product::with('Images')
                ->leftjoin('category', 'products.cat_id', '=', 'category.id')
                ->leftjoin('users', 'products.user_id', '=', 'users.id')
                ->groupBy( 'products.id' )
                ->leftjoin('feed_back', 'products.id', '=', 'feed_back.prod_id')
                ->select('products.id as product_id', 'products.id', 'products.user_id','bookmark.product_id as product_is_fav',
                    'products.views as product_viewer', 'products.name as product_name', 'users.user_name as products_user',
                    'feed_back.rate as products_rate', 'users.pic as products_user_pic', 'category.name as products_cat_name',
                    'products.desc as product_desc', 'products.prepration_time as product_time',
                    'products.requirement as product_requirement', 'products.img as product_pic', 'products.price as product_price',
                    'products.created_at as product_created',
                    DB::raw(" IFNULL(avg(feed_back.rate),0) AS average"),
                    DB::raw(" IF(bookmark.id,1,0) AS is_bookmark")
                )
                ->where('products.user_id', $vendor)
                ->orderBy('id', 'desc');
                if(isset($currentUser->id)){
                    $vendor_product_untoken = $vendor_product_untoken->leftjoin('bookmark', function ($join) use ($user_id){
                        $join->on('bookmark.product_id', '=', 'products.id')
                            ->where('bookmark.user_id', '=', $user_id);
                    });
                }
                else{
                    $vendor_product_untoken = $vendor_product_untoken->leftjoin('bookmark', function ($join) use ($device_id, $device_type){
                        $join->on('bookmark.product_id', '=', 'products.id')
                            ->where('bookmark.device_id', '=', $device_id)
                            ->where('bookmark.device_type', '=', $device_type);
                    });
                }
                $vendor_product_untoken = $vendor_product_untoken->get();
            return response()->json(['result' => $vendor_product_untoken, 'success' => true]);
        }
        return response()->json(['error' => 47,'message' => 'user id not found'])->setStatusCode(400);
    }

    public function Category(Request $request){
        try {
            $cat_s = Category::select('id', 'name', 'desc', 'img', 'is_offer', 'created_at', 'updated_at')->where('published', '=', 1);
            if($this->lang == 'en')
                $cat_s = $cat_s->addSelect('name_en as name', 'desc_en as desc', 'img_en as img');
            $cat_s = $cat_s->orderBy('is_offer', 'desc')->get();
            return response()->json(['result' => $cat_s]);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getCode(), 'message' => 'category not found'])->setStatusCode(400);
        }
    }

    public function Areas(Request $request){
        try {
            $areas = Area::select('*')
                ->leftjoin('currency','currency.id','=','area.currency_id')
                ->where('area.lang', '=', $this->lang)
                ->select('area.id as id','area.name as name','currency.currency_name as area_currency_name','currency.id as currency_id','currency.currency_code as area_currency_code')
                ->get();
            return response()->json(['result' => $areas]);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getCode(), 'message' => 'Area not found'])->setStatusCode(400);
        }
    }

    public function is_admin(Request $request){
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);

        $admin = User::Select('*')
            ->where('users.id',$currentUser->id)
            ->update([
                'is_admin' => 1,
                'is_vendor' => 0
            ]);

        if ($currentUser) {
            return response()->json(['result' => $admin, 'success' => true]);
        } else {
            return response()->json([
                'message' => 'Parramters ivalid!'
            ], 500);
        }
    }

    public function Rate_product(Request $request)
    {
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);
        try {
            $rate = Feeds::select('*')
                ->leftjoin('users', 'feed_back.user_id', '=', 'users.id')
                ->leftjoin('products', 'feed_back.prod_id', '=', 'products.id')
                ->select('feed_back.id as feed_id', 'feed_back.notes_product as feed_notes', 'users.user_name as feed_user', 'products.is_package as feed_type_pack', 'products.is_product as feed_type_prod', 'products.name as feed_name_pro', 'feed_back.rate as feed_rate', 'feed_back.created_at as feed_time')
                ->where('feed_back.user_id', $currentUser->id)
                ->get();
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getCode(), 'message' => 'No Rate found'])->setStatusCode(400);
        }


        return response()->json(['result' => $rate,'success' => true]);
    }

    public function bookmark_all(Request $request)
    {
        $input = $request->all();
        if(isset($input['token']) && $input['token'] != '')
            $currentUser = JWTAuth::toUser($input['token']);
        $device_id = $request->device_id;
        $device_type = $request->device_type;
        $wish = e(Input::get('cat_id'));

        if ($wish) {
            if ($wish == '') {
                return response()->json(['error' => 48, 'message' => 'category id required']);
            }
            if (!$wish && $wish == '') return Response::json(array())->setStatusCode(400);

            $whish_cat = Bookmark::select('product_id')
                ->leftjoin('products', 'products.id', '=', 'bookmark.product_id')
                ->leftjoin('category', 'products.cat_id', '=', 'category.id')
                ->leftjoin('users', 'bookmark.user_id', '=', 'users.id')
                ->leftjoin('feed_back', 'products.id', '=', 'feed_back.prod_id')
                ->groupBy( 'bookmark.product_id')
                ->select('bookmark.id as bookmark_id', 'products.name as bookmark_name_products',
                    'products.img as bookmark_img','products.id as bookmark_product_id',
                    'category.id as products_cat_id', 'category.name as products_cat_name',
                    'products.is_product as bookmark_type_prod', 'users.user_name as bookmark_user',
                    'bookmark.created_at as bookmark_time',DB::raw(" IFNULL(avg(feed_back.rate),0) AS products_rate"))
                ->where('products.cat_id', $wish);
            if(isset($currentUser->id))
                $whish_cat = $whish_cat->where('bookmark.user_id', $currentUser->id);
            else{
                $whish_cat = $whish_cat->where('bookmark.device_id', $device_id);
                $whish_cat = $whish_cat->where('bookmark.device_type', $device_type);
            }
            $whish_cat = $whish_cat->get();
            return response()->json(['result' => $whish_cat, 'success' => true]);

        }

        try {
            $bookmark_product = Bookmark::select('*')
                ->leftjoin('users', 'bookmark.user_id', '=', 'users.id')
                ->leftjoin('products', 'bookmark.product_id', '=', 'products.id')
                ->leftjoin('category', 'products.cat_id', '=', 'category.id')
                ->leftjoin('feed_back', 'products.id', '=', 'feed_back.prod_id')
                ->groupBy( 'bookmark.product_id')
                ->select('bookmark.id as bookmark_id', 'products.name as bookmark_name_products',
                    'products.img as bookmark_img','products.id as bookmark_product_id',
                    'category.id as products_cat_id', 'category.name as products_cat_name',
                    'products.is_product as bookmark_type_prod', 'users.user_name as bookmark_user',
                    'bookmark.created_at as bookmark_time',DB::raw(" IFNULL(avg(feed_back.rate),0) AS products_rate"));
            if(isset($currentUser->id))    
                $bookmark_product = $bookmark_product->where('bookmark.user_id', $currentUser->id);
            else{
                $bookmark_product = $bookmark_product->where('bookmark.device_id', $device_id);
                $bookmark_product = $bookmark_product->where('bookmark.device_type', $device_type);
            }
                $bookmark_product = $bookmark_product->get();
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getCode(), 'message' => 'nothing is added'])->setStatusCode(400);
        }


        return response()->json(['result' => $bookmark_product, 'success' => true]);
    }

    public function Payment(Request $request)
    {
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);
        $payment = Payment::select('*')
            ->leftjoin('users', 'payment.user_id', '=', 'users.id')
            ->select('payment.user_id as pay_user_id', 'payment.type as pay_type', 'users.user_name as pay_user', 'payment.num_card as pay_card', 'payment.token as pay_token', 'payment.merchant_id as pay_merchant', 'payment.created_at as pay_time')
            ->where('payment.user_id', $currentUser->id)
            ->get();
        return response()->json(['result' => $payment,'success' => true]);
    }

    public function Users()
    {
        $users = User::select('*')->get();

        return response()->json([$users]);
    }

    public function get_user_info(Request $request)
    {
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);

        return response()->json([$currentUser]);
    }

    public function register(Request $request)
    {
        $input = $request->only('phone', 'password','nation_id');
        $login = $request->only('phone', 'password','nation_id');
        $Zip = '+';
        $input['v_code'] = rand(1000, 9999);
        $input['password'] = Hash::make($input['password']);

        $rules = array(
            'phone' => 'required|min:9|unique:mysql.users',
            'password' => 'required|min:1|max:9',
            'nation_id' => 'required|exists:nations,id'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $errores = $validator->errors();
            $error_string = '';
            foreach ($errores->messages() as $key=>$value){
                $error_string .= $value[0];
            }
        }

        if ($validator->fails()) {
            // return response()->json(['error' => 49, 'message' => trans('api.wrong_mobile_number')])->setStatusCode(400);
            return response()->json(['error' => 49, 'message' => $error_string])->setStatusCode(400);
        }

        try {
            DB::beginTransaction();
            $Create = User::create($input);
            // $send = Twilio::message($input['phone'], trans('api.welcome_sms', ['code' => $input['v_code']]));
            $send = $this->SendSms($input['phone'],'Welcome to Rtb.li, your verification code ' . $input['v_code'] );

            DB::commit();
            $message = 'Successfuly Registerd ' . $input['phone'];
            return [
                'result' => $Create,
                'message' => $message
            ];
            if (!$send)
                return response()->json(['error' => 100, 'message' => trans('api.your_verify_cannot_send')])->setStatusCode(400);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['error' => $exception->getCode(), 'message' => $exception->getMessage()])->setStatusCode(400);
            // return response()->json(['error' => $exception->getCode(), 'message' => trans('api.phone_already_registerd')])->setStatusCode(400);
        }


        if (!$token = JWTAuth::attempt($login)) {
            return response()->json(['error' => 50,'message' => trans('api.wrong_phone_or_password')])->setStatusCode(400);
        }
        if (JWTAuth::setToken($token)) {
            return [
                'result' => $Create,
                'message' => $message
            ];
        } else {
            return response()->json(['error' => 51,'message' => 'Token could not be set!'])->setStatusCode(400);
        }
    }

    public function login(Request $request)
    {
        //dd($request->all());
        $rules = array(
            'phone' => 'required|min:10|exists:mysql.users,phone',
            'password' => 'required'
        );
        $input = $request->only('phone', 'password');
        $device_id = $request->device_id;
        $device_type = $request->device_type;
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            $errores = $validator->errors();
            $error_string = '';
            foreach ($errores->messages() as $key=>$value){
                $error_string .= $value[0];
            }
        }
        if ($validator->fails()) {
            // return response()->json(['error' => 51, 'message' => 'phone field is required and password'])->setStatusCode(400);
            return response()->json(['error' => 51, 'message' => $error_string])->setStatusCode(400);
        }

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json(['error' => 52, 'message' => trans('api.wrong_phone_or_password')])->setStatusCode(400);
        }
        $activation = User::where('verified', '=', 1);
        if (Auth::user()->verified == 1) {
            $user_prof = JWTAuth::toUser($token);
            $userss = User::select('*')
                ->leftjoin('country','country.id','=','users.country')
                ->leftjoin('area','area.id','=','country.area_id')
                ->leftjoin('currency','currency.id','=','users.currency_id')
                ->select('country.country as profile_country_name','area.name as profile_area_name',
                    'area.id as profile_area_name_id','currency.currency_name as profile_currency_name',
                    'currency.id as profile_currency_id','currency.currency_code as profile_currency_code',
                    DB::raw(" IFNULL(country.country,0) AS profile_country_name"),
                    DB::raw(" IFNULL(area.name,0) AS profile_area_name"),
                    DB::raw(" IFNULL(area.id,0) AS profile_area_name_id"),
                    DB::raw(" IFNULL(currency.currency_name,0) AS profile_currency_name"),
                    DB::raw(" IFNULL(currency.id,0) AS profile_currency_id"),
                    DB::raw(" IFNULL(currency.currency_code,0) AS profile_currency_code")
                )
                ->where('users.id',$user_prof->id)
                ->first();
                $nation_data = Nations::find($user_prof->nation_id);
                $data = ['user_id' => $user_prof->id, 'device_id' => null, 'device_type' => null];
                Cart::where('device_id', $device_id)->where('device_type', $device_type)->update($data);
                Bookmark::where('device_id', $device_id)->where('device_type', $device_type)->update($data);
            return [
                'token' => $token,
                'profile_id' => $user_prof->id,
                'profile_name' => $user_prof->user_name,
                'profile_pic' => $user_prof->pic,
                'profile_country_id' => $user_prof->country,
                'profile_country_name' => $userss->profile_country_name,
                'profile_country_area_id' => $userss->profile_area_name_id,
                'profile_country_area' => $userss->profile_area_name,
                'profile_currency_id' => $userss->profile_currency_id,
                'profile_currency_name' => $userss->profile_currency_name,
                'profile_currency_code' => $userss->profile_currency_code,
                'nation' => $nation_data,
                'message' => 'Token created!'
            ];
        } else {
            return response()->json(['error' => 101,'message' => 'you are not activaited'])->setStatusCode(404);

        }

        if (JWTAuth::setToken($token)) {

            return [
                'token' => $token,
                'message' => 'Token created!'
            ];

        } else {
            return ['error' => 'Token could not be set!'];
        }

        return response()->json(['result' => $token, 'success' => true]);
    }


    public function login_vendor(Request $request)
    {
        $rules = array(
            'email' => 'required|exists:mysql.users,email',
            'password' => 'required'
        );
        $input = $request->only('email', 'password');
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => 126, 'message' => trans('api.check_email_password')])->setStatusCode(400);
        }

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json(['error' => 130,'message' => trans('api.wrong_email_or_password')])->setStatusCode(400);
        }
        $vendor = User::where('is_vendor', '=', 1);
        if (Auth::user()->is_vendor == 1) {
            $user_prof = JWTAuth::toUser($token);
            $userss = User::select('*')
                ->leftjoin('country','country.id','=','users.country')
                ->leftjoin('area','area.id','=','country.area_id')
                ->leftjoin('currency','currency.id','=','users.currency_id')
                ->select('country.country as profile_country_name','area.name as profile_area_name',
                    'area.id as profile_area_name_id','currency.currency_name as profile_currency_name',
                    'currency.id as profile_currency_id','currency.currency_code as profile_currency_code',
                    DB::raw(" IFNULL(country.country,0) AS profile_country_name"),
                    DB::raw(" IFNULL(area.name,0) AS profile_area_name"),
                    DB::raw(" IFNULL(area.id,0) AS profile_area_name_id"),
                    DB::raw(" IFNULL(currency.currency_name,0) AS profile_currency_name"),
                    DB::raw(" IFNULL(currency.id,0) AS profile_currency_id"),
                    DB::raw(" IFNULL(currency.currency_code,0) AS profile_currency_code")
                )
                ->where('users.id',$user_prof->id)
                ->get();
            return [
                'token' => $token,
                'profile_id' => $user_prof->id,
                'profile_name' => $user_prof->user_name,
                'profile_pic' => $user_prof->pic,
                'profile_country_id' => $user_prof->country,
                'profile_country_name' => $userss[0]->profile_country_name,
                'profile_country_area_id' => $userss[0]->profile_area_name_id,
                'profile_country_area' => $userss[0]->profile_area_name,
                'profile_currency_id' => $userss[0]->profile_currency_id,
                'profile_currency_name' => $userss[0]->profile_currency_name,
                'profile_currency_code' => $userss[0]->profile_currency_code,
                'message' => 'Token created!'
            ];
        } else {
            return ['error' => 120 ,'message' => 'you are not activaited as vendor'];
        }

        if (JWTAuth::setToken($token)) {
            return [
                'token' => $token,
                'message' => 'Token created!'
            ];

        } else {
            return ['error' => 'Token could not be set!'];
        }

        return response()->json(['result' => $token, 'success' => true]);
    }


    public function city_identify(Request $request){
        $input = $request->all();
        $city = e(Input::get('id'));

        if ($city == null) {
            return response()->json(['error' => 58,'message' =>'no country id found'])->setStatusCode(400);
        }
        if (!$city && $city == '') return Response::json(array(), 400);

        $area_c = Country::select('id','country')
            ->where('id' ,$city)
            ->get();

        return response()->json(['result' => $area_c, 'success' => true]);
    }

    public function resend(Request $request){

        $input = $request->all();

        $query = Input::get('phone');
        if ($query == null) {
            return response()->json(['error' => 'no phone found'])->setStatusCode(400);
        }
        if (!$query && $query == '') return Response::json(array(), 400);

        $user = User::where('phone', '=',  $query )->first();
        //dd($user);
        $send = $this->SendSms($query, 'Welcome to Rtb.li, your verification code ' . ' : ' . $user->v_code . '' . ' ' . 'Use this to complete your registration');


        return response()->json(['result' => 'Succefuly Resend','success' => true]);
    }

    public function reset(Request $request){

        $input = $request->all();


        $query = e(Input::get('phone'));
        if ($query == null) {
            return response()->json(['error' => 'no phone found'])->setStatusCode(400);
        }
        if (!$query && $query == '')
            return response()->json(['error' => 300,'message' =>'check your phone number please'])->setStatusCode(400);

        //$pass_reset = rand(1000, 9999);
        $pass_reset = rand(100000,999999);//(6);

        $regenerate = Hash::make($pass_reset);

        $user = User::select('*')
            ->where('phone', '=', $query )
            ->update(['password'=> $regenerate]);
        
        if(!$user){
            return response()->json(['error' => 300,'message' =>'check your phone number please'])->setStatusCode(400);

        }

        $send = $this->SendSms("$query", 'Welcome to Rtb.li, your new Password is ' . ' : ' . $pass_reset . '' . ' ' . 'Use this to complete your Login');



        return response()->json(['result' => 'Succefuly Resend','success' => true]);
    }



    public function confirm(Request $request){
        $input = $request->only('phone', 'v_code', 'password');
        $rules = array(
            'phone' => 'required|min:10',
            'v_code' => 'required|max:4',
        );

        $device_id = $request->device_id;
        $device_type= $request->device_type;

        $validator = Validator::make(Input::all(), $rules);

        /*if ($validator->fails()) {
            return response()->json(['error' => 53, 'message' => 'your phone is wrong'])->setStatusCode(400);
        }*/

        if ($validator->fails()) {
            $errores = $validator->errors();
            $error_string = '';
            foreach ($errores->messages() as $key=>$value){
                $error_string .= $value[0];
            }
            return response()->json(['error' => 67, 'message' => $error_string])->setStatusCode(400);
        }

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json(['error' => 54,'message'=> 'wrong verify code'])->setStatusCode(400);
        }
        if (JWTAuth::setToken($token)) {
            $currentUser = JWTAuth::toUser($token);
            $active = User::find($currentUser->id);
            $active->verified = 1;
            $active->save();

            $data = ['user_id' => $currentUser->id, 'device_id' => null, 'device_type' => null];
            Cart::where('device_id', $device_id)->where('device_type', $device_type)->update($data);
            Bookmark::where('device_id', $device_id)->where('device_type', $device_type)->update($data);

            return [
                'token' => $token,
                'message' => 'You Are Activaited!'
            ];
        } else {
            return ['error' => 'Wrong Activation code!'];
        }

        return response()->json(['result' => $token,'success' => true]);
    }

    protected function profile(Request $request)
    {
        $input = $request->all();

        $user = JWTAuth::toUser($input['token']);

        if($user){
            if (strpos($user->pic, '/assets/images/big/placeholder-300x300.png') == false) {
                if(strpos($user->pic, 'Profile') == false) {
                    $user->pic = "https://ratb.li/Profile/" . $user->pic;
                }
            }
        }
        return response()->json(['result' => $user,'success' => true]);

    }

    public function logout(Request $request)
    {
        $input = $request->all();
        // $currentUser = JWTAuth::invalidate($request->input('token'));

        return response()->json([
            'message' => 'User logged off successfully!'
        ], 200);
    }

    public function Brand_store(Request $request)
    {
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);

        try {
            $brand = new Brand();
            $brand->name = $request->get('name');
            $brand->img = $request->get('img');
            $brand->desc = $request->get('desc');
            $brand->address = $request->get('address');
            $brand->area_id = $request->get('area_id');
            $brand->save();
        } catch (Exception $exception) {
            return response()->json(['Error Code' => $exception->getCode(), 'Message' => 'Field cannot be null']);
        }

        if ($currentUser) {
            return response()->json(['result' => $brand]);
        } else {
            return response()->json([
                'message' => 'Parramters ivalid!'
            ], 500);
        }
    }

    public function Product_store(Request $request)
    {
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);
        $product = new Product();
        $product->name = $request->get('name');
        if (Input::hasfile('img')) {
            $extension = Input::file('img')->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . '.' . $extension;
            $destinationPath = 'Product/';
            $url = asset('');
            $pic = input::file('img')->move($destinationPath, $fileName);
            $product->img = $url . $pic;
        }
        $product->desc = $request->get('desc');
        $product->price = $request->get('price');
        $product->is_product = $request->get('is_product');
        $product->prepration_time = $request->get('prepration_time');
        $product->requirement = $request->get('requirement');
        $product->cat_id = $request->get('cat_id');
        $product->user_id = $currentUser->id;
        $product->save();
        if ($currentUser) {
            return response()->json(['result' => $product,'success' => true]);
        } else {
            return response()->json([
                'message' => 'Parramters ivalid!'
            ], 500);
        }
    }

    public function Category_store(Request $request)
    {
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);
        try {
            $cat_e = new Category();
            $cat_e->name = $request->get('name');
            $cat_e->img = $request->get('img');
            $cat_e->desc = $request->get('desc');
            $cat_e->save();
        } catch (Exception $exception) {
            return response()->json(['Error Code' => $exception->getCode(), 'Message' => 'Field cannot be null'])->setStatusCode(400);
        }
        if ($currentUser) {
            return response()->json(['result' => $cat_e]);
        } else {
            return response()->json([
                'message' => 'Parramters ivalid!'
            ], 500);
        }
    }

    public function Feed_product(Request $request)
    {
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);
        $rules = array(
            'rate' => 'required|integer|between:1,5',
            'prod_id' => 'required|integer|exists:mysql.products,id',
            'order_id' => 'required|integer|exists:order_product,order_id'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => 55, 'message' => 'your rate is wrong number', 'errors' => $validator->errors()->all()])->setStatusCode(400);
        }
        $pro_id = Product::select('*')->where('id' == 'prod_id');

        try {

            $feed = Feeds::where('user_id' , $currentUser->id)
                ->where('prod_id',$request->get('prod_id'))
                ->where('order_id',$request->get('order_id'))->first();

            if(!$feed){
                $feed = new Feeds();
                $feed->prod_id = $request->get('prod_id');
                $feed->user_id = $currentUser->id;
                $feed->order_id = $request->get('order_id');
            }

            $feed->rate = $request->get('rate');

            if (Input::has('notes_product')) {
                $feed->notes_product = $request->get('notes_product');
            }

            $feed->save();
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getCode(), 'message' => 'product not found'])->setStatusCode(400);
        }

        if ($currentUser) {
            return response()->json(['result' => $feed]);
        } else {
            return response()->json([
                'message' => 'Parramters ivalid!'
            ], 500);
        }
    }

    public function bookmark_product(Request $request){
        $rules = array(
            'product_id' => 'required|integer|exists:mysql.products,id',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => 55, 'errors' => $validator->errors()->all()])->setStatusCode(400);
        }


        $input = $request->all();
        if($input['token'] && $input['token'] != ''){
            $currentUser = JWTAuth::toUser($input['token']);
        }
        $device_id = $request->device_id;
        $device_type= $request->device_type;
        $e_book = input::get('product_id');


        $validate = Bookmark::where('product_id', '=', $e_book);
        if(isset($currentUser->id))
            $validate = $validate->where('user_id', '=', $currentUser->id);
        else{
            $validate = $validate->where('device_id', '=', $device_id)->where('device_type', '=', $device_type);
        }
        $validate = $validate->count();
        if ($validate) {

            return response()->json(['error' => 56, 'message' => trans('api.product_already_in_your_bookmark')])->setStatusCode(404);
        }

        try {
            // DB::enableQueryLog();
            $book = new Bookmark();
            $book->product_id = $request->product_id;
            $book->user_id = isset($currentUser->id)?$currentUser->id:null;
            $book->device_id = !isset($currentUser->id)?$device_id:null;
            $book->device_type = !isset($currentUser->id)?$device_type:null;
            $book->save();


            // dd(
            //     DB::getQueryLog()
            // );
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getCode(), 'message' => 'product id empty'])->setStatusCode(400);
        }
        if (isset($currentUser->id) || ($device_id && $device_type)) {
            return response()->json(['result' => $book]);
        } else {
            return response()->json([
                'message' => 'Parramters ivalid!'
            ], 500);
        }
    }

    public function Payment_store(Request $request)
    {
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);
        try {
            $payments = new Payment();
            $payments->type = $request->get('type');
            $payments->merchant_id = $request->get('merchant_id');
            $payments->num_card = $request->get('num_card');
            $payments->user_id = $currentUser->id;
            $payments->save();
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getCode(), 'message' => 'Field cannot be null'])->setStatusCode(400);
        }
        if ($currentUser) {
            return response()->json(['result' => $payments]);
        } else {
            return response()->json([
                'message' => 'Parramters ivalid!'
            ], 500);
        }
    }

    public function Area_store(Request $request)
    {
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);
        try {
            $area = new Area();
            $area->name = $request->get('name');
            $area->save();
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getCode(), 'message' => 'Field cannot be null'])->setStatusCode(400);
        }
        if ($currentUser) {
            return response()->json(['result' => $area ,'success' => true]);
        } else {
            return response()->json([
                'message' => 'Parramters ivalid!'
            ], 500);
        }
    }

    public function Profile_edit(Request $request)
    {
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);
        $rules = array(
            'email' => 'email|unique:mysql.users,email,'.$currentUser->id.',id',
        );

        /*
        // $is_numeric =  preg_match('/^([0-9]*)$/',$phone);
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $errores = $validator->errors();
            $error_string = '';
            foreach ($errores->messages() as $key=>$value){
                $error_string .= $value[0];
            }
            return response()->json(['error' => 67, 'message' => $error_string])->setStatusCode(400);
        }*/

        try {
            $profile = User::find($currentUser->id);
            if (Input::has('user_name')) {
                $profile->user_name = input::get('user_name');
            }
            if (Input::has(('email'))) {
                $profile->email = input::get('email');
            }

            if (Input::has('phone')) {
                $profile->phone = input::get('phone');
            }

            if (Input::has('password')) {
                $profile->password = Hash::make(input::get('password'));
            }
            if (Input::hasfile('pic')) {
                $extension = Input::file('pic')->getClientOriginalExtension();
                $fileName = rand(11111, 99999) . '.' . $extension;
                $destinationPath = 'Profile/';
                $url = asset('');
                $pic = input::file('pic')->move($destinationPath, $fileName);
                $profile->pic = $url . $pic;
            }elseif (Input::has('pic') == true){

                $decoded_image = base64_decode(Input::get('pic'));
                $info = getimagesizefromstring($decoded_image);

                $extention = substr($info['mime'], 6);
                if(empty($extention))
                    $extention = 'jpeg';

                $fileName      = substr(md5(mt_rand()), 0, 7).'.'.$extention;

                file_put_contents('Profile/'.$fileName, $decoded_image);
                $profile->pic = $fileName;
            }


            if (Input::has('address')) {
                $profile->address = input::get('address');
            }
            if (Input::has('country')) {
                $profile->country = input::get('country');
            }
            if (Input::has('currency_id')) {
                $profile->currency_id = input::get('currency_id');
            }
            if (Input::has('nation_id')) {
                $profile->nation_id = input::get('nation_id');
            }
            $profile->save();

        }
        catch (Exception $exception) {
            return response()->json(['error' => $exception->getCode(), 'message' => $exception->getMessage()])->setStatusCode(400);
        }

        if ($currentUser) {
            return response()->json(['result' => $profile, 'message' => trans('api.user_updated_successfully'), 'success' => true]);
        } else {
            return response()->json([
                'message' => 'Parramters ivalid!'
            ], 500);
        }
    }


    public function Profile_edit_ios(Request $request)
    {
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);

        if(empty($currentUser))
            return response()->json(['error' =>404, 'message' => ' undefinded user '  ])->setStatusCode(404);

        try {
            $profile = User::find($currentUser->id);
            if (Input::has('user_name')) {
                $profile->user_name = input::get('user_name');
            }
            if (Input::has('email')) {
                $profile->email = input::get('email');
            }
            if (Input::has('phone')) {
                $profile->phone = input::get('phone');
            }
            if (Input::has('password')) {
                $profile->password = Hash::make(input::get('password'));
            }
            if (Input::hasfile('pic')) {
                $extension = Input::file('pic')->getClientOriginalExtension();
                $fileName = substr(md5(mt_rand()), 0, 7) . '.' . $extension;
                $destinationPath = 'Profile/';
                $url = asset('');
                $pic = input::file('pic')->move($destinationPath, $fileName);
                $profile->pic = $url.$pic;
            }
            // upload base64 image
            if(Input::hasfile('pic') == false && Input::has('pic') == true){

                $decoded_image = base64_decode(Input::get('pic'));
                $image_info    = finfo_open();
                $mime_type     = finfo_buffer($image_info, $decoded_image, FILEINFO_MIME_TYPE);
                $extention     = substr($mime_type , 6);
                $fileName      = substr(md5(mt_rand()), 0, 7).'.'.$extention;

                file_put_contents('Profile/'.$fileName, $decoded_image);
                $profile->pic = $fileName;
            }

//            if (Input::has('pic')) {
//                $profile->pic = input::get('pic');
//            }
            if (Input::has('address')) {
                $profile->address = input::get('address');
            }
            if (Input::has('country')) {
                $profile->country = input::get('country');
            }
            $profile->save();
        } catch (Exception $exception) {
            dd($exception);
            return response()->json(['error' => $exception->getCode(), 'message' => $exception->getMessage() .'in line '. $exception->getLine()  ])->setStatusCode(400);
        }


        if ($currentUser) {
            return response()->json(['result' => $profile,'success' => true]);
        } else {
            return response()->json([
                'message' => 'Parramters ivalid!'
            ], 500);
        }
    }

    protected function Payment_edit(Request $request, $id)
    {
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);

        $paymentss = Payment::select('*')
            ->leftjoin('users', 'payment.user_id', '=', 'users.id')
            ->select('payment.user_id as pay_user_id', 'payment.type as pay_type', 'users.user_name as pay_user', 'payment.num_card as pay_card', 'payment.token as pay_token', 'payment.merchant_id as pay_merchant', 'payment.created_at as pay_time')
            ->where('payment.user_id', $currentUser->id)
            ->get();

        $payments = Payment::find('id');
        $payments->type = $request->get('type');
        $payments->merchant_id = $request->get('merchant_id');
        $payments->num_card = $request->get('num_card');
        $payments->update();

        if ($paymentss) {
            return response()->json(['result' => $payments,'success' =>true]);
        } else {
            return response()->json([
                'message' => 'Parramters ivalid!'
            ], 500);
        }
    }

    public function show_payment(Request $request)
    {
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);
        $id = e(Input::get('id'));
        $pook = Payment::find($id)
            // ->leftjoin('users','payment.user_id','=','users.id')
            ->where('payment.user_id', $currentUser->id)
            ->get();

        if (!$pook)
            throw new NotFoundHttpException;
        if ($pook) {
            return response()->json(['result' => $pook]);
        } else {
            return response()->json([
                'message' => 'Parramters ivalid!'
            ], 500);
        }
    }

    public function search(Request $request)
    {

        $input = $request->all();

        $query = e(Input::get('query'));
        if ($query == null) {
            return response()->json(['error' => 'no query found']);
        }
        if (!$query && $query == '') return Response::json(array(), 400);

        $products = Product::where('name', true)
            ->where('name', 'like', '%' . $query . '%')
            ->where('price', 'like', '%' . $query . '%')
            ->orderBy('name', 'asc')
            ->take(5)
            ->get(array('name'))->toArray();
        $categories = Category::where('name', 'like', '%' . $query . '%')
            ->take(5)
            ->get(array('name', 'desc', 'img'))
            ->toArray();

        $brands = Brand::where('name', 'like', '%' . $query . '%')
            ->take(5)
            ->get(array('name', 'img', 'desc'))
            ->toArray();

        $products = $this->appendValue($products, 'product', 'class');

        $data = array_merge($products, $categories, $brands);

        return response()->json(['result' => $data]);

    }

    public function contact_store(Request $request)
    {

        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);
        try {
            $info = new info();
            $info->title = $request->get('title');
            $info->desc = $request->get('desc');
            $info->phone = $request->get('phone');
            $info->email = $request->get('email');
            $info->lat = $request->get('lat');
            $info->long = $request->get('long');
            $info->lang = $request->get('lang');
            $info->save();
        } catch (Exception $exception) {
            return response()->json(['Error Code' => $exception->getCode(), 'Message' => 'Field cannot be null']);
        }
        if ($currentUser) {
            return response()->json(['result' => $info]);
        } else {
            return response()->json([
                'message' => 'Parramters ivalid!'
            ], 500);
        }


    }

    protected function contact_get(){
        $info_lang = info::get()->toArray();
        return response()->json(['result' => $info_lang, 'success' => true]);
    }

    public function Time_Store(Request $request)
    {
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);
        try{
            $time = new Times();
            $time->name = $request->get('name');
            $time->save();
        }catch(Exception $exception) {
            return response()->json(['Error Code' =>  $exception->getCode(),'Message' => 'Field cannot be null']);
        }

        if ($currentUser) {
            return response()->json(['result' => $time, 'Success' => true]);
        } else {
            return response()->json([
                'message' => 'Parramters ivalid!'
            ], 500);
        }
    }

    protected function Time_get()
    {
        try {
            $time = Times::select('*')->get();
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getCode(), 'message' => 'No time Found'])->setStatusCode(400);
        }

        return response()->json(['result' => $time, 'Success' => true]);
    }

    public function country_store(Request $request)
    {
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);
        try {
            $country = new Country();
            $country->country = $request->get('country');
            $country->area_id = $request->get('area_id');
            $country->save();
        } catch (Exception $exception) {
            return response()->json(['Error Code' => $exception->getCode(), 'Message' => 'Field cannot be null']);
        }
        if ($currentUser) {
            return response()->json(['result' => $country, 'Success' => true]);
        } else {
            return response()->json([
                'message' => 'Parramters ivalid!'
            ], 500);
        }

    }

    public function town_store(Request $request)
    {
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);
        try {
            $town = new Town();
            $town->town = $request->get('town');
            $town->country_id = $request->get('country_id');
            $town->save();
        } catch (Exception $exception) {
            return response()->json(['Error Code' => $exception->getCode(), 'Message' => 'Field cannot be null']);
        }
        if ($currentUser) {
            return response()->json(['result' => $town, 'Success' => true]);
        } else {
            return response()->json([
                'message' => 'Parramters ivalid!'
            ], 500);
        }

    }

    public function country_list(Request $request)
    {
        $input = $request->all();
        $country = e(Input::get('area_id'));

        if ($country == null) {
            return response()->json(['error' => 58,'message' =>'no area id found'])->setStatusCode(400);
        }
        if (!$country && $country == '') return Response::json(array(), 400);
        $area = Country::select('id', 'country', 'area_id')
            ->leftjoin('area', 'area.id', '=', 'country.area_id')
            ->leftjoin('currency', 'currency.id', '=', 'area.currency_id')
            ->select('country.id as country_id', 'country.country as country_name', 'area.name as country_area_name', 'country.area_id as country_area_id', 'currency.currency_name as country_currency_name', 'currency.id as country_currency_id', 'currency.currency_code as country_currency_code')
            ->where('country.area_id', 'like', '%' . $country . '%')
            ->where('country.lang', '=', $this->lang)
            ->orderBy('area_id', 'asc')
            ->take(5)
            ->get(array('country'))->toArray();

        return response()->json(['result' => $area, 'success' => true]);

    }

    public function town_list(Request $request)
    {

        $input = $request->all();
        $town = e(Input::get('country_id'));

        if ($town == null) {
            return response()->json(['error' => 58,'message' => 'no country id found'])->setStatusCode(400);
        }
        if (!$town && $town == '') return Response::json(array(), 400);

        $area_t = Town::select('id', 'town', 'country_id')
            ->leftjoin('country', 'country.id', '=', 'town.country_id')
            ->select('town.id as town_id', 'town.town as town_name', 'country.country as town_country_name')
            ->where('town.country_id', 'like', '%' . $town . '%')
            ->orderBy('town.country_id', 'asc')
            ->take(5)
            ->get(array('town'))->toArray();

        return response()->json(['result' => $area_t, 'success' => true]);
    }

    public function postAddToCart(Request $request)
    {
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);

        $product_id = Input::get('product_id');
        $amount = Input::get('amount');
        $gender = Input::get('gender');
        $address = Input::get('address');
        $time = Input::get('time');
        $date = Input::get('date');
        $notes = Input::get('notes');

        $rules = array(
            'product_id' => 'required|integer',
            'amount' => 'required|numeric',
            'gender' => 'required',
            'address' => 'required',
            'time' => 'required',
            'date' => 'required',
            'notes' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $errores = $validator->errors();
            $error_string = '';
            foreach ($errores->messages() as $key=>$value){
                $error_string .= $value[0];
            }
            return response()->json(['error' => 67, 'message' => $error_string])->setStatusCode(400);
        }

        $product = Product::find($product_id);
        if(empty($product))
            return response()->json(['error' => 67, 'message' => 'undefined product '])->setStatusCode(405);

        $total = $amount * $product->price;

        $count = Cart::where('product_id', '=', $product_id)->where('user_id', '=', $currentUser->id)->count();

        if ($count){
            return response()->json(['error' => 59, 'message' => 'product already in your cart'])->setStatusCode(400);
        }


        $cart_add = Cart::create(
            array(
                'user_id' => $currentUser->id,
                'product_id' => $product_id,
                'amount' => $amount,
                'gender' => $gender,
                'address' => $address,
                'time' => $time,
                'date' => $date,
                'notes' => $notes,
                'total' => $total
            ));

        return response()->json(['result' => $cart_add, 'success' => true]);
    }
    public function postAddToCartEx(Request $request){
        $input = $request->all();

        if(isset($input['token']) && $input['token'] != '')
            $currentUser = JWTAuth::toUser($input['token']);

        $device_id = Input::get('device_id'); 
        $device_type = Input::get('device_type');    
        $product_id = Input::get('product_id');
        $amount = Input::get('amount');
        $gender = Input::get('gender');
        $address = Input::get('address');
        $time = Input::get('time');
        $date = Input::get('date');
        $notes = Input::get('notes');

        $rules = array(
            'product_id' => 'required|integer',
            'amount' => 'required|numeric|min:1',
            'gender' => 'required',
            'address' => 'required',
            'time' => 'required',
            'date' => 'required',
            'device_id' => 'required_without:token',
            'device_type' => 'required_without:token'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $errores = $validator->errors();
            $error_string = '';
            foreach ($errores->messages() as $key=>$value){
                $error_string .= $value[0];
            }
            return response()->json(['error' => 67, 'message' => $error_string])->setStatusCode(400);
        }

        $product = Product::find($product_id);
        if(empty($product))
            return response()->json(['error' => 67, 'message' => 'undefined product '])->setStatusCode(405);

        $total = $amount * $product->price;

        /*DB::enableQueryLog();*/

        // dd($currentUser);
        $count = Cart::where('product_id', '=', $product_id);
        if(isset($currentUser->id))
            $count = $count->where('user_id', '=', $currentUser->id);
        else{
            $count = $count->where('device_id', '=', $device_id);
            $count = $count->where('device_type', '=', $device_type);
        }

        $count = $count->get();

        /*dd(
            DB::getQueryLog()
        );*/

        // dd($count);

        if (count($count)){
            return response()->json(['error' => 59, 'message' => 'product already in your cart'])->setStatusCode(400);
        }

        $productAvailability = Cart::check_availibilityEx(0,$product_id,$date,$gender,$time,$amount);

        if(!$productAvailability['status']){
            return response()->json(['error' => 59, 'message' => $productAvailability['message']])->setStatusCode(400);
        }

        $cart_add = Cart::create(
            array(
                'user_id' => isset($currentUser->id)?$currentUser->id:null,
                'device_id' => !isset($currentUser->id)?$device_id:null,
                'device_type' => !isset($currentUser->id)?$device_type:null,
                'product_id' => $product_id,
                'amount' => $amount,
                'gender' => $gender,
                'address' => $address,
                'time' => $time,
                'date' => $date,
                'notes' => $notes,
                'total' => $total
            ));

        if($cart_add){
            $this->sendNotifications( $product->name , "اضافة للحافظة" , 2,'https://ratb.li/notifications',$product->user_id);
        }
        return response()->json(['result' => $cart_add, 'success' => true]);
    }

    protected function postOrder(Request $request)
    {
        $validation_complete = true;

        $input = $request->all();

        $product_id = Input::get('product_id');
        $amount     = Input::get('amount');
        $gender     = Input::get('gender');
        $address    = Input::get('address');
        // $time       = Input::get('time');
        // $daste       = Input::get('date');
        $notes      = Input::get('notes');

        $currentUser = JWTAuth::toUser($input['token']);

        $order_id = rand(1000, 5000);

        $cart_products = Cart::with('products')->where('user_id', '=', $currentUser->id)->get();

        $cart_total = Cart::with('products')->where('user_id', '=', $currentUser->id)->sum('total');

        $cart_qty = Cart::with('products')->where('user_id', '=', $currentUser->id)->sum('amount');

        if($cart_total == null){
            return response()->json(['error' => 60, 'message' => 'your cart is empty'])->setStatusCode(400);
        }

        $products_result = [];
        foreach ($cart_products as $cart_row ){
            $row = Cart::check_availibility($cart_row->id ,$cart_row->product_id,$cart_row->date,$cart_row->amount);
            if($row['status'] == false)
                $validation_complete = false;
            $products_result[] = $row;
        }

        // cart have some problems
        if($validation_complete == false){
            return response()->json(['result' => $products_result],404);
        }

        $order = Order::create([
            'user_id' => $currentUser->id,
            'order_id' => $order_id,
            'total' => $cart_total
        ]);

        if ($order) {

            foreach ($cart_products as $orders) {
                $fees = Product::select('*')
                    ->leftjoin('users','users.id','=','products.user_id')
                    ->select('users.fees as product_fees')
                    ->where('products.id',$orders->product_id)
                    ->get();
                $count_sum = Product::find($orders->product_id);
                // if ($count_sum->max_num  < $orders->amount ) {
                    // $cart = Cart::where('product_id', '=', $orders->product_id)->delete();
                  //  $cart_order_created = Order::select('*')->where('id', '=', $order->id)->delete();
                    // return response()->json(['error' => 85, 'message' => "your product $count_sum->name amount zero"])->setStatusCode(400);
                // }else{
                    ItemsOrder::create(array(
                        'order_id' => $order->id,
                        'product_id' => $orders->product_id,
                        'gender' => $orders->gender,
                        'address' => $address,
                        'date' => $orders->date,
                        'time' => $orders->time,
                        'notes' => $notes?$notes:$orders->notes,
                        'amount' => $orders->amount,
                        'total' => $orders->products->price * $orders->amount + $fees[0]->product_fees
                    ));
                    $count = Product::find($orders->product_id);
                    // $count->max_num = $count->max_num - $orders->amount;
                    $count->save();

                    Availibility::create([
                        'product_id' => $orders->product_id,
                        'date'       => $orders->date,
                        'period'     => 0,
                        'quantity'   => $orders->amount
                    ]);
                    $cart = Cart::where('user_id', '=', $currentUser->id)->delete();
                // }
            }
        }





       return response()->json(['result' => $order, 'success' => true]);

    }

    public function userLocations(Request $request){
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);

        // dd($currentUser);
        // Get user last 3 orders

        $usersLatestOrders = Order::where('user_id' , $currentUser->id)->orderby('created_at','desc')->take(3)->pluck('id');

        //dd($usersLatestOrders);

        // get user last orders locations
        $latestUserLocations = ItemsOrder::whereIn('order_id',$usersLatestOrders)->groupBy('order_id')->get(['order_long' , 'order_lat','address']);

        return response()->json(['result' => $latestUserLocations, 'success' => true]);
    }

    protected function postOrderEx(Request $request){
        $validation_complete = true;

        $input = $request->all();

        $product_id = Input::get('product_id');
        $amount     = Input::get('amount');
        $gender     = Input::get('gender');
        $address    = Input::get('address');
        $promoCode  = $request->promo_code;

        $system_promo = Promo::where('code' , trim($promoCode))->where('status',1)->first();

        if(isset($promoCode) && !$system_promo){
            return response()->json(['error' => 62, 'message' => 'promo code not found'])->setStatusCode(404);
        }
        // $time       = Input::get('time');
        // $daste       = Input::get('date');
        $notes      = Input::get('notes');

        $currentUser = JWTAuth::toUser($input['token']);

        //$order_id = rand(1000, 5000);
        $order_id = 5000 + Order::count();
        $cart_products = Cart::with('products')->where('user_id', '=', $currentUser->id)->get();

        $cart_total = Cart::with('products')->where('user_id', '=', $currentUser->id)->sum('total');

        $cart_qty = Cart::with('products')->where('user_id', '=', $currentUser->id)->sum('amount');

        // $cart = Cart::where('user_id', '=', $currentUser->id)->delete();


        if($cart_total == null){
            return response()->json(['error' => 60, 'message' => 'your cart is empty'])->setStatusCode(400);
        }

        $products_result = [];
        foreach ($cart_products as $cart_row ){
            $row = Cart::check_availibilityEx($cart_row->id,$cart_row->product_id,$cart_row->date,$cart_row->gender,$cart_row->time,$cart_row->amount);
            if($row['status'] == false)
                $validation_complete = false;
            $products_result[] = $row;
        }

        // cart have some problems
        if($validation_complete == false){
            return response()->json(['result' => $products_result],404);
        }
        $promo_code_id = null;
        $total_after_discount = $cart_total;
        if($system_promo){
            //dd($system_promo->toArray());
            $promo_code_id = $system_promo->id;
            $total_after_discount = $cart_total - (($system_promo->value *  $cart_total) / 100);
        }

        $data = [
            'user_id' => $currentUser->id,
            'order_id' => $order_id,
            'total' => $cart_total,
            'promo_code_id' => $promo_code_id,
            'total_after_discount' => round($total_after_discount,2)
        ];


        $order = Order::create($data);

        if ($order) {
            $vendorsUserIds = [];
            foreach ($cart_products as $orders) {
                $fees = Product::select('*')
                    ->leftjoin('users','users.id','=','products.user_id')
                    ->select('users.fees as product_fees')
                    ->where('products.id',$orders->product_id)
                    ->get();
                $count_sum = Product::find($orders->product_id);
                /*if ($count_sum->max_num  < $orders->amount ) {
                    $cart = Cart::where('product_id', '=', $orders->product_id)->delete();
                    //  $cart_order_created = Order::select('*')->where('id', '=', $order->id)->delete();
                    return response()->json(['error' => 85, 'message' => "your product $count_sum->name amount zero"])->setStatusCode(400);
                }else{*/
                    $data = ItemsOrder::create(array(
                        'order_id' => $order->id,
                        'product_id' => $orders->product_id,
                        'gender' => $orders->gender,
                        'address' => $address ? $address : $orders->address,
                        'date' => $orders->date,
                        'time' => $orders->time,
                        'notes' => $notes?$notes:$orders->notes,
                        'amount' => $orders->amount,
                        'total' => $orders->products->price * $orders->amount + $fees[0]->product_fees,

                        'order_long' => $request->has('long') ? $request->long : 0 ,
                        'order_lat' => $request->has('lat') ? $request->lat : 0 ,
                    ));
                    $count = Product::find($orders->product_id);
                    /*$count->max_num = $count->max_num - $orders->amount;*/
                    $count->save();
                    $this->sendNotifications(" طلب جديد للمنتج : " . $count->name , "عملية شراء" , 2,url("/vendors/orders/view/0"),$count->user_id);
                    // $this->sendWhatsapp(" طلب جديد للمنتج : " . $count->name, )
                    $admins = User::where('phone', '=', '+966593930006')->orwhere('phone', '=', '+966593930004')->orwhere('phone', '=', '+966541250203')->orwhere('phone', '=', '+966544374444')->orwhere('phone', '=', '+201004945663')->orwhere('phone', 'LIKE', '%1101510101%')->groupby('id')->pluck('firebase_token')->toArray();
                    foreach ($admins as $value) {
                        $notificationKey = $value;
                        $notificationBuilder = new PayloadNotificationBuilder('Rtb.li New Order');
                        $notificationBuilder->setBody(" طلب جديد للمنتج : " . $count->name)->setSound('default');
                        $notification = $notificationBuilder->build();
                        $groupResponse = FCM::sendToGroup($notificationKey, null, $notification, null);
                        $groupResponse->numberSuccess();
                        $groupResponse->numberFailure();
                        $groupResponse->tokensFailed();
                    }

                    $vendorsUserIds[$count->user_id][] = $count->name;

                    // $this->sendNotifications(" طلب جديد للمنتج : " . $count->name , "عملية شراء" , 2,url("/orderdetails/".$data->id),$count->user_id);
                    Availibility::create([
                        'product_id' => $orders->product_id,
                        'date'       => $orders->date,
                        'period'     => 0,
                        'quantity'   => $orders->amount
                    ]);
                    $cart = Cart::where('user_id', '=', $currentUser->id)->delete();
                // }
            }
            $this->dispatch(new SendReminderEmail($vendorsUserIds));
        }
        return response()->json(['result' => $order, 'success' => true]);
    }



    public function getOrderNew(Request $request){
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);

        $order_num = e(Input::get('order_number'));

        if ($order_num) {
            if ($order_num == '') {
                return response()->json(['error' => 61, 'message' => 'no order found'])->setStatusCode(400);
            }
            if (!$order_num && $order_num == '') return Response::json(array(), 400);

            $order_response = ItemsOrder::select('*')
                ->leftjoin('products','products.id','=','order_items.product_id')
                ->leftjoin('order_product','order_product.id','=','order_items.order_id')
                ->leftjoin('category', 'products.cat_id', '=', 'category.id')
                ->leftjoin('feed_back',function($join) use($currentUser,$order_num){
                    $join->on('feed_back.prod_id', '=', 'order_items.product_id')
                        ->where('feed_back.user_id', '=', $currentUser->id)
                        ->where('feed_back.order_id','=',$order_num);
                })
                ->select('order_product.id as order_id','products.id as order_product_id','products.name as order_product_name','products.price as order_product_price','order_items.gender as order_gender','order_items.address as order_address','order_items.date as order_delivery','order_items.time as order_time','order_product.status as order_status','order_items.status as order_status','order_items.amount as item_amount','order_product.order_id as order_number','order_product.total as order_total','order_product.created_at as order_created' , 'feed_back.rate')
                ->where('order_product.user_id',$currentUser->id)
                ->where('order_product.order_id',$order_num)
                ->orderBy('order_product.created_at' , 'desc')
                ->get();
            
            if (isset($order_response[0]->order_delivery) && ($order_response[0]->order_delivery > '2018-05-17') && ($order_response[0]->order_delivery < '2018-06-15')){
                if($order_response[0]->order_time == 'مساء')
                    $order_response[0]->order_time = 'سحور';
                elseif($order_response[0]->order_time == 'ظهرا')
                    $order_response[0]->order_time = 'عشاء';
                elseif($order_response[0]->order_time == 'صباحا')
                    $order_response[0]->order_time = 'افطار';
            }
            return response()->json(['result' => $order_response, 'success' => true]);

        }

        $orders = ItemsOrder::select('*')
                ->leftjoin('products','products.id','=','order_items.product_id')
                ->leftjoin('order_product','order_product.id','=','order_items.order_id')
                ->leftjoin('category', 'products.cat_id', '=', 'category.id')
                ->leftjoin('feed_back',function($join) use($currentUser){
                    $join->on('feed_back.prod_id', '=', 'order_items.product_id')
                        ->on('feed_back.order_id','=','order_product.order_id')
                        ->where('feed_back.user_id', '=', $currentUser->id);

                })
                ->select('order_product.id as order_id','products.id as order_product_id','products.name as order_product_name','products.price as order_product_price','order_items.gender as order_gender','order_items.address as order_address','order_items.date as order_delivery','order_items.time as order_time','order_product.status as order_status','order_items.status as order_status','order_items.amount as item_amount','order_product.order_id as order_number','order_product.total as order_total','order_product.created_at as order_created' , 'feed_back.rate')
                ->where('order_product.user_id',$currentUser->id)
                ->orderBy('order_product.created_at' , 'desc')
                ->get();


        foreach ($orders as $key => $order) {
            if (($order->order_delivery > '2018-05-17') && ($order->order_delivery < '2018-06-15')){
                if($order->order_time == 'مساء')
                    $orders[$key]->order_time = 'سحور';
                elseif($order->order_time == 'ظهرا')
                    $orders[$key]->order_time = 'عشاء';
                elseif($order->order_time == 'صباحا')
                    $orders[$key]->order_time = 'افطار';
            }
        }

        if ($currentUser) {
            return response()->json(['result' => $orders, 'success' => true]);
        } else {
            return response()->json([
                'message' => 'Parramters ivalid!'
            ], 500);
        }


    }
    public function getIndex(Request $request){
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);

        $order_num = e(Input::get('order_number'));

        if ($order_num) {
            if ($order_num == '') {
                return response()->json(['error' => 61, 'message' => 'no order found'])->setStatusCode(400);
            }
            if (!$order_num && $order_num == '') return Response::json(array(), 400);
            //dd('dd');
            $order_response = ItemsOrder::select('*')
                ->leftjoin('products','products.id','=','order_items.product_id')
                ->leftjoin('order_product','order_product.id','=','order_items.order_id')
                ->leftjoin('category', 'products.cat_id', '=', 'category.id')
                ->select('order_product.id as order_id','products.id as order_product_id','products.name as order_product_name','products.price as order_product_price','order_items.gender as order_gender','order_items.address as order_address','order_items.date as order_delivery','order_items.time as order_time','order_product.status as order_status','order_items.status as order_status','order_items.amount as item_amount','order_product.order_id as order_number','order_product.total as order_total','order_product.created_at as order_created')
                ->where('order_product.user_id',$currentUser->id)
                ->where('order_product.order_id',$order_num)
                ->orderBy('order_product.created_at' , 'desc')
                ->get();
            return response()->json(['result' => $order_response, 'success' => true]);

        }

        $orders = Order::Select('*')
            ->select('order_product.id as order_id','order_product.status as order_status','order_product.user_id as order_user_id','order_product.order_id as order_number','order_product.total as order_total','order_product.created_at as order_created')
            ->where('order_product.user_id',$currentUser->id)
            ->orderBy('order_product.created_at' , 'desc')
            ->get();

        if ($currentUser) {
            return response()->json(['result' => $orders, 'success' => true]);
        } else {
            return response()->json([
                'message' => 'Parramters ivalid!'
            ], 500);
        }


    }

    public function is_paid(Request $request){
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);

        $order_num = e(Input::get('order_number'));
        $payment_type = e(Input::get('payment_type'));
        $payment_no = e(Input::get('payment_no'))?e(Input::get('payment_no')):null;
        $payment_image = e(Input::get('payment_image'))?e(Input::get('payment_image')):null;
        $bank_id = e(Input::get('bank_id'))?e(Input::get('bank_id')):null;


        if (Input::hasfile('payment_image') == true){

            $decoded_image = base64_decode(Input::get('payment_image'));
            $info = getimagesizefromstring($decoded_image);

            $extention = substr($info['mime'], 6);
            if(empty($extention))
                $extention = 'jpeg';

            $fileName      = substr(md5(mt_rand()), 0, 7).'.'.$extention;

            file_put_contents('transactions/'.$fileName, $decoded_image);

            $payment_image = $fileName;
        }

        $status = true ;

            // dd($currentUser->id);

        // print_r($status);

        // die();

        if(!isset($status) || is_null($status)){
           return response()->json(['error' => 62, 'message' => 'not found'])->setStatusCode(404);
        }

        if ($status == true) {
            if (!$order_num && $order_num == '') return Response::json(array(), 400);
            $orders = Order::Select('*')
                ->select('order_product.id as order_id',
                         'order_product.status as order_status',
                         'order_product.user_id as order_user_id',
                         'order_product.order_id as order_number',
                         'order_product.total as order_total',
                         'order_product.created_at as order_created')
                ->where('order_product.user_id',$currentUser->id)
                ->where('order_product.order_id',$order_num)
                ->update(['status' => 2, 
                          'payment_type' => $payment_type, 
                          'payment_no' => $payment_no, 
                          'payment_image' => $payment_image, 
                          'bank_id' => $bank_id]);
            $notificationKey = $currentUser->firebase_token;
            $notificationBuilder = new PayloadNotificationBuilder('Rtb.li Order');
            $notificationBuilder->setBody('جاري مراجعة طلبك')->setSound('default');
            $notification = $notificationBuilder->build();
            $groupResponse = FCM::sendToGroup($notificationKey, null, $notification, null);
            $groupResponse->numberSuccess();
            $groupResponse->numberFailure();
            $groupResponse->tokensFailed();
            
           $lol = DB::update('update order_items set status=2 WHERE order_id = (select id from order_product where order_id ='.$order_num.')'); 
            

            return response()->json(['result' => $orders, 'success' => true]);
        }elseif($status->status  == 3){
            return response()->json(['error' => 76, 'message' => 'your request was accepted'])->setStatusCode(400);
        }elseif($status->status  == 4){
            return response()->json(['error' => 77, 'message' => 'your request refused'])->setStatusCode(400);
        }elseif($status->status  == 5){
            return response()->json(['error' => 78, 'message' => 'your request in perpareing'])->setStatusCode(400);
        }elseif($status->status  == 6){
            return response()->json(['error' => 79, 'message' => 'your request in processing'])->setStatusCode(400);
        }elseif($status->status  == 7){
            return response()->json(['error' => 80, 'message' => 'your request completed'])->setStatusCode(400);
        }
        if ($order_num == '') {
            return response()->json(['error' => 75, 'message' => 'no order found'])->setStatusCode(400);
        }

        if ($currentUser) {
            $orders = Order::
                select('order_product.id as order_id',
                    'order_product.status as order_status',
                    'order_product.user_id as order_user_id',
                    'order_product.order_id as order_number',
                    'order_product.total as order_total','order_product.created_at as order_created')
                ->where('order_product.user_id',$currentUser->id)
                ->where('order_product.order_id',$order_num)
                ->update(['status' => 2]);
            if($currentUser->firebase_token){
                $notificationKey = $currentUser->firebase_token;
                $notificationBuilder = new PayloadNotificationBuilder('Rtb.li Order');
                $notificationBuilder->setBody('جاري مراجعة طلبك')->setSound('default');
                $notification = $notificationBuilder->build();
                $groupResponse = FCM::sendToGroup($notificationKey, null, $notification, null);
                $groupResponse->numberSuccess();
                $groupResponse->numberFailure();
                $groupResponse->tokensFailed();
            }

            return response()->json(['result' => $orders, 'success' => true]);
        } else {
            return response()->json([
                'message' => 'Parramters ivalid!'
            ], 500);
        }


    }

    public function banks(){
        $data['banks'] = BankAccount::all();
        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function nations(){
        $nations = Nations::where('status', '=', 1);
        if($this->lang == 'en')
            $nations = $nations->select('id', 'name_en as name', 'code', 'currency_code', 'currency_name_en as currency_name', 'status', 'flag', 'created_at', 'updated_at');
        $nations = $nations->orderby('id')->get();

        $data['nations'] = $nations;
        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function nation($id){
        $nations = Nations::where('status', '=', 1)->where('id', '=', $id);
        if($this->lang == 'en')
            $nations = $nations->select('id', 'name_en as name', 'code', 'currency_code', 'currency_name_en as currency_name', 'status', 'flag', 'created_at', 'updated_at');
        $nations = $nations->get();

        if(!$nations)
            return response()->json([ 'success' => false, 'message' => trans('api.nation_not_found')], 404);    

        $data['nations'] = $nations;
        return response()->json(['success' => true, 'data' => $data], 200);
    }

    protected function update_cart(Request $request)
    {
        $input = $request->all();
        if($input['token'] && $input['token'] != '')
            $currentUser = JWTAuth::toUser($input['token']);
        $device_id = $request->device_id;
        $device_type = $request->device_type;

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            $errores = $validator->errors();
            $error_string = '';
            foreach ($errores->messages() as $key=>$value){
                $error_string .= $value[0];
            }
            return response()->json(['error' => 67, 'message' => $error_string])->setStatusCode(400);
        }


        /*if ($validator->fails()) {
            session()->flash('error_message', 'Quantity must be between 1 and 50.');
            return response()->json(['error' => 62, 'message' => 'quantity must be between 1 and 50'])->setStatusCode(400);
        }*/
        $rowId = e(Input::get('id'));
        $quantity = Input::get('amount');

        $product_id = Cart::where('id', '=', $rowId);

        if(isset($currentUser->id))
            $product_id = $product_id->where('user_id','=',$currentUser->id);
        else{
            $product_id = $product_id->where('device_id','=',$device_id);
            $product_id = $product_id->where('device_type','=',$device_type);
        }
        $product_id = $product_id->first();


        if(!isset($product_id) || is_null($product_id)){
            return response()->json(['error' => 62, 'message' => 'not found'])->setStatusCode(404);
        }

        $productAvailability = Cart::check_availibilityEx(0,$product_id->product_id,$product_id->date,$product_id->gender,$product_id->time,$quantity);

        if(!$productAvailability['status']){
            return response()->json(['error' => 59, 'message' => $productAvailability['message']])->setStatusCode(400);
        }
        $product = Product::find($product_id->product_id);

        $totald = $quantity * $product->price;

        $carts = Cart::where('id', $rowId)->update(['amount' => $quantity, 'total' => $totald]);
        $view = Cart::select('id', 'amount')->get();
        return response()->json(['result' => $view, 'message' => "Quantity Successfuly updated", 'success' => true]);

    }

    public function emptycart(Request $request)
    {
        $input = $request->all();

        $currentUser = JWTAuth::toUser($input['token']);


        $cart = Cart::where('user_id', '=', $currentUser->id)->delete();

        return response()->json(['result' => $cart, 'success' => true]);

    }

    public function delete_item(Request $request)
    {
        $device_id = $request->device_id;
        $device_type = $request->device_type;
        $input = $request->all();
        if(isset($input['token'])&& $input['token']!='')
            $currentUser = JWTAuth::toUser($request->token);
        if(isset($currentUser)){
            $rules = array(
                'id' => 'required|integer|exists:carts,id,user_id,'.$currentUser->id,
            );
        }
        else{
            $device_id = $request->device_id;
            $device_type = $request->device_type;
            $rules = array(
                'id' => 'required|integer|exists:carts,id,device_id,'.$device_id.',device_type,'.$device_type,
            );
        }
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $errores = $validator->errors();
            $error_string = '';
            foreach ($errores->messages() as $key=>$value){
                $error_string .= $value[0];
            }
            return response()->json(['error' => 67, 'message' => $error_string])->setStatusCode(400);
        }

        $id_cart = Input::get('id');

        $destroy = Cart::where('id', '=', $id_cart)->delete();
        return response()->json(['Result' => "your Item Id # $destroy removed !", 'success' => true]);
    }

    public function count_cart(Request $request)
    {

        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);
        try {
            $counts = Cart::count();
        } catch (Exception $exception) {
            return response()->json(['result' => 'your cart empty', 'success' => true]);
        }
        if ($currentUser) {
            return response()->json(['result' => $counts, 'success' => true]);
        } else {
            return response()->json([
                'message' => 'Parramters ivalid!'
            ], 500);
        }

    }

    public function get_all_cart(Request $request){
        $input = $request->all();

        $device_id = $request->device_id;
        $device_type = $request->device_type;

        if(isset($input['token']) && $input['token'] != '')
            $currentUser = JWTAuth::toUser($input['token']);

        DB::enableQueryLog();
        $all_cart = Cart::select('*')
            ->leftjoin('users', 'carts.user_id', '=', 'users.id')
            ->leftjoin('products', 'carts.product_id', '=', 'products.id')
            ->leftjoin('category', 'category.id', '=', 'products.cat_id')
            ->leftjoin('users as product_owner', 'products.user_id', '=', 'product_owner.id')
            ->leftjoin('nations', 'nations.id', '=', 'product_owner.nation_id')
            ->groupby('products.id')
            ->leftjoin('feed_back', 'products.id', '=', 'feed_back.prod_id')
            ->select('carts.id as cart_id', 'products.id as cart_product_id',
                'users.id as cart_user_id',
                'product_owner.user_name as cart_user_name', 'product_owner.pic as cart_user_pic', 'products.name as cart_product_name',
                'carts.amount as cart_qty','products.user_id as vendor_id', 'products.img as cart_produuct_pic',
                DB::raw('CONCAT(products.price, " ", nations.currency_code) AS cart_product_price'), 'category.name as cart_product_category',
                'carts.gender as cart_gender', 'carts.time as cart_time', 'carts.address as cart_address',
                DB::raw(" IFNULL(avg(feed_back.rate),0) AS average")
                ,DB::raw('CONCAT(product_owner.charge_cost, " ", nations.currency_code) AS charge_cost'),
                DB::raw('CONCAT(carts.total, " ", nations.currency_code) AS total_without_charge'),
                /*DB::raw("SUM(product_owner.charge_cost + carts.total ) as total_with_charge"),*/
                'carts.date as cart_date_time',
                'carts.notes as cart_notes');
        if(isset($currentUser->id))
            $all_cart = $all_cart->where('users.id', $currentUser->id);
        else{
            $all_cart = $all_cart->where('carts.device_id', $device_id);
            $all_cart = $all_cart->where('carts.device_type', $device_type);
        }

        // $all_cart = $all_cart->where('products.status', '!=', 2);

        $all_cart = $all_cart->get()->toArray();

        // dd(
        //     DB::getQueryLog()
        // );
        // die();


        $userNation = Nations::find(isset($currentUser->nation_id)?$currentUser->nation_id:1);
        $vendor_charges = [];
        $total_charge_cost = $total_order  = 0;
        // calculate charge fees
        foreach ($all_cart as $row){
            // if(!isset($charges[$row['vendor_id']])){
                // $charges[$row['vendor_id']] = $row['charge_cost'];
                $total_charge_cost += filter_var($row['charge_cost'], FILTER_SANITIZE_NUMBER_INT);
                $total_order += filter_var($row['total_without_charge'], FILTER_SANITIZE_NUMBER_INT);
            // }
        }

        $result = [
            'result' => $all_cart,
            'total_charge_cost' => $total_charge_cost . " " . $userNation->currency_code ,
            'total_order_without_charge' => $total_order . " " . $userNation->currency_code,
            'total_all' => $total_charge_cost + $total_order
        ];
        $result['total_all'] .=  " " . $userNation->currency_code;
        if (isset($currentUser) || $device_id) {
            return response()->json(['result' => $result, 'success' => true]);
        } else {
            return response()->json([
                'message' => trans('api.invalid_parameters')
            ], 500);
        }

    }


    protected function about_get(Request $request)
    {
        $input = $request->all();
        $lang = $this->lang;
        if (!$lang && $lang == '') return Response::json(array(), 400);

        $about_us = About::select('*')
            ->where('lang', '=', $lang)
            ->orderBy('lang', 'asc')
            ->select('desc')
            ->get();
        return response()->json($about_us);
    }

    protected function unbookmark(Request $request)
    {
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);
        $id_book = Input::get('bookmark_id');
        $rules = array(
            'bookmark_id' => 'required|integer'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => 63, 'message' => 'your bookmark not found'])->setStatusCode(400);
        }

        if ($currentUser) {

            $book_del = Bookmark::where('id', '=', $id_book)->delete();

            return response()->json(['result' => "your bookmark id # $id_book removed !", 'success' => true]);
        } else {
            return response()->json([
                'message' => 'you are not the correct user!'
            ], 500);
        }
    }

    protected function unbookmark_product(Request $request){
        $input = $request->all();
        if($input['token'] && $input['token'] != '')
            $currentUser = JWTAuth::toUser($input['token']);
        $device_id = $request->device_id;
        $device_type = $request->device_type;
        $id_pro = Input::get('product_id');
        $rules = array(
            'product_id' => 'required|integer'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => 63, 'message' => 'your product not found'])->setStatusCode(400);
        }

        $bookmark = Bookmark::where('product_id', '=', $id_pro);
        if(isset($currentUser->id))
            $bookmark = $bookmark->where('user_id', '=', $currentUser->id);
        else{
            $bookmark = $bookmark->where('device_id', '=', $device_id)->where('device_type', '=', $device_type);
        }
        $bookmark = $bookmark->first();
        if(isset($bookmark->id)){
            $bookmark->delete();
            return response()->json(['result' => "your product id # $id_pro removed !", 'success' => true]);
        }
        else
            return response()->json(['result' => "not found", 'success' => false])->setStatusCode(404);

        if (isset($currentUser) || ($device_type && $device_id)) {
            $book_del = Bookmark::where('product_id', '=', $id_pro);
            if(isset($currentUser->id))
                $book_del = $book_del->where('user_id', '=', $currentUser->id);
            else{
                $book_del = $book_del->where('device_id', '=', $device_id)->where('device_type', '=', $device_type);
            }
            if($book_del->get()){
                $book_del = $book_del->delete();
                return response()->json(['result' => "your product id # $id_pro removed !", 'success' => true]);
            }
            return response()->json(['result' => "your product id # $id_pro removed !", 'success' => true]);

        } else {
            return response()->json([
                'message' => 'you are not the correct user!'
            ], 500);
        }
    }

    protected function rate_edit(Request $request)
    {

        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);
        $id_rate = Input::get('rate_id');
        $new_rate = Input::get('rates');
        $new_notes = Input::get('notes');
        if ($currentUser) {
            $feed_update = Feeds::where('id', $id_rate)->update(['rate' => $new_rate, 'notes_product' => $new_notes]);

            return response()->json(['rate' => "your Rate Id # $feed_update updated ! ", 'success' => true]);
        } else {
            return response()->json([
                'message' => 'you are not the correct user!'
            ], 500);
        }
    }

    public function whishlist(Request $request)
    {
        $input = $request->all();

        $wish = e(Input::get('cat_id'));

        if ($wish == '') {
            return response()->json(['error' => 'no Category found']);
        }
        if (!$wish && $wish == '') return Response::json(array(), 400);

        // $single_post = Product::find($wish);

        try {
            $whish_cat = Bookmark::select('product_id')
                ->leftjoin('products', 'products.id', '=', 'bookmark.product_id')
                ->leftjoin('category', 'products.cat_id', '=', 'category.id')
                ->leftjoin('users', 'bookmark.user_id', '=', 'users.id')
                ->select('bookmark.id as book_id', 'users.user_name as book_user_name', 'category.name as book_cat_name', 'category.img as book_cat_img', 'products.name as book_product_name')
                ->where('products.cat_id', $wish)
                ->get();
        } catch (Exception $exception) {
            return response()->json(['error' => 64, 'message' => 'no book mark for that category'])->setStatusCode(400);
        }


        return response()->json(['result' => $whish_cat, 'success' => true]);


    }

    public function json_recive(Request $request)
    {

        $input = $request->all();

        $currentUser = JWTAuth::toUser($input['token']);
        $url = 'http://localhost/party/public/api/order/single?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly9sb2NhbGhvc3QvcGFydHkvcHVibGljL2FwaS9sb2dpbiIsImlhdCI6MTUwNjEwNTE3MSwiZXhwIjoxNTA2NDY1MTcxLCJuYmYiOjE1MDYxMDUxNzEsImp0aSI6InNmQXVzM2ROSnlxSllhN1gifQ.3UEdcrhfKWZ5teibSLy6trBzuw1M7vMkCellAQesEQg&order_number=4619'; //fetching data as JSON
        $json = json_decode(file_get_contents($url), true);

        // dd($json);
        $order_id = rand(1000, 5000);

        foreach ($json as $key => $value) {
            $order_json = Order::create([
                // 'user_id' => $currentUser->id,
                $key[0]['address'] => $value->order_address
                //$value->order_id => $key[0]->order_number
            ]);
        }
        if ($currentUser) {
            return response()->json(['result' => $order_json, 'Success' => true]);
        } else {
            return response()->json([
                'message' => 'you are not the correct user!'
            ], 500);
        }

    }

    public function firebase(Request $request){

        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);

        //        if(empty($currentUser->token))
        //            return response()->json(['result' => 'token is mandatory field','success' => false]);
        //        if(empty($currentUser->firebase_token))
        //            return response()->json(['result' => 'firebase_token is mandatory field ','success' => false]);


        $profile_fire = User::find($currentUser->id);
        $profile_fire->firebase_token = input::get('firebase_token');;
        $profile_fire->save();

        return response()->json(['result' => 'done','success' => true]);

    }

    public function firebase_test(Request $request){

        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);

        $this->sendNotifications("test" , "عملية شراء" , 2,null,$currentUser->id);

        return response()->json(['result' => 'done','success' => true]);

    }

    public function Push_Test(Request $request){
        $input = $request->all();
        //$currentUser = JWTAuth::toUser($input['token']);
        //  $notificationKey = 'cRBEUKfC69o:APA91bFN_I676xFC9QTkSod5MLQvhnq1xNRoHEyFe4vIoMQFZRg1jDdyKacwuDwvT4lMYN12UoRMvPZ3fs1PNdgjZrjSbQT5wSPJa2Obz76z7oxLfgIoI22dUlAAqJJMZH3pGVyo4cFM';
        $notificationKey = Input::get('fire');;
        $notificationBuilder = new PayloadNotificationBuilder('Rtb.li');
        $notificationBuilder->setBody('hello')->setSound('default');
        $notification = $notificationBuilder->build();
        $groupResponse = FCM::sendToGroup($notificationKey, null, $notification, null);
        $groupResponse->numberSuccess();
        $groupResponse->numberFailure();
        $groupResponse->tokensFailed();
    }

    public function group_send(Request $request){
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);
        $notificationBuilder = new PayloadNotificationBuilder('Rtb.li');
        $notificationBuilder->setBody('Hello Rtb.li User Happy Gift day use that code XCSE to get Voucher on your request from any Restaurant ')
            ->setSound('default');
        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);
        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();
        $tokens = User::pluck('firebase_token')->toArray();
        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();
        $downstreamResponse->tokensToDelete();
        $downstreamResponse->tokensToModify();
        $downstreamResponse->tokensToRetry();
        $downstreamResponse->tokensWithError();

         //file_put_contents('rami.txt', json_encode($downstreamResponse) . 'hhhhhhhhhhhh');


        return response()->json(['result' => $downstreamResponse,'success' => true]);

    }

    public function iosAppShareLink(){
        return response()->json(['status' => true, 'result' => ['link' => 'https://ratb.li']]);
    }

    public function providerByCategory($id){
        //dd($id);
        //$users = Category::with('Products')->where('id',$id)->get();
        $validator = Validator::make(['id' => $id],
            [
                'id' => 'required|integer|exists:category,id'
            ]
        );

        if($validator->fails()){
            return response()->json(['error' => 1, 'errors' => "invalid category id"])->setStatusCode(400);
        }

        $token = Request()->input('token')?Request()->input('token'):null;

        $currentUser = null;
        // get curent user identity
        if($token){
            $currentUser = JWTAuth::toUser($token);
        }


        $users = User::whereHas('Products', function($q) use($id){
            $q->where('cat_id' , $id);
            $q->where('status' , 1);

        })->with(['rate'])
            ->where('verified' , 1)
            ->where('is_vendor' , 1);

        if($currentUser)
            $users = $users->where('nation_id' , $currentUser->nation_id);

        $users = $users->get(['id' , 'user_name' , 'phone' , 'email' , 'address' , 'pic']);

        return response()->json(['success' => true , 'providers' => $users]);

    }

    public function getProductsByProviderAndCategory($category_id , $provider_id){
        $validator = Validator::make(
            [
                'category_id' => $category_id,
                'provider_id' => $provider_id
            ],
            [
                'category_id' => 'required|integer|exists:category,id',
                'provider_id' => 'required|integer|exists:users,id'
            ]
        );

        if($validator->fails()){
            return response()->json(['error' => 1, 'errors' => $validator->errors()->all()])->setStatusCode(400);
        }

        $products = Product::where('cat_id' , $category_id)
            ->where('user_id', $provider_id)
            ->where('status' , 1)
            ->get();

        return response()->json(['success' => true , 'products' => $products]);
    }

    public function sendTwiloMsg(Request $request){
        $rules = array(
            'phone' => 'required',
            'v_code' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()])->setStatusCode(400);
        }
        $phone = '+'.trim($request->get('phone'));
        $v_code = $request->get('v_code');
        $user = User::where('phone', '=', $phone)->first();

        $password = rand(100000,999999);

        $user->password = Hash::make($password);

        $user->update();
        // $message = "عميل رتب.لي نعتذر عن تأخر رسالة التفعيل وذلك حيث أنكم مشتركين في خدمة حظر الرسائل الدعائية. كود التفعيل الخاص بكم هو " . $v_code . " و كلمة المرور الخاصة بحسابكم هي" . $password;
        $message = "السلام عليكم , عميل رتب.لي نعتذر عن تأخر وصول رسالة التفعيل وذلك لخلل في مزود خدمة الرسائل , ونكرر الاعتذار مجددا نرجو منكم الدخول على صفحتكم في التطبيق. كود التفعيل الخاص بكم هو ".$v_code." و كلمة المرورالجديدة الخاصة بحسابكم هي ".$password." ويمكنك تغيرر رقمك السري من داخل التطبيق او طلب رقم سري جديد من التطبيق.";
        // $message = trans('api.welcome_sms', ['code' => $request->get('v_code')]);
        // $send = Twilio::message($phone, $message);
        $send = $this->SendSms($phone,$message);

        return back();
    }

/*    //Visa And Master Call URL
    public function payfort(Request $request){
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);
        $order_num = e(Input::get('order_number'));
        if ($order_num) {
            if ($order_num == '') {
                return response()->json(['error' => 61, 'message' => 'no order found'])->setStatusCode(400);
            }
            if (!$order_num && $order_num == '') return Response::json(array(), 400);
            $orderfort = Order::select('order_id','user_id','total')
                ->where('order_product.user_id',$currentUser->id)
                ->where('order_product.order_id',$order_num)
                ->get();
            $test =  Payfort::redirection()->displayRedirectionPage([
                'command' => 'AUTHORIZATION',
                // 'command' => 'PURCHASE',
                'merchant_reference' => "ORDR.$order_num",
                'amount' => $orderfort[0]->total,
                'currency' => 'SAR',
                'customer_email' => $currentUser->email
            ]);

            return $test;

        }else{
            return response()->json(['error' => 61, 'message' => 'no order found'])->setStatusCode(400);
        }


    }

    //Sadad Getway
    public function sadad(Request $request){
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);
        $order_num = e(Input::get('order_number'));
        if ($order_num) {
            if ($order_num == '') {
                return response()->json(['error' => 61, 'message' => 'no order found'])->setStatusCode(400);
            }
            if (!$order_num && $order_num == '') return Response::json(array(), 400);
            $orderfort = Order::select('order_id','user_id','total')
                ->where('order_product.user_id',$currentUser->id)
                ->where('order_product.order_id',$order_num)
                ->get();
            $test =  Payfort::redirection()->displayRedirectionPage([
                //SADAD (for Purchase operations only)
                'command' => 'PURCHASE',
                'merchant_reference' => "ORDR.$order_num",
                'amount' => $orderfort[0]->total,
                'currency' => 'SAR',
                'payment_option' =>'SADAD',
                'customer_email' => $currentUser->email
            ]);
            return $test;

        }else{
            return response()->json(['error' => 61, 'message' => 'no order found'])->setStatusCode(400);

        }


    }

    //Request Redirect URL
    public function processReturn(Request $request){

        $payfort_return = $this->handlePayfortCallback($request);
//        return response()->json(['success' => $payfort_return ]);
//        return die();

        $merchant_reference = $payfort_return['merchant_reference'];

        $order_number_find = substr($merchant_reference, 5);

        $current_user_card = Order::select('*')
            ->where('order_id','=',$order_number_find)
            ->get();
        //handle request from Visa and Master response code
        if($payfort_return['status'] == 02){
            $transaction = new Payment();
            $transaction->payment_option = $payfort_return['payment_option'];
            $transaction->card_number = $payfort_return['card_number'];
            $transaction->payment_option = $payfort_return['payment_option'];
            $transaction->expiry_date = $payfort_return['expiry_date'];
            $transaction->customer_ip = $payfort_return['customer_ip'];
            $transaction->status = $payfort_return['status'];
            $transaction->signature = $payfort_return['signature'];
            $transaction->fort_id = $payfort_return['fort_id'];
            $transaction->amount = $payfort_return['amount'];
            $transaction->order_number = $payfort_return['merchant_reference'];
            $transaction->authorization_code = $payfort_return['authorization_code'];
            $transaction->currency = $payfort_return['currency'];
            $transaction->user_id = $current_user_card[0]->user_id;
            $transaction->order_description = "الرقم طلب.".$order_number_find;
            $transaction->save();

            $updat_success = DB::update('update order_items set status=2 WHERE order_id = (select id from order_product where order_id ='.$order_number_find.')');
            return response()->json(['success' => true , 'message' => 'Payment Success'])->setStatusCode(200);
            //handle request from SADAD  response code
        }elseif( $payfort_return['status'] == 14){
            $transaction = new Payment();
            $transaction->sadad_olp = $payfort_return['sadad_olp'];
            $transaction->payment_option = $payfort_return['payment_option'];
            $transaction->customer_ip = $payfort_return['customer_ip'];
            $transaction->status = $payfort_return['status'];
            $transaction->fort_id = $payfort_return['fort_id'];
            $transaction->amount = $payfort_return['amount'];
            $transaction->signature = $payfort_return['signature'];
            $transaction->order_number = $payfort_return['merchant_reference'];
            $transaction->authorization_code = $payfort_return['authorization_code'];
            $transaction->currency = $payfort_return['currency'];
            $transaction->user_id = $current_user_card[0]->user_id;
            $transaction->order_description = "الرقم طلب.".$order_number_find;
            $transaction->save();
            $updat_success = DB::update('update order_items set status=2 WHERE order_id = (select id from order_product where order_id ='.$order_number_find.')');
            return response()->json(['success' => true , 'message' => 'Payment Success'])->setStatusCode(200);
        }else{
            $transaction_faild  = new Payment();
            $transaction_faild->user_id = $current_user_card[0]->user_id;
            $transaction_faild->status = $payfort_return['status'];
            $transaction_faild->currency = $payfort_return['currency'];
            $transaction_faild->sadad_olp = "XXXX";
            $transaction_faild->signature = $payfort_return['signature'];
            $transaction_faild->order_number = $payfort_return['merchant_reference'];
            $transaction_faild->customer_ip = $payfort_return['customer_ip'];
            $transaction_faild->order_description = "الرقم طلب.".$order_number_find;
            $transaction_faild->save();
            return response()->json(['success' => false , 'message' => 'Payment Failed'])->setStatusCode(400);
        }
    }

    //Make Purshace for Authorise
    public function Purchase(Request $request ){
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);
        $payment_id = e(Input::get('order_number'));
        if ($payment_id) {
            if ($payment_id == '') {
                return response()->json(['error' => 800, 'message' => 'no order found'])->setStatusCode(400);
            }
            if (!$payment_id && $payment_id == '') return Response::json(array(), 400);

            $orfort = Payment::select('*')
                ->where('payment.user_id',$currentUser->id)
                ->where('payment.order_number',"ORDR.".$payment_id)
                ->get();

            $signture = hash('sha256',"PASSaccess_code=B2XgLdkd9Rzt2ehZbbs3amount=".$orfort[0]->amount."command=CAPTUREcurrency=SARfort_id=".$orfort[0]->fort_id."language=armerchant_identifier=TETHkecgmerchant_reference=".$orfort[0]->order_number."order_description=".$orfort[0]->order_description."PASS");

            $capture = $this->payfort_capture($orfort[0]->order_number,$orfort[0]->order_description,$orfort[0]->amount,$orfort[0]->fort_id);

            return response()->json(['success' => "true", 'message' => 'Order Transaction Captured'])->setStatusCode(200);
        }else{
            return response()->json(['error' => 701, 'message' => 'no order found'])->setStatusCode(400);
        }
    }

    //Make Refund for Authorise
    public function Refund(Request $request){
        $input = $request->all();
        $currentUser = JWTAuth::toUser($input['token']);
        $payment_id = e(Input::get('order_number'));
        if ($payment_id) {
            if ($payment_id == '') {
                return response()->json(['error' => 800, 'message' => 'no order found'])->setStatusCode(400);
            }
            if (!$payment_id && $payment_id == '') return Response::json(array(), 400);

            $orfort = Payment::select('*')
                ->where('payment.user_id',$currentUser->id)
                ->where('payment.order_number',"ORDR.".$payment_id)
                ->get();

            $refund = $this->payfort_refund($orfort[0]->order_number,$orfort[0]->order_description,$orfort[0]->amount,$orfort[0]->fort_id);


            return response()->json(['success' => "true", 'message' => 'Order Transaction Refund'])->setStatusCode(200);
        }else{
            return response()->json(['error' => 701, 'message' => 'no order found'])->setStatusCode(400);
        }
    }

*/
}
