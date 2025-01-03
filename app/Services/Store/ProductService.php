<?php

namespace App\Services\Store;

use App\Models\Category;
use App\Models\Product;
use App\Services\FilesManagingService;

class ProductService
{
    public function __construct(private readonly FilesManagingService $filesManagingService)
    {
    }

    public function getProductBySlug(string $slug): ?Product
    {
        return Product::where('slug', $slug)->select(['id', 'brand_id', 'active', 'mnf_code', 'quantity'])->first();
    }

    public function getProductInfo(Product $product): array
    {
        $productNameAndDescription = $product->translationByLanguage;

        return [
            'id' => $product->id,
            'active' => $product->active,
            'quantity' => $product->quantity,
            'mnfCode' => $product->mnf_code,
            'name' => $productNameAndDescription->name,
            'description' => $productNameAndDescription->description,
            'brand' => $product->brand,
            'prices' => $product->priceByCurrency,
            'images' => $product->getMedia(),
            'breadcrumbs' => $this->prepareBreadcrumbs($product, $productNameAndDescription['name'])
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

    private function prepareBreadcrumbs(Product $product, string $name): array
    {
        $category = $product->categories()->first();
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/'],
        ];

        if ($category) {
            $categoryChain = $this->getCategoryChain($category);

            foreach ($categoryChain as $cat) {
                $breadcrumbs[] = [
                    'name' => $cat->name,
                    'url' => route('category', $cat->slug),
                ];
            }
        }

        $breadcrumbs[] = [
            'name' => $name
        ];

        return $breadcrumbs;
    }

    private function getCategoryChain(Category $category): array
    {
        $categories = [];

        while ($category) {
            $categories[] = $category;
            $category = $category->parent;
        }

        return array_reverse($categories);
    }
}
