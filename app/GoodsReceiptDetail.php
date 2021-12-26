<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsReceiptDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'goods_receipt_id','product_id','quantity', 'unit_price',
    ];

    public function goodsReceipt()
    {
        return $this->belongsTo('App\GoodsReceipt');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function trackingGoods()
    {
        return $this->hasOne('App\TrackingGoods');
    }
}
