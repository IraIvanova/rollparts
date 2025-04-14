<?php

namespace App\DTO;

class SearchParametersDTO
{
    private const OPTION_PREFIX = 'option_';
    public ?string $sortBy;
    public ?string $search = '';
    public ?array $carModels = [];
    public ?array $carMakes = [];
    public ?int $min = null;
    public ?int $max = null;
    public ?array $options = [];
    public ?array $optionValues = [];

    public function __construct(
        private readonly ?array $parameters = []
    ) {
        $this->carModels = isset($this->parameters['carModels']) ? explode(',', $this->parameters['carModels'] ) : [];
        $this->carMakes = isset($this->parameters['carMakes']) ? explode(',', $this->parameters['carMakes'] ) : [];
        $this->sortBy = $this->parameters['sortby'] ?? '';
        $this->search = $this->parameters['search'] ?? '';
        $this->min = $this->parameters['min'] ?? null;
        $this->max = $this->parameters['max'] ?? null;
        $this->resolveOptions($parameters);
    }

    public function getValuesArray(): array
    {
        return [
            'search' => $this->search,
            'carModels' => $this->carModels,
            'carMakes' => $this->carMakes,
            'sortby' => $this->sortBy,
            'optionValues' => $this->optionValues,
            'options' => $this->options,
            'min' => $this->min,
            'max' => $this->max,
        ];
    }

    private function resolveOptions(array $parameters): void
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
