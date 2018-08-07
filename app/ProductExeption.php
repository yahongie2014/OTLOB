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
class ProductExeption extends Model
{
    protected $table = 'product_exeption_date';

    protected $fillable = array('product_id','date');

    public function Products(){

        return $this->belongsTo('App\Product','product_id');

    }

}

