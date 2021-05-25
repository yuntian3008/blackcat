<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{

	protected $fillable = [
        'customer_id', 'product_id', 'quantity',
    ];
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
