<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'order_detail_id','comment','level','review_image',
    ];

    public function getImage($size = "sm") {
        return !$this->review_image ? null : \App\Components\Helper\ImageProcessing::getURL($this->review_image,$size);
    }

    public function orderDetail()
    {
        return $this->belongsTo('App\OrderDetail');
    }

    public function customer()
    {
        return $this->hasOneThrough('App\Customer', 'App\OrderDetail');
    }
}
