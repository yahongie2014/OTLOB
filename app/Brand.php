<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';

    public function Area(){

        return $this->belongsTo("App/Area");
    }

}
