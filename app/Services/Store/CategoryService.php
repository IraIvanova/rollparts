<?php

namespace App\Services\Store;

use App\Models\Category;

class CategoryService
{
    public function getAllCategories(): array
    {
        return Category::get(['name', 'slug', 'image'])->toArray();
    }

    public function getCategoryBySlug(string $slug): ?Category
    {
        return Category::where('slug', $slug)->first();
    }
}
