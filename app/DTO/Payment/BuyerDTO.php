<?php

namespace App\DTO\Payment;

class BuyerDTO
{

    public function __construct(
        public int $id,
        public string $name,
        public string $lastName,
        public string $phone,
        public string $registrationAddress,
        public string $ip,
        public string $email,
        public string $country,
        public string $city,
        public string $identityNumber,
    )
    {
    }
}
