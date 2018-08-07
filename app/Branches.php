<?php
/**
 * Created by PhpStorm.
 * User: mnaser
 * Date: 26/09/17
 * Time: 04:10 م
 */


namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
class Branches extends Model
{
    protected $table = 'Branches';

    protected $fillable = array('user_id','date' ,'branch_lat' , 'branch_long' , 'jiibli_branch_id');

    public function User(){

        return $this->belongsTo('App\User','user_id');

    }

}

