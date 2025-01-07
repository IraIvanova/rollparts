<?php

namespace App\Models;

use App\Observers\ProductStockObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([ProductStockObserver::class])]
class ProductStock extends Model
{
    protected $table = 'product_stock';
    protected $fillable = ['product_id', 'quantity'];
    protected $hidden = ['source'];
}
