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
            ['name' => 'diameter', 'unit_type_id' => $unitTypes['inch'], 'values' => [18, 19, 20, 21, 22, 23]],
            ['name' => 'diameter', 'unit_type_id' => $unitTypes['cm'], 'values' => [18, 19, 20, 21, 22, 23]],
            ['name' => 'width', 'unit_type_id' => $unitTypes['inch'], 'values' => ['5.5"', '6.5"']],
            ['name' => 'width', 'unit_type_id' => $unitTypes['cm'], 'values' => ['5.5"', '6.5"']],
        ];

        foreach ($options as $singleOption) {
            $option = new Option();
            $option->name = $singleOption['name'];
            $option->unit_type_id = $singleOption['unit_type_id'];
            $option->save();

            foreach ($singleOption['values'] as $singleValue) {
                $optionValue = new OptionValue();
                $optionValue->option_id = $option->id;
                $optionValue->value = $singleValue;
                $optionValue->save();
            }
        }
    }
}
