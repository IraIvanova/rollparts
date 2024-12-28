<?php

namespace App\Services\ShoppingCart;

use App\DTO\CartProductDTO;

class ShoppingCart
{
    private array $products = [];
    private float $totalPrice = 0.0;
    private float $totalWithDiscount = 0.0;
    private ?string $couponCode = null;

    public function __construct(array $products = [], ?string $couponCode = null)
    {
        $this->products = $products;
        $this->couponCode = $couponCode;
        $this->recalculateTotals();
    }

    public function addProduct(CartProductDTO $cartProduct, int $quantity): void
    {
        foreach ($this->products as $product) {
            if ($product->id === $cartProduct->id) {
                $product->amount += $quantity;
                $this->recalculateTotals();
                return;
            }
        }

        $this->products[] = $cartProduct;
        $this->recalculateTotals();
    }

    public function checkIfProductExists(int $productId): bool
    {
        return array_reduce(
            $this->products,
            fn($exists, $product) => $exists || $product->id === $productId,
            false
        );
    }

    public function removeProduct(int $productId, bool  $removeOne = true): void
    {
        if ($removeOne) {
            foreach ($this->products as $product) {
                if ($product->id === $productId && $product->amount > 1) {
                    $product->amount -= 1;
                    $this->recalculateTotals();
                    return;
                }
            }
        }

        $this->products = array_values(array_filter(
            $this->products,
            fn(CartProductDTO $product) => $product->id !== $productId
        ));
        $this->recalculateTotals();
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    public function getTotalWithDiscount(): float
    {
        return $this->totalWithDiscount;
    }

    public function setCouponCode(?string $couponCode): void
    {
        $this->couponCode = $couponCode;
    }

    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }

    private function recalculateTotals(): void
    {
        $this->totalPrice = 0.0;
        $this->totalWithDiscount = 0.0;

        foreach ($this->products as $product) {
            $this->totalPrice += $product->price * $product->amount;
            $this->totalWithDiscount += $product->discountedPrice * $product->amount;
        }
    }

    public function toArray(): array
    {
        return [
            'products' => array_map(fn($product) => (array)$product, $this->products),
            'totalPrice' => $this->totalPrice,
            'totalWithDiscount' => $this->totalWithDiscount,
            'couponCode' => $this->couponCode,
        ];
    }

    public static function fromArray(array $data): self
    {
        $products = array_map(
            fn($productData) => CartProductDTO::fromArray($productData),
            $data['products'] ?? []
        );

        return new self($products, $data['couponCode'] ?? null);
    }
}
