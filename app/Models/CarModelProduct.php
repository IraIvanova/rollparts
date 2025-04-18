<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModelProduct extends Model
{
    protected $table = 'car_model_product';
    protected $fillable = ['car_model_id', 'product_id', 'car_year_id'];
    public $timestamps = false;

    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }

    public function carYear()
    {
        return $this->belongsTo(CarYear::class);
    }
}
