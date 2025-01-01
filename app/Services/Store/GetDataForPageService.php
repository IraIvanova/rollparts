<?php

namespace App\Services\Store;

use App\Constant\PagesConstants;
use App\DTO\ProductsFilterParametersDTO;
use App\DTO\SearchParametersDTO;
use App\Exceptions\CustomException;
use App\Exceptions\ProductNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

readonly class GetDataForPageService
{
    public function __construct(
        private CategoryService $categoryService,
        private SearchProductsQueryBuilderService $productQueryBuilderService,
        private PaginationService $paginationService,
        private ProductService $productService,
        private BrandService $brandService,
        private OptionsService $optionsService,
        private CartService $cartService,
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
                default => [],
            } + $this->getBaseData();
    }

    private function getBaseData(): array
    {
        return [
            'categories' => $this->categoryService->getAllCategories(),
            'shoppingCart' => $this->cartService->getCart()->toArray()
        ];
    }

    private function getHomePageData(): array
    {
        $filtersParameters = new ProductsFilterParametersDTO(
            language: 'tr',
            currency: 'TRL',
            limit: 10
        );

        $bestsellerProducts = $this->productQueryBuilderService->getBestsellerProducts($filtersParameters)->get();
        $productImages = $this->productService->getMainImages($bestsellerProducts->pluck('id')->toArray());

        return [
            'bestsellers' => $this->toArray($bestsellerProducts),
            'images' => $productImages,
            'brands' => $this->brandService->getAllAvailableBrands()
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

        $products = $this->paginationService->paginate(
            $this->productQueryBuilderService->getProductsByCategory(
                new ProductsFilterParametersDTO(
                    language: 'tr',
                    currency: 'TRL',
                    categories: $nestedCategoriesId,
                    searchParameters: $searchParameters
                )
            )
        );

        $productImages = $this->productService->getMainImages(array_column($products->items(), 'id'));

        return [
            'category' => $category,
            'categories' => $this->categoryService->getMainCategoriesWithChildren(),
            'brands' => $this->brandService->getAvailableBrandsForCategory($nestedCategoriesId),
            'products' => $products,
            'options' => $this->optionsService->getOptionsAvailableForCategories($nestedCategoriesId),
            'selectedOptions' => $searchParameters->getValuesArray(),
            'images' => $productImages,
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

        return $this->productService->getProductInfo($product);
    }

    private function getCartPageData(): array
    {
        return $this->cartService->getCart()->toArray();
    }

    private function getCatalogPageData(array $searchParams = []): array
    {
        $searchParameters = new SearchParametersDTO($searchParams);

        //TODO Search by Part Name, Brand, Model, Sku
        $products = $this->paginationService->paginate(
            $this->productQueryBuilderService->getProductsByCategory(
                new ProductsFilterParametersDTO(
                    language: 'tr',
                    currency: 'TRL',
                    searchParameters: $searchParameters
                )
            )
        );

        $productImages = $this->productService->getImages(array_column($products->items(), 'id'));

        return [
            'categories' => $this->categoryService->getMainCategoriesWithChildren(),
            'brands' => $this->brandService->getAvailableBrandsForSearchResult(),
            'products' => $products,
            'options' => $this->optionsService->getOptionsAvailableForSearchResult(),
            'images' => $productImages,
            'selectedOptions' => $searchParameters->getValuesArray()
        ];
    }

    private function toArray(Collection $products): Collection
    {
        return $products->map(fn($i) => (array)$i);
    }
}
