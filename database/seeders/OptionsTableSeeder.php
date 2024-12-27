<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\OptionValue;
use App\Models\UnitType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unitTypes = UnitType::all()->pluck('id', 'code');

        $options = [
            ['name' => 'diameter (inch)', 'unit_type_id' => $unitTypes['inch'], 'values' => [18, 19, 20, 21, 22, 23]],
            ['name' => 'diameter (cm)', 'unit_type_id' => $unitTypes['cm'], 'values' => [18, 19, 20, 21, 22, 23]],
            ['name' => 'width (inch)', 'unit_type_id' => $unitTypes['inch'], 'values' => ['5.5"', '6.5"']],
            ['name' => 'width (sm)', 'unit_type_id' => $unitTypes['cm'], 'values' => ['5.5"', '6.5"']],
        ];

        foreach ($options as $singleOption) {
            $option = new Option();
            $option->name = $singleOption['name'];
            $option->unit_type_id = $singleOption['unit_type_id'];
            $option->values = array_map(fn($v) => ['value' => $v], $singleOption['values']);
            $option->save();
        }
    }
}
