<div class="p-2">
@if(count($products) === 0)
    <p>{{ trans('interface.cart.noItems') }}</p>
@else
    <ul class="sp-mini-cart cart_list sp_product_list ">
        @foreach($products as $product)
            <li class="single-item  mini_cart_item">
                <div class="rp-cart-item-list-item d-flex align-items-center">
                    <div class="rp-cart-item-list-item-img img-block">
                        <a href="{{route('product', $product['slug'])}}">
                            <img width="85" height="85"
                                 src="{{ $productImages[$product['id']] ?? asset('images/default.png')}}"
                                 class=" " alt=""
                            > </a>
                    </div>
                    <div class="rp-cart-item-list-item-title">
                        <div class="rp-cart-item-list-item-title-one">
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
