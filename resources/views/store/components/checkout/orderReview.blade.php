<div id="order_review">
    <div class="payment_list_item">
        <div class="price_single_cost">
            @foreach($products as $product)
                <h5 class="cart_item">
                    <span class="rp-checkout-order-name">{{$product['name']}}</span>
                    <strong class="product-quantity">× {{$product['amount']}}</strong>
                {!! price_display($product['discountedPrice'], $product['price'], 'checkout', $isBankTransfer ? 5 : 0 ) !!}
            @endforeach
        </div>
    <div>
</div>

<div class="payment_list_item">
    <div class="count_part cart-subtotal">
            @if($couponDiscount)
                <h5>{{ trans('interface.checkout.total.appliedCoupon') }}<span class="rp-checkout-order-price">
                        <span class="rp-Price-amount amount">
                            <span class="rp-currencySymbol">{{ trans('interface.trLira') }}</span>{{$couponDiscount}}</span></span>
                </h5>
            @endif
            @if($totalPrice !== $totalWithDiscount)
                <h5>{{ trans('interface.checkout.total.totalDiscount') }} <span class="rp-checkout-order-price">
                        <span class="rp-Price-amount amount">{{ trans('interface.trLira') }}{{$totalPrice - $totalWithDiscount }}</span></span>
                </h5>
            @endif
            <h5>{{ trans('interface.checkout.shippingPrice') }} <span class="rp-checkout-order-price">
                    <span class="rp-Price-amount amount">{{$shippingPrice > 0 ? trans('interface.trLira') . $shippingPrice : 'FREE'}}</span></span>
            </h5>
        </div>
    </div>
    <div class="payment_list_item">
        <div class="total_count order-total">
            <h4>{{ trans('interface.checkout.total.total') }} <span class="rp-checkout-order-price"><strong><span
                            class="rp-Price-amount amount"><bdi><span
                                    class="rp-currencySymbol">{{ trans('interface.trLira') }}</span>{{$totalWithDiscount + $shippingPrice}}</bdi></span></strong> </span>
            </h4>
        </div>
    </div>
</div>
</div>
