<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    protected $table = 'notify' ;

    public function User(){

        return $this->belongsToMany("App/User");
    }

}
