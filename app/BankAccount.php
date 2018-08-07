<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $table = 'bank_account';

    protected $fillable = array('bank_name','accout_no','iban','swift','country','currency');

    protected $visible = array('id','bank_name','iban','swift','country','currency','order','ordersum','sumtotal');

    public function order(){

        return $this->hasMany('App\Order','bank_id','id');

    }

    public function ordersum(){
        return $this->hasMany('App\Order','bank_id','id')->select(DB::raw('SUM(total) as sumtotal') , 'Bank_id')
            ->groupBy('Bank_id');
    }
    public function currency(){
        return $this->belongsTo('App\Currency','currency');
    }
}
