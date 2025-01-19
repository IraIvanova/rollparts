<?php

namespace App\Services\Store;

use App\Models\Category;
use App\Models\Product;

class BreadcrumbsService
{
    private function getCommonPart(): array
    {
        return [
            ['name' => 'homepage', 'url' => '/'],
        ];
    }

    public function prepareBreadcrumbsForProduct(Product $product, string $name): array
    {
        $breadcrumbs = $this->getCommonPart();

        if ($category = $product->categories()->first()) {
            $categoryChain = $this->getCategoryChain($category);

            foreach ($categoryChain as $cat) {
                $breadcrumbs[] = [
                    'name' => $cat->slug,
                    'url' => route('category', $cat->slug),
                ];
            }
        }

        $breadcrumbs[] = [
            'name' => $name
        ];

        return $breadcrumbs;
    }

    public function prepareBreadcrumbsForCategory(Category $category): array
    {
        $breadcrumbs = $this->getCommonPart();
        $categoryChain = $this->getCategoryChain($category);

        foreach ($categoryChain as $cat) {
            $data = [
                'name' => $cat->slug
            ];

            if ($cat->id !== $category->id) $data['url'] = route('category', $cat->slug);

            $breadcrumbs[] = $data;
        }

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
