<?php

namespace App\Http\Controllers\Store;

use App\DTO\ProductsFilterParametersDTO;
use App\DTO\SearchParametersDTO;
use App\Http\Controllers\Controller;
use App\Services\Store\ProductService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AsyncController extends Controller
{

    public function __construct(private readonly ProductService $productService)
    {
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

        $productImages = $this->productService->getMainImages(array_column($products->items(), 'id'));

        return view('store.components.search.dynamicSearch', [
            'products' => $products,
            'productImages' => $productImages,
            'search' => $request->get('search')
        ])->render();
    }
}
