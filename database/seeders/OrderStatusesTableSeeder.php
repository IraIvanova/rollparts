<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Insert predefined order statuses
        DB::table('statuses')->insert([
            ['name' => 'Created'],
            ['name' => 'Pending'],
            ['name' => 'Waiting payment'],
            ['name' => 'Paid'],
            ['name' => 'Payment Failure'],
            ['name' => 'Processing'],
            ['name' => 'Shipped'],
            ['name' => 'Delivered'],
            ['name' => 'Cancelled'],
            ['name' => 'Returned' ],
            ['name' => 'Refunded'],
            ['name' => 'Completed'],
        ]);
    }
}
