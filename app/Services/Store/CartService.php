<?php

namespace App\Services\Store;

use App\Models\Product;

class CartService
{
    public function addToCart(int $productId): array
    {
        dd($productId);
        $shoppingCart = session('shoppingCart', []);

        if (isset($shoppingCart[$productId])) {
            $shoppingCart[$productId]['amount'] += 1;
        } else {
            $product = Product::findOrFail($productId);
            $prices = $product->priceByCurrency;

            $shoppingCart[$productId] = [
                'productId' => $productId,
                'amount'    => 1,
                'price'     => $prices['price'],
                'name'      => $product->translationByLanguage['name'],
                'discount'  => $prices['discounted_price']
            ];
        }

        session(['shoppingCart' => $shoppingCart]);

        return $shoppingCart;
    }

    public function removeFromCart(int $productId): ?array
    {
        $shoppingCart = session('shoppingCart', []);

        if (!isset($shoppingCart[$productId])) return null;

        if ($shoppingCart[$productId]['amount'] == 1){
            unset($shoppingCart[$productId]);
        } else {
            $shoppingCart[$productId]['amount'] -= 1;
        }

        session(['shoppingCart' => $shoppingCart]);

        return $shoppingCart;
    }
}
