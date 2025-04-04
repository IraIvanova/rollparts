<?php

namespace App\Http\Controllers\Store;

use App\Constant\PagesConstants;
use App\Exceptions\ProductNotFoundException;
use App\Http\Controllers\Controller;
use App\Services\Store\CartService;
use App\Services\Store\GetDataForPageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PagesController extends Controller
{
    public function __construct(
        private readonly GetDataForPageService $getDataForPageService,
        private readonly CartService $cartService
    ) {
    }

    /**
     * @throws ProductNotFoundException
     * @throws \ErrorException
     */
    public function homepage(): View
    {
        return view('store.homepage', $this->getDataForPageService->getSpecificPageData(PagesConstants::HOME_PAGE));
    }

    /**
     * @throws \ErrorException
     * @throws ProductNotFoundException
     */
    public function categories(): View
    {
        return view('store.categories', $this->getDataForPageService->getSpecificPageData(PagesConstants::ALL_CATEGORIES_PAGE));
    }

    /**
     * @throws \ErrorException
     * @throws ProductNotFoundException
     */
    public function category(Request $request, string $categorySlug): View
    {
        return view(
            'store.category',
            $this->getDataForPageService->getSpecificPageData(PagesConstants::CATEGORY_PAGE, ['slug' => $categorySlug, 'searchParams' => $request->query()])
        );
    }

    /**
     * @throws \ErrorException
     * @throws ProductNotFoundException
     */
    public function product(Request $request, string $productSlug): View
    {
        return view('store.product', $this->getDataForPageService->getSpecificPageData(PagesConstants::PRODUCT_PAGE, ['slug' => $productSlug]));
    }

    /**
     * @throws \ErrorException
     * @throws ProductNotFoundException
     */
    public function cart(): View
    {
        return view('store.cart', $this->getDataForPageService->getSpecificPageData(PagesConstants::CART_PAGE));
    }

    /**
     * @throws ProductNotFoundException
     * @throws \ErrorException
     */
    public function catalog(Request $request): View
    {
        return view('store.catalog', $this->getDataForPageService->getSpecificPageData(PagesConstants::CATALOG_PAGE, ['searchParams' => $request->query()]));
    }

    /**
     * @throws ProductNotFoundException
     * @throws \ErrorException
     */
    public function checkout(): View|RedirectResponse
    {
        if ($this->cartService->isCartEmpty()) {
            return redirect()->route('cart');
        }

        return view('store.checkout', $this->getDataForPageService->getSpecificPageData(PagesConstants::CHECKOUT_PAGE));
    }

    /**
     * @throws ProductNotFoundException
     * @throws \ErrorException
     */
    public function returnPolicy(): View
    {
        return view('store.info.returnPolicy', $this->getDataForPageService->getSpecificPageData(PagesConstants::INFO_PAGE));
    }

    /**
     * @throws ProductNotFoundException
     * @throws \ErrorException
     */
    public function privacy(): View
    {
        return view('store.info.privacy', $this->getDataForPageService->getSpecificPageData(PagesConstants::INFO_PAGE));
    }

    /**
     * @throws ProductNotFoundException
     * @throws \ErrorException
     */
    public function contactUs(): View
    {
        return view('store.info.contacts', $this->getDataForPageService->getSpecificPageData(PagesConstants::INFO_PAGE));
    }

    /**
     * @throws ProductNotFoundException
     * @throws \ErrorException
     */
    public function faq(): View
    {
        return view('store.info.faq', $this->getDataForPageService->getSpecificPageData(PagesConstants::INFO_PAGE));
    }

    /**
     * @throws ProductNotFoundException
     * @throws \ErrorException
     */
    public function aboutUs(): View
    {
        return view('store.info.aboutUs', $this->getDataForPageService->getSpecificPageData(PagesConstants::INFO_PAGE));
    }

    /**
     * @throws ProductNotFoundException
     * @throws \ErrorException
     */
    public function orderConfirmation(Request $request): View|RedirectResponse
    {
        if (!$request->session()->has('orderId')) {
            return redirect()->route('homepage');
        }

        return view('store.orderConfirmation', $this->getDataForPageService->getSpecificPageData(PagesConstants::ORDER_CONFIRMATION_PAGE));
    }
}
