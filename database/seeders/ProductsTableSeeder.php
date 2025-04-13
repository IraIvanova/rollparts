<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductStock;
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
        for ($i = 1; $i <= 100; $i++) {
            $name = 'Product-' . Str::random(10);
            $product = new Product();
            $product->slug = Str::slug($name);
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

            ProductStock::create([
                'product_id' => $product->id,
                'quantity' => rand(1, 100),
            ]);

            foreach (Category::where('parent_id', null)->get() as $category) {
                $product->categories()->attach([$category->id, $category->children->first()->id]);
            }
        }
    }
}
