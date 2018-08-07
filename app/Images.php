<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $fillable = [
        'product_id', 'pic'
    ];

    public $table = 'product_image';
}
