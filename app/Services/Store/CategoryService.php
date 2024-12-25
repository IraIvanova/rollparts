<?php

namespace App\Services\Store;

use App\Models\Category;

class CategoryService
{
    public function getAllCategories(): array
    {
        return Category::get(['name', 'slug', 'image'])->toArray();
    }

    public function getMainCategoriesWithChildren(): array
    {
        return Category::where('parent_id', null)->with('children')->get(['id', 'name', 'slug', 'image', 'parent_id'])->toArray();
    }

    public function getCategoryBySlug(string $slug): ?Category
    {
        return Category::where('slug', $slug)->first();
    }
}
