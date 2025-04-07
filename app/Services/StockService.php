<?php

namespace App\Services;

use App\Models\ProductStock;

class StockService
{
    public function changeQuantityInStock(int $productId, int $quantity, int $orderId, bool $reduce = true): void
    {
        $stock = ProductStock::where('product_id', $productId)->first();
        $stock->setAttribute('source', "order #$orderId");
        $reduce ? $stock->decrement('quantity', $quantity) : $stock->increment('quantity', $quantity);
    }
}
