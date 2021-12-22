<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodsReceipt extends Model
{
    protected $fillable = [
        'staff_id','supplier_id','receipt_date', 'total_amount',
   ];  

    protected $casts = [
        'receipt_date' => 'datetime',
    ];

    public function goodsReceiptDetails()
    {
        return $this->hasMany('App\GoodsReceiptDetail');
    }

    public function staff()
    {
        return $this->belongsTo('App\Staff');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
