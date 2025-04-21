<?php

namespace App\Services\Store;

use App\DTO\ProductsFilterParametersDTO;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchService
{
    public function getProductsList(ProductsFilterParametersDTO $params): LengthAwarePaginator
    {
        $filters = [];

        if (!empty($params->categories)) {
            $filters[] = 'category_ids IN [' . implode(',', $params->categories) . ']';
        }

        if (!empty($params->products)) {
            $filters[] = 'id IN [' . implode(',', $params->products) . ']';
        }

        if (!empty($params->searchParameters?->carMakes)) {
            $makeFilters = array_map(fn($make) => "make_names = \"$make\"", $params->searchParameters->carMakes);
            $filters[] = '(' . implode(' OR ', $makeFilters) . ')';
        }

        // Filter by car model
        if (!empty($params->searchParameters?->carModels)) {
            $modelFilters = array_map(fn($model) => "car_model_names = \"$model\"", $params->searchParameters->carModels);
            $filters[] = '(' . implode(' OR ', $modelFilters) . ')';
        }

        if ($params->searchParameters?->min && $params->searchParameters?->max) {
            $filters[] = "discounted_price >= {$params->searchParameters->min} AND discounted_price <= {$params->searchParameters->max}";
        }

        // Combine filters
        $filterString = implode(' AND ', $filters);

        $results = Product::search($params->searchParameters?->search ?? '', function ($meili, $query, $options) use ($params, $filterString) {
            if (!empty($filterString)) {
                $options['filter'] = $filterString;
            }

            // Sorting
            if ($params->searchParameters?->sortBy === 'priceAsc') {
                $options['sort'] = ['discounted_price:asc'];
            } elseif ($params->searchParameters?->sortBy === 'priceDesc') {
                $options['sort'] = ['discounted_price:desc'];
            }

            // Limit (pagination handling)
            $options['limit'] = $params->limit ?? 30;

            return $meili->search($query, $options);
        });

        return $results->paginate($params->limit ?? 30);
    }

    public function getMinMaxPrices(ProductsFilterParametersDTO $params): array
    {
        // Meilisearch doesn't support aggregate queries natively
        // You can post-process it manually
        $products = $this->getProductsList($params);

        $min = $products->min('discounted_price');
        $max = $products->max('discounted_price');

        return ['minPrice' => $min, 'maxPrice' => $max];
    }
}
