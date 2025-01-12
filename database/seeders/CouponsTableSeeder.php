<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'WELCOME10',
                'discount_value' => 10,
                'discount_type' => 'percentage',
                'minimum_order_amount' => 50,
                'usage_limit' => 100,
                'used' => 0,
                'is_active' => true,
                'expires_at' => now()->addDays(30),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'FLAT50',
                'discount_value' => 50,
                'discount_type' => 'fixed',
                'minimum_order_amount' => 100,
                'usage_limit' => 50,
                'used' => 0,
                'is_active' => true,
                'expires_at' => now()->addDays(15),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SUMMER20',
                'discount_value' => 20,
                'discount_type' => 'percentage',
                'minimum_order_amount' => 200,
                'usage_limit' => 20,
                'used' => 0,
                'is_active' => true,
                'expires_at' => now()->addDays(45),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'NEWYEAR2025',
                'discount_value' => 25,
                'discount_type' => 'fixed',
                'minimum_order_amount' => 150,
                'usage_limit' => 30,
                'used' => 0,
                'is_active' => false,
                'expires_at' => now()->addDays(60),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('coupons')->insert($coupons);
    }
}
