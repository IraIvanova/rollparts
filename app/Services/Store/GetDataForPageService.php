<?php

namespace App\Services\Store;

use App\Constant\PagesConstants;
use App\DTO\ProductsFilterParametersDTO;
use App\DTO\SearchParametersDTO;

readonly class GetDataForPageService
{
    public function __construct(
        private CategoryService $categoryService,
        private SearchProductsQueryBuilderService $productQueryBuilderService,
        private PaginationService $paginationService,
        private ProductService $productService,
        private BrandService $brandService,
        private OptionsService $optionsService,
    ) {
    }

    /**
     * @throws \ErrorException
     */
    public function getSpecificPageData(string $page, array $params = []): array
    {
        return match ($page) {
                PagesConstants::HOME_PAGE => $this->getHomePageData(),
                PagesConstants::ALL_CATEGORIES_PAGE => $this->getAllCategoriesPageData(),
                PagesConstants::CATEGORY_PAGE => $this->getCategoryPageData($params['slug'], $params['searchParams']),
                PagesConstants::PRODUCT_PAGE => $this->getProductPageData($params['slug']),
                default => [],
            } + $this->getBaseData();
    }

    private function getBaseData(): array
    {
        return [];
    }

    private function getHomePageData(): array
    {
        return [
            'asd' => 'asd555'
        ];
    }

    private function getAllCategoriesPageData(): array
    {
        return ['categories' => $this->categoryService->getAllCategories()];
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

        $productImages = $this->productService->getImages(array_column($products->items(), 'id'));

        return [
            'category' => $category,
            'categories' => $this->categoryService->getMainCategoriesWithChildren(),
            'brands' => $this->brandService->getAvailableBrandsForCategory($nestedCategoriesId),
            'products' => $products,
            'options' => $this->optionsService->getOptionsAvailableForCategories($nestedCategoriesId),
            'images' => $productImages,
            'selectedOptions' => $searchParameters->getValuesArray()
        ];
    }

    private function getProductPageData(string $slug): array
    {
        $product = $this->productService->getProductBySlug($slug);
        //TODO check if it exists and return error

        return $this->productService->getProductInfo($product);
    }
}
