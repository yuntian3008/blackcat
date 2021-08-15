<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    // recursive, loads all descendants
    public function childrenRecursive()
    {
    return $this->children()->with('childrenRecursive');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    protected $fillable = [
        'category_name', 'category_slug', 'category_image', 'parent_id',
    ];
}
