<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarModel extends Model
{
    protected $fillable = ['make_id', 'model', 'years', 'engine'];

    public function make(): BelongsTo
    {
        return $this->belongsTo(CarMake::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'car_model_product')
            ->withPivot('car_year_id');
    }

    public function years(): HasMany
    {
        return $this->hasMany(CarYear::class);
    }
}
