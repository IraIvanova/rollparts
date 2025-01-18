<div class="p-2">
@if($products->total() === 0)
    <p class="woocommerce-mini-cart__empty-message">{{ trans('interface.cart.noItems') }}</p>
@else
    <ul class="woocommerce-mini-cart cart_list product_list_widget ">
        @foreach($products as $product)
            <li class="single-item woocommerce-mini-cart-item mini_cart_item">
                <div class="brator-cart-item-list-item d-flex align-items-center">
                    <div class="brator-cart-item-list-item-img img-block">
                        <a href="{{route('product', $product['slug'])}}">
                            <img width="85" height="85"
                                 src="{{ $productImages[$product['id']] ?? asset('images/default.png')}}"
                                 class="attachment-brator-cart-img-size size-brator-cart-img-size" alt=""
                            > </a>
                    </div>
                    <div class="brator-cart-item-list-item-title">
                        <div class="brator-cart-item-list-item-title-one">
                            <a href="{{ route('product', $product['slug']) }}">
                                <p>{{$product['name']}}</p></a>
                        </div>

                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    <div id="searchResults" class="text-right">
        <a href="{{ route('catalog', ['search' => $search]) }}">{{ trans('interface.search.catalogLink') }} >>></a>
    </div>
@endif
</div>
