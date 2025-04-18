<?php

namespace Database\Seeders;

use App\Models\CarModel;
use Illuminate\Database\Seeder;

class CarModelSeeder extends Seeder
{
    public function run(): void
    {
        $models = [
            [
                'make_id' => 1,
                'model' => 'Megane II',
                'engine' => '1.6 16V',
            ],
            [
                'make_id' => 1,
                'model' => 'Scenic II',
                'engine' => '1.5 dCi',
            ],
            [
                'make_id' => 2,
                'model' => 'Logan',
                'engine' => '1.4 MPI',
            ],
            [
                'make_id' => 4,
                'model' => 'Note',
                'engine' => '1.6',
            ],
            [
                'make_id' => 5,
                'model' => 'Astra H',
                'engine' => '1.8',
            ],
        ];

        foreach ($models as $data) {
            CarModel::create($data);
        }
    }
}
