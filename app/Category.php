<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function plants()
    {
        return $this->hasMany('App\Plant');
    }

    protected $fillable = [
        'category_name', 'category_slug', 'category_visible', 'category_image',
    ];
}
