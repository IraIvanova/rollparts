<?php

namespace App\Services;

use App\Constant\StatusesConstants;
use App\DTO\CartProductDTO;
use App\Models\Client;
use App\Models\Order;
use App\Models\User;
use App\Services\ShoppingCart\ShoppingCart;
use App\Services\Store\ProductService;

class OrderService
{
    public function __construct(
        private readonly StockService $stockService,
    )
    {
    }

    public function createOrder(User $user, ShoppingCart $shoppingCart): Order
    {
        $order = new Order();
        $order->user_id = $user->id;
        $order->status_id = StatusesConstants::CREATED;
        $order->order_number = null;
        $order->used_promo = json_encode([$shoppingCart->getCouponCode() => $shoppingCart->getCouponDiscount()], true);
        $order->total_price = array_reduce($shoppingCart->getProducts(), fn ($carry, CartProductDTO $item) => $carry + $item->price);
        $order->total_price_with_discount = array_reduce($shoppingCart->getProducts(), fn ($carry, CartProductDTO $item) => $carry + $item->discountedPrice) - $shoppingCart->getCouponDiscount();

        $order->save();

        $this->addProductsToOrder($order, $shoppingCart->getProducts());

        return $order;
    }

    private function addProductsToOrder(Order $order, array $products): void
    {
        foreach ($products as $product) {
            $order->orderProductsPivot()->attach($product->id,
                [
                    'amount' => $product->amount,
                    'price' => $product->price,
                    'discounted_price' => $product->discountedPrice,
                ]);

            $this->stockService->reduceQuantityInStock($product->id, $product->amount, $order->id);
        }
    }
}
