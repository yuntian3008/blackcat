<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
	protected $fillable = [
        'product_id','order_id','quantity','discount',
    ];


    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function review()
    {
        return $this->hasOne('App\Review');
    }

    public function customer()
    {
        return $this->hasOneThrough('App\Customer', 'App\Order');
    }

    public function trackingGoods()
    {
        return $this->hasOne('App\TrackingGoods');
    }
}
