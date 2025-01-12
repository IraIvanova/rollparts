<?php

namespace App\Services\ShoppingCart;

use App\Models\Coupon;

class CouponHandler
{
    public float $total;
    public ?float $discount = 0;
    public string $givenCoupon;
    public ?string $result = null;
    public ?Coupon $coupon = null;

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function setGivenCoupon(string $givenCoupon): self
    {
        $this->givenCoupon = $givenCoupon;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function applyCoupon(?string $appliedCoupon): void
    {
        if ($this->givenCoupon === $appliedCoupon) $this->result = 'Coupon is already applied';

        $this->coupon = Coupon::where('code', $this->givenCoupon)
            ->where('is_active', true)
            ->first();

        if (!$this->coupon) {
            $this->result = 'Invalid or inactive coupon.';
        } elseif ($this->coupon->expires_at && $this->coupon->expires_at < NOW()) {
            $this->result = 'This coupon has expired.';
        } elseif ($this->coupon->minimum_order_amount && $this->total < $this->coupon->minimum_order_amount) {
            $this->result = "The order subtotal must be at least {$this->coupon->minimum_order_amount} to use this coupon.";
        } elseif ($this->coupon->usage_limit && $this->coupon->used >= $this->coupon->usage_limit) {
            $this->result = 'This coupon has reached its usage limit.';
        } else {
            if ($this->coupon->discount_type === 'fixed') {
                $this->discount = min($this->coupon->discount_value, $this->total);
            } elseif ($this->coupon->discount_type === 'percentage') {
                $this->discount = ($this->coupon->discount_value / 100) * $this->total;
            }
        }
    }
}
