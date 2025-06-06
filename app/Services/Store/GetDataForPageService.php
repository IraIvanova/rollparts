<?php

namespace App\Services\Store;

use App\Constant\PagesConstants;
use App\DTO\ProductsFilterParametersDTO;
use App\DTO\SearchParametersDTO;
use App\Exceptions\CustomException;
use App\Exceptions\ProductNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

readonly class GetDataForPageService
{
    public function __construct(
        private CategoryService $categoryService,
        private SearchProductsQueryBuilderService $productQueryBuilderService,
        private SearchService $searchService,
        private ProductService $productService,
        private CarMakesAndModelsService $brandService,
        private OptionsService $optionsService,
        private CartService $cartService,
        private BreadcrumbsService $breadcrumbsService,
        private CitiesService $citiesService,
        private CarMakesAndModelsService $carMakeAndModelsService,
    ) {
    }

    /**
     * @throws \ErrorException
     * @throws ProductNotFoundException
     */
    public function getSpecificPageData(string $page, array $params = []): array
    {
        return match ($page) {
                PagesConstants::HOME_PAGE => $this->getHomePageData(),
                PagesConstants::ALL_CATEGORIES_PAGE => $this->getAllCategoriesPageData(),
                PagesConstants::CATEGORY_PAGE => $this->getCategoryPageData($params['slug'], $params['searchParams']),
                PagesConstants::PRODUCT_PAGE => $this->getProductPageData($params['slug']),
                PagesConstants::CART_PAGE => $this->getCartPageData(),
                PagesConstants::CATALOG_PAGE => $this->getCatalogPageData($params['searchParams']),
                PagesConstants::CHECKOUT_PAGE => $this->getCheckoutPageData(),
                PagesConstants::ORDER_CONFIRMATION_PAGE => $this->getOrderConfirmationPageData(),
                PagesConstants::ACCOUNT_PAGE => $this->getAccountPageData(),
                default => [],
            } + $this->getBaseData($page);
    }

    private function getBaseData(string $page): array
    {
        return [
            'categories' => $this->categoryService->getMainCategoriesWithChildren(),
            'shoppingCart' => $this->cartService->getCart()->toArray(),
            'user' => Auth::user(),
            'contacts' => $this->getContactDetails()
        ];
    }

    private function getHomePageData(): array
    {
        $bestsellerProductsId = $this->productService->getBestsellerProductsList();
        $newestProductsId = $this->productService->getNewestProductsList();

        $filtersParameters = new ProductsFilterParametersDTO(
            language: 'tr',
            currency: 'TRL',
            products: $bestsellerProductsId,
            limit: 10
        );
        $bestsellerProducts = $this->searchService->getProductsList($filtersParameters);

        $filtersParameters = new ProductsFilterParametersDTO(
            language: 'tr',
            currency: 'TRL',
            products: $newestProductsId,
            limit: 10
        );
        $newestProducts = $this->searchService->getProductsList($filtersParameters);

        $productImages = $this->productService->getMainImages($bestsellerProductsId + $newestProductsId);

        return [
            'bestsellers' => $bestsellerProducts,
            'newestProducts' => $newestProducts,
            'images' => $productImages,
            'makes' => $this->brandService->getAllAvailableMakes()
        ];
    }

    private function getAllCategoriesPageData(): array
    {
        return [];
    }

    /**
     * @throws \ErrorException
     */
    private function getCategoryPageData(string $slug, array $searchParams = []): array
    {
        if (!$category = $this->categoryService->getCategoryBySlug($slug)) {
            throw new \ErrorException('Category not found');
        }
        //TODO process errors in listener and create specific error exception

        $nestedCategoriesId = $this->categoryService->getAllNestedCategoriesOfParentCategory($category->id);
        $searchParameters = new SearchParametersDTO($searchParams);

        $products = $this->searchService->getProductsList(
            new ProductsFilterParametersDTO(
                language: 'tr',
                currency: 'TRL',
                categories: $nestedCategoriesId,
                searchParameters: $searchParameters,
                limit: 30
            )
        );

        $products->load(['translationByLanguage', 'priceByCurrency']);
//TODO change with new service
        $priceRange = $this->productQueryBuilderService->getMinMaxPricesForProducts(
            new ProductsFilterParametersDTO(
                language: 'tr',
                currency: 'TRL',
                categories: $nestedCategoriesId,
                searchParameters: $searchParameters
            ))->first();

        $productImages = $this->productService->getMainImages($products->only('id')->toArray());

        return [
            'category' => $category,
            'categories' => $this->categoryService->getMainCategoriesWithChildren(),
            'brands' => $this->carMakeAndModelsService->getAllAvailableMakes(),
            'products' => $products,
            'options' => $this->optionsService->getOptionsAvailableForCategories($nestedCategoriesId),
            'selectedOptions' => $searchParameters->getValuesArray(),
            'images' => $productImages,
            'breadcrumbs' => $this->breadcrumbsService->prepareBreadcrumbsForCategory($category),
            'prices' => [(int)$priceRange->minPrice, (int)$priceRange->maxPrice]
        ];
    }

    /**
     * @throws ProductNotFoundException
     */
    private function getProductPageData(string $slug): array
    {
        $product = $this->productService->getProductBySlug($slug);

        if (!$product) {
            throw new ProductNotFoundException();
        }

        $this->productService->saveProductToRecentlyViewed($product->id);

        return $this->productService->getProductInfo($product);
    }

    private function getCartPageData(): array
    {
        return $this->cartService->getCart()->toArray();
    }

    private function getCatalogPageData(array $searchParams = []): array
    {
        $searchParameters = new ProductsFilterParametersDTO(
            language: 'tr',
            currency: 'TRL',
            searchParameters: new SearchParametersDTO($searchParams)
        );

        //TODO Search by Part Name, Brand, Model, Sku
        $products = $this->productService->getFilteredProducts($searchParameters);
        $priceRange = $this->productQueryBuilderService->getMinMaxPricesForProducts($searchParameters)->first();
        $productImages = $this->productService->getMainImages($products->only('id')->toArray());

        return [
            'categories' => $this->categoryService->getMainCategoriesWithChildren(),
            'brands' => $this->brandService->getAllAvailableMakes(),
            'products' => $products,
            'options' => $this->optionsService->getOptionsAvailableForSearchResult(),
            'images' => $productImages,
            'selectedOptions' => $searchParameters->searchParameters->getValuesArray(),
            'search' => $searchParams['search'] ?? '',
            'prices' => [(int)$priceRange->minPrice, (int)$priceRange->maxPrice]
        ];
    }

    private function getAccountPageData(): array
    {
        $client = Auth::user();

        return [
            'addresses' => $client->addresses,
            'orders' => $client->orders,
            'provinces' => $this->citiesService->getAllProvinces(),
            'shippingDistricts' => $this->citiesService->getDistrictsByProvinceId($client->shippingAddress?->province_id),
            'billingDistricts' => $this->citiesService->getDistrictsByProvinceId($client->billingAddress?->province_id)
        ];
    }

    private function getCheckoutPageData(): array
    {
        $client = Auth::user();

        return array_merge(
            [
                'provinces' => $this->citiesService->getAllProvinces(),
                'shippingDistricts' => $this->citiesService->getDistrictsByProvinceId($client?->shippingAddress?->province_id),
                'billingDistricts' => $this->citiesService->getDistrictsByProvinceId($client?->billingAddress?->province_id),
                'isBankTransfer' => false,
            ],
            $this->cartService->getCart()->toArray()
        );
    }

    private function getOrderConfirmationPageData(): array
    {
        return [];
    }

    private function toArray(Collection $products): Collection
    {
        return $products->map(fn($i) => (array)$i);
    }

    private function getContactDetails(): array
    {
        return [
            'email' => 'rollparts@gmail.com',
            'phone' => '111122223',
            'address' => 'Turkey, Bursa, Boulevard Test address',
            'workingHours' => '09:00 - 18:00',
        ];
    }
}
