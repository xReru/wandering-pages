<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'phone_number',
        'address',
        'profile_picture',
        'gender',
        'date_of_birth'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date',
    ];

    public function cart()
    {
        return $this->hasOne(ShoppingCart::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
} 