<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'lastName', 'email', 'phone'];

    public function billingAddress()
    {
        return $this->hasOne(ClientAddress::class)->where('type', 'billing');
    }

    public function shippingAddress()
    {
        return $this->hasOne(ClientAddress::class)->where('type', 'shipping');
    }
}
