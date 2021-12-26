<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrackingGoods extends Model
{
    use SoftDeletes;

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
