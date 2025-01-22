<?php

namespace App\Services\Store;

use App\DTO\ProductsFilterParametersDTO;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class SearchProductsQueryBuilderService
{
    protected Builder $query;
    protected array $selectFields = [];

    public function __construct()
    {
        $this->query = DB::table('products as p');
    }

    public function getProductsByCategory(ProductsFilterParametersDTO $parameters): Builder
    {
        $this->resetQuery();

        return $this->active()
            ->addProductTranslations($parameters->language, $parameters->searchParameters?->search ?? '')
            ->addCategory($parameters->categories)
            ->addPrices($parameters->currency, $parameters->searchParameters->min, $parameters->searchParameters->max)
            ->filterByBrands($parameters->searchParameters?->brands)
            ->filterByOptions($parameters->searchParameters?->options, $parameters->searchParameters?->optionValues)
            ->applyOrdering($parameters->searchParameters?->sortBy)
            ->getResults();
    }

    public function getMinMaxPricesForProducts(ProductsFilterParametersDTO $parameters): Builder
    {
        $this->resetQuery();

        return $this->active()
            ->addCategory($parameters->categories)
            ->getMinMaxPrices($parameters->currency)
            ->getResults();
    }

    public function getProductsList(ProductsFilterParametersDTO $parameters): Builder
    {
        $this->resetQuery();

        return $this->active()
            ->addProductTranslations($parameters->language, $parameters->searchParameters?->search ?? '')
            ->addCategory($parameters->categories)
            ->addPrices($parameters->currency)
            ->filterByBrands($parameters->searchParameters?->brands)
            ->filterByProductIds($parameters->products)
            ->setLimit($parameters->limit)
            ->applyOrdering($parameters->searchParameters?->sortBy)
            ->getResults();
    }

    private function addCategory(array $categories = []): self
    {
        if (!empty($categories)) {
            $this->query
                ->join('category_product as cp', 'p.id', '=', 'cp.product_id')
                ->whereIntegerInRaw('cp.category_id', $categories);
        }

        return $this;
    }

    private function addProductTranslations(string $languageCode, string $searchString = ''): self
    {
        $this->query
            ->join('product_translations as pt', 'p.id', '=', 'pt.product_id')
            ->where('pt.language', $languageCode);
        //TODO search with elastic?

        if ($searchString) {
            $this->query->where('pt.name', 'like', '%' . $searchString . '%');
        }

        $this->selectFields = array_merge(
            $this->selectFields,
            ['p.id', 'p.created_at', 'p.slug', 'pt.name', 'pt.description']
        );

        return $this;
    }

    private function active(): self
    {
        $this->query->where('p.active', true);

        return $this;
    }

    private function addPrices(string $currencyCode, ?int $min = null, ?int $max = null): self
    {
        $this->query->join('product_prices as pp', 'p.id', '=', 'pp.product_id')
            ->join('currencies as cur', 'cur.id', '=', 'pp.currency_id')
            ->where('cur.code', $currencyCode);

        if ($min && $max) {
            $this->query->whereBetween('pp.discounted_price', [$min, $max]);
        }

        $this->selectFields = array_merge($this->selectFields, ['pp.discounted_price', 'pp.discount_amount', 'pp.price']
        );

        return $this;
    }

    private function getMinMaxPrices(string $currencyCode): self
    {
        $this->query->join('product_prices as pp', 'p.id', '=', 'pp.product_id')
            ->join('currencies as cur', 'cur.id', '=', 'pp.currency_id')
            ->where('cur.code', $currencyCode);

        $this->selectFields = array_merge(
            $this->selectFields,
            [DB::raw('MAX(pp.discounted_price) AS maxPrice, MIN(pp.discounted_price) AS minPrice')]
        );

        return $this;
    }

    private function filterByBrands(?array $brands = []): self
    {
        $this->query->join('brands as b', 'b.id', '=', 'p.brand_id');

        if (!empty($brands)) {
            $this->query->whereIn('b.name', $brands);
        }

        $this->selectFields = array_merge($this->selectFields, ['b.slug as brand_slug', 'b.name as brand_name']);

        return $this;
    }

    private function filterByOptions(?array $options, ?array $values): self
    {
//        dd($options, $values);
        if (!empty($options) && !empty($values)) {
            $sql = '';
            foreach ($options as $key => $option) {
                $sql .= "exists(select 1 from product_options as pv WHERE `pv`.`option`='" . $option . "' AND pv.related_product_id=p.id AND pv.option_value in (" . implode(
                        ',',
                        $values[$key]
                    ) . "))";
                if ($key + 1 < count($options)) {
                    $sql .= ' AND ';
                }
            }
            $this->query->whereRaw($sql);
        }

        return $this;
    }

    private function filterByProductIds(?array $products = []): self
    {
        if (!empty($products)) {
            $this->query->whereIntegerInRaw('p.id', $products);
        }

        return $this;
    }

    private function applyOrdering(?string $order): self
    {
        $this->selectFields = array_merge($this->selectFields, [
            DB::raw('CASE WHEN pp.discounted_price > 0 THEN pp.discounted_price ELSE pp.price END as finalPrice')
        ]);

        switch ($order) {
            case 'latest':
                $this->query->orderBy('p.created_at', 'desc');
            case 'priceAsc':
                $this->query->orderBy('finalPrice');
            case 'priceDesc':
                $this->query->orderBy('finalPrice', 'desc');
        }

        return $this;
    }

    public function setLimit(?int $limit = null): self
    {
        if ($limit) {
            $this->query->limit($limit);
        }

        return $this;
    }

    private function getResults(): Builder
    {
        $this->query->select($this->selectFields)->distinct();

        return $this->query;
    }

    private function resetQuery(): self
    {
        $this->query = DB::table('products as p');
        $this->selectFields = [];

        return $this;
    }
}
