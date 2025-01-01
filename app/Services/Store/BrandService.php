<?php

namespace App\Services\Store;

use App\Models\Brand;
use App\Services\FilesManagingService;
use Illuminate\Support\Facades\DB;

class BrandService
{
    public function __construct(private readonly FilesManagingService $filesManagingService)
    {
    }

    public function getAvailableBrandsForCategory(array $categoriesId): array
    {
        return DB::table('brands')
            ->join('products', 'brands.id', '=', 'products.brand_id')
            ->join('category_product as cp', 'products.id', '=', 'cp.product_id')
            ->whereIn('cp.category_id', $categoriesId)
            ->distinct()
            ->select('brands.id', 'brands.name')
            ->get()
            ->map(fn($item) => (array) $item)
            ->toArray();
    }

    public function getAvailableBrandsForSearchResult(): array
    {
        return DB::table('brands')
            ->select('brands.id', 'brands.name')
            ->get()
            ->map(fn($item) => (array) $item)
            ->toArray();
    }

    public function getAllAvailableBrands(): array
    {
        return Brand::all()->toArray();
    }
}
