<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Payment extends Model
{
    use SearchableTrait;
    protected $table = 'payment';


    public function User(){

        return $this->belongsTo("App/User");
    }
}
