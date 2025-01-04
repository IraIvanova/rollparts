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
        return $this->active()
            ->addProductTranslations($parameters->language, $parameters->searchParameters?->search)
            ->addCategory($parameters->categories)
            ->addPrices($parameters->currency)
            ->filterByBrands($parameters->searchParameters?->brands)
            ->filterByOptions($parameters->searchParameters?->options, $parameters->searchParameters?->optionValues)
            ->applyOrdering($parameters->searchParameters?->sortBy)
            ->getResults();
    }

    public function getBestsellerProducts(ProductsFilterParametersDTO $parameters): Builder
    {
        return $this
            ->addProductTranslations($parameters->language)
            ->addPrices($parameters->currency)
            ->filterByBrands($parameters->searchParameters?->brands)
            ->setLimit($parameters->limit)
            ->getResults();
    }

    private function addCategory(array $categories = []): self
    {
        if (!empty($categories)) {
            $this->query
                ->join('category_product as cp', 'p.id', '=', 'cp.product_id')
                ->join('categories as c', 'c.id', '=', 'cp.category_id')
                ->whereIn('c.id', $categories);
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

    private function addPrices(string $currencyCode): self
    {
        $this->query->join('product_prices as pp', 'p.id', '=', 'pp.product_id')
            ->join('currencies as cur', 'cur.id', '=', 'pp.currency_id')
            ->where('cur.code', $currencyCode);
        $this->selectFields = array_merge($this->selectFields, ['pp.discounted_price', 'pp.discount_amount', 'pp.price']
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
        //ToDO check how many queries would be performed
        if (!empty($options) && !empty($values)) {
//            foreach ($options as $key => $option) {
//                $this->query->whereExists(function ($query) use ($option, $values, $key) {
//                    $query->select(DB::raw(1))
//                        ->from('product_options as po')
//                        ->where('po.option', $option)
//                        ->where('po.product_id', '=', 'p.id')
//                        ->whereIn('po.option_value', $values[$key]);
//                });
//            }
            $sql = '';
            foreach ($options as $key => $option) {
                $sql .= "exists(select 1 from product_options as pv WHERE `pv`.`option`='" . $option . "' AND pv.product_id=p.id AND pv.option_value in (" . implode(
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

    private function applyOrdering(?string $order): self
    {
        $this->selectFields = array_merge($this->selectFields, [
            DB::raw('CASE WHEN pp.discounted_price > 0 THEN pp.discounted_price ELSE pp.price END as finalPrice')
        ]);

        switch ($order) {
            case 'latest':
                $this->query->orderBy('p.created_at', 'desc');
            case 'price-asc':
                $this->query->orderBy('finalPrice');
            case 'price-desc':
                $this->query->orderBy('finalPrice', 'desc');
        }

        return $this;
    }

    public function setLimit(int $limit): self
    {
        $this->query->limit($limit);

        return $this;
    }

    private function getResults(): Builder
    {
        $this->query->distinct()->select($this->selectFields);

        return $this->query;
    }
}
