<?php

namespace App\Services\Store;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryService
{
    public function getAllCategories(): Collection
    {
//        dd(Category::with('children')->get());
        return Category::with('children')->get();
    }

    public function getMainCategoriesWithChildren(): array
    {
        return Category::where('parent_id', null)->with('children')->get(['id', 'name', 'slug', 'image', 'parent_id'])->toArray();
    }

    public function getCategoryBySlug(string $slug): ?Category
    {
        return Category::where('slug', $slug)->first();
    }

    public function getAllNestedCategoriesOfParentCategory(int $parentId): array
    {
        $ids = [$parentId];
        $this->getNestedCategoriesId($parentId, $ids);

        return $ids;
    }

    private function getNestedCategoriesId(int $categoryId, &$ids): void
    {
        $categories = Category::where('parent_id', $categoryId)
            ->with('children')
            ->get();

        foreach ($categories as $category) {
            $ids[] = $category->id;
            $this->getNestedCategoriesId($category->id, $ids);
        }
    }
}
