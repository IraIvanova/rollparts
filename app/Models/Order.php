<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    public function orderProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('price', 'discounted_price', 'amount');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function clientAddresses()
    {
        return $this->hasManyThrough(ClientAddress::class, Client::class, 'id', 'client_id', 'client_id', 'id');
    }
    public function clientShippingAddress()
    {
        return $this->hasOneThrough(ClientAddress::class, Client::class, 'id', 'client_id', 'client_id', 'id')->where('type', 'shipping');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

}
