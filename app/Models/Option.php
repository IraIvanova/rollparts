<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends Model
{
    protected $fillable = ['name', 'values', 'unit_type_id', 'active'];
    protected $casts = [
        'values' => 'array',
    ];
    public function unitType(): BelongsTo
    {
        return $this->belongsTo(UnitType::class);
    }

    public function optionValues(): HasMany
    {
        return $this->hasMany(OptionValue::class);
    }
}
