<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductFile extends Model
{
    protected $fillable = ['product_id', 'file_path', 'category', 'file_extension', 'order'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
