<?php

namespace App\Services\Store;

use App\DTO\CartProductDTO;
use App\Exceptions\ProductNotFoundException;
use App\Models\Product;
use App\Services\ShoppingCart\ShoppingCart;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * @throws ProductNotFoundException
     */
    public function addToCart(int $productId, int $quantity): ShoppingCart
    {
        $product = Product::find($productId);

        if (!$product) throw new ProductNotFoundException();

        $shoppingCart = $this->getCart();
        $prices = $product->priceByCurrency;
        $productInCart = new CartProductDTO(
            id: $productId,
            slug: $product->slug,
            name: $product->translationByLanguage['name'],
            amount: $quantity,
            image: $product->getFirstMediaUrl() ?: asset('images/default.png'),
            price: $prices['price'],
            discountedPrice: $prices['discounted_price']
        );

        $shoppingCart->addProduct($productInCart, $quantity);
        $this->saveCart($shoppingCart);

        return $shoppingCart;
    }

    public function removeFromCart(int $productId, $removeOne = true): ShoppingCart
    {
        $shoppingCart = $this->getCart();
        $shoppingCart->removeProduct($productId, $removeOne);
        $this->saveCart($shoppingCart);

        return $shoppingCart;
    }

    public function getCart(): ShoppingCart
    {
        return session('shoppingCart', new ShoppingCart());
    }

    private function saveCart(ShoppingCart $shoppingCart): void
    {
        session(['shoppingCart' => $shoppingCart]);
    }
}
