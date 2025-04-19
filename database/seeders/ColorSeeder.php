<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name' => 'Red',    'hex_code' => '#FF0000'],
            ['name' => 'Green',  'hex_code' => '#00FF00'],
            ['name' => 'Blue',   'hex_code' => '#0000FF'],
            ['name' => 'Black',  'hex_code' => '#000000'],
            ['name' => 'White',  'hex_code' => '#FFFFFF'],
            ['name' => 'Yellow', 'hex_code' => '#FFFF00'],
            ['name' => 'Purple', 'hex_code' => '#800080'],
            ['name' => 'Orange', 'hex_code' => '#FFA500'],
            ['name' => 'Pink',   'hex_code' => '#FFC0CB'],
            ['name' => 'Gray',   'hex_code' => '#808080'],
        ];

        foreach ($colors as $color) {
            Color::updateOrCreate(['name' => $color['name']], [
                'hex_code' => $color['hex_code'],
            ]);
        }
    }
}
