<?php

namespace App\Services\Store;

use App\DTO\CartProductDTO;
use App\Exceptions\ProductNotFoundException;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use App\Services\ShoppingCart\ShoppingCart;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function __construct(
        private readonly ClientService $clientService,
        private readonly OrderService $orderService,
    ) {
    }

    /**
     * @throws ProductNotFoundException
     */
    public function addToCart(int $productId, int $quantity): array
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

        return $shoppingCart->toArray();
    }

    public function removeFromCart(int $productId, $removeOne = true): ShoppingCart
    {
        $shoppingCart = $this->getCart();
        $shoppingCart->removeProduct($productId, $removeOne);
        $this->saveCart($shoppingCart);

        return $shoppingCart;
    }

    public function isCartEmpty(): bool
    {
        return $this->getCart()->getTotalItems() === 0;
    }

    public function createOrder(array $contactDetails): Order
    {
        $client = $this->clientService->findOrCreateClient($contactDetails);
        $this->clientService->saveAddress($client, $contactDetails);
        $shoppingCart = $this->getCart();

        $order = $this->orderService->createOrder($client, $shoppingCart->getProducts());
        $this->clearCart();

        return $order;
    }

    public function getCart(): ShoppingCart
    {
        return session('shoppingCart', new ShoppingCart());
    }

    private function saveCart(ShoppingCart $shoppingCart): void
    {
        session(['shoppingCart' => $shoppingCart]);
    }

    private function clearCart(): void
    {
        session()->forget('shoppingCart');
    }

    public function getRenderedProductsList(): string
    {
        return view('store.components.cart.previewInHeader', ['shoppingCart' => $this->getCart()->toArray()])->render();
    }
}
