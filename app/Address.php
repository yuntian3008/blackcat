<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
	protected $fillable = [
        'country', 'province', 'district', 'ward', 'address',
    ];
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function getFull()
    {
        return "{$this->address}, {$this->ward}, {$this->district}, {$this->province}, {$this->country}";
    }
}
