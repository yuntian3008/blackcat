<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function childrenWithTrash()
    {
        return $this->hasMany(self::class, 'parent_id')->withTrashed();
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

    // recursive, loads all descendants
    public function childrenWithTrashRecursive()
    {
        return $this->children()->withTrashed()->with('childrenWithTrashRecursive');
    }

    // recursive, loads all descendants
    public function childrenOnlyTrashRecursive()
    {
        return $this->children()->onlyTrashed()->with('childrenOnlyTrashRecursive');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function randomProducts($quantity = 1)
    {
        return $this->products()->where('product_visible', 1)->inRandomOrder()->limit($quantity)->get();
    }

    public function visibleProducts()
    {
        return $this->hasMany('App\Product')->where('product_visible', 1);
    }

    protected $fillable = [
        'category_name', 'category_slug', 'category_image', 'parent_id',
    ];
}
