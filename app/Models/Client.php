<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    protected $fillable = ['name', 'lastName', 'email', 'phone', 'password'];

    public function billingAddress()
    {
        return $this->hasOne(ClientAddress::class)->where('type', 'billing');
    }

    public function shippingAddress()
    {
        return $this->hasOne(ClientAddress::class)->where('type', 'shipping');
    }

    public function addresses()
    {
        return $this->hasMany(ClientAddress::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->lastName}";
    }
}
