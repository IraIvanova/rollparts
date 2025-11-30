<?php

namespace App\Services;

class PriceCalculationService
{
    public static function calculateDiscountedPrice(float $price, float $discount): float
    {
        if ($discount <= 0 || $price <= 0) {
            return $price;
        }

        return round($price - ($price * $discount / 100), 2);
    }

    public static function calculateDiscountPercent(float $price, float $discountedPrice): float
    {
        if ($price <= 0 || $discountedPrice >= $price) {
            return 0;
        }

        return round((($price - $discountedPrice) / $price) * 100, 2);
    }
}
