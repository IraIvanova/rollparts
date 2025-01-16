<div class="brator-best-seller-section-header-area py-5">
    <div class="row">
    <div class=" col-12 brator-section-header all-item-left">
        <div class="brator-section-header-title mb-2">
            <h2>{{ trans('interface.home.bestsellers') }}</h2>
        </div>
        <a href="{{ route('catalog') }}">{{ trans('interface.home.seeAllProducts') }}
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                      d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"></path>
            </svg>
        </a>
    </div>
    </div>
    <div class="mt-3">
        <div class="bestseller-products product-list-items">
            @foreach($bestsellers as $bestseller)
                @include('store.components.productsList.item', ['product' => $bestseller])
            @endforeach
        </div>
    </div>
</div>

<div class="brator-best-seller-section-header-area py-5">
    <div class="row">
        <div class=" col-12 brator-section-header all-item-left">
            <div class="brator-section-header-title mb-2">
                <h2>{{ trans('interface.home.newProducts') }}</h2>
            </div>
            <a href="{{ route('catalog') }}">{{ trans('interface.home.seeAllProducts') }}
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                          d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"></path>
                </svg>
            </a>
        </div>
    </div>
    <div class="mt-3">
        <div class="bestseller-products product-list-items">
            @foreach($newestProducts as $newestProduct)
                @include('store.components.productsList.item', ['product' => $newestProduct])
            @endforeach
        </div>
    </div>
</div>

