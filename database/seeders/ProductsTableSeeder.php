<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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


        $products = [
            [
                'brand_id' => 1,
                'mnf_code' => 'MNF PROD',
                'quantity' => rand(1, 100),
            ],
        ];
    }
}
