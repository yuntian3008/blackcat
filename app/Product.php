<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function specs()
    {
        return $this->hasMany('App\Specs');
    }

    protected $fillable = [
        'product_name', 'product_image', 'product_slug', 'category_id', 'product_price', 'product_visible', 'product_desc',
    ];
}
