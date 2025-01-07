<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductStock;

class StockService
{
    public function reduceQuantityInStock(int $productId, int $quantity, int $orderId): void
    {
        $stock = ProductStock::where('product_id', $productId)->first();
        $stock->setAttribute('source', "order #$orderId");
        $stock->decrement('quantity', $quantity);
    }
}
