<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    protected $visible = ['id', 'name', 'name_en', 'desc', 'desc_en', 'img', 'img_en', 'is_offer', 'published', 'created_at', 'updated_at'];

    protected $fillable = ['name', 'name_en', 'desc', 'desc_en', 'img', 'img_en', 'is_offer', 'published'];

    public function Products(){
        return $this->hasMany('App\Product');
    }

    public function languages(){
        return $this->belongsToMany('App\User', 'user_category','user_id', 'cat_id');
    }

    public function scopePublished($query) {
        $query->where('published', '=', 1);
    }
}
