<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProduct extends Model
{
    protected $table = 'order_product';
    protected $fillable = ['amount'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    protected static function booted()
    {
        static::saved(function ($orderProduct) {
            $orderProduct->order->updateTotal();
        });

        static::deleted(function ($orderProduct) {
            $orderProduct->order->updateTotal();
        });
    }
}
