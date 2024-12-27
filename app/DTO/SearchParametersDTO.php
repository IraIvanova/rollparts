<?php

namespace App\DTO;

class SearchParametersDTO
{
    private const OPTION_PREFIX = 'option_';
    public ?array $brands;
    public ?array $options = [];
    public ?array $optionValues = [];

    public function __construct(
        private readonly ?array $parameters = []
    ) {
        $this->brands = isset($this->parameters['brands']) ? explode(',', $this->parameters['brands'] ) : [];
        $this->resolveOptions($parameters);
    }

    public function resolveOptions(array $parameters): void
    {
        foreach ($parameters as $key => $parameter) {
            if (str_starts_with($key, self::OPTION_PREFIX)) {
                $explodedKey = explode(self::OPTION_PREFIX, $key);
                $this->options[] = $explodedKey[1];
                $this->optionValues[] = explode(',', $parameter);
            }
        }
    }
}