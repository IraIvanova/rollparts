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
                'years' => '2003–2009',
            ],
            [
                'make_id' => 1,
                'model' => 'Scenic II',
                'engine' => '1.5 dCi',
                'years' => '2004–2009',
            ],
            [
                'make_id' => 2,
                'model' => 'Logan',
                'engine' => '1.4 MPI',
                'years' => '2005–2012',
            ],
            [
                'make_id' => 4,
                'model' => 'Note',
                'engine' => '1.6',
                'years' => '2006–2013',
            ],
            [
                'make_id' => 5,
                'model' => 'Astra H',
                'engine' => '1.8',
                'years' => '2004–2010',
            ],
        ];

        foreach ($models as $data) {
            CarModel::create($data);
        }
    }
}
