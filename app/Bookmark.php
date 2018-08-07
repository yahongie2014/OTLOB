<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{

    protected $table = 'bookmark';

    public function User(){

        return $this->belongsToMany("App/User");
    }
    public function Product(){

        return $this->belongsToMany("App/Product");
    }


}
