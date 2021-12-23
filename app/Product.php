<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Components\Helper\ImageProcessing;

class Product extends Model
{
    protected $appends = ['images','stars','url'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function specs()
    {
        return $this->hasMany('App\Specs');
    }


    public function getImage($size = 'sm')
    {
        return ImageProcessing::getURL($this->product_image,$size);
    }

    public function getUrlAttribute()
    {
        return url("/shop/{$this->category->category_slug}/{$this->product_slug}");
    }

    public function getImagesAttribute()
    {
        return [
            ImageProcessing::getURL($this->product_image,'sm'),
            ImageProcessing::getURL($this->product_image,'bg')
        ];
    }

    public function getStarsAttribute()
    {
        $stars = $this->reviews->avg('level');
        $stars = is_null($stars) ? 0 : $stars;
        return $stars;
    }

    protected $fillable = [
        'product_name', 'product_image', 'product_slug', 'category_id', 'product_price', 'product_desc', 'product_visible'
    ];

    public function cartItems()
    {
        return $this->hasMany('App\CartItem');
    }

    public function orderDetails()
    {
        return $this->hasMany('App\OrderDetail');
    }

    public function reviews()
    {
        return $this->hasManyThrough('App\Review', 'App\OrderDetail');
    }
}
