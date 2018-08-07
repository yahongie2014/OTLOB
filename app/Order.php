<?php

namespace App;
use App\Product;
use App\BankAccount;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order_product';

    protected $fillable = array('user_id','order_id','total','status', 'currency_rate' , 'promo_code_id' , 'total_after_discount');

    public function Items()
    {
        return $this->hasMany('App\ItemsOrder');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function bankaccount(){
        return $this->belongsTo('App\BankAccount','bank_id','id');
    }

}
