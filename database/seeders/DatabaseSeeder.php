<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Currency;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        Currency::factory()->create([
            'code' => 'TRL',
            'display_code' => '₺',
        ]);

        $this->call([
            LanguagesTableSeeder::class,
            CategoriesTableSeeder::class
        ]);
    }
}