<?php

namespace App\Services;

use App\Models\ProductOption;

class ProductOptionsService
{
    public static function addBidirectionalRelationship(
        int $productId,
        int $relatedProductId,
        string $option,
        string $optionValue
    ): void {
        $existingRelation = ProductOption::where(function ($query) use ($productId, $relatedProductId, $optionValue) {
            $query->where('product_id', $productId)
                ->where('related_product_id', $relatedProductId)
                ->where('option_value', $optionValue);
        })->orWhere(function ($query) use ($productId, $relatedProductId, $optionValue) {
            $query->where('product_id', $relatedProductId)
                ->where('related_product_id', $productId)
                ->where('option_value', $optionValue);
        })->exists();

        if (!$existingRelation) {
            ProductOption::create([
                'product_id' => $productId,
                'related_product_id' => $relatedProductId,
                'option' => $option,
                'option_value' => $optionValue,
            ]);


            ProductOption::create([
                'product_id' => $relatedProductId,
                'related_product_id' => $productId,
                'option' => $option,
                'option_value' => $optionValue,
            ]);
        }
    }
}
