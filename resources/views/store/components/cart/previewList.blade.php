@if($shoppingCart['totalItems'] === 0)
    <p class="woocommerce-mini-cart__empty-message">{{ trans('interface.cart.noItems') }}</p>
@else
    <ul class="woocommerce-mini-cart cart_list product_list_widget ">
        @foreach($shoppingCart['products'] as $product)
            <li class="single-item woocommerce-mini-cart-item mini_cart_item">
                <div class="brator-cart-item-list-item">
                    <div class="brator-cart-item-list-item-img">
                        <a href="{{route('product', $product['slug'])}}">
                            <img width="85" height="85"
                                 src="{{ $product['image'] }}"
                                 class="attachment-brator-cart-img-size size-brator-cart-img-size" alt=""
                            > </a>
                    </div>
                    <div class="brator-cart-item-list-item-title">
                        <div class="brator-cart-item-list-item-title-one">
                            <a href="{{ route('product', $product['slug']) }}">
                                <h2>{{$product['name']}}</h2></a>
                            <div class="price-pdo">
                                <h6>
                                                <span class="quantity">{{$product['amount']}} × <span
                                                        class="woocommerce-Price-amount amount"><bdi><span
                                                                class="woocommerce-Price-currencySymbol">{{ trans('interface.trLira') }}</span>{{min($product['price'], $product['discountedPrice'])}}</bdi></span></span>
                                </h6>
                            </div>
                        </div>

                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    <div class="brator-cart-total-money">
        <div class="woocommerce-mini-cart__total total brator-cart-total-header">
            <strong>{{ trans('interface.cart.subtotal') }}:</strong> <span class="woocommerce-Price-amount amount"><bdi><span
                        class="woocommerce-Price-currencySymbol">{{ trans('interface.trLira') }}</span>{{min($shoppingCart['totalWithDiscount'], $shoppingCart['totalPrice'])}}</bdi></span>
        </div>
        <div class="woocommerce-mini-cart__buttons brator-cart-total-action">
            <a href="{{route('cart')}}" class="button wc-forward">{{ trans('interface.buttons.viewCart') }}</a><a href="{{route('checkout')}}"
                           class="button checkout wc-forward">{{ trans('interface.buttons.checkout') }}</a></div>
    </div>
@endif
