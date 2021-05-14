<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['display_name', 'name', 'desc'];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
