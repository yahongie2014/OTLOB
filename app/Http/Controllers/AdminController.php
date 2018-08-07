<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\info;
use Cookie;
use Illuminate\Http\Request;
use Input;
use Event;
use Session;
use Validator;
use Hash;
use App\User;
use App\Product;
use App\Cart;
use App\WebNotification;
use App\Times;
use App\Area;
use App\Brand;
use App\Category;
use App\ItemsOrder;
use App\Town;
use App\Feeds;
use App\Nations;
use App\Currency;
use App\Order;
use App\Report;
use App\ProductAvailibility;
use Auth;
use DB;
use Carbon\Carbon;
use App\Bookmark;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use LaravelFCM\Message\Topics;
use App\Notify;
use Illuminate\Cookie\CookieJar;

class AdminController extends Controller
{

    public function __construct(CookieJar $cookieJar, Request $request)
    {
        $this->middleware('auth')->except('contact');
        $id = \Request::segment(4);
        if($request->referrer){
            $cookieJar->queue(cookie('referrer', $request->referrer, 45000));
        }
    }

    public function index(Request $request){
        $user_count = User::select('*')->count();
        $product_count = Product::select('*')->count();
        $feed_count = Feeds::select('*')->count();
        $order_count = Order::select('*')->count();

        Cookie::queue('referrer', true, 15);

        return View('admin.index')
            ->with('user_count',$user_count)
            ->with('product_count',$product_count)
            ->with('feed_count',$feed_count)
            ->withCookie(cookie('referrer', $request->referrer, 45000))
            ->with('order_count',$order_count);
    }

    public function setAdminfcmToken(Request $request){
        $user = auth()->user();
        $user->token = $request->fcmtoken;

        if($user->save()){
            //$this->sendNotifications("Some one loged in" , "Hello" , 1);
            return response()->json(['success' => true])->setStatusCode(200);
        }else{
            return response()->json(['success' => false])->setStatusCode(200);
        }
    }

    public function UserNotifications(){
        $user = auth()->user();
        $notifications = WebNotification::where('user_id',$user->id)->orderBy('created_at','desc')->get();
        WebNotification::where('user_id',$user->id)->update(['seen'=>1]);
        //dd($notifications->toArray());
        return View('admin.notifications')->with('userNotifications',$notifications);
    }

    public function getContries(){
        $nations = Nations::all();
        $statusColors = [0 => "btn-danger" , 1 => "btn-info" , 2 => "btn-danger"];
        //        dd($nations->toArray());
        return View('admin.countries.view')
            ->with('nations',$nations)
            ->with('statusColors' , $statusColors);
    }

    public function newContries(){
        return View('admin.countries.new');
    }

    public function carts(){
        $users = User::with(['cart' => function($q){$q->with('Products');}])->has('cart')->get();
        // dd($users->toArray());
        return View('admin.carts.view')->with('users', $users);
    }

    public function user_cart($user_id){
        $user = User::findOrFail($user_id);
        $cart_products = Cart::with(['Products'])->whereUserId($user_id)->get();
        return View('admin.carts.user_cart')->with(['cart_products' => $cart_products, 'user' => $user]);
    }

    public function delete_cart($user_id){
        if(Cart::whereUserId($user_id)->delete())
            $this->carts();

        return back()->with('flash_errors', 'Cannot delete this cart')->withInput();
    }

    function addCountries(Request $request){
        $messages = [
            'name.required' => 'اسم الدولة حقل الزامي',
            'name.unique' => 'اسم الدولة مستخدم سابقا',
            'name_en.required' => 'اسم الدولة (EN) حقل الزامي',
            'name_en.unique' => 'اسم الدولة (EN) مستخدم سابقا',
            'code.required' => 'رمز الدولة حقل الزامي',
            'code.unique' => 'رمز الدولة مستخدم سابقا',
            'currency_code.required' => 'عملة الدولة حقل الزامي',
            'currency_code.unique' => 'رمز الدولة مستخدم سابقا',
            'currency_name.required' => ' عملة الدولة حقل الزامي',
            'currency_name.unique' => 'عملة الدولة مستخدمة سابقا',
            'currency_name_en.required' => ' عملة الدولة (EN) حقل الزامي',
            'currency_name_en.unique' => 'عملة الدولة (EN) مستخدمة سابقا',
            'flag.required' => 'علم الدولة الزامي',
            'flag.mimes' => 'صيغة علم الدولة يجب ان تكون ico',
            'flag.dimensions' => 'ابعاد علم الدولة يجب ان تكون 16x 16',
        ];
        $validator = Validator::make(
            $request->all(),
            array(
                'name' => 'required|unique:nations,name|string|max:255',
                'name_en' => 'required|unique:nations,name|string|max:255',
                'code' => 'required|unique:nations,name|string|max:255',
                'currency_code' => 'required|unique:nations,currency_code|string|max:10',
                'currency_name' => 'required|unique:nations,currency_name|string|max:100',
                'currency_name_en' => 'required|unique:nations,currency_name|string|max:100',
                'flag' => 'required|file|dimensions:max_width=64,max_height=64',
            ),
            $messages
        );

        if($validator->fails()) {
        //            $error_messages = implode(',', $validator->messages()->all());
            return back()->withErrors($validator)->withInput();
        } else {
            //$newData = $request->all();
            $file = Input::file('flag');
            $path = 'uploads/contries/';

            //if(!is_dir($path))
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }


            //$file_name = $file->getClientOriginalName();
            $file_name = uniqid() . ".png";

            $file->move($path , $file_name);

            //$nation = Nations::create($newData);
            $nation = new Nations();
            $nation->name = $request->name;
            $nation->name_en = $request->name_en;
            $nation->code = $request->code;
            $nation->currency_code = $request->currency_code;
            $nation->currency_name = $request->currency_name;
            $nation->currency_name_en = $request->currency_name_en;
            $nation->flag = $path . $file_name;

            if(!$nation->save()){
                return back()->with('flash_errors', 'Cannot create country')->withInput();
            }else{
                return redirect('/admin/countries')->with('message', "تم اضافة دولة جديدة");
            }
        }
    }

    public function editContries($id){
        $validator = Validator::make(
            ['id' => $id],
            array(
                'id' => 'required|exists:nations,id|integer',
            ),
            [
                'id.required' => 'رقم تعريف الدولة الزامي',
                'id.exists' => 'رقم تعريف الدولة غير صحيح',
                'id.integer' => 'رقم تعريف الدولة يجب ان يكون رقم'
            ]
        );

        if($validator->fails()) {
        //$error_messages = implode(',', $validator->messages()->all());
            return back()->withErrors($validator)->withInput();
        } else {
            $nation = Nations::find($id);

            return View('admin.countries.edit')->with('nation' , $nation);
        }
    }

    public function updateContries(Request $request) {
        //dd($request->all());
        $messages = [
            'name.required' => 'اسم الدولة حقل الزامي',
            'name.unique' => 'اسم الدولة مستخدم سابقا',
            'name_en.required' => 'اسم الدولة (EN) حقل الزامي',
            'name_en.unique' => 'اسم الدولة (EN) مستخدم سابقا',
            'code.required' => 'رمز الدولة حقل الزامي',
            'code.unique' => 'رمز الدولة مستخدم سابقا',
            'currency_code.required' => 'عملة الدولة حقل الزامي',
            'currency_code.unique' => 'رمز الدولة مستخدم سابقا',
            'currency_name.required' => ' عملة الدولة حقل الزامي',
            'currency_name.unique' => 'عملة الدولة مستخدمة سابقا',
            'currency_name_en.required' => ' عملة الدولة (EN) حقل الزامي',
            'currency_name_en.unique' => 'عملة الدولة (EN) مستخدمة سابقا',
            'flag.required' => 'علم الدولة الزامي',
            'flag.mimes' => 'صيغة علم الدولة يجب ان تكون ico',
            'flag.dimensions' => 'ابعاد علم الدولة يجب ان تكون 64x 64',
            'oldCountryFlag.required_without' => 'علم الدولة الزامي'
        ];
        $validator = Validator::make(
            $request->all(),
            array(
                'nation_id' => 'required|exists:nations,id|integer',
                'name' => 'required|unique:nations,name,' . $request->nation_id . '|string|max:255',
                'name_en' => 'required|unique:nations,name_en,' . $request->nation_id . '|string|max:255',
                'code' => 'required|unique:nations,name,' . $request->nation_id . '|string|max:255',
                'currency_code' => 'required|unique:nations,currency_code,' . $request->nation_id . '|string|max:10',
                'currency_name' => 'required|unique:nations,currency_name,' . $request->nation_id . '|string|max:100',
                'currency_name_en' => 'required|unique:nations,currency_name_en,' . $request->nation_id . '|string|max:100',
                'flag' => 'file|dimensions:max_width=64,max_height=64',
                'oldCountryFlag' => 'required_without:flag|string|exists:nations,flag'
            ),
            $messages
        );

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            if($request->hasFile('flag')){
               // dd('dd');
                $file = Input::file('flag');
                $path = 'uploads/contries/';

                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }

                $file_name = uniqid() . ".png";

                $file->move($path , $file_name);
                $flagPath = $path . $file_name ;
            }else{
                $flagPath = $request->oldCountryFlag;
            }

            //$nation = Nations::create($newData);
            $nation = Nations::find($request->nation_id);
            $nation->name = $request->name;
            $nation->name_en = $request->name_en;
            $nation->code = $request->code;
            $nation->currency_code = $request->currency_code;
            $nation->currency_name = $request->currency_name;
            $nation->currency_name_en = $request->currency_name_en;
            $nation->flag = $flagPath;

            if(!$nation->save()){
                return back()->with('flash_errors', 'Cannot create country')->withInput();
            }else{
                return redirect('/admin/countries')->with('message',  "تم تعديل دولة " . $nation->name );
            }
        }
    }

    public function approveContries($id,$cstatus){
        $messages = [
            'id.required' => 'رقم الدولة الزامي',
            'id.exists' => 'رقم الدولة غير موجود',
            'cstatus.required' => 'الحالة مطلوبة',
            'cstatus.in' => 'الحالة لها رموز محددة',

        ];
        $validator = Validator::make(
            [
                'id' => $id,
                'cstatus' => $cstatus
            ],
            array(
                'id' => 'required|exists:nations,id|integer',
                'cstatus' => 'required|in:0,1',

            ),
            $messages
        );

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $nation = Nations::find($id);
            $nation->status = $cstatus;

            if(!$nation->save()){
                return back()->with('danger', 'لا يمكن تعديل الدولة حايلا');
            }else{
                return back()->with('message',  "تم تفعيل دولة " . $nation->name);
            }
        }
    }
    public function getVendores(){
        $vendors = User::with('categories')->where('is_vendor',1)->get();
        //        dd($vendors->toArray());
        return View('admin.vendors.view')->with('vendors',$vendors);
    }

    public function getVendoresProducts($vendorid){
        $vendorProducts = Product::with('Category')->where('user_id',$vendorid)->get();
        $vendorDetails = User::find($vendorid);
        $statusColors = [0 => "btn-warning" , 1 => "btn-info" , 2 => "btn-danger"];
        $productsByCount = Product::where('user_id',$vendorid)->select('status',DB::raw('count(*) as status_count'))->groupby('status')->get();
        return View('admin.vendors.product')->with(['vendorsProducts' => $vendorProducts,'statusColors' => $statusColors,
                                                    'vendor'=>$vendorDetails , 'status_count' => $productsByCount]);
    }

    public function getProductByStatus($status){
        $vendorProducts = Product::where('status',$status)->get();
        //$vendorDetails = User::find($vendorid);
        $statusColors = [0 => "btn-warning" , 1 => "btn-info" , 2 => "btn-danger"];
        //$productsByCount = Product::where('status',$vendorid)->select('status',DB::raw('count(*) as status_count'))->groupby('status')->get();

        return View('admin.vendors.product')->with(['vendorsProducts' => $vendorProducts,'statusColors' => $statusColors]);
    }

    public function approveProduct($product_id,$newStatus){
        $product = Product::find($product_id);
        //$product_user = User::find($product->user_id);
        //        dd($product->id);
        if($product != null){
            $product->status = $newStatus;
            // $product->save();

            if($product->save()){
                $msgText = $product->status == 1 ? "تم تفعيل المنتج " . $product->name : " تم ايقاف المنتج " . $product->name;
                $this->sendNotifications($msgText , "Product Updated" , 2,url("/vendors/product/view"),$product->user_id);

                $this->storeLogs($product_id, 'product', Auth::user()->id, $msgText);
            }
        }


        return Redirect::back()->with('message' , 'Product updated');
    }

    function getProductDetails($id){
        $pro_dic = Product::with('User')->find($id);
        $categories = Category::lists('name', 'id');
        $users = User::with('categories')->find($pro_dic->user_id); 
        $user_category = [];
        if($users['categories']){
            $user_categories = $users['categories']->toArray();

            foreach($user_categories as $userCats){
                $user_category[$userCats['id']] = $categories[$userCats['id']];
            } 
        }

        $success = Input::get('success');
        $cat = Category::Select('*')->get();
        $statusColors = [0 => "btn-warning" , 1 => "btn-info" , 2 => "btn-danger"];
        if ($pro_dic ) {
            //dd($pro_dic->cat_id);
            $userCats = Category::find($pro_dic->cat_id);
            //dd($userCats->name);
            $weekDays = [6 => "السبت",0 => "الاحد", 1 => "الاثنين",2 => "الثلاثاء",3 => "الاربعاء", 4 => "الخميس",5 => "الجمعة"];
            $availablePeriodes = ProductAvailibility::where("product_id",$id)->get();
            $availablePeriodesProduct = [];
            $pro_dic->price = floatval($pro_dic->price) ;
            foreach ($availablePeriodes as $v){
                $availablePeriodesProduct[$v->day_no][$v->gender][$v->period] = $v->quantity;
            }

        //dd($pro_dic);
            return view('admin.vendors.edit')
                ->with('success', $success)
                ->with('pro_dic', $pro_dic)
                ->with('categories', $user_category)
                ->with(['userCategories' => $userCats->id , "weekDays" => $weekDays , 'availablePeriodesProduct' => $availablePeriodesProduct ,'statusColors' => $statusColors]);
        } else {
            return View('admin.vendors.edit',['Product' => Product::findOrFail($id)])
                ->with('title', 'Error Page Not Found');
        }
    }

    public function updateProduct(Request $request){
        $product = Product::findOrFail($request->input('id'));
        $product->cat_id = $request->input('cat_id');
        $product->update();
        $this->storeLogs($product->id, 'product', Auth::user()->id, 'تم تعديل المنتج ' . $product->name . ' رقم ' . $product->id);
        return redirect('admin/getvendorsproducts/'.$product->user_id);
    }

    public function statistics(){
        $user_id = Auth::user()->id;

        $user_products = Product::select('id');
        $link = URL((Auth::user()->is_admin?'/admin':'vendors').'/orders/view/');
        if(Auth::user()->is_vendor){
            $user_products->where('user_id', '=', $user_id);
            $link = URL('/vendors/orders/view/');
        }
        $user_products = $user_products->get();
        $catSales = [];

        if(Auth::user()->is_vendor)
            $categories = Auth::user()->categories()->get();
        elseif(Auth::user()->is_admin)
            $categories = Category::all();
        else
            $categories = [];

        foreach ($categories as $category) {
            $category_id = $category->id;
            $categoryProducts = Product::where('cat_id', '=', $category_id)->select('id');

            if(Auth::user()->is_vendor)
                $categoryProducts = $categoryProducts->where('user_id', '=', $user_id);

            $products = $categoryProducts->get();
            $count = $categoryProducts->select(DB::raw('SUM(views) as count'))->groupBy('cat_id')->first();

            //$catSales[] = $categoryProducts->get();
            $catSalesTemp = ItemsOrder::where('date','>',date("Y") . "-1-1")->where('created_at', '>', '2018-04-23')->select(DB::raw('SUM(total) as total'), DB::raw('YEAR(date) year'))->whereIN('product_id', $products)->first();

            $catSales[] = ['catName' => $category->name , 'total' => $catSalesTemp->total ];
            $views[] = array('label' => $category->name, 'value' => $count['count'] == null ? 0 : $count['count'] );
        }

        
        $sales = array();
        $sales_object = ItemsOrder::select(DB::raw('SUM(total) as total'), DB::raw('YEAR(date) year'))->where('created_at', '>', '2018-04-23')->whereIN('product_id', $user_products)->groupBy('year')->get();
        foreach ($sales_object as $value) {
            $sales[] = $value['attributes'];
        }

        $ordersStatus = ItemsOrder::select(DB::raw('count(*) as total') , 'status')->where('created_at', '>', '2018-04-23')->whereIN('product_id', $user_products)->groupBy('status')->get();
        $ordersStatusCount = [];
        foreach($ordersStatus as $order){
            $ordersStatusCount[] = ['label' => $this->getStatusArrayLabel($order->status) , 'value' => $order->total, 'link' => $link . '/' . $order->status];
        }

        //$ordersCategories = Order::select('status')->groupBy('status')->count();

        $statistics = array('viewsall' => $views, 'sales' => $sales , 'catSales' => $catSales , 'orders' => $ordersStatusCount);


        return response()->json(['data' => $statistics])->setStatusCode(200);
    }

    public function getStatusArrayLabel($status){
        $orderStatuses = [
            1 => 'قيد الانتظار',
            2 => 'تم الدفع',
            3 => 'تم قبول الطلب',
            4 => 'تم رفض الطلب',
            5 => 'جاري تحضير الطلب',
            6 => 'جاري تجهيز الطلب',
            7 => 'تم اكتمال الطلب'
        ];

        return $orderStatuses[$status];
    }
    public function Dashboard(Request $request){
        $user_id = Auth::user()->id;
        $user_products = Product::select('id');


        $user_count = User::select('*')->count();


        $product_count = Product::count();
        $feed_count = Feeds::count();
        $order_count = Order::where('created_at', '>', '2018-04-23')->count();


        if(Auth::user()->is_vendor){
            $product_count = $product_count->where('user_id', '=', $user_id);
            $feed_count = $feed_count->whereIN('prod_id', $user_products);
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
        $sales_object = ItemsOrder::select(DB::raw('SUM(total) as total'), DB::raw('YEAR(date) year'))->where('created_at', '>', '2018-04-23')->whereIN('product_id', $user_products)->groupBy('year')->get();
        foreach ($sales_object as $value) {
            $sales[] = $value['attributes'];
        }
        $statistics = array('views' => $views, 'sales' => $sales);
        $productsByCount = Product::select('status',DB::raw('count(*) as status_count'))->groupby('status')->get();

        Cookie::queue('referrer', true, 15);
        return View('admin.index')
            ->with('user_count',$user_count)
            ->with('product_count',$product_count)
            ->with('feed_count',$feed_count)
            ->with('statistics', $statistics)
            ->withCookie(cookie('referrer', $request->referrer, 45000))
            ->with('order_count',$order_count)
            ->with('status_count',$productsByCount);
    }


    public function lock(Request $request){
        $rules=[
            'email'=>'required|email',
            'name'=>'required',
            'password'=>'required'
        ];
        $val = Validator::make($request->all(),$rules);

        if(!\Auth::check())
            return redirect('/login')->with('message', "you are logout");

        $password = \Input::get('password');

        if(\Hash::check($password,\Auth::user()->password)){
            \Session::forget('locked');
            return redirect('/admin')->with('message', "مرحباً بك");
        }else{
            return redirect('/admin/lock')->with('danger', "password not correct");
        }
    }

    public function edit_user($id){
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
            return view('admin.Edit')
                ->with('success', $success)
                ->with('categories', $categories)
                ->with('user_categories', $user_category)
                ->with('users', $users)
                ->with('can_update', $can_update);
        } else {
            return View('admin.Edit',['user' => User::findOrFail($id)])
                ->with('title', 'Error Page Not Found')
                ->with('danger',"No user found");

        }
    }

    public function update_User_profile(Request $request) {
        $rules=[
            'email' => 'required|email',
            'phone' => 'required|unique:users,phone,'.Input::get('id').',id',
            'user_name'=>'required',
            /*'charge_cost'=>'required|numeric',*/
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
            return Redirect::to("/admin")
                ->with('message',"your profile $user->user_name updated");
        }

    }

    public function product_show($today = null){
        $product = Product::with('Images')
            ->leftjoin('category','products.cat_id','=','category.id')
            ->leftjoin('users','products.user_id','=','users.id')
            ->leftjoin('feed_back','products.id','=','feed_back.prod_id')
            ->groupBy( 'products.id','feed_back.prod_id' )
            ->select('products.id as product_id','products.id','products.views as product_viewer',
                'products.name as product_name','users.user_name as products_user','feed_back.rate as products_rate',
                'users.pic as products_user_pic','category.name as products_cat_name','products.desc as product_desc',
                'products.created_at as product_time','products.requirement as product_requirement','products.max_num as product_num',
                'products.img as product_pic_cover','products.price as product_price',
                'products.updated_at as product_created')
            ->orderBy('product_created','ASC');
        if(!is_null($today))
            $product = $product->whereRaw('Date(products.created_at) = CURDATE()');
        $product = $product->get();

        $vendor = Product::with('Images')
            ->leftjoin('category','products.cat_id','=','category.id')
            ->leftjoin('users','products.user_id','=','users.id')
            ->leftjoin('feed_back','products.id','=','feed_back.prod_id')
            ->groupBy( 'products.id','feed_back.prod_id' )
            ->select('products.id as product_id','products.id','products.views as product_viewer',
                'products.name as product_name','users.user_name as products_user','feed_back.rate as products_rate',
                'users.pic as products_user_pic','category.name as products_cat_name','products.desc as product_desc',
                'products.created_at as product_time','products.requirement as product_requirement','products.max_num as product_num',
                'products.img as product_pic_cover','products.price as product_price',
                'products.updated_at as product_created')
            ->where('products.user_id',Auth::User()->id)
            ->orderBy('product_created','ASC')
            ->get();

        return view('admin.products.view')
            ->with('product',$product)
            ->with('vendor',$vendor);
    }

    public function orders_view(){
        $order = Order::with('Items')
            ->leftjoin('users','order_product.user_id','=','users.id')
            ->leftjoin('order_items','order_items.order_id','=','order_product.id')
            ->leftjoin('products','order_items.product_id','=','products.id')
            ->leftjoin('area','order_product.area_id','=','area.id')
            ->groupBy( 'order_items.order_id')
            ->select('order_product.id as ord_id','order_product.id','users.user_name as ord_user',
                'order_product.status as ord_status','area.name as ord_area_name','order_items.amount as ord_qty',
                'order_product.order_id as ord_number','products.name as ord_name',
                'products.requirement as ord_requirement','products.img as ord_img','products.is_product as ord_is_product',
                'order_items.address as ord_add','order_items.time as ord_event','order_items.id as ord_item_id','order_product.created_at as ord_time_created')
            ->orderBy('ord_time_created','DEC')
            ->get();

        $order_vendor = Order::with('Items')
            ->leftjoin('users','order_product.user_id','=','users.id')
            ->leftjoin('order_items','order_items.order_id','=','order_product.id')
            ->leftjoin('products','order_items.product_id','=','products.id')
            ->leftjoin('area','order_product.area_id','=','area.id')
            ->groupBy( 'order_items.order_id')
            ->select('order_product.id as ord_id','order_product.id','users.user_name as ord_user',
                'order_product.status as ord_status','area.name as ord_area_name','order_items.amount as ord_qty',
                'order_product.order_id as ord_number','products.name as ord_name',
                'products.requirement as ord_requirement','products.img as ord_img','products.is_product as ord_is_product',
                'order_items.address as ord_add','order_items.time as ord_event','order_product.created_at as ord_time_created')
            ->where('products.user_id',Auth::User()->id)
            ->get();


        return view('admin.orders.view')
            ->with('order',$order)
            ->with('order_vendor',$order_vendor);
    }

    public function orderitemdetails($orderItemId){
        $orderItem = ItemsOrder::with(['products' => function($q){$q->with('user');},'order' => function($q){$q->with('user');}])->findOrFail($orderItemId);

        if($orderItem['products']->user_id != Auth::user()->id && !Auth::user()->is_admin)
            return view('errors.404')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');

        if (($orderItem->date > '2018-05-17') && ($orderItem->date < '2018-06-15')){
            if($orderItem->time == 'مساء')
                $orderItem->time = 'سحور';
            elseif($orderItem->time == 'ظهرا')
                $orderItem->time = 'عشاء';
            elseif($orderItem->time == 'صباحا')
                $orderItem->time = 'افطار';
        }
        
        return view('admin.orders.edit')->with('details',$orderItem);
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

    public function info_store(Request $request){
        $info = new info();
        $info->id = input::get('id');
        $info->title = input::get('title');
        $info->desc = input::get('desc');
        $info->policy = input::get('policy');
        if (Input::hasfile('pic')) {
            $extension_pic_info= Input::file('pic')->getClientOriginalExtension();
            $fileName_pic_info = rand(11111, 99999) . '.' . $extension_pic_info;
            $destinationPath_pic_info =  'Info/';
            $pic_info = input::file('pic')->move($destinationPath_pic_info, $fileName_pic_info);
            $url = asset('');
            $info->pic = $url.$pic_info;
        }
        $info->phone =  input::get('phone');
        $info->email =  input::get('email');
        $info->lat =  input::get('lat');
        $info->long =  input::get('long');
        $info->lang =  input::get('lang');
        $info->save();

        return Redirect::to("/admin/info/view")
            ->with('message',"تم إضافة $info->title بنجاح");
    }

    public function info_view(){
        $info = info::select('*')->first();
        return view('admin.info.view')
            ->with('info',$info);
    }

    protected function info_edit($id){
        $info = info::find($id);

        $success = Input::get('success');

        if ($info ) {
            return view('admin.info.edit')
                ->with('success', $success)
                ->with('info', $info);
        } else {
            return View('admin.info.edit',['info' => info::findOrFail($id)])
                ->with('title', 'Error Page Not Found')
                ->with('danger',"No info found");

        }
    }

    public function info_update(Request $request){
        ini_set ('upload_max_filesize', '40M');
        $infoo = info::find(Input::get('id'));

        $infoo->title = $request->title;
        $infoo->desc = $request->desc;
        $infoo->policy = $request->policy;
        $infoo->app_store = $request->app_store;
        $infoo->play_store = $request->play_store;
        $infoo->address = $request->address;
        $infoo->facebook = $request->facebook;
        $infoo->twitter = $request->twitter;
        $infoo->instagram = $request->instagram;
        $infoo->google = $request->google;
        $infoo->phone = $request->phone;
        $infoo->lat = $request->lat;
        $infoo->long = $request->long;
        $infoo->lang = $request->lang;
        $infoo->email = $request->email;

        if (Input::hasFile('pic')) {
            $extension_pic_info= Input::file('pic')->getClientOriginalExtension();
            $fileName_pic_info = rand(11111, 99999) . '.' . $extension_pic_info;
            $destinationPath_pic_info =  'Info/';
            $pic_info = input::file('pic')->move($destinationPath_pic_info, $fileName_pic_info);
            $url = asset('');
            $infoo->pic = $url.$pic_info;
        }
        if (Input::hasFile('favicon')) {
            $extension_favicon_info= Input::file('favicon')->getClientOriginalExtension();
            $fileName_favicon_info = rand(11111, 99999) . '.' . $extension_favicon_info;
            $destinationPath_favicon_info =  'Info/';
            $favicon_info = input::file('favicon')->move($destinationPath_favicon_info, $fileName_favicon_info);
            $url = asset('');
            $infoo->favicon = $fileName_favicon_info;
        }
        if (Input::hasFile('video')) {
            $extension_video_info= Input::file('video')->getClientOriginalExtension();
            $fileName_video_info = rand(11111, 99999) . '.' . $extension_video_info;
            $destinationPath_video_info =  'Info/';
            $video_info = input::file('video')->move($destinationPath_video_info, $fileName_video_info);
            $url = asset('');
            $infoo->video = $fileName_video_info;
        }
        $infoo->update();

        session()->flash('flash_message', 'Your idea has been Edit for Review');
        return Redirect::to("admin/info/view?success=$infoo->id")
            ->with('message', "your Item successfully has been edit $infoo->title");
    }

    public function Del_info($id) {

        $inf = info::find($id);

        if ($inf) {
            info::where('id', $id)->delete();
            return Redirect::to("/admin/info/view?success=$inf->id")
                ->with('message', "your Item successfully deleted $inf->title");

        } else {
            return view('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('page', 'Error Page Not Found')
                ->with('danger',"no info found");
        }

    }

    public function add_user(Request $request){
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
            $users->v_code = $code;
            $users->address = input::get('address');
            $users->save();
            return Redirect::to("/admin/user/view?success=$users->id")
                ->with('message', "تم إضافة $users->user_name بنجاح");
        }

    }

    public function User_view($user_type, $today = null){
        $user = User::select('*');
        // dd($user);
        if(!is_null($today))
            $user = $user->whereRaw('Date(created_at) = CURDATE()');
        if($user_type == 1)
            $user = $user->where('is_admin', '=', 1);
        elseif($user_type == 2)
            $user = $user->where('is_vendor', '=', 1);
        elseif($user_type == 0)
            $user = $user->where('is_vendor', '=', 0)->where('is_admin', '=', 0);
        else
            return view('errors.404')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');

        $user = $user->get();

        return view('admin.users.view')
            ->with('user',$user)->with('user_type', $user_type)->with('today', $today);
    }

    public function Del_user($id){
        $success = Input::get('success');
        $users = User::find($id);
        if ($users) {
            if($users->is_admin)
                $user_type = 1;
            elseif($users->is_vendor)
                $user_type = 2;
            else
                $user_type = 0;
            User::where('id', $id)->delete();
            return Redirect::to("/admin/user/view/".$user_type)
                ->with('message', 'user successfully deleted');

        } else {
            return View::make('notfound')->with('title', 'Error Page Not Found')
                ->with('page', 'Error Page Not Found')
                ->with('danger',"No user found");
        }

    }

    public function permission(){
        $userss = User::select('*')->get();

        return view('admin.users.permission')
            ->with('userss',$userss);
    }

    public function Verifed ($id, $user_type){
        $success = Input::get('success');
        $users_v = User::find($id);
        if ($users_v) {
            DB::table('users')
                ->where('id', $id)
                ->update(['verified' => 1, 'blocked' => 0]);

            $this->sendNotificationsToUser("تم تفعيل حسابك ","",$id);

            //$this->storeLogs($id, 'user', Auth::user()->id, 'تم تفعيل المستخدم ' . $users_v->user_name . ' رقم ' . $id);

            // return Redirect::to("/admin/user/permission?success=$users_v->id")
            return Redirect::to("/admin/user/view/".$user_type.'?success=$users_v->id')
                ->with('user_type', $user_type)
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

            //$this->storeLogs($id, 'user', Auth::user()->id, 'تم تفعيل المستخدم ' . $users_v->user_name . ' رقم ' . $id);

            // return Redirect::to("/admin/user/permission?success=$users_v->id")
            return back()->with('message', 'تم تفعيل المستخدم');

        } else {
            return View::make('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('danger', 'No user found');
        }

    }

    public function UN_Verifed ($id, $user_type){
        $success = Input::get('success');
        $users_v = User::find($id);
        if ($users_v) {
            DB::table('users')
                ->where('id', $id)
                ->update(['verified' => 0,'is_vendor' => 0 ,'is_admin' => 0 , 'blocked' => 1]);

                $this->storeLogs($id, 'user', Auth::user()->id, 'تم ايقاف المستخدم ' . $users_v->user_name . ' رقم ' . $id);

            $this->sendNotificationsToUser("تم ايقاف حسابك","",$id);
            return Redirect::to("/admin/user/view/".$user_type."?success=$users_v->id")
                ->with('user_type', $user_type)
                ->with('message', "user successfully unverified $users_v->id");

        } else {
            return View::make('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('danger', 'No user found');
        }

    }

    public function MK_admin ($id, $user_type){
        $success = Input::get('success');
        $users_v = User::find($id);
        if ($users_v) {
            DB::table('users')
                ->where('id', $id)
                ->update(['is_admin' => 1,'is_vendor' => 0]);

            $this->sendNotificationsToUser("تم اضافة صلاحيات الادارة لحسابك","",$id);

            $this->storeLogs($id, 'user', Auth::user()->id, 'تم اضافة صلاحيات الادارة لحسابك للمستخدم ' . $users_v->user_name . ' رقم ' . $id);
            return Redirect::to("/admin/user/view/".$user_type."?success=$users_v->id")
                ->with('user_type', $user_type)
                ->with('message', "user successfully added as admin $users_v->id");
            return;
        } else {
            return View::make('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('danger', 'No user found');
        }
    }

    public function MK_vendor ($id, $user_type){
        $success = Input::get('success');
        $users_v = User::find($id);
        if ($users_v) {
            DB::table('users')
                ->where('id', $id)
                ->update(['is_vendor' => 1,'is_admin' => 0]);
            $this->sendNotificationsToUser("تم اضافة صلاحيات صاحب عمل لحسابك","",$id);
            $this->storeLogs($id, 'user', Auth::user()->id, 'تم اضافة صلاحيات صاحب عمل للمستخدم ' . $users_v->user_name . ' رقم ' . $id);
            return Redirect::to("/admin/user/view/".$user_type."?success=$users_v->id")
                ->with('user_type', $user_type)
                ->with('message', "user add successfully as a vendor $users_v->id");

        } else {
            return View::make('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('danger', 'No user found');
        }

    }

    public function MK_regular ($id, $user_type){
        $success = Input::get('success');
        $users_v = User::find($id);
        if ($users_v) {
            DB::table('users')
                ->where('id', $id)
                ->update(['is_vendor' => 0 , 'is_admin' => 0]);

            $this->sendNotificationsToUser("تم اضافة صلاحيات المستخدم لحسابك","",$id);

            $this->storeLogs($id, 'user', Auth::user()->id, 'تم اضافة صلاحيات المستخدم للمستخدم ' . $users_v->user_name . ' رقم ' . $id);
            return Redirect::to("/admin/user/view/".$user_type."?success=$users_v->id")
                ->with('user_type', $user_type)
                ->with('message', "user add successfully as a regular $users_v->id");
        } else {
            return View::make('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('danger', 'No user found');
        }
    }

    public function ORSTR ($id){

        $success = Input::get('success');
        $ord_st = Order::find($id);
        if ($ord_st) {
            DB::table('order_product')
                ->where('id', $id)
                ->update(['status' => 1]);
            return Redirect::to("/orders/view?success=$ord_st->id")
                ->with('message', "order number $ord_st->id  start now");

        } else {
            return View::make('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('danger', 'No order found');
        }

    }

    public function INPro ($id){

        $success = Input::get('success');

        $ord_st = Order::find($id);
        if ($ord_st) {
            DB::table('order_product')
                ->where('id', $id)
                ->update(['status' => 2]);
            return Redirect::to("/orders/view?success=$ord_st->id")
                ->with('message', "order number $ord_st->id in progress");

        } else {
            return View::make('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('danger', 'No order found');
        }

    }

    public function prepare ($id){

        $success = Input::get('success');

        $ord_st = Order::find($id);


        $ord_st_fire = Order::select('*')
            ->leftjoin('users','users.id','=','order_product.user_id')
            ->select('order_product.id','users.id as use_fire_id','users.firebase_token as use_fire')
            ->where('users.id','=',$ord_st->user_id)
            ->where('order_product.id','=',$ord_st->id)
            ->get();


        if ($ord_st) {
            DB::table('order_product')
                ->where('id', $id)
                ->update(['status' => 5]);
            $notificationKey = $ord_st_fire[0]->use_fire;
            $notificationBuilder = new PayloadNotificationBuilder('Ratb.li Order');
            $notificationBuilder->setBody('your order preparing now')->setSound('default');
            $notification = $notificationBuilder->build();
            $groupResponse = FCM::sendToGroup($notificationKey, null, $notification, null);
            $groupResponse->numberSuccess();
            $groupResponse->numberFailure();
            $groupResponse->tokensFailed();

            return Redirect::to("/orders/view?success=$ord_st->id")
                ->with('message', "order number $ord_st->id in prepare");

        } else {
            return View::make('notfound')->with('title', 'Error Page Not Found')
                ->with('page', 'Error Page Not Found')
                ->with('danger',"No order id found");

        }

    }

    public function processing ($id){

        $success = Input::get('success');

        $ord_st = Order::find($id);

        $ord_st_fire_proces = Order::select('*')
            ->leftjoin('users','users.id','=','order_product.user_id')
            ->select('order_product.id','users.id as use_fire_id','users.firebase_token as use_fire')
            ->where('users.id','=',$ord_st->user_id)
            ->where('order_product.id','=',$ord_st->id)
            ->get();

        if ($ord_st) {
            DB::table('order_product')
                ->where('id', $id)
                ->update(['status' => 6]);
            $notificationKey = $ord_st_fire_proces[0]->use_fire;
            $notificationBuilder = new PayloadNotificationBuilder('Ratb.li Order');
            $notificationBuilder->setBody('your order processing now')->setSound('default');
            $notification = $notificationBuilder->build();
            $groupResponse = FCM::sendToGroup($notificationKey, null, $notification, null);
            $groupResponse->numberSuccess();
            $groupResponse->numberFailure();
            $groupResponse->tokensFailed();

            return Redirect::to("/orders/view?success=$ord_st->id")
                ->with('message', "order number $ord_st->id processing now");

        } else {
            return View::make('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('page', 'Error Page Not Found')
                ->with('danger',"No order id found");

        }

    }

    public function completed ($id){

        $success = Input::get('success');

        $ord_st = Order::find($id);

        $ord_st_fire_completed = Order::select('*')
            ->leftjoin('users','users.id','=','order_product.user_id')
            ->select('order_product.id','users.id as use_fire_id','users.firebase_token as use_fire')
            ->where('users.id','=',$ord_st->user_id)
            ->where('order_product.id','=',$ord_st->id)
            ->get();

        if ($ord_st) {
            DB::table('order_product')
                ->where('id', $id)
                ->update(['status' => 7]);

            $notificationKey = $ord_st_fire_completed[0]->use_fire;
            $notificationBuilder = new PayloadNotificationBuilder('Ratb.li Order');
            $notificationBuilder->setBody('your order completed on your way')->setSound('default');
            $notification = $notificationBuilder->build();
            $groupResponse = FCM::sendToGroup($notificationKey, null, $notification, null);
            $groupResponse->numberSuccess();
            $groupResponse->numberFailure();
            $groupResponse->tokensFailed();

            return Redirect::to("/orders/view?success=$ord_st->id")
                ->with('message', "order number $ord_st->id completed");

        } else {
            return View::make('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('page', 'Error Page Not Found')
                ->with('danger',"No order found");

        }

    }

    public function add_category(Request $request){
        $cat = new Category();
        $cat->id = input::get('id');
        $cat->name = input::get('name');
        $cat->name_en = input::get('name_en');
        $cat->desc = input::get('desc');
        $cat->desc_en = input::get('desc_en');
        $cat->is_offer = input::get('is_offer');
        $cat->published = input::get('published');
        if (Input::hasfile('img')) {
            $extension_img = Input::file('img')->getClientOriginalExtension();
            $fileName_img = rand(11111, 99999) . '.' . $extension_img;
            $destinationPath_img = 'Category/';
            $img = Input::file('img')->move($destinationPath_img, $fileName_img);
            $url = asset('');
            $cat->img = $url.$img;
        }
        if (Input::hasfile('img_en')) {
            $extension_img_en = Input::file('img_en')->getClientOriginalExtension();
            $fileName_img_en = rand(11111, 99999) . '.' . $extension_img_en;
            $destinationPath_img_en = 'Category/';
            $img_en = Input::file('img_en')->move($destinationPath_img_en, $fileName_img_en);
            $url = asset('');
            $cat->img_en = $url.$img_en;
        }
        $cat->lang = input::get('lang');

        $cat->save();

        $this->storeLogs($cat->id, 'category', Auth::user()->id, 'تم إضافة الخدمة ' . $cat->name . ' رقم ' . $cat->id);

        return Redirect::to("/admin/category/view?success=$cat->id")
            ->with('message', "تم إضافة $cat->name بنجاح");

    }

    public function show_category(){
        $categories = Category::select('*')->get();

        return view('admin.category.view')
            ->with('categories',$categories);

    }

    protected function category_edit($id){
        $category = Category::find($id);

        $success = Input::get('success');

        if ($category ) {
            return view('admin.category.edit')
                ->with('success', $success)
                ->with('category', $category);
        } else {
            return View('admin.category.edit',['category' => Category::findOrFail($id)])
                ->with('title', 'Error Page Not Found')
                ->with('danger',"No category found");

        }
    }

    public function category_update(Request $request){
        $cateogries = Category::find(Input::get('id'));

        if(Input::has('name')) {
            $cateogries->name = input::get('name');
        }
        if(Input::has('desc')) {
            $cateogries->desc = input::get('desc');
        }
        if(Input::has('name_en')){
            $cateogries->name_en = input::get('name_en');
        }
        if(Input::has('desc_en')){
            $cateogries->desc_en = input::get('desc_en');
        }
        if(Input::has('is_offer')){
            $cateogries->is_offer = input::get('is_offer');
        }
        if(Input::has('published')){
            $cateogries->published = input::get('published');
        }
        if (Input::hasfile('img')) {
            $extension_pic_cater= Input::file('img')->getClientOriginalExtension();
            $fileName_pic_cater = rand(11111, 99999) . '.' . $extension_pic_cater;
            $destinationPath_pic_cater =  'Category/';
            $pic_categorysss = input::file('img')->move($destinationPath_pic_cater, $fileName_pic_cater);
            $url = asset('');
            $cateogries->img = $url.$pic_categorysss;
        }
        if (Input::hasfile('img_en')) {
            $extension_pic_cater= Input::file('img_en')->getClientOriginalExtension();
            $fileName_pic_cater = rand(11111, 99999) . '.' . $extension_pic_cater;
            $destinationPath_pic_cater =  'Category/';
            $pic_categorysss_en = input::file('img_en')->move($destinationPath_pic_cater, $fileName_pic_cater);
            $url = asset('');
            $cateogries->img_en = $url.$pic_categorysss_en;
        }
        if (Input::has('lang')) {
            $cateogries->lang = input::get('lang');
        }

        $cateogries->update();

        $this->storeLogs(Input::get('id'), 'category', Auth::user()->id, 'تم تعديل الخدمة ' . $cateogries->name . ' رقم ' . $cateogries->id);

        session()->flash('flash_message', 'Your idea has been Edit for Review');
        return Redirect::to("admin/category/view?success=$cateogries->id")
            ->with('message', "category updated success $cateogries->name");

    }

    public function Del_category($id) {
        $cats = Category::find($id);
        if ($cats) {
            $this->storeLogs($id, 'category', Auth::user()->id, 'تم حذف الخدمة ' . $cats->name . ' رقم ' . $cats->id);
            Category::where('id', $id)->delete();
            return Redirect::to("/admin/category/view?success=$cats->id")
                ->with('message', "category deleted success $cats->name");

        } else {
            return view('notfound')->with('title', 'Error Page Not Found')
                ->with('page', 'Error Page Not Found')
                ->with('danger',"No category found");

        }
    }

    public function started ($id){
        $success = Input::get('success');
        $started = Order::find($id);
        if ($started) {
            DB::table('order_product')
                ->where('id', $id)
                ->update(['status' => 1]);
            return Redirect::to("/orders/view?success=$started->id")
                ->with('message', "order number $started->id started");
        } else {
            return View::make('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('page', 'Error Page Not Found')
                ->with('danger',"No order found");
        }
    }

    public function progress ($id){
        $success = Input::get('success');
        $progress = Order::find($id);
        if ($progress) {
            DB::table('order_product')
                ->where('id', $id)
                ->update(['status' => 2]);
            return Redirect::to("/orders/view?success=$progress->id")
                ->with('message', "order number $progress->id  in progress");

        } else {
            return View::make('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('page', 'Error Page Not Found')
                ->with('danger',"No order found");
        }
    }

    public function Completed_stat ($id){
        $success = Input::get('success');
        $completed = Order::find($id);
        $ord_st_fire_start = Order::select('*')
            ->leftjoin('users','users.id','=','order_product.user_id')
            ->select('order_product.id','users.id as use_fire_id','users.firebase_token as use_fire')
            ->where('users.id','=',$completed->user_id)
            ->where('order_product.id','=',$completed->id)
            ->get();
        if ($completed) {
            DB::table('order_product')
                ->where('id', $id)
                ->update(['status' => 3]);
            $notificationKey = $ord_st_fire_start[0]->use_fire;
            $notificationBuilder = new PayloadNotificationBuilder('Ratb.li Order');
            $notificationBuilder->setBody('your order started')->setSound('default');
            $notification = $notificationBuilder->build();
            $groupResponse = FCM::sendToGroup($notificationKey, null, $notification, null);
            $groupResponse->numberSuccess();
            $groupResponse->numberFailure();
            $groupResponse->tokensFailed();
            return Redirect::to("/orders/view?success=$completed->id")
                ->with('message', "order number $completed->id  started");
        } else {
            return View::make('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('page', 'Error Page Not Found')
                ->with('danger',"No order found");
        }
    }

    public function accept ($id){
        $success = Input::get('success');
        $accept = Order::find($id);

        $ord_st_fire_accept = Order::select('*')
            ->leftjoin('users','users.id','=','order_product.user_id')
            ->select('order_product.id','users.id as use_fire_id','users.firebase_token as use_fire')
            ->where('users.id','=',$accept->user_id)
            ->where('order_product.id','=',$accept->id)
            ->get();

        if ($accept) {
            DB::table('order_product')
                ->where('id', $id)
                ->update(['status' => 3]);

            $this->storeLogs($id, 'order', Auth::user()->id, 'تم قبول المنتج ' . $accept->name . ' رقم ' . $accept->id);

            $notificationKey = $ord_st_fire_accept[0]->use_fire;
            $notificationBuilder = new PayloadNotificationBuilder('Ratb.li Order');
            $notificationBuilder->setBody('your order Accepted')->setSound('default');
            $notification = $notificationBuilder->build();
            $groupResponse = FCM::sendToGroup($notificationKey, null, $notification, null);
            $groupResponse->numberSuccess();
            $groupResponse->numberFailure();
            $groupResponse->tokensFailed();


            return Redirect::to("/orders/view?success=$accept->id")
                ->with('message', "order number $accept->id  was Accepted");
        } else {
            return View::make('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('page', 'Error Page Not Found')
                ->with('danger',"No order found");
        }
    }

    public function refuse ($id){
        $success = Input::get('success');
        $refuse = Order::find($id);

        $ord_st_fire_refuse = Order::select('*')
            ->leftjoin('users','users.id','=','order_product.user_id')
            ->select('order_product.id','users.id as use_fire_id','users.firebase_token as use_fire')
            ->where('users.id','=',$refuse->user_id)
            ->where('order_product.id','=',$refuse->id)
            ->get();


        if ($refuse) {
            DB::table('order_product')
                ->where('id', $id)
                ->update(['status'=> 4]);

            $this->storeLogs($id, 'order', Auth::user()->id, 'تم رفض المنتج ' . $refuse->name . ' رقم ' . $refuse->id);

            $notificationKey = $ord_st_fire_refuse[0]->use_fire;
            $notificationBuilder = new PayloadNotificationBuilder('Ratb.li Order');
            $notificationBuilder->setBody('your order refuse please check with bank')->setSound('default');
            $notification = $notificationBuilder->build();
            $groupResponse = FCM::sendToGroup($notificationKey, null, $notification, null);
            $groupResponse->numberSuccess();
            $groupResponse->numberFailure();
            $groupResponse->tokensFailed();

            return Redirect::to("/orders/view?success=$refuse->id")
                ->with('message', "order number $refuse->id  was Refuesd");

        } else {
            return View::make('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('page', 'Error Page Not Found')
                ->with('danger',"No order found");
        }
    }

    public function getPayments(){
        $payment = BankAccount::all();
        return view('admin.payment.view')->with('payment',$payment);
    }

    public function payment_store(Request $request){
        $rules=[
            'bank_name'=>'required',
            'accout_no'=>'required|integer',
            'country'=>'required',
            'currency'=>'required',
            'swift'=>'required|integer',
            'iban'=>'required|integer'
        ];
        $val = Validator::make($request->all(),$rules);

        $payrol = new BankAccount();
        $payrol->bank_name = input::get('bank_name');
        $payrol->accout_no = input::get('accout_no');
        $payrol->iban =  input::get('iban');
        $payrol->swift =  input::get('swift');
        $payrol->country =  input::get('country');
        $payrol->currency =  input::get('currency');
        $payrol->save();

        return Redirect::to("/admin/payment/view")
            ->with('message',"تم إضافة $payrol->BankAccount بنجاح");
    }
    public function getPaymentOrders($payment_id){
        $payment = BankAccount::find($payment_id);
        $orders = Order::where('bank_id',$payment_id)->with('user')->get();
        return view('admin.payment.orders')->with('orders',$orders)
            ->with('bank',$payment);
    }

    protected function payment_edit($id){
        $paymentss = BankAccount::find($id);
        $currencies = Currency::where('lang', '=', 'ar')->get();
        $nations = Nations::get();
        $success = Input::get('success');

        if ($paymentss ) {
            return view('admin.payment.edit')
                ->with('currencies', $currencies)
                ->with('nations', $nations)
                ->with('success', $success)
                ->with('paymentss', $paymentss);
        } else {
            return view('admin.payment.edit')
                ->with('title', 'Error Page Not Found')
                ->with('danger',"No info found");
        }
    }

    public function payment_update(Request $request){
        $rules=[
            'bank_name'=>'required',
            'accout_no'=>'required|integer',
            'country'=>'required',
            'currency'=>'required',
            'swift'=>'required|integer',
            'iban'=>'required|integer'
        ];
        $val = Validator::make($request->all(),$rules);

        $pay = BankAccount::find(Input::get('id'));

        if (Input::has('bank_name')) {
            $pay->bank_name = input::get('bank_name');
        }
        if (Input::has('accout_no')) {
            $pay->accout_no = input::get('accout_no');
        }
        if (Input::has('iban')) {
            $pay->iban = input::get('iban');
        }
        if (Input::has('swift')) {
            $pay->swift = input::get('swift');
        }
        if (Input::has('country')) {
            $pay->country = input::get('country');
        }
        if (Input::has('currency')) {
            $pay->currency = input::get('currency');
        }

        $pay->update();

        session()->flash('flash_message', 'Your idea has been Edit for Review');
        return Redirect::to("admin/payment/view?success=$pay->id")
            ->with('message', "your Item successfully has been edit $pay->title");
    }

    public function payment_del($id){
        $pay = BankAccount::find($id);
        if ($pay) {
            BankAccount::where('id', $id)->delete();
            return Redirect::to("/admin/payment/view?success=$pay->id")
                ->with('message', "your Item successfully deleted $pay->title");
        } else {
            return view('notfound')
                ->with('title', 'Error Page Not Found')
                ->with('page', 'Error Page Not Found')
                ->with('danger', "no info found");
        }
    }

    public function resend($email, $verify){
        return View('auth.email.resend')->with(['email' => $email,'verify' => $verify]);
    }

    public function contact(Request $request){
        $info = info::select('*')->first();
        $message = input::get('message');
        $data = $request->all();
        \Mail::send('emails.contact_form',
            ['data' => $data],
            function ($mail) use ($data) {
                $to_email = 'info@ratb.li';
                $to_name = 'Ratb.li';
                $mail->from('info@ratb.li',
                    "Ratb.li Contact");
                $mail->to($to_email, $to_name)->subject('Ratb.li Contact');
             });
        return view('landing')->with('info', $info);
    }

    public function dailyReport(){
        // get total No of users
        $counts['users']['all'] = User::all()->count();
        $counts['users']['providers'] = User::where('is_vendor' , 1)->get()->count();

        // get products counts
        $counts['products'] = Product::select(
            DB::raw('count(*) as allProducts') ,
            DB::raw('sum(case when status = 0 then 1 else 0 end) as waiting') ,
            DB::raw('sum(case when status = 1 then 1 else 0 end) as activated'),
            DB::raw('sum(case when status = 2 then 1 else 0 end) as deactivated')
        )->first()->toArray();

        $counts['orders'] = ItemsOrder::select(
            DB::raw('count(*) as allOrders') ,
            DB::raw('sum(case when status = 7 then 1 else 0 end) as completed') ,
            DB::raw('sum(case when status = 4 then 1 else 0 end) as rejected') ,
            DB::raw('sum(case when status = 5 then 1 else 0 end) as preparing') ,
            DB::raw('sum(case when status = 1 then 1 else 0 end) as waiting')
        )->where('created_at', '>', '2018-04-23')->first()->toArray();

        $counts['feed_back'] = Feeds::count();

        $date = Carbon::now()->format('Y-m-d');


        $lastDayData = Report::where('date', "<>", Carbon::now()->format('Y-m-d'))->orderBy('date' , 'desc')->first();


        $toDayData = Report::where('date', Carbon::now()->format('Y-m-d'))->first();
        if(!$toDayData){
            $toDayData = new Report();
            $toDayData->date = Carbon::now()->format('Y-m-d');
        }


        $toDayData->all_users = $counts['users']['all'];
        $toDayData->providers = $counts['users']['providers'];
        $toDayData->all_products = $counts['products']['allProducts'];
        $toDayData->waiting_products = $counts['products']['waiting'];
        $toDayData->active_products = $counts['products']['activated'];
        $toDayData->deactivated_products = $counts['products']['deactivated'];
        $toDayData->all_orders = $counts['orders']['allOrders'];
        $toDayData->completed_orders = $counts['orders']['completed'];
        $toDayData->rejected_orders = $counts['orders']['rejected'];
        $toDayData->preparing_orders = $counts['orders']['preparing'];
        $toDayData->waiting_orders = $counts['orders']['waiting'];
        $toDayData->feed_back = $counts['feed_back'];

        $toDayData->save();

        $toDayData = $toDayData->toArray();

        $lastDay = [
            'all_users' => 0,
            'providers' => 0,
            'all_products' => 0,
            'waiting_products' => 0,
            'active_products' => 0,
            'deactivated_products' => 0,
            'all_orders' => 0,
            'completed_orders' => 0,
            'rejected_orders' => 0,
            'preparing_orders' => 0,
            'waiting_orders' => 0,
            'feed_back' => 0,
        ];

        if($lastDayData){
            $lastDay = $lastDayData->toArray();
            unset($lastDay['id']);
            unset($lastDay['date']);
            unset($lastDay['created_at']);
            unset($lastDay['updated_at']);
        }

        $progressLevel = [];
        foreach ($lastDay as $k => $v){
            if($v > 0)
                $progressLevel[$k] = round(((intval($toDayData[$k]) - intval($v)) / ($v)) * 100,2) ;
            else if($v > 0 && intval($toDayData[$k]) > 0)
                $progressLevel[$k] = 100;
            else
                $progressLevel[$k] = 0;
        }

        return view('admin.report.report')
            ->with([
                'lastDay' => $lastDay,
                'toDayData' => $toDayData,
                'progressLevel' => $progressLevel
            ]);
    }

    public function reports(){
        $toDayData = Report::get();
        return view('admin.report.index')
            ->with([
                'reports' => $toDayData,
            ]);
    }

    public function report($date){
        $report = Report::orderBy('id', 'desc')->where('date', '=', $date)->first();

        $toDayData = $report->toArray();
        $report = Report::orderBy('id', 'desc')->where('id', '<', $toDayData['id'])->first();

        $lastDay = [
            'all_users' => 0,
            'providers' => 0,
            'all_products' => 0,
            'waiting_products' => 0,
            'active_products' => 0,
            'deactivated_products' => 0,
            'all_orders' => 0,
            'completed_orders' => 0,
            'rejected_orders' => 0,
            'preparing_orders' => 0,
            'waiting_orders' => 0,
            'feed_back' => 0,
        ];

        if($report){
            $lastDayData = $report->toArray();
            if($lastDayData){
                $lastDay = $lastDayData;
                unset($lastDay['id']);
                unset($lastDay['date']);
                unset($lastDay['created_at']);
                unset($lastDay['updated_at']);
            }
        }

        $progressLevel = [];
        foreach ($lastDay as $k => $v){
            if($v > 0)
                $progressLevel[$k] = round(((intval($toDayData[$k]) - intval($v)) / ($v)) * 100,2) ;
            else if($v > 0 && intval($toDayData[$k]) > 0)
                $progressLevel[$k] = 100;
            else
                $progressLevel[$k] = 0;
        }
        
        return view('admin.report.report')
            ->with([
                'lastDay' => $lastDay,
                'toDayData' => $toDayData,
                'progressLevel' => $progressLevel
            ]);
    }

    public function notifyVendor($id){
        $itemOrder = ItemsOrder::find($id);
        $order = Order::find($itemOrder->order_id);
        $product = Product::with('user')->findOrFail($itemOrder->product_id);


        $sms_try = $this->SendSms($product['user']->phone, ' السلام عليكم؛ تم التواصل معك بخصوص منتجك ' . $product->name . " علي منصة رتب.لي ولم يتم الرد. برجاء التواصل مع فريق عمليات رتب.لي من خلال رقم 920009277 ");
        return back()->with('message', " تم اشعار مزود الخدمة ");
    }

    public function notifyVendorProduct($id){
        $user = User::with(['Products' => function($query) use($id){
            $query->where('id',$id);
        } ])->whereHas('Products',function($query) use($id){
            $query->where('id',$id);
        })->first();

        $sms_try = $this->SendSms($user->phone, ' السلام عليكم؛ تم التواصل معك بخصوص منتجك ' . $user->products->first()->name . "علي منصة رتب.لي ولم يتم الرد. برجاء التواصل مع فريق عمليات جب. لي من خلال رقم 920009277" );

        return back()->with('message', " تم اشعار مزود الخدمة ");
    }

    public function unverifiedUsers(){
        $users = User::where('verified',0)->where('blocked' , 0)->get();

        return view('admin.users.unverified')
            ->with('users',$users);
    }

    public function resendTwiloMsg(Request $request){
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
        // $password = rand(100000,999999);

        // $user->password = Hash::make($password);

        $user->update();
        $this->storeLogs($user['id'], 'resend SMS Msg', Auth::user()->id, 'تم إعادة إرسال رسالة إلى المستخدم  ' . $user['user_name'] . ' رقم ' . $user['id']);
        // $message = "عميل رتب.لي نعتذر عن تأخر رسالة التفعيل وذلك حيث أنكم مشتركين في خدمة حظر الرسائل الدعائية. كود التفعيل الخاص بكم هو " . $v_code . " و كلمة المرور الخاصة بحسابكم هي" . $password;
        // $message = "السلام عليكم , عميل رتب.لي نعتذر عن تأخر وصول رسالة التفعيل وذلك لخلل في مزود خدمة الرسائل , ونكرر الاعتذار مجددا نرجو منكم الدخول على صفحتكم في التطبيق. كود التفعيل الخاص بكم هو ".$v_code." و كلمة المرورالجديدة الخاصة بحسابكم هي ".$password." ويمكنك تغيرر رقمك السري من داخل التطبيق او طلب رقم سري جديد من التطبيق.";
        // $message = trans('api.welcome_sms', ['code' => $request->get('v_code')]);
        // $send = Twilio::message($phone, $message);
        $message = "عزيزي العميل, تم إرسال رمز التفعيل (".$v_code.")  , يرجى المحاوله مره اخرى و إذا وجهتك أي مشكله برجاء التواصل مع احد ممثلي خدمة العملاء على الأرقام التاليه : 0593930003 - 0593930006";
        $send = $this->SendSms($phone,$message);

        return back();
    }

    public function published($id, $status){
        $category = Category::findOrFail($id);
        if($category->update(array('published' => $status))){
            return Redirect::to("/admin/category/view?success=$id")
                ->with('message', " تم تعديل حالة الخدمة   : ".$category->name_ar);
        }
    }

    public function sendLocation($id){
        $order = ItemsOrder::with(array('order' => function($q){$q->with('user');}, 'products' => function($q){$q->with('user');}))->findOrFail($id);
        /*echo */$phone = $order['products']['user']->phone;
        // echo "<br>";
        /*echo */$lat = $order->order_lat;
        // echo "<br>";
        /*echo */$long = $order->order_long;
        // echo "<br>";
        // dd($order['order']['user']->user_name);
        /*echo */$user_name = $order['order']['user']->user_name;
        /*echo */$product_name = $order['products']->name;
        // die();
        /*echo */$address = "https://www.google.com/maps/place?q=$lat,$long";
        // die();
        /*echo*/ $message = "عزيزنا شريك رتب لي؛ موقع العميل '$user_name' الخاص بالطلب '$product_name' هو $address";
        // die();

        $send = $this->SendSms($phone,$message);
        return back();
    }
}