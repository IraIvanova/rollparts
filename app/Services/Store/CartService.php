<?php

namespace App\Services\Store;

use App\DTO\CartProductDTO;
use App\Exceptions\AddToCartException;
use App\Exceptions\ProductNotFoundException;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderService;
use App\Services\ShoppingCart\ShoppingCart;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class CartService
{
    public function __construct(
        private readonly ClientService $clientService,
        private readonly OrderService $orderService,
    ) {
    }

    /**
     * @throws ProductNotFoundException
     * @throws AddToCartException
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
            image: getMainImagePath($product, 'thumb'),
            price: $prices['price'],
            discountedPrice: $prices['discounted_price']
        );
        if (!$shoppingCart->checkIfQuantityEnough($productInCart, $product->stock->quantity)) throw new AddToCartException();

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

    public function createOrder(User $client, array $additionalInfo): ?Order
    {
       return DB::transaction(function () use ($client, $additionalInfo) {
            $shoppingCart = $this->getCart();

            return $this->orderService->createOrder($client, $shoppingCart, $additionalInfo);
        });
    }

    public function applyCoupon(string $couponCode): ?array
    {
        return $this->getCart()->applyCoupon($couponCode);
    }

    public function removeCoupon(): void
    {
       $this->getCart()->removeCoupon();
    }

    public function getCart(): ShoppingCart
    {
        return session('shoppingCart', new ShoppingCart());
    }

    private function saveCart(ShoppingCart $shoppingCart): void
    {
        session(['shoppingCart' => $shoppingCart]);
    }

    public function clearCart(): void
    {
        session()->forget('shoppingCart');
    }

    public function getRenderedProductsList(): string
    {
        return view('store.components.cart.previewList', ['shoppingCart' => $this->getCart()->toArray()])->render();
    }
}
