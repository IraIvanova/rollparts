<div class="rollparts-inline-product-filter-area">
    <div class="rollparts-inline-product-filter-left">
        <div class="rollparts-filter-show-result">
            <p class="result-count">
                {!! trans('interface.filtersAndSort.totalResults', ['qnt' => $products->total()]) !!}
            </p>
        </div>
    </div>
    <div class="rollparts-inline-product-filter-right">
        <div class="rollparts-filter-short-by">
            <p>{{ trans('interface.filtersAndSort.sortBy') }}</p>
            <div class="rollparts-filter-show-items-count">
                    <select id="orderby" class="orderby" aria-label="Shop order">
                        @foreach(['default', 'latest', 'priceAsc', 'priceDesc'] as $order)
                            <option value="{{$order}}" @if($order === $selectedOptions['sortby'])selected="selected" @endif>{{ trans('interface.filtersAndSort.' . $order) }}</option>
                        @endforeach
                    </select>
            </div>
        </div>
    </div>
</div>
