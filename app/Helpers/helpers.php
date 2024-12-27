<?php

if (!function_exists('isOptionShouldBeChecked')) {
    function isOptionShouldBeChecked(array $selectedOptions, string $currentOption, string $currentValue): bool {
        $optionKey = array_search($currentOption, $selectedOptions['options']);

        if ($optionKey !== false) {
            return in_array($currentValue, $selectedOptions['optionValues'][$optionKey]);
        }

        return false;
    }
}
