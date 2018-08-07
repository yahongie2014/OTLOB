<?php

namespace App\Http\Controllers;

use App\Branches;
use App\info;
use App\Nations;
use App\ProductExeption;
use App\Roles;
use Cookie;
use Illuminate\Http\Request;
use Input;
use Event;
use Session;
use Carbon;
use Validator;
use Hash;
use App\User;
use App\Product;
use App\Times;
use App\Area;
use App\Brand;
use App\Category;
use App\ItemsOrder;
use App\Town;
use App\Feeds;
use App\Country;
use App\Order;
use App\Payment;
use App\ProductAvailibility;
use Auth;
use DB;
use App\Images;
use App\Bookmark;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Notify;
use Illuminate\Cookie\CookieJar;


class VendorController extends Controller
{

    public function __construct(CookieJar $cookieJar, Request $request)
    {

        $this->middleware('auth');
        $id = \Request::segment(4);
        //dd(Auth::user()->id);
        if(Auth::user()->verified != 1){
            Auth::logout();
            return Redirect::to('/')->with('danger','برجاء مراجعة الايميل الشخصي المسجل لدينا لتفعيل حسابك - أو تواصل مع مسئول الدعم الفني');

        }
        if($request->referrer){
            $cookieJar->queue(cookie('referrer', $request->referrer, 45000));
        }


    }


	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function index(Request $request){
        $user_id = Auth::User()->id;
        $user_products = Product::select('id');
        $lang = $request->server('HTTP_ACCEPT_LANGUAGE');
        if(!$lang || $lang == '' || ($lang != 'en' && $lang !='ar')){
            $lang = 'ar';
        }
        $product_count = Product::select('*')
            ->leftjoin('users','users.id','=','products.user_id')
            ->where('products.user_id',Auth::User()->id)
            ->count();
        $feed_count = Feeds::select('*')
            ->leftjoin('products','products.id','=','feed_back.prod_id')
            ->leftjoin('users','users.id','=','products.user_id')
            ->where('products.user_id',Auth::User()->id)
            ->count();
        $order_count = ItemsOrder::select('*')
            ->leftjoin('products','order_items.product_id','=','products.id')
            ->leftjoin('users','users.id','=','products.user_id')
            ->where('products.user_id',Auth::User()->id)
            ->count();

        Cookie::queue('referrer', true, 15);

        $categories = Category::where('lang', '=', $lang)->get();

        $categories_count = Product::select(DB::raw('SUM(views) as views'), 'cat_id')->where('user_id', '=', Auth::User()->id)->groupBy('cat_id')->get();

        $final_category = array();

        foreach ($categories as $category) {
            foreach ($categories_count as $count) {
                if($category->id == $count->cat_id){
                    $final_category[] = array('category_id' => $category->id,
                                            'name' => $category->name,
                                            'count' => $count->views,
                                            'color' => str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT));
                                            break;
                }
            }
        }

        $categories = Category::all();
        foreach ($categories as $category) {
            $category_id = $category->id;
            $count = Product::where('cat_id', '=', $category_id)->select(DB::raw('SUM(views) as count'))->groupBy('cat_id');
            if(Auth::user()->is_vendor)
                $count = $count->where('user_id', '=', $user_id);
            $count = $count->first();


            $views[] = array('name' => $category->name, 'count' => $count['count']);
        }
        if(Auth::user()->is_vendor)
            $user_products->where('user_id', '=', $user_id);
        $user_products = $user_products->get();

        $sales = array();
        $sales_object = ItemsOrder::select(DB::raw('SUM(total) as total'), DB::raw('YEAR(date) year'))->whereIN('product_id', $user_products)->groupBy('year')->get();
        foreach ($sales_object as $value) {
            $sales[] = $value['attributes'];
        }
        $statistics = array('views' => $views, 'sales' => $sales);


        return View('admin.index')
            ->with('product_count',$product_count)
            ->with('feed_count',$feed_count)
            ->with('categories', $final_category)
            ->with('statistics', $statistics)
            ->withCookie(cookie('referrer', $request->referrer, 45000))
            ->with('order_count',$order_count);
    }

    public function lock(Request $request)
    {
        $rules=[
            'email'=>'required|email',
            'name'=>'required',
            'password'=>'required'
        ];
        $val = Validator::make($request->all(),$rules);

        if(!\Auth::check())
            return redirect('/login');
        $password = \Input::get('password');

        if(\Hash::check($password,\Auth::user()->password)){
            \Session::forget('locked');
            return redirect('/vendors');
        }else{
            return redirect('/vendors/lock');
        }
    }

    public function edit_user($id)
    {
        if(Auth::user()->id != $id)
            return view('errors.404')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');

        $users = User::with('categories')->find($id);
        $success = Input::get('success');

        $categories = Category::lists('name', 'id');

        $can_update = false;

        $user_categories = $users['categories']->toArray();
        $user_category = [];

        foreach($user_categories as $userCats){
            $user_category[] = $userCats['id'];
        }

        if ($users) {
            return view('admin.edit_vendor')
                ->with('categories', $categories)
                ->with('user_categories', $user_category)
                ->with('success', $success)
                ->with('users', $users);
        } else {
            return View('admin.edit_vendor',['user' => User::findOrFail($id)])
                ->with('title', 'Error Page Not Found');
        }
    }

    public function update_User_profile(Request $request) {
        $rules=[
            'user_name'=>'required',
            'charge_cost'=>'required|numeric'
        ];
        $val = Validator::make($request->all(),$rules);
        if($val->fails())
        {
            return redirect()->back()->withInput()->withErrors($val);
        }else{
            $cccode= rand(1000,5000);
            $user = User::find(Input::get('id'));
            if (Input::hasfile('pic')) {
                $extension = Input::file('pic')->getClientOriginalExtension();
                $fileName = rand(11111, 99999) . '.' . $extension;
                $destinationPath = 'Profile/';
                $url = asset('');
                $pic = input::file('pic')->move($destinationPath, $fileName);
                $user->pic = $url.$pic;
            }
            if (Input::has('password')) {
                $user->password = bcrypt($request->input('password'));
            }
            if (Input::has('user_name')) {
                $user->user_name = Input::get('user_name');
            }
            if (Input::has('email')) {
                $user->email = Input::get('email');
            }
            $user->v_code = $cccode;
            if (Input::has('phone')) {
                $user->phone = Input::get('phone');
            }
            if (Input::has('address')) {
                $user->address = Input::get('address');
            }
            if (Input::has('charge_cost')) {
                $user->charge_cost = Input::get('charge_cost');
            }
            if($user->update()){
                $user->categories()->sync((array) Input::get('categories_list'));
            }
            session()->flash('flash_message', 'Your idea has been submitted for Review');
            return Redirect::to("vendors?success")
                ->with('message', "تم تعديل $user->user_name بنجاح");


        }
    }

    public function product_show(){
        $product = Product::with('Images')
            ->leftjoin('category','products.cat_id','=','category.id')
            ->leftjoin('users','products.user_id','=','users.id')
            ->leftjoin('feed_back','products.id','=','feed_back.prod_id')
            ->groupBy( 'products.id','feed_back.prod_id' )
            ->select('products.id as product_id','products.id','products.views as product_viewer',
                'products.name as product_name','users.user_name as products_user','feed_back.rate as products_rate',
                'users.pic as products_user_pic','category.name as products_cat_name','products.desc as product_desc',
                'products.prepration_time as product_time','products.requirement as product_requirement','products.max_num as product_num',
                'products.img as product_pic_cover','products.price as product_price','products.created_at as product_created' )
            ->orderBy('product_created','ASC')
            ->get();

        $vendor = Product::with('Images')
            ->leftjoin('category','products.cat_id','=','category.id')
            ->leftjoin('users','products.user_id','=','users.id')
            ->leftjoin('feed_back','products.id','=','feed_back.prod_id')
            ->groupBy( 'products.id','feed_back.prod_id' )
            ->select('products.id as product_id','products.id','products.views as product_viewer',
                'products.name as product_name','users.user_name as products_user','feed_back.rate as products_rate',
                'users.pic as products_user_pic','category.name as products_cat_name','products.desc as product_desc',
                'products.prepration_time as product_time','products.requirement as product_requirement','products.max_num as product_num',
                'products.img as product_pic_cover','products.price as product_price','products.created_at as product_created' , DB::raw('SUBSTRING_INDEX(products.prepration_time, ":", 1) as preperationHour') ,DB::raw('SUBSTRING_INDEX(products.prepration_time, ":", -1) as preperationMin') )
            ->where('products.user_id',Auth::User()->id)
            ->orderBy('product_created','ASC')
            ->get();
        $currency = Nations::find(Auth::User()->nation_id);

        if(!$currency)
            $currency = "ريال سعودي";
        else
            $currency = $currency->currency_name;
        return view('admin.productsvendor.view')
            ->with('product',$product)
            ->with('vendor',$vendor)
            ->with('currRatio',$currency);
    }

    public function orders_view($id = null){
        $user_products = Product::select('id');
        if(Auth::User()->is_vendor == 1)
            $user_products = $user_products->where('user_id', '=', Auth::User()->id);
        $user_products = $user_products->pluck('id');

        // $order = ItemsOrder::whereIN('product_id', $user_products)->with(array('products', 'order' => function($q){$q->with('user');}))->get();
        $order_prepared = null;
        $order_under_process = null;
        $order_done = null;
        if($id == 1){
            $orders = ItemsOrder::whereIN('product_id', $user_products)->where('status', '=', 1)->with(array('products', 'order' => function($q){$q->with('user');}))->orderBy('created_at', 'desc')->get();
            $page_title = "الطلبات الجديدة";
        }
        elseif($id == 2){
            $orders = ItemsOrder::whereIN('product_id', $user_products)->whereIN('status',[3, 5, 4, 7])->with(array('products', 'order' => function($q){$q->with('user');}))->orderBy('created_at', 'desc')->get();
            $order_done = ItemsOrder::whereIN('product_id', $user_products)->whereIN('status',[7])->with(array('products', 'order' => function($q){$q->with('user');}))->orderBy('created_at', 'desc')->get();
            $order_under_process = ItemsOrder::whereIN('product_id', $user_products)->whereIN('status',[5])->with(array('products', 'order' => function($q){$q->with('user');}))->orderBy('created_at', 'desc')->get();
            $order_prepared = ItemsOrder::whereIN('product_id', $user_products)->whereIN('status',[6])->with(array('products', 'order' => function($q){$q->with('user');}))->orderBy('created_at', 'desc')->get();
            $page_title = "الطلبات المقبولة";
        }
        elseif($id == 3){
            $orders = ItemsOrder::whereIN('product_id', $user_products)->where('status', '=', 4)->with(array('products', 'order' => function($q){$q->with('user');}))->orderBy('created_at', 'desc')->get();
            $page_title = "الطلبات المرفوضة";
        }
        else
            return view('errors.404')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');

        return view('admin.orders.view_edit')
            ->with('orders',$orders)
            ->with('order_done',$order_done)
            ->with('order_under_process',$order_under_process)
            ->with('order_prepared',$order_prepared)
            ->with('page_title',$page_title)
            ->with('id', $id);
    }

    public function orders_viewEX($id = null, $today = null){
        $user_products = Product::select('id');

        $order_date = Request()->input('orderDate') ? Request()->input('orderDate') : null;



        if(Auth::User()->is_vendor == 1)
            $user_products = $user_products->where('user_id', '=', Auth::User()->id);
        $user_products = $user_products->pluck('id');

        if($id == 0)
            $orders = ItemsOrder::whereIN('product_id', $user_products)->with(array('products', 'order' => function($q){$q->with('user');}));
        elseif($id == 1)
            $orders = ItemsOrder::whereIN('product_id', $user_products)->where('status', '=', 1)->with(array('products', 'order' => function($q){$q->with('user');}));
        elseif($id == 2)
            $orders = ItemsOrder::whereIN('product_id', $user_products)->where('status', '=', 2)->with(array('products', 'order' => function($q){$q->with('user');}));
        elseif($id == 3)
            $orders = ItemsOrder::whereIN('product_id', $user_products)->where('status', '=', 3)->with(array('products', 'order' => function($q){$q->with('user');}));
        elseif($id == 4)
            $orders = ItemsOrder::whereIN('product_id', $user_products)->where('status', '=', 4)->with(array('products', 'order' => function($q){$q->with('user');}));
        elseif($id == 5)
            $orders = ItemsOrder::whereIN('product_id', $user_products)->whereIN('status',[5])->with(array('products', 'order' => function($q){$q->with('user');}));
        elseif($id == 6)
            $orders = ItemsOrder::whereIN('product_id', $user_products)->whereIN('status',[6])->with(array('products', 'order' => function($q){$q->with('user');}));
        elseif($id == 7)
            $orders = ItemsOrder::whereIN('product_id', $user_products)->whereIN('status',[7])->with(array('products', 'order' => function($q){$q->with('user');}));
        else
            return view('errors.404')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');


        if($order_date)
            $orders = $orders->where('date',$order_date);


        // dd($today);

        if($today == 1)
            $orders = $orders->whereRaw('Date(created_at) = CURDATE()');
        else
            $orders = $orders->where('created_at', '>', '2018-04-23');

        DB::enableQueryLog();
        $orders = $orders->orderBy('created_at', 'desc')->get();

        // print_r($orders);

        // dd(
        //     DB::getQueryLog()
        // );
        // die();
        // $new_orders = ItemsOrder::whereIN('product_id', $user_products)->where('status', '=', 1)->with(array('products', 'order' => function($q){$q->with('user');}))->orderBy('created_at', 'desc')->get();

        // $accepted_orders = ItemsOrder::whereIN('product_id', $user_products)->whereIN('status',[3, 5, 4, 7])->with(array('products', 'order' => function($q){$q->with('user');}))->orderBy('created_at', 'desc')->get();

        $page_title = "الطلبات";

        return view('admin.orders.view_edit')
            ->with('orders',$orders)
            ->with('page_title',$page_title)
            ->with('id', $id)
            ->with('today', $today)
            ->with('orderDate',$order_date);
            /*->with('order_done',$order_done)
            ->with('order_under_process',$order_under_process)
            ->with('order_prepared',$order_prepared)
            ->with('accepted_orders',$accepted_orders)
            ->with('new_orders',$new_orders)
            ->with('rejected_orders',$rejected_orders)*/
    }

    public function rate_view(){
        $rate = Feeds::select('*')
            ->leftjoin('users','feed_back.user_id','=','users.id')
            ->leftjoin('products','feed_back.prod_id','=','products.id')
            ->groupBy( 'products.id')
            ->select('feed_back.id as feed_id','feed_back.notes_product as feed_notes',
                'users.user_name as feed_user',
                'products.is_product as feed_type_prod','products.name as feed_name_pro',
                'feed_back.created_at as feed_time',
                DB::raw(" IFNULL(avg(feed_back.rate),0) AS feed_rate"))
            ->get();

        $rate_vendor = Feeds::select('*')
            ->leftjoin('users','feed_back.user_id','=','users.id')
            ->leftjoin('products','feed_back.prod_id','=','products.id')
            ->groupBy( 'products.id')
            ->select('feed_back.id as feed_id','feed_back.notes_product as feed_notes',
                'users.user_name as feed_user',
                'products.is_product as feed_type_prod','products.name as feed_name_pro',
                'feed_back.created_at as feed_time',
                DB::raw(" IFNULL(avg(feed_back.rate),0) AS feed_rate"))
            ->where('products.user_id',Auth::User()->id)
            ->get();
        return view('admin.rate.view')
            ->with('rate_vendor',$rate_vendor)
            ->with('rate',$rate);


    }

    public function ORSTR ($id){

        $success = Input::get('success');
        $ord_st = Order::find($id);
        if ($ord_st) {
            DB::table('order_product')
                ->where('id', $id)
                ->update(['status' => 1]);
            return Redirect::to("/vendors/orders/view?success=$ord_st->id");
        } else {
            return View::make('notfound')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');
        }

    }

    public function INPro ($id){

        $success = Input::get('success');

        $ord_st = Order::find($id);
        if ($ord_st) {
            DB::table('order_product')
                ->where('id', $id)
                ->update(['status' => 2]);
            return Redirect::to("/vendors/orders/view?success=$ord_st->id");
        } else {
            return View::make('notfound')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');
        }

    }

    public function prepare ($id){

        $success = Input::get('success');

        $ord_st = Order::find($id);
        if ($ord_st) {
            DB::table('order_product')
                ->where('id', $id)
                ->update(['status' => 5]);

            $this->storeLogs($id, 'order', Auth::user()->id, 'تم تغيير حالة الطلب رقم ' . $id . ' إلى قيد الانتظار');
            return Redirect::to("/vendors/orders/view?success=$ord_st->id")
                ->with('message', "order number $ord_st->id in prepare");

        } else {
            return View::make('notfound')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');
        }

    }

    public function processing ($id){
        $success = Input::get('success');
        $ord_st = Order::find($id);
        if ($ord_st) {
            DB::table('order_product')
                ->where('id', $id)
                ->update(['status' => 6]);
            return Redirect::to("/vendors/orders/view?success=$ord_st->id")
                ->with('message', "order number $ord_st->id processing now");

        } else {
            return View::make('notfound')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');
        }
    }

    public function completed ($id){
        $success = Input::get('success');
        $ord_st = Order::find($id);
        if ($ord_st) {
            DB::table('order_product')
                ->where('id', $id)
                ->update(['status' => 7]);



            return Redirect::to("/vendors/orders/view?success=$ord_st->id")
                ->with('message', "order number $ord_st->id completed");

        } else {
            return View::make('notfound')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');
        }
    }

    public function started ($id){
        $success = Input::get('success');
        $started = Order::find($id);
        if ($started) {
            DB::table('order_product')
                ->where('id', $id)
                ->update(['status' => 1]);

                $this->storeLogs($id, 'order', Auth::user()->id, 'تم تغيير حالة الطلب رقم ' . $id . ' إلى قيد الانتظار');
            return Redirect::to("/vendors/orders/view?success=$started->id")
                ->with('message', "order number $started->id started");

        } else {
            return View::make('notfound')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');
        }
    }

    public function progress ($id){
        $success = Input::get('success');
        $progress = Order::find($id);
        if ($progress) {
            DB::table('order_product')
                ->where('id', $id)
                ->update(['status' => 2]);

            // $this->storeLogs($id, 'order', Auth::user()->id, 'تم تغيير حالة الطلب رقم ' . $id . ' إلى مكتمل');
            return Redirect::to("/vendors/orders/view?success=$progress->id")
                ->with('message', "order number $progress->id  in progress");

        } else {
            return View::make('notfound')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');
        }
    }

    public function Completed_stat ($id){
        $success = Input::get('success');
        $completed = Order::find($id);
        if ($completed) {
            DB::table('order_product')
                ->where('id', $id)
                ->update(['status' => 3]);
            return Redirect::to("/vendors/orders/view?success=$completed->id")
                ->with('message', "order number $completed->id  started");

        } else {
            return View::make('notfound')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');
        }
    }

    public function accept ($id){
        $success = Input::get('success');
        $accept = Order::find($id);
        if ($accept) {
            DB::table('order_product')
                ->where('id', $id)
                ->update(['status' => 3]);
            return Redirect::to("/vendors/orders/view?success=$accept->id")
                ->with('message', "order number $accept->id  was Accepted");

        } else {
            return View::make('notfound')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');
        }
    }

    function acceptOrderItem($id){
        $itemOrder = ItemsOrder::find($id);

        if($itemOrder){
            $itemOrder->status = 3;

            if($itemOrder->save()){
                /*$orderCountByStatus = Order::where('status','1')->where('id',$itemOrder->order_id)->count();

                if($orderCountByStatus == 0)
                    Order::where('id',$itemOrder->order_id)->update([]);*/
                $orderUser = Order::where('id',$itemOrder->order_id)->first();
                $product = Product::where('id',$itemOrder->product_id)->first();
                $this->sendNotificationsToUser("تم قبول طلبكم : " . $product->name,"",$orderUser->user_id);
                $this->storeLogs($id, 'order', Auth::user()->id, 'تم قبول المنتج الخاص بالطلب رقم ' . $id);
                return back()->with('message', " تم قبول الطلب ");
            }else{
                return back()->with('danger', " خطأ في قبول الطلب ");
            }
        }else{
            return View::make('notfound')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');
        }
    }

    function refuseOrderItem($id){
        $itemOrder = ItemsOrder::find($id);

        if($itemOrder){
            $itemOrder->status = 4;

            if($itemOrder->save()){
                $orderUser = Order::where('id',$itemOrder->order_id)->first();
                $product = Product::where('id',$itemOrder->product_id)->first();
                $this->sendNotificationsToUser("Your order refused " . $product->name,"",$orderUser->user_id);
                $this->storeLogs($id, 'order', Auth::user()->id, 'تم رفض المنتج الخاص بالطلب رقم ' . $id);
                return back()->with('message', " تم رفض الطلب ");
            }else{
                return back()->with('danger', " خطأ في رفض الطلب ");
            }
        }else{
            return View::make('notfound')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');
        }
    }

    function startedOrderItem($id){
        $itemOrder = ItemsOrder::find($id);

        if($itemOrder){
            $itemOrder->status = 1;

            if($itemOrder->save()){
                $orderUser = Order::where('id',$itemOrder->order_id)->first();
                $product = Product::where('id',$itemOrder->product_id)->first();
                $this->sendNotificationsToUser("  طلبكم قيد الانتظار : " . $product->name,"",$orderUser->user_id);

                $this->storeLogs($id, 'order', Auth::user()->id, 'تم تغيير حالة الطلب رقم ' . $id . ' إلى قيد الانتظار');
                return back()->with('message', " تم تعديل حالة الطلب ");
            }else{
                return back()->with('danger', " خطأ في تعديل حالة الطلب ");
            }
        }else{
            return View::make('notfound')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');
        }
    }

    public function prepareOrderItem($id){
        $itemOrder = ItemsOrder::find($id);

        if($itemOrder){
            $itemOrder->status = 5;

            if($itemOrder->save()){
                $this->storeLogs($id, 'order', Auth::user()->id, 'تم تغيير حالة الطلب رقم ' . $id . ' إلى قيد التحضير');
                $orderUser = Order::where('id',$itemOrder->order_id)->first();
                $product = Product::where('id',$itemOrder->product_id)->first();
                $this->sendNotificationsToUser("  الطلب قيد التحضير : " . $product->name,"",$orderUser->user_id);
                return back()->with('message', " تم تعديل حالة الطلب ");
            }else{
                return back()->with('danger', " خطأ في تعديل حالة الطلب ");
            }
        }else{
            return View::make('notfound')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');
        }
    }

    public function processingOrderItem($id){
        $itemOrder = ItemsOrder::find($id);

        if($itemOrder){
            $itemOrder->status = 6;

            if($itemOrder->save()){
                $orderUser = Order::where('id',$itemOrder->order_id)->first();
                $product = Product::where('id',$itemOrder->product_id)->first();
                $this->sendNotificationsToUser("الطلب قيد التنفيذ : " . $product->name,"",$orderUser->user_id);
                $this->storeLogs($id, 'order', Auth::user()->id, 'تم تغيير حالة الطلب رقم ' . $id);
                return back()->with('message', " تم تعديل حالة الطلب ");
            }else{
                return back()->with('danger', " خطأ في تعديل حالة الطلب ");
            }
        }else{
            return View::make('notfound')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');
        }
    }

    public function completedOrderItem($id){
        $itemOrder = ItemsOrder::find($id);

        if($itemOrder){
            $itemOrder->status = 7;

            if($itemOrder->save()){
                $orderUser = Order::where('id',$itemOrder->order_id)->first();
                $product = Product::where('id',$itemOrder->product_id)->first();
                $this->sendNotificationsToUser(" طلبكم اكتمل " . $product->name,"",$orderUser->user_id);
                $orderCountByStatus = Order::where('status','<>','7')->where('id',$itemOrder->order_id)->count();

                if($orderCountByStatus == 0)
                    Order::where('id',$itemOrder->order_id)->update(['status' => 7]);
                $this->storeLogs($id, 'order', Auth::user()->id, 'تم تغيير حالة الطلب رقم ' . $id . ' إلى مكتمل');

                return back()->with('message', " تم تعديل حالة الطلب ");
            }else{
                return back()->with('danger', " خطأ في تعديل حالة الطلب ");
            }
        }else{
            return View::make('notfound')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');
        }
    }


    public function refuse ($id){
        $success = Input::get('success');
        $refuse = Order::find($id);
        if ($refuse) {
            DB::table('order_product')
                ->where('id', $id)
                ->update(['status'=> 4]);
            $this->sendNotificationsToUser("Your order number $refuse->id refused" ,"",$refuse->user_id);

            $this->storeLogs($id, 'order', Auth::user()->id, 'تم رفض الطلب رقم ' . $id );

            return Redirect::to("/vendors/orders/view?success=$refuse->id")
                ->with('message', "order number $refuse->id  was Refuesd");

        } else {
            return View::make('notfound')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');
        }
    }

    public function add_new_product(Request $request)
    {
        $product_images = [];
        //dd($request->all());
        $validator = Validator::make(input::file(), [
            'pic' => 'max:4120',
        ]);

        $product = new Product();
        $product->id = input::get('id');
        $product->name = input::get('name');
        $product->cat_id = input::get('cat_id');
        $product->user_id = Auth::User()->id;
        $product->desc = input::get('desc');
        $product->status = 0;
        $product->fawry = input::get('fawry');
        $product->gender = input::get('gender');
        if (Input::hasfile('pic')) {
            $extension = Input::file('pic')->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . '.' . $extension;
            $destinationPath = 'Product/';
            $url = asset('');
            $pic = input::file('pic')->move($destinationPath, $fileName);
            $product->img = $url . $pic;
        }
        $files = $request->file('img');
        foreach($files as $file){
            $extension_pic_pro = $file->getClientOriginalName();
            $fileName_pic_pro = rand(11111, 99999) . '.' . $extension_pic_pro;
            $destinationPath_pic_pro = 'Product/';
            $pic_pro = $file->move($destinationPath_pic_pro, $fileName_pic_pro);
            $url = asset('');

            $product_images[] = $url . $pic_pro;
        }
        $productQunt = input::get('qunt');
        $product->price = floatval(input::get('price'));
        //$product->prepration_time = input::get('prepration_time');
        // $product->prepration_time = input::get('preperation_hour') . ":" . input::get('preperation_min');
        $product->max_num = input::get('max_num');
        $product->requirement = input::get('requirement');
        if($product->save()){
            foreach ($product_images as $product_image ){
                $product_image_model = new Images();
                $product_image_model->product_id = $product->id;
                $product_image_model->pic = $product_image;
                $product_image_model->save();
            }

            foreach($productQunt as $k => $genderIdx){
                foreach ($genderIdx as $Idx => $value){
                    //$product->productavailabilty()->save
                    foreach ($value as $key => $v){
                        //if($v > 0) {
                            $productDayQunt = new ProductAvailibility();
                            $productDayQunt->product_id = $product->id;
                            $productDayQunt->day_no = $k;
                            $productDayQunt->gender = $Idx;
                            $productDayQunt->period = $key;
                            $productDayQunt->quantity = $v;
                            $productDayQunt->save();
                        //}
                    }
                }
            }

            $this->sendNotifications(" مقدم الخدمة -  " . Auth::User()->user_name . " - اضاف منتج جديد " . $product->name , "اضافة منتج" , 1,url("/admin/getproduct/" . $product->id));

        }

        return Redirect::to("/vendors/product/view")
            ->with('message', "تم إضافة $product->name بنجاح");
    }

    public function product_edit($id)
    {
        $pro_dic = Product::find($id);

        $success = Input::get('success');
        //dd($pro_dic->toArray());
        if ($pro_dic ) {
            $userCats = auth()->user()->categories()->get();
            $weekDays = [6 => "السبت",0 => "الاحد", 1 => "الاثنين",2 => "الثلاثاء",3 => "الاربعاء", 4 => "الخميس",5 => "الجمعة"];
            $availablePeriodes = ProductAvailibility::where("product_id",$id)->get();
            $availablePeriodesProduct = [];
            $pro_dic->price = floatval($pro_dic->price);

            // $preperation_time = explode(":",$pro_dic->prepration_time);

            //            dd($pro_dic->toArray());
            foreach ($availablePeriodes as $v){
                $availablePeriodesProduct[$v->day_no][$v->gender][$v->period] = $v->quantity;
            }

            //dd($availablePeriodesProduct);
            return view('admin.productsvendor.edit')
                ->with('success', $success)
                ->with('pro_dic', $pro_dic)
                ->with(['userCategories' => $userCats , "weekDays" => $weekDays , 'availablePeriodesProduct' => $availablePeriodesProduct]);
        } else {
            return View('admin.productsvendor.edit',['Product' => Product::findOrFail($id)])
                ->with('title', 'Error Page Not Found');
        }
    }

    public function updateProductsWithNewGeder(){
        $productIds = Product::all()->pluck("id");
        dd($productIds);
    }

    public function deleteProductImg(Request $request){
        $messages = [
            'imageId.required' => 'رقم الصورة الزامي',
            'imageId.exists' => 'رقم الصورة غير صحيح',

        ];
        $validator = Validator::make(
            $request->all(),
            array(
                'imageId' => 'required|exists:product_image,id',

            ),
            $messages
        );
        if($validator->fails()) {
            return response()->json(['status'=>false,'error' => $validator->errors()])->setStatusCode(200);
        }else{
            $image = Images::find($request->imageId);
            $image->delete();

            return response()->json(['status'=>true , 'id' => $request->imageId ])->setStatusCode(200);
        }

    }

    public function product_update(Request $request)
    {
        $ports = Product::find(Input::get('id'));
        if (Input::has('name')) {
            $ports->name = input::get('name');
        }
        if (Input::has('cat_id')) {
            $ports->cat_id = input::get('cat_id');
        }
        if (Input::has('desc')) {
            $ports->desc = input::get('desc');
        }
        if(Input::has('fawry')){
            $ports->fawry = input::get('fawry');
        }
        if (Input::has('price')) {
            $ports->price = floatval(input::get('price'));
        }
        //dd(floatval($this->getCurrencyRate('SAR','USD')));
        if (Input::has('gender')) {
            $ports->gender = input::get('gender');
        }
        if (Input::has('is_package')) {
            $ports->is_package = input::get('is_package');
        }
        if (Input::has('is_product')) {
            $ports->is_product = input::get('is_product');
        }
        /*if (Input::has('prepration_time')) {
            $ports->prepration_time = input::get('prepration_time');
        }*/
        if (Input::has('preperation_hour') && Input::has('preperation_min')) {
            $ports->prepration_time = input::get('preperation_hour') . ":" . input::get('preperation_min');
        }
        //if (Input::has('requirement')) {
            $ports->requirement = input::get('requirement');
        //}
        if (Input::has('town_id')) {
            $ports->town_id = input::get('town_id');
        }
        if (Input::hasfile('pic')) {
            $extension = Input::file('pic')->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . '.' . $extension;
            $destinationPath = 'Product/';
            $url = asset('');
            $pic = input::file('pic')->move($destinationPath, $fileName);
            $ports->img = $url . $pic;
        }
        if (Input::hasfile('img')) {
            $files = $request->file('img');
            foreach($files as $file){
                $extension_pic_pro = $file->getClientOriginalName();
                $fileName_pic_pro = rand(11111, 99999) . '.' . $extension_pic_pro;
                $destinationPath_pic_pro = 'Product/';
                $pic_pro = $file->move($destinationPath_pic_pro, $fileName_pic_pro);
                $url = asset('');

                $product_images[] = $url . $pic_pro;
            }
        }
        $ports->status = 0;
        $productQunt = input::get('qunt');
        ProductAvailibility::where("product_id",Input::get('id'))->delete();
        if($productQunt && count($productQunt) > 0){
            foreach($productQunt as $k => $genderIdx){
                foreach ($genderIdx as $Idx => $value){
                    //$product->productavailabilty()->save
                    foreach ($value as $key => $v){
                            //                        if($v > 0) {
                            $productDayQunt = new ProductAvailibility();
                            $productDayQunt->product_id = Input::get('id');
                            $productDayQunt->day_no = $k;
                            $productDayQunt->gender = $Idx;
                            $productDayQunt->period = $key;
                            $productDayQunt->quantity = $v;
                            $productDayQunt->save();
                    //                        }
                    }
                }
            }
        }

        if($ports->save()){
            //dd($ports->gender);
            if(isset($product_images)){
                foreach ($product_images as $product_image ){
                    $product_image_model = new Images();
                    $product_image_model->product_id = $ports->id;
                    $product_image_model->pic = $product_image;
                    $product_image_model->save();
                }
            }
            $this->sendNotifications(" مقدم الخدمة " . Auth::User()->user_name . " - عدل المنتج : " . $ports->name , "تعديل منتج" , 1,url("/admin/getproduct/" . $ports->id));
        }
        session()->flash('flash_message', 'Your idea has been Edit for Review');
        return Redirect::to("/vendors/product/view?success=$ports->id")
            ->with('message', "تم تعديل $ports->name بنجاح");
    }

    public function Del_Product($id) {
        $Product = Product::find($id);

        if ($Product) {
            Product::where('id', $id)->delete();
            return Redirect::to("/vendors/product/view?success=$Product->id")
                ->with('message', "تم حذف $Product->name بنجاح");

        } else {
            return view('notfound')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');
        }
    }

    public function delete_order($id) {
        $order = ItemsOrder::findOrFail($id);

        if ($order->delete()) {
            return back()
                ->with('message', "تم حذف الطلب بنجاح");

        } else {
            return view('notfound')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');
        }
    }

    public function productDateException($product_id ){
        $vendor_product = Product::where('id' , $product_id)->where('user_id' ,Auth::user()->id )->first();

        if($vendor_product) {
            $vendor_products_exeptions = ProductExeption::with('Products')->where('product_id' , $product_id)->whereHas('Products', function ($q) {
                $q->where('user_id', Auth::user()->id);
            })->get();

            return view('admin.date_exeption.index')
                ->with([
                    'vendor_product_Exeption' => $vendor_products_exeptions,
                    'product_id' => $product_id
                ]);
        }else{
            return redirect()->back();
        }
    }

    public function productDateExceptionAdd($id , Request $request){

        $validator = Validator::make(
            $request->all(),
            [
                'exception_date' => 'required|date_format:Y-m-d',

            ]
        );

        if($validator->fails()){
            return redirect()
                ->back()
                ->with('errormsg','صيغة التاريخ خطأ');
        }else{
            $vendor_product = Product::where('id' , $id)->where('user_id' ,Auth::user()->id )->first();
            if($vendor_product) {
                $check_date = ProductExeption::where('product_id' , $id)
                                                ->where('date' , $request->exception_date)->first();

                if($check_date)
                    return redirect()
                        ->back()
                        ->with('errormsg','التاريخ مسجل مسبقا');

                $exception_date = new ProductExeption();
                $exception_date->product_id = $id;
                $exception_date->date = $request->exception_date;

                if($exception_date->save()){
                    return $this->productDateException($id);
                }else{
                    return redirect()
                        ->back()
                        ->with('errormsg','خطأ في اضافة التاريخ');
                }
            }else{
                return redirect()
                    ->back()
                    ->with('errormsg','رقم المنتج خطأ');
            }
        }


    }

    public function productDateExceptionDelete($id){
        // check for that date
        $exception_date = ProductExeption::find($id);

        if($exception_date){
            $vendor_product = Product::where('id' , $exception_date->product_id)->where('user_id' ,Auth::user()->id )->first();

            if($vendor_product){
                $exception_date->delete();

                return redirect('/vendors/product/exception/' . $vendor_product->id);
            }

            $outputMsg = "لا يمكن مسح هذا اليوم";
        }else{
            $outputMsg = "اليوم غير موجود";
        }

        return redirect()
            ->back()
            ->with('errormsg',$outputMsg);
    }

    public function getBranch(){
        $user = Auth::user();
        $branches = Branches::where('user_id',$user->id)->first();

        //dd($branches);
        return view('admin.branches.view')
            ->with([

                'branch' => $branches
            ]);
    }

    public function addBranch(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'branchLat' => 'required|numeric',
                'branchLong' => 'required|numeric'

            ]
        );

        if($validator->fails()){
            return redirect()
                ->back()
                ->with('errormsg','يجب اختيار موقع صحيح على الخريطة');
        }else{

            $branch = Branches::where('user_id' , Auth::user()->id)->first();

            if(!$branch){
                $branch = new Branches();
                $branch->user_id = Auth::user()->id;
            }


            $branch->branch_lat = $request->branchLat;
            $branch->branch_long = $request->branchLong;


            $branch->save();
            if($branch->save()){
                try{

                    // Login
                    $data = array(
                        "email" => e("orders@ratb.li"),
                        "password" => "123456",

                    );
                    $data_string = json_encode($data);

                    $ch = curl_init('https://jiibli.sa/app/api/login');
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Accept:application/json',
                            'Content-Type: application/json',
                            'Content-Length: ' . strlen($data_string)
                        )
                    );
                    $result = curl_exec($ch);
                    dd($result);
                    if ($result === FALSE) {
                        Log::error('Curl failed: ' . curl_error($ch));
                    }
                    else{
                        //echo $result;

                    }
                }catch (\Exception $e){
                    return redirect()
                        ->back()
                        ->with('errormsg','خطأ في تسجيل الموقع لدى موقع التوصيل');
                }
                return redirect()
                    ->back()
                    ->with('message','تم تسجيل الموقع بنجاح');
            }else{
                return redirect()
                    ->back()
                    ->with('errormsg','خطأ في اضافة الموقع');
            }
        }
    }

    public function User_view(){
        $user = User::select('*')
            ->leftjoin('roles','roles.user_id','=','users.id')
            ->select('users.user_name as user_name','users.email as email','users.phone as phone','users.address as address','users.v_code as v_code','users.verified as verified','roles.vendor_id as vendor_id','roles.is_sales as is_sales','roles.is_account as is_cook','roles.user_id as user_id','roles.is_account as is_account','users.is_privillage as is_privillage')
            ->where('roles.vendor_id','=',Auth::user()->id)
            ->get();

        return view('vendor.users.view')
            ->with('user',$user);
        }

    public function User_save(Request $request){
        $rules=[
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required|unique:users',
            'user_name'=>'required',
            'password'=>'required'
        ];
        $val = Validator::make($request->all(),$rules);
        if($val->fails())
        {
            return redirect()->back()->withInput()->withErrors($val);
        }else {
            $code= rand(1000,5000);
            $users = new User();
            $users->id = input::get('id');
            $users->user_name = input::get('user_name');
            $users->email = input::get('email');
            $users->password = bcrypt($request->input('password'));
            if (Input::hasfile('pic')) {
                $extension_pic = Input::file('pic')->getClientOriginalExtension();
                $fileName_pic = rand(11111, 99999) . '.' . $extension_pic;
                $destinationPath_pic = 'Profile/';
                $pic = Input::file('pic')->move($destinationPath_pic, $fileName_pic);
                $url = asset('');
                $users->pic = $url.$pic;
            }
            $users->phone = input::get('phone');
            $users->nation_id = Auth::user()->nation_id;
            $users->v_code = $code;
            $users->is_privillage = $request->is_privillage;
            $users->address = input::get('address');
            if($users->save()){
                $role = new Roles();
                $role->user_id = $users->id ;
                $role->vendor_id = Auth::user()->id ;
                if(Input::has('is_sales')) {
                    $role->is_sales = $request->is_sales;
                }
                if(Input::has('is_account')) {
                    $role->is_account = $request->is_account;
                }
                if(Input::has('is_cook')) {
                    $role->is_cook = $request->is_cook;
                }
                $role->save();
            }
            return Redirect::to("/vendors/user/view?success=$users->id")
                ->with('message', "تم إضافة $users->user_name بنجاح");
        }

    }

    public function edit_user_($id){
        $users = User::with('categories')->find($id);

        $success = Input::get('success');

        $categories = Category::lists('name', 'id');

        $user_category = [];
        $can_update = false;
        if($users['categories']){
            $user_categories = $users['categories']->toArray();

            foreach($user_categories as $userCats){
                $user_category[] = $userCats['id'];
            }
        }


        if($id == \Auth::user()->id)
            $can_update = true;

        if ($users) {
            return view('vendor.users.edit')
                ->with('success', $success)
                ->with('categories', $categories)
                ->with('user_categories', $user_category)
                ->with('users', $users)
                ->with('can_update', $can_update);
        } else {
            return View('vendor.users.edit',['user' => User::findOrFail($id)])
                ->with('title', 'Error Page Not Found')
                ->with('danger',"No user found");

        }
    }

    public function update_User_Vendor(Request $request) {
        $rules=[
            'email' => 'required|email',
            'phone' => 'required|unique:users,phone,'.Input::get('id').',id',
            'user_name'=>'required',
        ];
        $val = Validator::make($request->all(),$rules);
        if($val->fails())
        {
            return redirect()->back()->withErrors($val);
        }else{
            $cccode= rand(1000,5000);
            $user = User::find(Input::get('id'));
            if (Input::hasfile('pic')) {
                $extension = Input::file('pic')->getClientOriginalExtension();
                $fileName = rand(11111, 99999) . '.' . $extension;
                $destinationPath = 'Profile/';
                $url = asset('');
                $pic = input::file('pic')->move($destinationPath, $fileName);
                $user->pic = $url.$pic;
            }
            if (Input::has('password')) {
                $user->password = bcrypt($request->input('password'));
            }
            if (Input::has('user_name')) {
                $user->user_name = Input::get('user_name');
            }
            if (Input::has('email')) {
                $user->email = Input::get('email');
            }
            $user->v_code = $cccode;
            if (Input::has('phone')) {
                $user->phone = Input::get('phone');
            }
            if (Input::has('address')) {
                $user->address = Input::get('address');
            }

            if($user->update()){
                $this->storeLogs(Input::get('id'), 'user', Auth::user()->id, 'تم تعديل المستخدم ' . $user->user_name . ' رقم ' . Input::get('id'));
                $user->categories()->sync((array) Input::get('categories_list'));
            }
            session()->flash('flash_message', 'Your idea has been submitted for Review');
            return Redirect::to("/vendors/user/view")
                ->with('message',"your profile $user->user_name updated");
        }

    }


    public function Verifed ($id){
        $success = Input::get('success');
        $users_v = User::find($id);
        if ($users_v) {
            DB::table('users')
                ->where('id', $id)
                ->update(['verified' => 1, 'blocked' => 0]);

            $this->sendNotificationsToUser("تم تفعيل حسابك ","",$id);

            return Redirect::to("/vendors/user/view/?success=$users_v->id")
                ->with('message', "user successfully verified $users_v->id");

        } else {
            return View::make('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('danger', 'No user found');
        }

    }

    public function Verify ($id){

        $users_v = User::find($id);
        if ($users_v) {
            DB::table('users')
                ->where('id', $id)
                ->update(['verified' => 1, 'blocked' => 0]);

            $this->sendNotificationsToUser("تم تفعيل حسابك ","",$id);

            return back()->with('message', 'تم تفعيل المستخدم');

        } else {
            return View::make('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('danger', 'No user found');
        }

    }

    public function UN_Verifed ($id){
        $success = Input::get('success');
        $users_v = User::find($id);
        if ($users_v) {
            DB::table('users')
                ->where('id', $id)
                ->update(['verified' => 0,'is_vendor' => 0 ,'is_admin' => 0 , 'blocked' => 1]);

            $this->storeLogs($id, 'user', Auth::user()->id, 'تم ايقاف المستخدم ' . $users_v->user_name . ' رقم ' . $id);

            $this->sendNotificationsToUser("تم ايقاف حسابك","",$id);
            return Redirect::to("/vendors/user/view?success=$users_v->id")
                ->with('message', "user successfully unverified $users_v->id");

        } else {
            return View::make('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('danger', 'No user found');
        }

    }

    public function MK_cook($id){
        $success = Input::get('success');
        $users_v = User::find($id);
        if ($users_v) {
            DB::table('roles')
                ->where('user_id', $id)
                ->update(['is_sales' => 0,'is_account' => 0,'is_cook' =>3]);
            DB::table('users')
                ->where('id', $id)
                ->update(['is_privillage' => 3]);


            $this->sendNotificationsToUser("تم اضافة صلاحيات المطبخ للمستخدم","",$id);

            $this->storeLogs($id, 'user', Auth::user()->id, 'تم اضافة صلاحيات المطبخ للمستخدم  ' . $users_v->user_name . ' رقم ' . $id);
            return Redirect::to("/vendors/user/view?success=$users_v->id")
                ->with('message', "user successfully added as admin $users_v->id");
            return;
        } else {
            return View::make('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('danger', 'No user found');
        }

    }

    public function MK_market($id){
        $success = Input::get('success');
        $users_v = User::find($id);
        if ($users_v) {
            DB::table('roles')
                ->where('user_id', $id)
                ->update(['is_sales' => 2,'is_account' => 0,'is_cook' =>0]);
            DB::table('users')
                ->where('id', $id)
                ->update(['is_privillage' => 2]);


            $this->sendNotificationsToUser("تم اضافة صلاحيات السوق للمستخدم","",$id);

            $this->storeLogs($id, 'user', Auth::user()->id, 'تم اضافة صلاحيات السوق للمستخدم  ' . $users_v->user_name . ' رقم ' . $id);
            return Redirect::to("/vendors/user/view?success=$users_v->id")
                ->with('message',  'تم اضافة صلاحيات متابعه السوق للمستخدم  ' . $users_v->user_name . ' رقم ' . $id);
            return;
        } else {
            return View::make('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('danger', 'No user found');
        }

    }

    public function MK_account($id){
        $success = Input::get('success');
        $users_v = User::find($id);
        if ($users_v) {
            DB::table('roles')
                ->where('user_id', $id)
                ->update(['is_sales' => 1,'is_account' => 1,'is_cook' =>0]);
            DB::table('users')
                ->where('id', $id)
                ->update(['is_privillage' => 1]);


            $this->sendNotificationsToUser("تم اضافة صلاحيات الحسابات للمستخدم","",$id);

            $this->storeLogs($id, 'user', Auth::user()->id, 'تم اضافة صلاحيات الحسابات للمستخدم  ' . $users_v->user_name . ' رقم ' . $id);
            return Redirect::to("/vendors/user/view?success=$users_v->id")
                ->with('message',  'تم اضافة صلاحيات متابعه الحسابات للمستخدم  ' . $users_v->user_name . ' رقم ' . $id);
            return;
        } else {
            return View::make('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('danger', 'No user found');
        }


    }

}