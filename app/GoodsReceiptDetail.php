<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodsReceiptDetail extends Model
{
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
}
