<?php

namespace App\DTO;

class ProductsFilterParametersDTO
{
    public function __construct(
        public string $language,
        public ?string $currency,
        public ?array $categories = [],
        public ?SearchParametersDTO $searchParameters = null,
        public bool $paginate = false,
        public ?int $limit = null
    ) {
    }
}
