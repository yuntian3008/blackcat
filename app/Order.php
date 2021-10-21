<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'request_date', 'get_date', 'ship_date', 'completion_date', 'discount','payment', 'address', 'phone',
    ];

    public function getStatus() {
        if (!empty($this->completion_date) && !empty($this->ship_date) && !empty($this->get_date) && !empty($this->request_date)) {
            return "Order is completed";
        }
        elseif ( !empty($this->ship_date) && !empty($this->get_date) && !empty($this->request_date)) {
            return "Order is being shipped";
        }
        elseif (!empty($this->get_date) && !empty($this->request_date)) {
            return "Order is being processed";
        }
        elseif (!empty($this->request_date)) {
            return "Order is initialized";
        }
        elseif (empty($this->completion_date) && empty($this->ship_date) && empty($this->get_date) && empty($this->request_date)) {
            return "Order has been cancelled";
        }
        return "Sorry, There is a problem with your order";

    }

    public function orderDetails()
    {
        return $this->hasMany('App\OrderDetail');
    }
}
