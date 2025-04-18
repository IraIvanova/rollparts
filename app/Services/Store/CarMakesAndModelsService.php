<?php

namespace App\Services\Store;

use App\Models\Brand;
use App\Models\CarMake;
use App\Models\CarModel;
use App\Models\CarYear;
use App\Services\FilesManagingService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

readonly class CarMakesAndModelsService
{
    public function __construct(private FilesManagingService $filesManagingService)
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

    public function getAllAvailableMakes(): Collection
    {
        return CarMake::all();
    }

    public function getModelsByMake(int $makeId): Collection
    {
        return CarModel::where('make_id', $makeId)->get();
    }

    public function getModelsYears(?string $model = null): ?Collection
    {
        return $this->getManufactureYearsForModel($model);
    }

    public function getManufactureYearsForModel(?string $model = null): Collection
    {
        $carModel = CarModel::where('model', $model)->first();
        return $model && $carModel ? CarYear::where('car_model_id', $carModel->id)->orderBy('year')->get() : new Collection();
    }
}
