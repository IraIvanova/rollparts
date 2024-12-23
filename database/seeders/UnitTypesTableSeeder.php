<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitTypesTableSeeder extends Seeder
{
    public function run()
    {
        $unitTypes = [
            ['name' => 'Inches', 'code' => 'inch'],
            ['name' => 'mm', 'code' => 'mm'],
            ['name' => 'cm', 'code' => 'cm'],
            ['name' => 'Pcs', 'code' => 'pcs'],
            ['name' => 'Meter', 'code' => 'm'],
            ['name' => 'Kg', 'code' => 'kg'],
            ['name' => 'Gram', 'code' => 'g'],
            ['name' => 'Liter', 'code' => 'l'],
            ['name' => 'Unit', 'code' => 'unit'],
        ];

        foreach ($unitTypes as $unitType) {
            DB::table('unit_types')->insert($unitType);
        }
    }
}
