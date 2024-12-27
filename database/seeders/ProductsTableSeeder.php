<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultTranslations = [
            'tr' => ['name' => 'Product-', 'description' => '<p>Prod description</p>'],
            'en' => ['name' => 'Product-', 'description' => '<p>Prod EN description</p>']
        ];

        $defaultPrices = [
            'TRL' => ['price' => '100', 'discountedPrice' => '90', 'discountAmount' => '10'],
            'USD' => ['price' => '100', 'discountedPrice' => '90', 'discountAmount' => '10'],

        ];

        for ($i = 1; $i <= 100; $i++) {
            $name = 'Product-' . Str::random(10);
            $product = new Product();
            $product->slug = Str::slug($name);
            $product->brand_id = rand(1, 10);
            $product->mnf_code = "MNF PROD $i";
            $product->save();

            ProductTranslation::create([
                'product_id' => $product->id,
                'language' => 'tr',
                'name' => $name,
                'description' => '<p>Prod EN description</p>'
            ]);

            $price = rand(10, 1000);
            $discountAmount = rand(0, 50);
            $discountedPrice = $price - ($price / 100 * $discountAmount);

            ProductPrice::create([
                'product_id' => $product->id,
                'currency_id' => 1,
                'price' => $price,
                'discounted_price' => $discountedPrice,
                'discount_amount' => $discountAmount,
            ]);

            foreach (Category::where('parent_id', null)->get() as $category) {
                if ($category->getSubCategories) {
                    $product->categories()->attach([$category->id, $category->getSubCategories->first()->id]);
                }
            }
        }
    }
}
