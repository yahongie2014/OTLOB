<?php

namespace App\Http\Controllers;

use App\Category;
use App\Feeds;
use App\ItemsOrder;
use App\Nations;
use App\Product;
use App\User;
use App\WebNotification;
use Auth;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SalesController extends Controller
{
    public function __construct(CookieJar $cookieJar, Request $request)
    {
        $this->middleware('auth');

        $id = \Request::segment(4);

        if(Auth::user()->verified != 1 && Auth::user()->is_privillage != 2){
            Auth::logout();
            return Redirect::to('/')->with('danger','برجاء مراجعة الايميل الشخصي المسجل لدينا لتفعيل حسابك - أو تواصل مع مسئول الدعم الفني');

        }
        if($request->referrer){
            $cookieJar->queue(cookie('referrer', $request->referrer, 45000));
        }


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = Auth::User()->id;
        $user_vendor = User::select('*')
            ->leftjoin('roles','roles.vendor_id','=','users.id')
            ->where('roles.user_id',$user_id)
            ->get();

        $user_products = Product::select('id');
        $lang = $request->server('HTTP_ACCEPT_LANGUAGE');
        if(!$lang || $lang == '' || ($lang != 'en' && $lang !='ar')){
            $lang = 'ar';
        }
        $product_count = Product::select('*')
            ->leftjoin('users','users.id','=','products.user_id')
            ->where('products.user_id',$user_vendor[0]->vendor_id)
            ->count();
        $feed_count = Feeds::select('*')
            ->leftjoin('products','products.id','=','feed_back.prod_id')
            ->leftjoin('users','users.id','=','products.user_id')
            ->where('products.user_id',$user_vendor[0]->vendor_id)
            ->count();
        $order_count = ItemsOrder::select('*')
            ->leftjoin('products','order_items.product_id','=','products.id')
            ->leftjoin('users','users.id','=','products.user_id')
            ->where('products.user_id',$user_vendor[0]->vendor_id)
            ->count();

        Cookie::queue('referrer', true, 15);

        $categories = Category::where('lang', '=', $lang)->get();

        $categories_count = Product::select(DB::raw('SUM(views) as views'), 'cat_id')->where('user_id', '=', $user_vendor[0]->vendor_id)->groupBy('cat_id')->get();

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
                $count = $count->where('user_id', '=', $user_vendor[0]->vendor_id);
            $count = $count->first();


            $views[] = array('name' => $category->name, 'count' => $count['count']);
        }
        if(Auth::user()->is_vendor)
            $user_products->where('user_id', '=', $user_vendor[0]->vendor_id);
        $user_products = $user_products->get();

        $sales = array();
        $sales_object = ItemsOrder::select(DB::raw('SUM(total) as total'), DB::raw('YEAR(date) year'))->whereIN('product_id', $user_products)->groupBy('year')->get();
        foreach ($sales_object as $value) {
            $sales[] = $value['attributes'];
        }
        $statistics = array('views' => $views, 'sales' => $sales);


        return View('vendor.index')
            ->with('product_count',$product_count)
            ->with('feed_count',$feed_count)
            ->with('categories', $final_category)
            ->with('statistics', $statistics)
            ->withCookie(cookie('referrer', $request->referrer, 45000))
            ->with('order_count',$order_count);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function rate_view(){
        $user_id = Auth::User()->id;
        $user_vendor = User::select('*')
            ->leftjoin('roles','roles.vendor_id','=','users.id')
            ->where('roles.user_id',$user_id)
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
            ->where('products.user_id',$user_vendor[0]->vendor_id)
            ->get();
        return view('vendor.view')
            ->with('rate_vendor',$rate_vendor);

    }

    public function product_show(){
        $user_id = Auth::User()->id;
        $user_vendor = User::select('*')
            ->leftjoin('roles','roles.vendor_id','=','users.id')
            ->where('roles.user_id',$user_id)
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
            ->where('products.user_id',$user_vendor[0]->vendor_id)
            ->orderBy('product_created','ASC')
            ->get();
        $currency = Nations::find(Auth::User()->nation_id);

        if(!$currency)
            $currency = "ريال سعودي";
        else
            $currency = $currency->currency_name;
        return view('vendor.products')
            ->with('vendor',$vendor)
            ->with('user_vendor',$user_vendor)
            ->with('currRatio',$currency);
    }

    public function UserNotifications_sales(){

        $notifications = WebNotification::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->get();
        WebNotification::where('user_id',Auth::user()->id)->update(['seen'=>1]);
        return View('vendor.notifications')->with('userNotifications',$notifications);
    }



}
