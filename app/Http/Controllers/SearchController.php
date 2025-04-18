<?php

namespace App\Http\Controllers;

use App\DTO\ProductsFilterParametersDTO;
use App\DTO\SearchParametersDTO;
use App\Models\CarMake;
use App\Services\Store\CarMakesAndModelsService;
use App\Services\Store\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    public function __construct(
        private readonly CarMakesAndModelsService $carMakesAndModelsService,
        private readonly ProductService $productService,
    ) {
    }

    public function dynamicSearch(Request $request): string
    {
        $searchParameters = new ProductsFilterParametersDTO(
            language: 'tr',
            currency: 'TRL',
            searchParameters: new SearchParametersDTO(['search' => $request->get('search')]),
            limit: ProductService::SEARCH_RESULTS_LIMIT
        );

        $products = $this->productService->getFilteredProducts($searchParameters);

        $productImages = $this->productService->getMainImages($products->only('id')->toArray());

        return view('store.components.search.dynamicSearch', [
            'products' => $products,
            'productImages' => $productImages,
            'search' => $request->get('search')
        ])->render();
    }

    public function searchByMakesAndModel(Request $request): RedirectResponse
    {
        return redirect()->route('catalog', $request->query());
    }

    public function getModelsByMake(Request $request): array
    {
        $make = CarMake::where('name', $request->get('make'))->first();
        $models = $this->carMakesAndModelsService->getModelsByMake($make->id);
        $years = $this->carMakesAndModelsService->getModelsYears($models->first()?->model);

        return ['models' => $models, 'years' => $years];
    }

    public function getManufactureYearsForModel(Request $request): Collection
    {
        return $this->carMakesAndModelsService->getModelsYears($request->get('model'));
    }
}
