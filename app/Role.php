<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'code', 'desc'];

    public function staff()
    {
        return $this->belongsToMany('App\Staff');
    }
}
