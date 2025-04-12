<?php

namespace Database\Seeders;

use App\Models\CarMake;
use Illuminate\Database\Seeder;

class CarMakeSeeder extends Seeder
{
    public function run(): void
    {
        CarMake::create(['name' => 'Renault']);
        CarMake::create(['name' => 'Dacia']);
        CarMake::create(['name' => 'Toyota']);
        CarMake::create(['name' => 'Nissan']);
        CarMake::create(['name' => 'Opel']);
    }
}
