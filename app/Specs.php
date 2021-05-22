<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specs extends Model
{
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    protected $fillable = [
        'key', 'value', 'product_id',
    ];
}
