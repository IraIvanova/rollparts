<?php

namespace App\Services\Store;

use App\Models\Product;
use App\Services\FilesManagingService;

class ProductService
{
    public function __construct(
        private readonly FilesManagingService $filesManagingService,
        private readonly BreadcrumbsService $breadcrumbsService
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
}
