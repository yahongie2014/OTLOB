<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
class Area extends Model
{
    protected $table = 'area';

    public function Area(){

        return $this->hasManyThrough('App\Country', 'App\Town');
    }

}
