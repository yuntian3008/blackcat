<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Components\Helper\ImageProcessing;

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


    public function getImage($size = 'sm')
    {
        return ImageProcessing::getURL($this->product_image,$size);
    }

    protected $fillable = [
        'product_name', 'product_image', 'product_slug', 'category_id', 'product_price', 'product_desc', 'product_visible'
    ];

    public function cartItems()
    {
        return $this->hasMany('App\CartItem');
    }

    public function orderDetail()
    {
        return $this->hasMany('App\OrderDetail');
    }
}
