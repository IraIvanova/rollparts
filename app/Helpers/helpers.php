<?php

use App\Constant\FilesConstants;
use Illuminate\Support\Collection;

if (!function_exists('isOptionShouldBeChecked')) {
    function isOptionShouldBeChecked(array $selectedOptions, string $currentOption, string $currentValue): bool
    {
        $optionKey = array_search($currentOption, $selectedOptions['options']);

        if ($optionKey !== false) {
            return in_array($currentValue, $selectedOptions['optionValues'][$optionKey]);
        }

        return false;
    }
}

if (!function_exists('displayPrices')) {
    function displayPrices(array $selectedOptions, string $currentOption, string $currentValue): bool
    {
        $optionKey = array_search($currentOption, $selectedOptions['options']);

        if ($optionKey !== false) {
            return in_array($currentValue, $selectedOptions['optionValues'][$optionKey]);
        }

        return false;
    }
}

if (!function_exists('getMainImagePath')) {
    function getMainImagePath(Collection|array|null $images): string
    {
        if ($images && count($images) > 0) {
           return $images->first()->getFullUrl();
        }

        return asset(FilesConstants::DEFAULT_IMAGE);
    }
}
