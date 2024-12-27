<div class="brator-inline-product-filter-area">
    <div class="brator-inline-product-filter-left">
        <div class="brator-filter-show-result">
            <p class="woocommerce-result-count">
                <span> Total {{$products->total()}}</span>results</p>
        </div>
    </div>
    <div class="brator-inline-product-filter-right">
        <div class="brator-filter-short-by">
            <p>Sort by</p>
            <div class="brator-filter-show-items-count">
                    <select id="orderby" class="orderby" aria-label="Shop order">
                        @foreach(['default', 'latest', 'price-asc', 'price-desc'] as $order)
                            <option value="{{$order}}" @if($order === $selectedOptions['sortby'])selected="selected" @endif>{{$order}}</option>
                        @endforeach
                    </select>
            </div>
        </div>
    </div>
</div>
