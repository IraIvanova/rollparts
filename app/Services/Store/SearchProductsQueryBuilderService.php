<?php

namespace App\Services\Store;

use App\DTO\ProductsFilterParametersDTO;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class SearchProductsQueryBuilderService
{
    protected Builder $query;
    protected array $selectFields = [];

    public function __construct() {
        $this->query = DB::table('products as p');
    }

    public function getProductsByCategory(ProductsFilterParametersDTO $parameters): Builder
    {
        return $this->active()
            ->addProductTranslations($parameters->language, $parameters->searchString)
            ->addCategory($parameters->categoryId)
            ->addPrices($parameters->currency)
            ->getResults();
    }

    private function addCategory(int $category): self
    {
        $this->query
            ->join('category_product as cp', 'p.id', '=', 'cp.product_id')
            ->join('categories as c', 'c.id', '=', 'cp.category_id')
            ->where('c.id', $category);

        return $this;
    }

    private function addProductTranslations(string $languageCode, string $searchString = ''): self
    {
        $this->query
            ->join('product_translations as pt', 'p.id', '=', 'pt.product_id')
            ->where('pt.language', $languageCode);
        //TODO search with elastic?
        if ($searchString) $this->query->where('pt.title', 'like', '%' . $searchString . '%');

        $this->selectFields = array_merge($this->selectFields, ['p.id', 'p.slug', 'pt.name', 'pt.description']);

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
        $this->selectFields = array_merge($this->selectFields, ['pp.discounted_price', 'pp.discount_amount', 'pp.price']);

        return $this;
    }

    private function getResults(): Builder
    {
        $this->query->select($this->selectFields);

        return $this->query;
    }
}
