<?php

namespace App\DTO;

class ProductsFilterParametersDTO
{
    public function __construct(
        public string $language,
        public ?string $currency,
        public ?int $categoryId,
        public ?SearchParametersDTO $searchParameters,
        public ?string $searchString = '',
        public bool $paginate = false
    ) {
    }
}
