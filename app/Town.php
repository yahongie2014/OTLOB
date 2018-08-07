<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    protected $table = 'town';

    public function Country(){

        return $this->belongsTo("App/Country");
    }

}
