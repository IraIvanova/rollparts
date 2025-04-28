<?php

namespace Database\Seeders;

use App\Models\Manufacturer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManufacturersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Manufacturer::create(['name' => 'Forge Motorsport']);
        Manufacturer::create(['name' => 'HKS']);
        Manufacturer::create(['name' => 'Eibach']);
        Manufacturer::create(['name' => 'Racing line']);
    }
}
