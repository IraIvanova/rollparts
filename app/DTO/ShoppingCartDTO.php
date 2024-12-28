<?php

namespace App\DTO;

class ShoppingCartDTO
{
    public float $total = 0.0;
    public float $totalWithDiscount = 0.0;

    public function __construct(
        public ?array $products = [],
        public ?string $couponCode = null,
    ) {
        $this->setTotalPrices();
    }

    private function addProduct()
    {

    }

    private function removeProduct()
    {

    }

    private function setTotalPrices(): void
    {
    }
}
