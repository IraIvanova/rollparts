<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\File;

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

        $translations = [];

        foreach ($categories as $category) {
            $parentCategory = Category::create([
                'name' => $category['name'],
                'slug' => $category['slug'],
            ]);

            $translations["{$category['slug']}"] = $category['name'];

            // Create the subcategories
            foreach ($category['subcategories'] as $subcategory) {
                Category::create([
                    'name' => $subcategory['name'],
                    'slug' => $subcategory['slug'],
                    'parent_id' => $parentCategory->id,
                ]);

                $translations["{$subcategory['slug']}"] = $subcategory['name'];
            }
        }

        $this->updateTranslationsFile('lang/tr/interface.php', $translations);
    }

    protected function updateTranslationsFile(string $filePath, array $translations): void
    {
        $fullPath = base_path($filePath);

        // Load existing translations
        $existingTranslations = File::exists($fullPath) ? include $fullPath : [];

        // Merge new translations with existing ones
        $updatedTranslations = array_merge($existingTranslations, $translations);

        // Export the translations as PHP code
        $exported = "<?php\n\nreturn " . var_export($updatedTranslations, true) . ";\n";

        // Write back to the file
        File::put($fullPath, $exported);
    }
}
