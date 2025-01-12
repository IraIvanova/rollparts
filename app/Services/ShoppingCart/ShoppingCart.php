<?php

namespace App\Services\ShoppingCart;

use App\DTO\CartProductDTO;

class ShoppingCart
{
    private array $products = [];
    private float $totalPrice = 0.0;
    private float $totalWithDiscount = 0.0;
    private ?string $couponCode = null;
    private ?float $couponDiscount = 0;
    private int $totalItems = 0;

    public function __construct(array $products = [], ?string $couponCode = null)
    {
        $this->products = $products;
        $this->couponCode = $couponCode;
        $this->totalItems = count($this->products);
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
        $this->totalItems = count($this->products);
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

    public function checkIfQuantityEnough(CartProductDTO $cartProductDTO, int $maxAmount): bool
    {
        foreach ($this->products as $product) {
            if ($product->id === $cartProductDTO->id) {
                return $maxAmount >= $cartProductDTO->amount + $product->amount;
            }
        }

        return true;
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
        $this->totalItems = count($this->products);
        $this->recalculateTotals();
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getTotalItems(): int
    {
        return $this->totalItems;
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

    public function getCouponDiscount(): float
    {
        return $this->couponDiscount;
    }

    private function recalculateTotals(): void
    {
        $this->totalPrice = 0.0;
        $this->totalWithDiscount = 0.0;

        foreach ($this->products as $product) {
            $this->totalPrice += $product->price * $product->amount;
            $this->totalWithDiscount += $product->discountedPrice * $product->amount;
        }

        $this->totalWithDiscount -= $this->couponDiscount;
    }

    public function applyCoupon(string $couponCode): ?array
    {
//        if ($this->couponCode === $couponCode) return ['error' => 'Coupon is already applied'];
//
//        $coupon = Coupon::where('code', $couponCode)
//            ->where('is_active', true)
//            ->first();
//
//        if (!$coupon) return ['error' => 'Invalid or inactive coupon.'];
//
//        if ($coupon->expires_at && $coupon->expires_at < NOW()) return ['error' => 'This coupon has expired.'];
//
//        if ($coupon->minimum_order_amount && $this->totalWithDiscount < $coupon->minimum_order_amount) {
//          return [
//                'error' => "The order subtotal must be at least {$coupon->minimum_order_amount} to use this coupon."
//            ];
//        }
//
//        if ($coupon->usage_limit && $coupon->used >= $coupon->usage_limit) {
//            return ['error' => 'This coupon has reached its usage limit.'];
//        }
//
//        $discount = 0;
//        if ($coupon->discount_type === 'fixed') {
//            $discount = min($coupon->discount_value, $this->totalWithDiscount);
//        } elseif ($coupon->discount_type === 'percentage') {
//            $discount = ($coupon->discount_value / 100) * $this->totalWithDiscount;
//        }

        $couponHandler = (new CouponHandler())->setGivenCoupon($couponCode)->setTotal($this->totalWithDiscount);
        $couponHandler->applyCoupon($this->couponCode);

        $this->couponCode = $couponCode;
        $this->couponDiscount = $couponHandler->getDiscount();

        $this->recalculateTotals();

        return ['result' => $couponHandler->getResult()];
    }

    public function removeCoupon(): void
    {
        $this->couponCode = null;
        $this->couponDiscount = 0;
        $this->recalculateTotals();
    }

    public function toArray(): array
    {
        return [
            'products' => array_map(fn($product) => (array)$product, $this->products),
            'totalPrice' => $this->totalPrice,
            'totalWithDiscount' => $this->totalWithDiscount,
            'couponCode' => $this->couponCode,
            'couponDiscount' => $this->couponDiscount,
            'totalItems' => count($this->products)
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
