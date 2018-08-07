<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemsOrder extends Model
{
    protected $table = 'order_items' ;

    public function orderItems()
    {
        return $this->belongsToMany('App\Product')->withPivot('total','product_id','gender','address','time','date','notes','amount');
    }

    public function products()
    {
        return $this->belongsTo('App\Product','product_id');
    }

    public function user(){
    	return $this->belongsTo('App\User','user_id');
    }

    public function order(){
        return $this->belongsTo('App\Order');
    }
    protected $guarded = array();

}
