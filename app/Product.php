<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public function User(){
        return $this->belongsTo("App\User",'user_id');
    }

    public function owner(){
        return $this->belongsTo("App\User",'user_id');
    }

    public function Category(){
        return $this->belongsTo('App\Category', 'cat_id');
    }

    public function Images(){
        return $this->hasMany('App\Images');
    }

    public function orders(){
        return $this->hasMany('App\ItemsOrder');
    }

    public function productavailabilty(){
        return $this->hasMany('App\ProductAvailibility');
    }

    public function Feed(){
        return $this->hasMany('App\Feeds','prod_id')
            ->selectRaw('prod_id , avg(rate) AS avg')
            ->groupBy('prod_id');
    }
}
