<?php

namespace App\Services\Store;

use App\Models\Province;
use Illuminate\Database\Eloquent\Collection;

class CitiesService
{
    public function getDistrictsByProvinceId(?int $provinceId): array
    {
        if (!$provinceId) return [];

        return Province::find($provinceId)->districts->toArray();
    }

    public function getAllProvinces(): Collection
    {
        return Province::all();
    }
}
