<?php

namespace App\Services\Store;

use App\DTO\ProductsFilterParametersDTO;
use App\Models\Product;
use App\Services\FilesManagingService;
use Illuminate\Database\Eloquent\Model;

class ProductService
{
    public function __construct(
        private readonly FilesManagingService $filesManagingService,
        private readonly BreadcrumbsService $breadcrumbsService,
        private readonly SearchProductsQueryBuilderService $productQueryBuilderService,
    )
    {
    }

    public function getProductBySlug(string $slug): ?Product
    {
        return Product::where('slug', $slug)->select(['id', 'brand_id', 'active', 'mnf_code', 'quantity'])->first();
    }

    public function getProductById(int $id): ?Product
    {
        return Product::find($id);
    }

    public function getProductInfo(Product $product): array
    {
        $productNameAndDescription = $product->translationByLanguage;
        if ($frequentlyIds = $product->frequentlyBoughtTogether()->pluck('related_product_id')->toArray()) {
            $frequentlyBoughtFilterParameters = new ProductsFilterParametersDTO(
                language: 'tr',
                currency: 'TRL',
                products: $frequentlyIds
            );
            $frequentlyBoughtTogetherProducts = $this->productQueryBuilderService->getProductsList(
                $frequentlyBoughtFilterParameters
            )->get()->toArray();
        }

        if ($recentlyViewedIds = array_diff(session()->get('recentlyViewedProducts', []), [$product->id])) {
            $recentlyViewedFilterParameters = new ProductsFilterParametersDTO(
                language: 'tr',
                currency: 'TRL',
                products: $recentlyViewedIds
            );
            $recentlyViewedProducts = $this->productQueryBuilderService->getProductsList(
                $recentlyViewedFilterParameters
            )->get()->toArray();
        }

        return [
            'id' => $product->id,
            'active' => $product->active,
            'quantity' => $product->stock?->quantity,
            'mnfCode' => $product->mnf_code,
            'name' => $productNameAndDescription->name,
            'description' => $productNameAndDescription->description,
            'brand' => $product->brand,
            'prices' => $product->priceByCurrency,
            'images' => $product->getMedia(),
            'productOptions' => $product->productOptions->load('relatedProduct')->mapToGroups(fn($i) => [$i->option => [$i->option_value, $i->relatedProduct->slug]]),
            'frequentlyBoughtTogetherProducts' => $frequentlyBoughtTogetherProducts ?? [],
            'recentlyViewedProducts' => $recentlyViewedProducts ?? [],
            'breadcrumbs' => $this->breadcrumbsService->prepareBreadcrumbsForProduct($product, $productNameAndDescription['name']),
        ];
    }

    public function getImages(array $products)
    {
        $images = $this->filesManagingService->getProductImages($products);

        return $images
            ->groupBy('model_id');
    }

    public function getMainImages(array $products)
    {
        return $this->filesManagingService->getMainImages($products)->mapWithKeys(function($i) {
           return [$i->model_id => $i->getFullUrl()];
        })
            ->toArray();
    }

    public function saveProductToRecentlyViewed(int $productId): void
    {
        $recentlyViewed = session()->get('recentlyViewedProducts', []);

        if (!in_array($productId, $recentlyViewed)) {
            if (count($recentlyViewed) >= 10) {
                array_shift($recentlyViewed); // Remove the first item (oldest)
            }

            $recentlyViewed[] = $productId;
            session()->put('recentlyViewedProducts', $recentlyViewed);
        }
    }
}
