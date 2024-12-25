<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOptionValue extends Model
{
    protected $fillable = ['product_id', 'option_value_id'];

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }

    public function optionValues(): BelongsTo
    {
        return $this->belongsTo(OptionValue::class, 'option_value_id', 'id');
    }
}
