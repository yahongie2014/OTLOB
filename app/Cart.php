<?php

namespace App;
use App\Product;
use App\Availibility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\ProductExeption;
class Cart extends Model
{
    protected $table = 'carts';

    protected $fillable = array('user_id','product_id','amount','total','gender','address','time','date','notes', 'device_id', 'device_type');

    public function Products(){
        return $this->belongsTo('App\Product','product_id');
    }

    public function user(){
        return $this->belongsTo('App\user');
    }

    public static function check_availibilityEx($cart_id = 0,$product_id , $date , $gender ,$period , $quantity){
        $genders = [
            1 => "male",
            2 => "female",
            3 => "nogeder"
        ];
        // $dayPeriods = [1 => "افطار" , 2 => "عشاء" , 3 => "سحور"];
        $dayPeriods = [1 => "صباحا" , 2 => "ظهرا" , 3 => "مساء"];
        $date = new \DateTime($date);

        $product = Product::find($product_id);
        if($product->status == 2)
            return  $result = ['cart_id' => $cart_id , 'product_id' => $product_id, 'status' => false,'message' => ' product is deactivated '];


        $availablePeriodes = ProductAvailibility::where("product_id",$product_id)->where('day_no',$date->format('w'))->where('gender',array_search ($gender, $genders))->where('period',array_search ($period, $dayPeriods))->first();

        $exception_date = ProductExeption::where('product_id' , $product_id)->pluck('date')->toArray();

        if($availablePeriodes && !in_array($date->format('Y-m-d'), $exception_date)){
            $oldOrders = ItemsOrder::select('time',DB::raw('sum(amount) as itemtotal'))
                                    ->where('product_id', '=', $product_id)
                                    ->where('date', '=', $date->format('Y-m-d'))
                                    ->where('time',$period)->where('gender',$gender)
                                    ->groupBy('time')->first();

            $checkQunt = $oldOrders ? $availablePeriodes->quantity - $oldOrders->itemtotal - $quantity : $availablePeriodes->quantity - $quantity;


            //dd($availablePeriodes->quantity);
            if($checkQunt < 0){
                return ['status' => false,'cart_id' => $cart_id , 'product_id' => $product_id,'message' => ' out of stock '];
            }else{
                return ['status' => true, 'cart_id' => $cart_id ,'product_id' => $product_id,'message' => ' available '];
            }
        }else{
            return ['status' => false, 'cart_id' => $cart_id ,'product_id' => $product_id,'message' => ' unavailable '];
        }
    }
    public static function check_availibility($cart_id ,$product_id , $date , $quantity){

        // get available quantity from product
        $product = Product::find($product_id);

        if(empty($product))
            return ['cart_id' => $cart_id , 'product_id' => $product_id, 'status' => false,'message' => 'undefinde product '];

        if(!isset($product->m) || empty($product->m))
            $product->m = 0 ;

        // get reserved quantity
        $area_t = Availibility::select('sum(quantity)')
            ->select(DB::raw("SUM(quantity) as total_quantity"))
            ->where([
                ['product_id', '=', $product_id],
                ['date', '=', $date]
            ])
            ->get()->toArray();

        if(isset($area_t [0]['total_quantity']) && !empty($area_t [0]['total_quantity'])){
            $quantity_resived = $area_t [0]['total_quantity'];
            $available_to_reserve = $product->m - $quantity_resived;

            if($available_to_reserve >= $quantity)
                return $result = ['cart_id' => $cart_id , 'product_id' => $product_id, 'status' => true,'message' => 'available'];
            elseif($product->status == 2)
                return  $result = ['cart_id' => $cart_id , 'product_id' => $product_id, 'status' => false,'message' => ' product is deactivated '];
            else
                return  $result = ['cart_id' => $cart_id , 'product_id' => $product_id, 'status' => false,'message' => ' out of stock '];

        }else
            return  $result = ['cart_id' => $cart_id , 'product_id' => $product_id, 'status' => true,'message' => 'available'];


    }


}
