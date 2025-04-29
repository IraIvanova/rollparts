<?php

namespace Database\Seeders;

use App\Models\WebsiteSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebsiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WebsiteSettings::create([
            'free_shipping_threshold' => 10000,
            'fixed_shipping_price' => 250,
        ]);
    }
}
