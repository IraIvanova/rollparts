<?php

namespace App\DTO\Payment;

use App\Models\ClientAddress;

class BuyerAddressesDTO
{
    public function __construct(
        public ClientAddress $shippingAddress,
        public ClientAddress $billingAddress,
    ) {
    }
}
