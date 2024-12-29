<?php

namespace App\Services\Store;

use App\Models\Option;
use Illuminate\Support\Facades\DB;

class OptionsService
{
    public function getOptionsAvailableForCategories(array $categoriesId)
    {
        ///TODO save it to cache to quicker retrieving
        return DB::table('products')
            ->join('category_product as cp', 'products.id', '=', 'cp.product_id')
            ->join('product_options as po', 'products.id', '=', 'po.product_id')
            ->join('options', 'po.option', '=', 'options.name')
            ->whereIn('cp.category_id', $categoriesId)
            ->distinct()
            ->select('options.name', 'options.values')
            ->get()
            ->mapWithKeys(function (\stdClass $item) {
                return [$item->name => array_column(json_decode($item->values, true), 'value')];
            })
            ->toArray();
    }

    public function getOptionsAvailableForSearchResult() : array
    {
        return DB::table('products')
            ->join('product_options as po', 'products.id', '=', 'po.product_id')
            ->join('options', 'po.option', '=', 'options.name')
            ->distinct()
            ->select('options.name', 'options.values')
            ->get()
            ->mapWithKeys(function (\stdClass $item) {
                return [$item->name => array_column(json_decode($item->values, true), 'value')];
            })
            ->toArray();
    }

}
