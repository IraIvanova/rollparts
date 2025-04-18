<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Order extends Model
{
    protected $fillable = ['user_id', 'manual_discount', 'total_price_with_discount'];

    public function orderProductsPivot(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('price', 'discounted_price', 'amount');
    }

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class,  'user_id');
    }

    public function clientAddresses(): HasManyThrough
    {
        return $this->hasManyThrough(ClientAddress::class, User::class, 'id', 'user_id', 'client_id', 'id');
    }
    public function clientShippingAddress(): HasOneThrough
    {
        return $this->hasOneThrough(ClientAddress::class, User::class, 'id', 'user_id', 'client_id', 'id')->where('type', 'shipping');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function orderInfo(): HasOne
    {
        return $this->hasOne(OrderInfo::class, 'order_id');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
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
