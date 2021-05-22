<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class Staff extends Authenticatable
{
    use Notifiable;


    /**
     *  Generate Api_Token 
     */
    public function generateToken()
    {
        $this->api_token = Str::random(60);
        $this->save();

        return $this->api_token;
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    /**
    * Check multiple roles
    * @param array $roles
    */
    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('code', $roles)->exists();
    }

    /**
    * Check one role
    * @param string $role
    */
    public function hasRole($role)
    {
        //var_dump($this->first_name);
        return $this->roles()->where('code', $role)->exists();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'gender', 'email', 'password','address', 'phone','avatar', 'dob', 'username','block'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
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
