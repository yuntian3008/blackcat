<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'request_date', 'get_date', 'completion_date', 'discount','payment', 'address', 'phone',
    ];

    public function orderDetails()
    {
        return $this->hasMany('App\OrderDetail');
    }
}
