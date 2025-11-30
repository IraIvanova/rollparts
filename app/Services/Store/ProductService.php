<?php

namespace App\Services\Store;

use App\DTO\ProductsFilterParametersDTO;
use App\Models\Product;
use App\Services\FilesManagingService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductService
{
    private const int PRODUCTS_LIMIT_ON_HOMEPAGE = 12;
    public const int SEARCH_RESULTS_LIMIT = 30;
    private const string BESTSELLER_KEY = 'bestsellers';
    private const string NEWEST_PRODUCTS_KEY = 'newProducts';

    public function __construct(
        private readonly FilesManagingService $filesManagingService,
        private readonly BreadcrumbsService $breadcrumbsService,
        private readonly SearchService $searchService,
        private readonly StorageService $storageService,
    ) {
    }

    public function getProductBySlug(string $slug): ?Product
    {
        return Product::where('slug', $slug)->with(['carModels', 'carModels.make', 'manufacturer'])->first();
    }

    public function getProductById(int $id): ?Product
    {
        return Product::find($id);
    }

    public function getProductInfo(Product $product): array
    {
        $productNameAndDescription = $product->translationByLanguage;
        if ($frequentlyIds = $product->frequentlyBoughtTogether()->pluck('related_product_id')->toArray()) {
            $frequentlyBoughtFilterParameters = new ProductsFilterParametersDTO(
                language: 'tr',
                currency: 'TRL',
                products: $frequentlyIds,
                limit: 8
            );
            $frequentlyBoughtTogetherProducts = $this->searchService->getProductsList(
                $frequentlyBoughtFilterParameters
            );
        }

        if ($recentlyViewedIds = array_diff(session()->get('recentlyViewedProducts', []), [$product->id])) {
//           dd($product->id, $recentlyViewedIds);
            $recentlyViewedFilterParameters = new ProductsFilterParametersDTO(
                language: 'tr',
                currency: 'TRL',
                products: $recentlyViewedIds,
                limit: 8
            );
            $recentlyViewedProducts = $this->searchService->getProductsList(
                $recentlyViewedFilterParameters
            );
        }

        return [
            'product' => $product,
            'id' => $product->id,
            'active' => $product->active,
            'quantity' => $product->stock?->quantity,
            'mnfCode' => $product->mnf_code,
            'name' => $productNameAndDescription->name,
            'description' => $productNameAndDescription->description,
            'brand' => $product->carModels,
            'prices' => $product->priceByCurrency,
            'images' => $product->getMedia('products'),
            'productOptions' => $product->productOptions()->whereNot('related_product_id', $product->id)->with(
                'relatedProduct'
            )->get()->mapToGroups(fn($i) => [$i->option => [$i->option_value, $i->relatedProduct->slug]]),
            'frequentlyBoughtTogetherProducts' => $frequentlyBoughtTogetherProducts ?? [],
            'recentlyViewedProducts' => $recentlyViewedProducts ?? [],
            'colorVariants' => $product->productVariants,
            'breadcrumbs' => $this->breadcrumbsService->prepareBreadcrumbsForProduct(
                $product,
                $productNameAndDescription['name']
            ),
        ];
    }

    public function getImages(array $products)
    {
        $images = $this->filesManagingService->getProductImages($products);

        return $images
            ->groupBy('model_id');
    }

    public function getMainImages(array $products)
    {
        return $this->filesManagingService->getMainImages($products)->mapWithKeys(function ($i) {
            return [$i->model_id => $i->getFullUrl()];
        })
            ->toArray();
    }

    public function saveProductToRecentlyViewed(int $productId): void
    {
        $recentlyViewed = session()->get('recentlyViewedProducts', []);

        if (!in_array($productId, $recentlyViewed)) {
            if (count($recentlyViewed) >= 10) {
                array_shift($recentlyViewed); // Remove the first item (oldest)
            }

            $recentlyViewed[] = $productId;
            session()->put('recentlyViewedProducts', $recentlyViewed);
        }
    }

    public function getBestsellerProductsList(): array
    {
        if (!$this->storageService->checkKeyIsInStorage(self::BESTSELLER_KEY)) {
            $bestsellers = Product::join('order_product as op', 'products.id', '=', 'op.product_id')
                ->select('products.id', DB::raw('SUM(op.amount) as totalSold'))
                ->groupBy('products.id')
                ->where('active', 1)
                ->orderByDesc('totalSold')
                ->take(self::PRODUCTS_LIMIT_ON_HOMEPAGE)
                ->pluck('products.id')
                ->toArray();

            if (empty($bestsellers)) {
                $bestsellers = Product::where('active', 1)
                    ->take(self::PRODUCTS_LIMIT_ON_HOMEPAGE)
                    ->pluck('id')
                    ->toArray();
            }

            $this->storageService->setValueToStorage(self::BESTSELLER_KEY, $bestsellers);
        }

        return $this->storageService->getValueFromStorage(self::BESTSELLER_KEY);
    }

    public function getNewestProductsList(): array
    {
        if (!$this->storageService->checkKeyIsInStorage(self::NEWEST_PRODUCTS_KEY)) {
            $bestsellers = Product::where('active', 1)
                ->select('id')
                ->orderByDesc('id')
                ->take(self::PRODUCTS_LIMIT_ON_HOMEPAGE)
                ->pluck('id')
                ->toArray();
            $this->storageService->setValueToStorage(self::NEWEST_PRODUCTS_KEY, $bestsellers);
        }

        return $this->storageService->getValueFromStorage(self::NEWEST_PRODUCTS_KEY);
    }

    public function getFilteredProducts(ProductsFilterParametersDTO $filters): LengthAwarePaginator
    {
        return $this->searchService->getProductsList($filters);
    }
}
