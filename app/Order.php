<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    protected $notFoundMessage = 'The order could not be found';

    protected $fillable = [
        'request_date', 'get_date', 'ship_date', 'completion_date', 'discount','payment', 'address', 'phone',
    ];


    public function getLateLevel()
    {
        $newUpdate = new Carbon($this->getStatus()["date"]);
        $diff = Carbon::now()->diffInDays($newUpdate,false);
        $warning_time = \App\Setting::where('option','order_processing_warning_time')->first()->value;
        $late_time = \App\Setting::where('option','order_processing_late_time')->first()->value;
        if ($diff + $late_time <= 0) {
            return 2;
        }
        if ($diff + $warning_time <= 0) {
            return 1;
        }
        return 0;
    }

    public function getLateLevelShippingAttribute()
    {
        $diff = Carbon::now()->diffInDays(new Carbon($this->request_date));
        $warning_time = \App\Setting::where('order_processing_warning_time')->first()->value;
        $late_time = \App\Setting::where('order_processing_late_time')->first()->value;
        if ($diff + $late_time < 0) {
            return 2;
        }
        if ($diff + $warning_time < 0) {
            return 1;
        }
        return 0;
    }

    public function getLateLevelProcessingAttribute()
    {
        $diff = Carbon::now()->diffInDays(new Carbon($this->request_date));
        $warning_time = \App\Setting::where('order_processing_warning_time')->first()->value;
        $late_time = \App\Setting::where('order_processing_late_time')->first()->value;
        if ($diff + $late_time < 0) {
            return 2;
        }
        if ($diff + $warning_time < 0) {
            return 1;
        }
        return 0;
    }

    public function getStatus() {
        if (!empty($this->completion_date) && !empty($this->ship_date) && !empty($this->get_date) && !empty($this->request_date)) {
            return [
                "status" => 4,
                "message" => "Order is completed",
                "date" => $this->completion_date,
            ];
        }
        elseif ( !empty($this->ship_date) && !empty($this->get_date) && !empty($this->request_date)) {
            return [
                "status" => 3,
                "message" => "Order is being shipped",
                "date" => $this->ship_date,
            ];
        }
        elseif (!empty($this->get_date) && !empty($this->request_date)) {
            return [
                "status" => 2,
                "message" => "Order is being processed",
                "date" => $this->get_date,
            ];
        }
        elseif (!empty($this->request_date)) {
            return [
                "status" => 1,
                "message" => "Order is initialized",
                "date" => $this->request_date,
            ];
        }
        elseif (empty($this->completion_date) && empty($this->ship_date) && empty($this->get_date) && empty($this->request_date)) {
            return [
                "status" => 0,
                "message" => "Order has been cancelled",
                "date" => $this->updated_at,
            ];
        }
        return [
            "status" => -1,
            "message" => "Order has been cancelled",
        ];

    }

    public function orderDetails()
    {
        return $this->hasMany('App\OrderDetail');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function reviews()
    {
        return $this->hasManyThrough('App\Review', 'App\OrderDetail');
    }
}
