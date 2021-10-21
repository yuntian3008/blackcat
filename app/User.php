<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    use Notifiable;


    /**
     *  Generate Api_Token 
     */
    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Permission');
    }


    
    /**
    * Check multiple roles
    * @param array $roles
    */
    public function hasAnyPermission($permissions)
    {
        return $this->permissions()->whereIn('name', $permissions)->exists();
    }

    /**
    * Check one role
    * @param string $role
    */
    public function hasPermission($permission)
    {
        return $this->permissions()->where('name', $permission)->exists();
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname', 'lname', 'gender', 'email', 'password', 'avatar', 'api_token', 'isAdmin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
