<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    public function orderProductsPivot(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('price', 'discounted_price', 'amount');
    }

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
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

    public function updateTotal(): void
    {
        $orderedProducts = $this->orderProducts;
        $total = $orderedProducts->sum(function ($orderProduct) {
            return $orderProduct->price * $orderProduct->amount;
        });
        $totalWithDiscount = $orderedProducts->sum(function ($orderProduct) {
            return $orderProduct->discounted_price * $orderProduct->amount;
        });

        $promocodeDiscount = json_decode($this->used_promo, true)['discount'] ?? 0;

        $this->total_price = $total;
        $this->total_price_with_discount = $totalWithDiscount - $this->manual_discount - $promocodeDiscount;
        $this->save();
    }
}
