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

    public function createOrder(User $user, ShoppingCart $shoppingCart, ?string $notes = ''): Order
    {
        $order = new Order();
        $order->user_id = $user->id;
        $order->status_id = StatusesConstants::PENDING;
        $order->order_number = $shoppingCart->getOrderReference();
        $order->used_promo = json_encode([$shoppingCart->getCouponCode() => $shoppingCart->getCouponDiscount()], true);
        $order->total_price = array_reduce($shoppingCart->getProducts(), fn ($carry, CartProductDTO $item) => $carry + $item->price);
        $order->total_price_with_discount = array_reduce($shoppingCart->getProducts(), fn ($carry, CartProductDTO $item) => $carry + $item->discountedPrice) - $shoppingCart->getCouponDiscount();
        $order->notes = $notes;

        $order->save();

        $this->addProductsToOrder($order, $shoppingCart->getProducts());

        return $order;
    }

    public function getOrderByReference(string $reference): ?Order
    {
        return Order::where('order_number', $reference)->first();
    }

    public function changeOrderStatus(Order $order, int $status): void
    {
        $order->status_id = $status;
        $order->save();
    }

    public function updateOrderClient (User $client, Order $order): void
    {
        $order->user_id = $client->id;
        $order->save();
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

    public static function calculateTotalPriceWithManualDiscount(Order $order, ?float $manualDiscount = 0): float
    {
        $orderedProducts = $order->orderProducts;
        $total = $orderedProducts->sum(fn ($orderProduct) => $orderProduct->discounted_price * $orderProduct->amount);
        $promocodeDiscount = json_decode($order->used_promo, true)['discount'] ?? 0;

        return +number_format($total - $promocodeDiscount - $manualDiscount, 2);
    }
}
