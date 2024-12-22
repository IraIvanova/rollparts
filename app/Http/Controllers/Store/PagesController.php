<?php

namespace App\Http\Controllers\Store;

use App\Constant\PagesConstants;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Store\GetDataForPageService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PagesController extends Controller
{
    public function __construct(private readonly GetDataForPageService $getDataForPageService)
    {
    }

    public function homepage(): View
    {
        return view('store.homepage');
    }

    public function categories(): View
    {
        return view('store.categories', $this->getDataForPageService->getSpecificPageData(PagesConstants::ALL_CATEGORIES_PAGE));
    }

    public function category(Request $request, string $categorySlug): View
    {
        return view(
            'store.category',
            $this->getDataForPageService->getSpecificPageData(PagesConstants::CATEGORY_PAGE, ['slug' => $categorySlug])
        );
    }

    public function product(Request $request, string $productSlug): View
    {
        return view('store.product', $this->getDataForPageService->getSpecificPageData(PagesConstants::PRODUCT_PAGE, ['slug' => $productSlug]));
    }
}
