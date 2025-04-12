<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CarModel extends Model
{
    protected $fillable = ['make_id', 'model', 'years', 'engine'];

    public function make(): BelongsTo
    {
        return $this->belongsTo(CarMake::class, 'make_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
