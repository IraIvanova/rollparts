<div class="brator-inline-product-filter-area">
    <div class="brator-inline-product-filter-left">
        <div class="brator-filter-show-result">
            <p class="woocommerce-result-count">
                {!! trans('interface.filtersAndSort.totalResults', ['qnt' => $products->total()]) !!}
            </p>
        </div>
    </div>
    <div class="brator-inline-product-filter-right">
        <div class="brator-filter-short-by">
            <p>{{ trans('interface.filtersAndSort.sortBy') }}</p>
            <div class="brator-filter-show-items-count">
                    <select id="orderby" class="orderby" aria-label="Shop order">
                        @foreach(['default', 'latest', 'priceAsc', 'priceDesc'] as $order)
                            <option value="{{$order}}" @if($order === $selectedOptions['sortby'])selected="selected" @endif>{{ trans('interface.filtersAndSort.' . $order) }}</option>
                        @endforeach
                    </select>
            </div>
        </div>
    </div>
</div>
