<?php

namespace App\Console\Commands;

use App\Constant\StatusesConstants;
use App\Models\Order;
use App\Services\StockService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CancelStaleOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-stale-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel stale orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cutoff = Carbon::now()->subMinutes(30);

        $orders = Order::where('created_at', '<', $cutoff)
            ->where('status_id', StatusesConstants::PENDING)
            ->get();

        $this->info("Found {$orders->count()} stale orders to cancel.");

        foreach ($orders as $order) {
            app(StockService::class)->returnProductsToStock($order);

            $order->status_id = StatusesConstants::EXPIRED;
            $order->save();

            $this->info("Order #{$order->id} set to EXPIRED.");
        }
    }
}
