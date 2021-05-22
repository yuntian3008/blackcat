<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    protected $fillable = [
        'plant_name', 'plant_image', 'plant_slug', 'category_id'
    ];

    
}
