<?php

namespace App\Http\Controllers;

use App\Category;
use App\Feeds;
use App\ItemsOrder;
use App\Product;
use App\WebNotification;
use Auth;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Cookie;

class AccountController extends Controller
{
    public function __construct(CookieJar $cookieJar, Request $request)
    {

        $this->middleware('auth');
        $id = \Request::segment(4);
        if(Auth::user()->verified != 1 && Auth::user()->is_privillage != 1){
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



        //  dd($user_vendor);
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
    public function orders_viewEX($id = null, $today = null){

        $user_id = Auth::User()->id;
        $user_vendor = User::select('*')
            ->leftjoin('roles','roles.vendor_id','=','users.id')
            ->where('roles.user_id',$user_id)
            ->get();

       // dd($user_vendor[0]->vendor_id);
        $user_products = Product::select('id')->where('user_id',$user_vendor[0]->vendor_id);

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

        $page_title = "الطلبات";

        return view('vendor.view_edit')
            ->with('orders',$orders)
            ->with('page_title',$page_title)
            ->with('id', $id)
            ->with('today', $today)
            ->with('orderDate',$order_date);
    }

    public function UserNotifications_account(){
        $user = auth()->user();
        $notifications = WebNotification::where('user_id',$user->id)->orderBy('created_at','desc')->get();
        WebNotification::where('user_id',$user->id)->update(['seen'=>1]);
        //dd($notifications->toArray());
        return View('vendor.notifications')->with('userNotifications',$notifications);
    }


}
