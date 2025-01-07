<?php

namespace App\Services;

use App\Constant\StatusesConstants;
use App\Models\Client;
use App\Models\Order;
use App\Services\Store\ProductService;

class OrderService
{
    public function __construct(
        private readonly StockService $stockService,
    )
    {
    }

    public function createOrder(Client $client, array $products): Order
    {
        $order = new Order();
        $order->client_id = $client->id;
        $order->status_id = StatusesConstants::CREATED;
        $order->order_number = null;
        $order->save();

        $this->addProductsToOrder($order, $products);

        return $order;
    }

    private function addProductsToOrder(Order $order, array $products): void
    {
        foreach ($products as $product) {
            $order->products()->attach($product->id,
                [
                    'amount' => $product->amount,
                    'price' => $product->price,
                    'discounted_price' => $product->discountedPrice,
                ]);

            $this->stockService->reduceQuantityInStock($product->id, $product->amount, $order->id);
        }
    }
}
