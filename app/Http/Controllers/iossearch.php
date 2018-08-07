<?php

namespace App\Http\Controllers;
use App\ItemsOrder;
use Illuminate\Http\Request;
use Mail;
use Input;
use Event;
use Session;
use Carbon;
use Validator;
use Hash;
use JWTAuth;
use Tymon\JWTAuth\JWTException;
use App\Http\Requests;
use App\User;
use App\Times;
use App\Area;
use App\Category;
use App\Town;
use App\Feeds;
use App\Country;
use App\Order;
use App\Product;
use App\Bookmark;
use Exception;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Illuminate\Support\Facades\Auth;
use Helpers;
use DB;

class iossearch extends Controller
{
    public function __construct(JWTAuth $jwt )
    {
        $this->jwt = $jwt;

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */

    public function filters(Request $request , $fil_pro_rate = NULL){

        $cat = input::get('cat');
        $product = input::get('name');
        $event = input::get('time');
        $id_filter = input::get('filter');
        $country = input::get('city');

        try {
            $orders = ItemsOrder::select('*')
                ->leftjoin('products','products.id','=','order_items.product_id')
                ->leftjoin('category', 'category.id', '=', 'products.cat_id')
                ->leftjoin('users', 'products.user_id', '=', 'users.id')
                ->leftjoin('order_product', 'order_product.id', '=', 'order_items.order_id')
                ->leftjoin('feed_back', 'feed_back.prod_id', '=', 'products.id')
                ->groupBy( 'products.id' )
                ->select('products.name as fil_name', 'products.price as fil_price',
                    'users.user_name as fil_product_user_name','products.cat_id as fil_category',
                    'category.name as fil_cat_name', 'products.views as fil_pro_views', 'products.desc as fil_pro_desc',
                    'products.img as fil_pro_img', 'category.name as fil_pro_category',
                    DB::raw(" IFNULL(avg(feed_back.rate),0) AS average")
                )
                ->where('order_items.date','like',"%{$event}%")
                ->get();

            $most_viewed = Product::select('views')
                ->leftjoin('category', 'category.id', '=', 'products.cat_id')
                ->leftjoin('users', 'products.user_id', '=', 'users.id')
                ->leftjoin('feed_back', 'feed_back.prod_id', '=', 'products.id')
                ->groupBy( 'products.id' )
                ->select('products.name as fil_name', 'products.price as fil_price','users.user_name as fil_product_user_name',
                    'products.cat_id as fil_category', 'category.name as fil_cat_name', 'products.views as fil_pro_views',
                    'products.desc as fil_pro_desc','products.img as fil_pro_img', 'category.name as fil_pro_category',
                    'feed_back.rate as fil_pro_rate',
                    DB::raw(" IFNULL(avg(feed_back.rate),0) AS average")
                )
                ->where('views','>',10)
                ->orderBy('views','DEC')
                ->get();

            $most_order = ItemsOrder::select('total')
                ->leftjoin('products','products.id','=','order_items.product_id')
                ->leftjoin('users', 'products.user_id', '=', 'users.id')
                ->leftjoin('category', 'category.id', '=', 'products.cat_id')
                ->leftjoin('feed_back', 'feed_back.prod_id', '=', 'products.id')
                ->groupBy( 'products.id' )
                ->select('products.name as fil_name', 'products.price as fil_price','users.user_name as fil_product_user_name',
                    'products.cat_id as fil_category', 'category.name as fil_cat_name', 'products.views as fil_pro_views',
                    'products.desc as fil_pro_desc','products.img as fil_pro_img', 'category.name as fil_pro_category',
                    DB::raw(" IFNULL(avg(feed_back.rate),0) AS average")
                )
                ->orderBy('total','DEC')
                ->get();
            $most_rated = Feeds::select('rate')
                ->leftjoin('products','products.id','=','feed_back.prod_id')
                ->leftjoin('users', 'products.user_id', '=', 'users.id')
                ->leftjoin('category', 'category.id', '=', 'products.cat_id')
                ->groupBy( 'products.id' )
                ->select('products.name as fil_name', 'products.price as fil_price','users.user_name as fil_product_user_name',
                    'products.cat_id as fil_category', 'category.name as fil_cat_name', 'products.views as fil_pro_views',
                    'products.desc as fil_pro_desc','products.img as fil_pro_img', 'category.name as fil_pro_category',
                    DB::raw(" IFNULL(avg(feed_back.rate),0) AS average")
                )
                ->where('rate','>',3)
                ->orderBy('rate','DEC')
                ->get();


            $query = Product::select('*')
                ->leftjoin('feed_back', 'feed_back.prod_id', '=', 'products.id')
                ->leftjoin('order_items', 'order_items.product_id', '=', 'products.id')
                ->leftjoin('users', 'products.user_id', '=', 'users.id')
                ->leftjoin('country', 'country.id', '=', 'users.country')
                ->leftjoin('order_product', 'order_product.id', '=', 'order_items.order_id')
                ->leftjoin('category', 'category.id', '=', 'products.cat_id')
                ->groupBy( 'products.id' )
                ->select('products.name as fil_name', 'products.price as fil_price','users.user_name as fil_product_user_name',
                    'products.cat_id as fil_category', 'category.name as fil_cat_name', 'products.views as fil_pro_views',
                    'products.desc as fil_pro_desc','products.img as fil_pro_img', 'category.name as fil_pro_category',
                    DB::raw(" IFNULL(avg(feed_back.rate),0) AS average")
                )
                ->where('products.name', 'like', "%{$product}%")
                ->where('products.cat_id', 'like', "%{$cat}%")
                ->where('users.country', 'like', "%{$country}%")
                ->get();
            if($product || $cat) {
                return response()->json(['result' => $query, 'success' => true]);
            }elseif($product || $cat || $event){
                return response()->json(['result' => $orders, 'success' => true]);
            }elseif($id_filter == 3) {
                return response()->json(['result' => $most_viewed, 'success' => true]);
            }elseif($id_filter == 2){
                return response()->json(['result' => $most_order, 'success' => true]);
            }elseif($id_filter == 1){
                return response()->json(['result' => $most_rated, 'success' => true]);
            }
            if($product == null || $cat == null ||$event == null || $id_filter == null){
                return response()->json(['error' => 70, 'message' => 'must add on field at least'])->setStatusCode(400);
            }
        }catch(Exception $exception) {
            return response()->json(['error' =>  $exception->getCode(),'message' => 'no thing found'])->setStatusCode(400);
        }
    }

}
