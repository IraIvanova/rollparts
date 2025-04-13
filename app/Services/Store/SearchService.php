<?php

namespace App\Services\Store;

use App\DTO\ProductsFilterParametersDTO;
use App\Models\Product;

class SearchService
{
    public function getProductsByCategory(ProductsFilterParametersDTO $params)
    {
        $filters = [];

        if (!empty($params->categories)) {
            $filters[] = 'category_ids IN [' . implode(',', $params->categories) . ']';
        }

//        if (!empty($params->searchParameters?->brands)) {
//            $brandFilters = array_map(fn($b) => "brand = \"$b\"", $params->searchParameters->brands);
//            $filters[] = '(' . implode(' OR ', $brandFilters) . ')';
//        }

        if ($params->searchParameters?->min && $params->searchParameters?->max) {
            $filters[] = "discounted_price >= {$params->searchParameters->min} AND discounted_price <= {$params->searchParameters->max}";
        }

        // Combine filters
        $filterString = implode(' AND ', $filters);

        // Use Meilisearch's raw search
        $results = Product::search($params->searchParameters?->search ?? '', function ($meili, $query, $options) use ($filterString, $params) {
            $options['filter'] = $filterString;

            // Sorting
            if ($params->searchParameters?->sortBy === 'priceAsc') {
                $options['sort'] = ['discounted_price:asc'];
            } elseif ($params->searchParameters?->sortBy === 'priceDesc') {
                $options['sort'] = ['discounted_price:desc'];
            }

            return $meili->search($query, $options);
        });

        return $results->paginate(30);
    }

    public function getProductsList(ProductsFilterParametersDTO $params)
    {
        $products = Product::search('', function ($meili, $query, $options) use ($params) {
            if (!empty($params->products)) {
                $options['filter'] = 'id IN [' . implode(',', $params->products) . ']';
            }

            if ($params->limit) {
                $options['limit'] = $params->limit;
            }

            return $meili->search($query, $options);
        });

        return $products->get();
    }

    public function getMinMaxPrices(ProductsFilterParametersDTO $params): array
    {
        // Meilisearch doesn't support aggregate queries natively
        // You can post-process it manually
        $products = $this->getProductsByCategory($params);

        $min = $products->min('discounted_price');
        $max = $products->max('discounted_price');

        return ['minPrice' => $min, 'maxPrice' => $max];
    }
}
