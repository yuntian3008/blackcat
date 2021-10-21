<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class Customer extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'gender', 'email', 'password', 'phone','avatar', 'dob', 'username','block',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','firebase_uid',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullName()
    {
        return ($this->firstname && $this->lastname ? "{$this->firstname} {$this->lastname}" : null);
    }

    public function getAvatar($size = "sm") {
        return !$this->avatar ? null : Storage::url('public/'.$size.'_' . $this->avatar . '.' . config('image-processing')['format']);
    }

    public function cartItems()
    {
        return $this->hasMany('App\CartItem');
    }

    public function addresses()
    {
        return $this->hasMany('App\Address');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
