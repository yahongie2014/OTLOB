<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nations extends Model
{
    protected $table = 'nations';

    protected $fillable = array('name', 'code', 'currency_code', 'currency_name');

    protected $visible = array('id', 'name', 'code', 'currency_code', 'currency_name', 'status', 'flag', 'created_at', 'updated_at');

    public function bankaccount(){

        return $this->hasMany('App\BankAccount');

    }

}
