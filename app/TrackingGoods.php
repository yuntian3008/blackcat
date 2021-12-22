<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackingGoods extends Model
{
    protected $fillable = ['order_detail_id','goods_receipt_detail_id'];

    public function goodsReceipt()
    {
        return $this->belongsTo('App\GoodsReceiptDetail');
    }

    public function goodsIssue()
    {
        return $this->belongsTo('App\OrderDetail');
    }
}
