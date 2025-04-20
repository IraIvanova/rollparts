<?php

use App\Constant\FilesConstants;
use App\Models\Product;
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
    function getMainImagePath($product, ?string $size = 'image-sm'): string
    {
        if ($product instanceof Product) {
            return $product->getFirstMediaUrl('products', $size) ??
                asset(FilesConstants::DEFAULT_IMAGE);
        }

        return $product->getUrl($size) ??
            asset(FilesConstants::DEFAULT_IMAGE);

    }
}
