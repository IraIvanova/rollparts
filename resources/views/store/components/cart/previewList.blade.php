@if($shoppingCart['totalItems'] === 0)
    <p>{{ trans('interface.cart.noItems') }}</p>
@else
    <ul class="sp-mini-cart cart_list sp_product_list ">
        @foreach($shoppingCart['products'] as $product)
            <li class="single-item mini_cart_item">
                <div class="rollparts-cart-item-list-item">
                    <div class="rollparts-cart-item-list-item-img">
                        <a href="{{route('product', $product['slug'])}}">
                            <img width="85" height="85"
                                 src="{{ $product['image'] }}"
                                 class=" " alt=""
                            > </a>
                    </div>
                    <div class="rollparts-cart-item-list-item-title">
                        <div class="rollparts-cart-item-list-item-title-one">
                            <a href="{{ route('product', $product['slug']) }}">
                                <h2>{{$product['name']}}</h2></a>
                            <div class="price-pdo">
                                <h6>
                                                <span class="quantity">{{$product['amount']}} × <span
                                                        class="rollparts-Price-amount amount"><bdi><span
                                                                class="rollparts-currencySymbol">{{ trans('interface.trLira') }}</span>{{min($product['price'], $product['discountedPrice'])}}</bdi></span></span>
                                </h6>
                            </div>
                        </div>

                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    <div class="rollparts-cart-total-money">
        <div class=" total rollparts-cart-total-header">
            <strong>{{ trans('interface.cart.subtotal') }}:</strong> <span class="rollparts-Price-amount amount"><bdi><span
                        class="rollparts-currencySymbol">{{ trans('interface.trLira') }}</span>{{min($shoppingCart['totalWithDiscount'], $shoppingCart['totalPrice'])}}</bdi></span>
        </div>
        <div class=" rollparts-cart-total-action">
            <a href="{{route('cart')}}" class="button primary-rp-button">{{ trans('interface.buttons.viewCart') }}</a><a href="{{route('checkout')}}"
                           class="button checkout primary-rp-button">{{ trans('interface.buttons.checkout') }}</a></div>
    </div>
@endif
