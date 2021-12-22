<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Components\Helper\ImageProcessing;

class Product extends Model
{
    protected $fillable = [
        'product_name', 'product_image', 'product_slug', 'category_id', 'product_price', 'product_desc', 'product_visible'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category')->withTrashed();
    }

    public function specs()
    {
        return $this->hasMany('App\Specs');
    }


    public function getImage($size = 'sm')
    {
        return ImageProcessing::getURL($this->product_image,$size);
    }

    public function addStock($quantity)
    {
        $this->stock += $quantity;
        $this->save();
    }

    public function subStock($quantity)
    {
        $this->stock -= $quantity;
        $this->save();
    }

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

    public function avgRating()
    {
        return $this->reviews()
          ->selectRaw('avg(level) as aggregate')
          ->groupBy('product_id');
    }

    public function getAvgRatingAttribute()
    {
        if ( ! array_key_exists('avgRating', $this->relations)) {
           $this->load('avgRating');
        }

        $relation = $this->getRelation('avgRating')->first();

        return ($relation) ? $relation->aggregate : null;
    }

    protected $appends = ['available'];

    public function getAvailableAttribute()
    {
        return $this->stock > 0;
    }
}
