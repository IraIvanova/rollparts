<?php

namespace App\Services\Store;

use App\Models\Product;
use App\Services\FilesManagingService;

class ProductService
{
    public function __construct(private readonly FilesManagingService $filesManagingService)
    {
    }

    public function getProductBySlug(string $slug): Product
    {
        return Product::where('slug', $slug)->select(['id', 'brand_id', 'active', 'mnf_code', 'quantity'])->first();
    }

    public function getProductInfo(Product $product): array
    {
        $productNameAndDescription = $product->translationByLanguage;

        return [
            'active' => $product->active,
            'quantity' => $product->quantity,
            'mnfCode' => $product->mnf_code,
            'name' => $productNameAndDescription->name,
            'description' => $productNameAndDescription->description,
            'brand' => $product->brand,
            'prices' => $product->priceByCurrency->toArray(),
            'images' => $product->images
        ];
    }

    public function getImages(array $products): array
    {
        $images = $this->filesManagingService->getProductImages($products);

        return $images
            ->groupBy('product_id')
            ->toArray();
    }
}