<?php

namespace App\Services\Store;

use App\DTO\ProductInCartDTO;
use App\DTO\ShoppingCartDTO;
use App\Exceptions\ProductNotFoundException;
use App\Models\Product;

class CartService
{
    /**
     * @throws ProductNotFoundException
     */
    public function addToCart(int $productId): array
    {
        $shoppingCart = $this->getCartFromSession();

        if (isset($shoppingCart[$productId])) {
            $shoppingCart[$productId]['amount'] += 1;
        } else {
            //TODO move to ProductService and throw exception there
            $product = Product::find($productId);

            if (!$product) {
                throw new ProductNotFoundException();
            }

            $prices = $product->priceByCurrency;

            $shoppingCart[$productId] = new ProductInCartDTO (
                productId: $productId,
                slug: $product->slug,
                name: $product->translationByLanguage['name'],
                amount: 1,
                price: $prices['price'],
                discountedPrice: $prices['discounted_price']
            );
        }

        session(['shoppingCart' => $shoppingCart]);

        return $shoppingCart;
    }

    public function removeFromCart(int $productId): ?array
    {
        $shoppingCart = $this->getCartFromSession();

        if (!isset($shoppingCart[$productId])) {
            return null;
        }

        if ($shoppingCart[$productId]['amount'] == 1) {
            unset($shoppingCart[$productId]);
        } else {
            $shoppingCart[$productId]['amount'] -= 1;
        }

        session(['shoppingCart' => $shoppingCart]);

        return $shoppingCart;
    }

    public function getProductsInCart(): array
    {
        return $this->getCartFromSession();
    }

    public function getTotalAmount(): float
    {
        $products = $this->getCartFromSession();
        $total = 0;
        $withDiscount = 0;

        foreach ($products as $product) {
            $total += $product['amount'] * $product['price'];

            if ($product['discountedPrice']) {
            }
        }
    }

    private function getCartFromSession(): array
    {
        return session('shoppingCart', new ShoppingCartDTO());
    }
}
