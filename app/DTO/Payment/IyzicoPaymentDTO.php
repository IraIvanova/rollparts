<?php

namespace App\DTO\Payment;

use App\Services\ShoppingCart\ShoppingCart;

class IyzicoPaymentDTO
{
    public function __construct(
        public string $conversationId,
        public float $price,
        public int $cartId,
        public string $callbackUrl,
        public BuyerDTO $buyer,
        public BuyerAddressesDTO $buyerAddresses,
        public ShoppingCart $shoppingCart,
    ) {
    }
}
