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
}
