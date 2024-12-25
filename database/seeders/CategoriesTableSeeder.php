<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Engine Parts',
                'slug' => 'engine-parts',
                'subcategories' => [
                    ['name' => 'Pistons & Rings', 'slug' => 'pistons-rings'],
                    ['name' => 'Cylinder Heads', 'slug' => 'cylinder-heads'],
                    ['name' => 'Oil Filters', 'slug' => 'oil-filters'],
                ],
            ],
            [
                'name' => 'Suspension & Steering',
                'slug' => 'suspension-steering',
                'subcategories' => [
                    ['name' => 'Shock Absorbers', 'slug' => 'shock-absorbers'],
                    ['name' => 'Control Arms', 'slug' => 'control-arms'],
                    ['name' => 'Ball Joints', 'slug' => 'ball-joints'],
                ],
            ],
            [
                'name' => 'Brakes & Components',
                'slug' => 'brakes-components',
                'subcategories' => [
                    ['name' => 'Brake Pads', 'slug' => 'brake-pads'],
                    ['name' => 'Brake Rotors', 'slug' => 'brake-rotors'],
                    ['name' => 'Brake Calipers', 'slug' => 'brake-calipers'],
                ],
            ],
            [
                'name' => 'Exhaust Systems',
                'slug' => 'exhaust-systems',
                'subcategories' => [
                    ['name' => 'Mufflers', 'slug' => 'mufflers'],
                    ['name' => 'Catalytic Converters', 'slug' => 'catalytic-converters'],
                    ['name' => 'Exhaust Pipes', 'slug' => 'exhaust-pipes'],
                ],
            ],
            [
                'name' => 'Electrical Components',
                'slug' => 'electrical-components',
                'subcategories' => [
                    ['name' => 'Alternators', 'slug' => 'alternators'],
                    ['name' => 'Batteries', 'slug' => 'batteries'],
                    ['name' => 'Ignition Coils', 'slug' => 'ignition-coils'],
                ],
            ],
            [
                'name' => 'Wheels & Tires',
                'slug' => 'wheels-tires',
                'subcategories' => [
                    ['name' => 'Alloy Wheels', 'slug' => 'alloy-wheels'],
                    ['name' => 'Steel Wheels', 'slug' => 'steel-wheels'],
                    ['name' => 'Tires', 'slug' => 'tires'],
                    ['name' => 'Wheel Accessories', 'slug' => 'wheel-accessories'],
                ],
            ],
        ];

        foreach ($categories as $category) {
            $parentCategory = Category::create([
                'name' => $category['name'],
                'slug' => $category['slug'],
            ]);

            // Create the subcategories
            foreach ($category['subcategories'] as $subcategory) {
                Category::create([
                    'name' => $subcategory['name'],
                    'slug' => $subcategory['slug'],
                    'parent_id' => $parentCategory->id,
                ]);
            }
        }
    }
}
