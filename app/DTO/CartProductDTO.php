<?php

namespace App\DTO;

class CartProductDTO
{
    public function __construct(
        public int $id,
        public string $slug,
        public string $name,
        public int $amount,
        public float $price,
        public ?float $discountedPrice,
    ) {
    }
}