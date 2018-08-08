<?php

use App\info;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
//Api Access
Route::group(['middleware' => ['api'],'prefix' => 'api'], function () {

//order
Route::post('/twiloTest', 'ApiController@sendTwiloMsg');
Route::get('firebase', 'ApiController@firebase_test');
Route::get('user_info', 'ApiController@get_user_info');
Route::post('firebase', 'ApiController@firebase');
Route::post('push/all', 'ApiController@group_send');
Route::post('push/one', 'ApiController@Push_Test');
Route::post('register', 'ApiController@register');
Route::post('login', 'ApiController@login');
Route::post('resend', 'ApiController@resend');
Route::post('reset', 'ApiController@reset');
Route::post('login/vendor', 'ApiController@login_vendor');
Route::post('/profile/confirm', array('as' => 'profile confirm', 'uses' => 'ApiController@confirm'));
Route::get('category','ApiController@Category');
Route::get('currency','ApiController@currency');
Route::get('country','ApiController@country_list');
Route::get('city','ApiController@city_identify');
Route::get('town','ApiController@town_list');
Route::get('area','ApiController@Areas');
Route::get('product','ApiController@Products');
Route::get('product/single', array('as' => 'Show_Productss', 'uses' => 'ApiController@Single_ProductEX'));
Route::get('category/products', array('as' => 'cat_pro', 'uses' => 'ApiController@Category_products'));
Route::get('vendors/products', array('as' => 'Category_vendor', 'uses' => 'ApiController@Category_vendors'));
Route::get('/contact', array('as' => 'contact', 'uses' => 'ApiController@contact_get'));
Route::get('/about', array('as' => 'about_us', 'uses' => 'ApiController@about_get'));
Route::get('/filters', array('as' => 'Search_advanced', 'uses' => 'FilterSearch@filters'));
Route::post('/filterios', array('as' => 'Search_ios', 'uses' => 'iossearch@filters'));
Route::get('/search', array('as' => 'RegularSearch', 'uses' => 'ApiController@search'));
Route::get('times', array('as' => 'Time_stamp', 'uses' => 'ApiController@Time_get'));
Route::post('cart', 'ApiController@postAddToCartEx');
Route::get('category/{id}/provider','ApiController@providerByCategory');
Route::get('category/{category_id}/provider/{provider_id}' , 'ApiController@getProductsByProviderAndCategory');
Route::get('count/cart', 'ApiController@count_cart');
Route::get('cart/all',array('as'=>'cart_all_in_one','uses'=>'ApiController@get_all_cart'));
Route::delete('deleteItem', 'ApiController@delete_item');
Route::post('update/cart', 'ApiController@update_cart');
Route::post('bookmark/product/store','ApiController@bookmark_product');
Route::get('bookmark/all','ApiController@bookmark_all');
Route::delete('unbookmark', 'ApiController@unbookmark');
Route::delete('unbookmark/product', 'ApiController@unbookmark_product');
Route::group(['middleware' => 'jwt-auth'], function () {
Route::get('order/single', array('as'=>'get_orders','uses'=>'ApiController@getIndex'));
Route::get('ordersnew', array('as'=>'get_orders_new','uses'=>'ApiController@getOrderNew'));
Route::post('profile', 'ApiController@profile');
Route::post('brand/store', 'ApiController@Brand_store');
Route::post('product/store', 'ApiController@Product_store');
Route::post('category/store','ApiController@Category_store');
Route::post('bookmark/package/store','ApiController@bookmark_package');
Route::post('feed/package', 'ApiController@Feed_package');
Route::post('feed/product', 'ApiController@Feed_product');
Route::post('contact/store', 'ApiController@contact_store');
Route::post('payment/store', 'ApiController@Payment_store');
Route::post('time/store', 'ApiController@Time_Store');
Route::post('country/store', 'ApiController@country_store');
Route::post('town/store', 'ApiController@town_store');
Route::post('area/store', 'ApiController@Area_store');
Route::post('logout', 'ApiController@logout');
Route::get('payment','ApiController@Payment');
Route::get('orders','ApiController@Orders');
Route::get('bookmark/get/product','ApiController@bookmark_get_product');
Route::post('/profile/edit', array('as' => 'Profileedit', 'uses' => 'ApiController@Profile_edit'));
Route::post('/profile/edit/ios', array('as' => 'Profile_edit_ios', 'uses' => 'ApiController@Profile_edit_ios'));
Route::post('/payment/edit', array('as' => 'payedit', 'uses' => 'ApiController@Payment_edit'));
Route::post('/order/edit', array('as' => 'ordedit', 'uses' => 'ApiController@Order_edit'));
Route::get('/payment/show', array('as' => 'payment_show', 'uses' => 'ApiController@show_payment'));
Route::get('feed/product','ApiController@Rate_product');
Route::get('feed/package','ApiController@Rate_package');
Route::post('update/rate', 'ApiController@rate_edit');
Route::delete('empty', 'ApiController@emptycart');
Route::post('order/store', array('as'=>'order_make','uses'=>'ApiController@postOrderEx'));
Route::get('user/locations', array('uses'=>'ApiController@userLocations'));
Route::get('whishlist', array('as' => 'whishlist_cat', 'uses' => 'ApiController@whishlist'));
Route::post('/receive', 'ApiController@json_recive');
Route::post('/paid', array('as' => 'paid', 'uses' => 'ApiController@is_paid'));
Route::get('users','ApiController@Users');
Route::get('data/payment','ApiController@payment_data');
//payment
Route::get('payfort', 'ApiController@payfort');
Route::post('capture', 'ApiController@Purchase');
Route::post('Refund ', 'ApiController@Refund');
Route::get('sadad', 'ApiController@sadad');
Route::get('/thankyou',function(){
return view('thanku');
});
});
Route::get('banks','ApiController@banks');
Route::get('nations','ApiController@nations');
Route::get('nations/{id}','ApiController@nation');
    Route::get('/promo/{code}', "PromoController@show");
});
//Admin Access
Route::group(['middleware' => ['web','admin']], function () {
Route::get('/admin/twiloResend', array('as' => 'twiloTest', 'uses' => 'AdminController@resendTwiloMsg'));
Route::get('/admin', array('as' => 'dashboard', 'uses' => 'AdminController@Dashboard'));
Route::get('/admin/report','AdminController@dailyReport');
Route::get('/admin/reports','AdminController@Reports');
Route::get('/admin/report/{date}','AdminController@report');
Route::get('/admin/lock', function () {return view('admin.Lock');});
Route::get('/admin/countries/{id?}', 'AdminController@getContries');
Route::get('/admin/newcountry', 'AdminController@newContries');
Route::get('/admin/countries/edit/{id}', 'AdminController@editContries');
Route::post('/admin/countries', 'AdminController@addCountries');
Route::post('/admin/updatecountry', 'AdminController@updateContries');
Route::get('/admin/countrystatus/{id}/{cstatus}', 'AdminController@approveContries');
Route::post('/admin/lock/auth', array('as' => 'Admin_lock', 'uses' => 'AdminController@lock'));

Route::get('/admin/users/carts', 'AdminController@carts');
Route::get('/admin/user/{id}/cart', 'AdminController@user_cart');
Route::get('/admin/user/{id}/cart/delete', 'AdminController@delete_cart');
Route::get('/dashboard', array('as' => 'Dashboard', 'uses' => 'AdminController@Dashboard'));

Route::get('/resend/{mail}/{verify}', array('as' => 'resend', 'uses' => 'Auth\AdminController@resend'));

Route::get('/admin/promo','PromoController@index');
    Route::post('/admin/promo/add','PromoController@store');
    Route::get('/admin/promo/update/{id}/{status}','PromoController@update');

/*Route::get('/admin/profile/{user_name}' , function () {
$title = auth()->user()->user_name;
return view('admin.profile')->with('title',$title);
});*/

Route::get('/admin/edit/{id}', array('as' => 'Edit_User', 'uses' => 'AdminController@edit_user'));
Route::get('/admin/category/published/{id}/{status}', 'AdminController@published');

Route::post('/admin/profile/update', array('as' => 'AdminUserUpdate', 'uses' => 'AdminController@update_User_profile'));

Route::get('product/add', function () {
return view('admin.products.new');});

Route::post('product/add/new', array('as' => 'ProductAdd', 'uses' => 'CreateController@add_new_product'));

Route::get('product/view', array('as' => 'ProductShow', 'uses' => 'AdminController@product_show'));

Route::get('admin/product/view/{today}', array('as' => 'ProductShow', 'uses' => 'AdminController@product_show'));

Route::get('/admin/product/edit/{id}', 'CreateController@product_edit');

Route::get('/admin/getvendores', 'AdminController@getVendores');
Route::get('/admin/getvendorsproducts/{vendorid}', 'AdminController@getVendoresProducts');
Route::get('/admin/productapprove/{productid}/{statusid}', 'AdminController@approveProduct');
Route::get('/admin/getproduct/{productid}', 'AdminController@getProductDetails');
Route::get('/admin/getproductsbystatus/{status}', 'AdminController@getProductByStatus');
Route::get('/admin/sendLocation/{id}', 'AdminController@sendLocation');

Route::get('/admin/product/delete/{id}', 'CreateController@Del_Product');

Route::post('/admin/product/update', array('as' => 'ProUpdate', 'uses' => 'CreateController@product_update'));

Route::post('/admin/update_product', 'AdminController@updateProduct');

Route::get('/admin/transaction', array('as' => 'Transaction', 'uses' => 'TransactionController@Transaction_view'));
Route::get('admin/purchase/{tran_order_number}', array('as' => 'Purchase_admin', 'uses' => 'TransactionController@Purchase_Trancaction'));
Route::get('admin/refund/{tran_order_number}', array('as' => 'Refund_admin', 'uses' => 'TransactionController@Refund_Trancaction'));



/*Route::get('admin/payment/view', function () {
//$payment = App\BankAccount::select('*')->get();
$payment = App\BankAccount::with('order')->get();
dd($payment->toArray());
return view('admin.payment.view')->with('payment',$payment);
});*/

Route::get('admin/payment/view','AdminController@getPayments');

Route::get('admin/payment/new', function () {
return view('admin.payment.new');
});

Route::get('admin/payment/edit/{id}', function () {
return view('admin.payment.edit');});



Route::post('/admin/payment/post', array('as' => 'payment_store', 'uses' => 'AdminController@payment_store'));

Route::post('/admin/payment/update', array('as' => 'payment_update', 'uses' => 'AdminController@payment_update'));

Route::get('admin/payment/edit/{id}', array('as' => 'payment_edit', 'uses' => 'AdminController@payment_edit'));

Route::get('admin/payment/delete/{id}', array('as' => 'payment_del', 'uses' => 'AdminController@payment_del'));


Route::get('/admin/orders/view/{id}', array('as' => 'OrderShow', 'uses' => 'VendorController@orders_viewEX'));

Route::get('/admin/orders/delete/{id}', array('as' => 'OrderShow', 'uses' => 'VendorController@delete_order'));

Route::get('/admin/orders/view/{id}/{today}', array('as' => 'OrderShow', 'uses' => 'VendorController@orders_viewEX'));

Route::get('rates/view', array('as' => 'RateShow', 'uses' => 'AdminController@rate_view'));

Route::get('/admin/info', function () {return view('admin.info.new');});

Route::get('/admin/info/view', array('as' => 'InfoShow', 'uses' => 'AdminController@info_view'));

Route::post('/admin/info/new', array('as' => 'InfoAdd', 'uses' => 'AdminController@info_store'));

Route::get('/admin/info/edit/{id}', 'AdminController@info_edit');

Route::get('/admin/info/delete/{id}', 'AdminController@Del_info');

Route::post('/admin/info/update', array('as' => 'InfoUpdate', 'uses' => 'AdminController@info_update'));

Route::get('/admin/user', function () {return view('admin.users.new');});

Route::post('/admin/user/new', array('as' => 'AdminUserNew', 'uses' => 'AdminController@add_user'));

Route::get('/admin/user/view/{id}', 'AdminController@User_view');

Route::get('/admin/user/view/{id}/{today}', 'AdminController@User_view');

Route::get('/admin/user/delete/{id}', 'AdminController@Del_user');

Route::get('/admin/user/permission', 'AdminController@permission');

Route::get('/admin/user/verify/{id}/{user_type}', array('as' => 'PermissionVerify', 'uses' => 'AdminController@Verifed'));
Route::get('/admin/verifyuser/{id}', 'AdminController@Verify');

Route::get('/admin/user/unverify/{id}{user_type}', array('as' => 'PermissionUNVerify', 'uses' => 'AdminController@UN_Verifed'));

Route::get('/admin/make/admin/{id}/{user_type}', array('as' => 'MakeAdmin', 'uses' => 'AdminController@MK_admin'));

Route::get('/admin/make/vendor/{id}/{user_type}', array('as' => 'MakeVendor', 'uses' => 'AdminController@MK_vendor'));

Route::get('/admin/make/regular/{id}/{user_type}', array('as' => 'MakeRegular', 'uses' => 'AdminController@MK_regular'));

Route::get('/admin/started/{id}', array('as' => 'Started', 'uses' => 'AdminController@started'));

Route::get('/admin/inprogress/{id}', array('as' => 'Progress', 'uses' => 'AdminController@progress'));

Route::get('/admin/Completed/{id}', array('as' => 'Completed', 'uses' => 'AdminController@completed'));

Route::get('/admin/Prepare/{id}', array('as' => 'prepare', 'uses' => 'AdminController@prepare'));

Route::get('/admin/processing/{id}', array('as' => 'processing', 'uses' => 'AdminController@processing'));

Route::get('/admin/accept/{id}', array('as' => 'accept', 'uses' => 'AdminController@accept'));

Route::get('/admin/refuse/{id}', array('as' => 'refuse', 'uses' => 'AdminController@refuse'));

Route::get('/admin/category/add', function () {return view('admin.category.new');});

Route::post('/admin/category/new', array('as' => 'AdminCategoryNew', 'uses' => 'AdminController@add_category'));

Route::get('/admin/category/view', array('as' => 'AdminCategoryView', 'uses' => 'AdminController@show_category'));

Route::get('/admin/category/edit/{id}', 'AdminController@category_edit');

Route::post('/admin/category/update', array('as' => 'CategoryUpdate', 'uses' => 'AdminController@category_update'));

Route::get('/admin/category/delete/{id}', 'AdminController@Del_category');
Route::get('/admin/payment/orders/{id}','AdminController@getPaymentOrders');
Route::get('/notifyvendor/{id}','AdminController@notifyVendor');
Route::get('/notifyvendorproduct/{id}','AdminController@notifyVendorProduct');
Route::get('/unverifiedusers','AdminController@unverifiedUsers');
});

//Vendor Access
Route::group(['middleware' => ['web','vendor']], function () {
Route::get('/vendors', array('as' => 'Dah', 'uses' => 'VendorController@index'));

//user privillage for vendor
Route::get('/vendors/user/view', array('as' => 'user_view', 'uses' => 'VendorController@User_view'));

Route::get('/vendors/user', function () {
    return view('vendor.users.new');
});

Route::post('/vendors/user/add', array('as' => 'user_add', 'uses' => 'VendorController@User_save'));

Route::get('/vendors/user/verify/{id}', array('as' => 'PermissionVerifyvendors', 'uses' => 'VendorController@Verifed'));

Route::get('/vendors/verifyuser/{id}', 'VendorController@Verify');

Route::get('/vendors/user/unverify/{id}', array('as' => 'PermissionUNVerifyvendors', 'uses' => 'VendorController@UN_Verifed'));

Route::get('/vendors/user/cook/{id}', array('as' => 'MakeCook', 'uses' => 'VendorController@MK_cook'));

Route::get('/vendors/user/marketing/{id}', array('as' => 'MakeMarketing', 'uses' => 'VendorController@MK_market'));

Route::get('/vendors/user/account/{id}', array('as' => 'MakeAccount', 'uses' => 'VendorController@MK_account'));

Route::get('/vendors/user/edit/{id}', array('as' => 'edit_user_vendor', 'uses' => 'VendorController@edit_user_'));
Route::post('/vendors/profile/update', array('as' => 'VendorsUserUpdate', 'uses' => 'VendorController@update_User_Vendor'));

//end

Route::get('/vendors/branch', 'VendorController@getBranch');
Route::post('/vendors/branch/add', 'VendorController@addBranch');
Route::get('/vendors/edit/{id}', array('as' => 'Edit_User', 'uses' => 'VendorController@edit_user'));
Route::post('/vendors/profile/update', array('as' => 'AdminUserUpdateVendor', 'uses' => 'VendorController@update_User_profile'));
Route::get('/vendors/profile/{user_name}' , function () {
$title = auth()->user()->user_name;
return view('admin.edit_vendor')->with('title',$title);
});
Route::get('/vendors/lock', function () {return view('admin.Lock');});
Route::get('/vendors/product/add', function () {
$userCats = auth()->user()->categories()->orwhere('is_offer', '=', 1)->published()->groupby('id')->get();
$weekDays = [6 => "السبت",0 => "الاحد", 1 => "الاثنين",2 => "الثلاثاء",3 => "الاربعاء", 4 => "الخميس",5 => "الجمعة"];
//$weekDays = [];
//dd($userCats->toArray());
return view('admin.productsvendor.new')->with(['userCategories' => $userCats , "weekDays" => $weekDays]);
});
Route::post('/vendors/product/add/new', array('as' => 'ProductAddVendor', 'uses' => 'VendorController@add_new_product'));
Route::get('/vendors/product/exception/{id}', array('uses' => 'VendorController@productDateException'));
Route::post('/vendors/product/exception/{id}', array('uses' => 'VendorController@productDateExceptionAdd'));
Route::get('/vendors/product/exceptiondelete/{id}', array('uses' => 'VendorController@productDateExceptionDelete'));
Route::get('/vendors/product/view', array('as' => 'ProductShow', 'uses' => 'VendorController@product_show'));
Route::get('/vendors/product/edit/{id}', 'VendorController@product_edit');
Route::get('/vendors/product/delete/{id}', 'VendorController@Del_Product');
Route::post('/vendors/product/update', array('as' => 'ProUpdateVendor', 'uses' => 'VendorController@product_update'));
Route::get('/vendors/orders/view/{id}', array('as' => 'OrderShowVendor', 'uses' => 'VendorController@orders_viewEX'));
Route::get('/vendors/rates/view', array('as' => 'RateShowVendor', 'uses' => 'VendorController@rate_view'));
Route::get('/vendors/started/{id}', array('as' => 'StartedVendor', 'uses' => 'VendorController@startedOrderItem'));
Route::get('/vendors/inprogress/{id}', array('as' => 'ProgressVendor', 'uses' => 'VendorController@progress'));
Route::get('/vendors/Completed/{id}', array('as' => 'CompletedVendor', 'uses' => 'VendorController@completedOrderItem'));
Route::get('/vendors/Prepare/{id}', array('as' => 'prepareVendor', 'uses' => 'VendorController@prepareOrderItem'));
Route::get('/vendors/processing/{id}', array('as' => 'processingVendor', 'uses' => 'VendorController@processingOrderItem'));
Route::get('/vendors/accept/{id}', array('as' => 'acceptVendor', 'uses' => 'VendorController@accept'));
Route::get('/vendors/refuse/{id}', array('as' => 'refuseVendor', 'uses' => 'VendorController@refuse'));
Route::get('/vendors/acceptitemorder/{id}', array('as' => 'acceptVendor', 'uses' => 'VendorController@acceptOrderItem'));
Route::get('/vendors/refuseitemorder/{id}', array('as' => 'refuseVendor', 'uses' => 'VendorController@refuseOrderItem'));
Route::post('/vendors/deleteproductimg','VendorController@deleteProductImg');
});


// New Update For Vendor
Route::group(['middleware' => ['web','sales']], function () {
route::resource('sales','SalesController');
Route::get('/sales/rates/view', array('as' => 'RateShowSales', 'uses' => 'SalesController@rate_view'));
Route::get('/sales/product/view', array('as' => 'ProductShow_sales', 'uses' => 'SalesController@product_show'));
Route::get('/sales/notifications', 'SalesController@UserNotifications_sales');
});

Route::group(['middleware' => ['web','account']], function () {
route::resource('accountant','AccountController');
Route::get('/accountant/orders/view/{id}', array('as' => 'OrderShow_Vendor', 'uses' => 'AccountController@orders_viewEX'));
Route::get('/accountant/notifications', 'AccountController@UserNotifications_account');

});

Route::group(['middleware' => ['web','cook']], function () {
route::resource('cooker','CookController');
Route::get('/cooker/orders/view/{id}', array('as' => 'Ordercooker_Vendor', 'uses' => 'CookController@orders_viewEX'));
Route::get('/cooker/product/view', array('as' => 'ProductShow_sales', 'uses' => 'CookController@product_show'));
Route::get('/cooker/notifications', 'CookController@UserNotifications_cook');

});
//End














//User Access
Route::group(['middleware' => ['web']], function () {
Route::auth();

Route::get('policy',function (){
return view('admin.policy');
});
Route::get('/home', 'HomeController@index');
Route::get('admin/logs', 'HomeController@logs');
Route::get('/statistics', 'AdminController@statistics');
Route::get('/notifications', 'AdminController@UserNotifications');
Route::post('/setuserwebtoken', 'AdminController@setAdminfcmToken');
route::get('/orderdetails/{orderitemid}','AdminController@orderitemdetails');

Route::get('/',function(){
if(isset(Auth::user()->id))
return Redirect::to('dashboard');
$rate = DB::table('feed_back')->count();
$orders = DB::table('order_product')->count();
$vendors = DB::table('users')->where('is_vendor', '!', '1')->count();
$download_apps = DB::table('users')->whereNotNull('firebase_token')->count();
$statistics['rate'] = $rate;
$statistics['orders'] = $orders;
$statistics['vendors'] = $vendors;
$statistics['download_apps'] = $download_apps;
$info = info::first();
return view('landing_sa3ed')->with('info', $info)->with('statistics', $statistics);
});

Route::get('/confirmiton',function(){
return view('confirmiton');
});

Route::get('/verify/resend',function(){
return view('auth.verifyresend');
});
Route::post('/verify/resend','HomeController@verifyResend');
Route::get('/confirm/{vcode}/{email}', [
'as' => 'confirmation_path',
'uses' => 'HomeController@userActivation'
]);

});
Route::post('/contacting', 'AdminController@contact');

Route::get("test",'Controller@test');
Route::get('user/activation', 'Auth\AuthController@userActivation');
Route::get('api/ios/app', 'ApiController@iosAppShareLink');