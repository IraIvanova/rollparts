<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Honda'],
            ['name' => 'Audi'],
            ['name' => 'BMW'],
            ['name' => 'Mercedes'],
            ['name' => 'Lanos'],
            ['name' => 'Geele'],
            ['name' => 'Hundai'],
            ['name' => 'Citroen'],
            ['name' => 'Reno'],
            ['name' => 'Opel'],
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'name' => $brand['name'],
                'slug' => Str::slug($brand['name'])
            ]);
        }
    }
}
