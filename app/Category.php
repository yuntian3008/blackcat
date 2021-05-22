<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    protected $fillable = [
        'category_name', 'category_slug', 'category_visible', 'category_image',
    ];
}
