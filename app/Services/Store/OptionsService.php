<?php

namespace App\Services\Store;

use App\Models\Option;
use Illuminate\Support\Facades\DB;

class OptionsService
{
    public function getOptionsAvailableForCategories(array $categoriesId)
    {
        return DB::table('products')
            ->join('category_product as cp', 'products.id', '=', 'cp.product_id')
            ->join('product_option_values as pov', 'products.id', '=', 'pov.product_id')
            ->join('option_values as ov', 'ov.id', '=', 'pov.option_value_id')
            ->join('options', 'ov.option_id', '=', 'options.id')
            ->whereIn('cp.category_id', $categoriesId)
            ->distinct()
            ->select('ov.value', 'options.name')
            ->get()
            ->mapToGroups(function (\stdClass $item) {
                return [$item->name => $item->value];
            })
            ->toArray();
    }
}
