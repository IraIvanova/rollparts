<?php

namespace App\DTO;

class ProductInCartDTO
{
    public function __construct(
        public int $productId,
        public string $slug,
        public string $name,
        public int $amount,
        public float $price,
        public ?float $discountedPrice,
    ) {
    }
}
