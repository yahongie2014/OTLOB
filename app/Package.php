<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';

    public function User(){

        return $this->belongsToMany("App/User");
    }
    public function Product(){

        return $this->hasMany("App/Product");
    }


}
