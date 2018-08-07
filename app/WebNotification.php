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
class WebNotification extends Model
{
    protected $table = 'web_notifications';

    protected $fillable = array('user_id','title','body','action_link','seen');

    public function User(){

        return $this->belongsTo('App\User','user_id');

    }

}

