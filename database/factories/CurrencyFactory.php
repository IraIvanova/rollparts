<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => fake()->name(),
            'display_code' =>  fake()->name(),
        ];
    }
}
