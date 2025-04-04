@if($order->orderProducts)
<div class="rp-cart-area">
{{--    <div class="row">--}}
{{--        <div class="col-md-12 col-lg-8">--}}
            <div class="rp-cart-info ">
                <h6 class="mt-3">{{ trans('interface.account.order') }} #{{$order->id}} - {{$order->created_at}}</h6>
                    <table
                        class="shop_table shop_table_responsive cart cart-form__contents rp-cart-list"
                        cellspacing="0">
                        <thead>
                        <tr>
                            <th class="product-name">{{ trans('interface.cart.item') }}</th>
                            <th class="product-price">{{ trans('interface.cart.price') }}</th>
                            <th class="product-quantity">{{ trans('interface.cart.qnt') }}</th>
                            <th class="product-subtotal">{{ trans('interface.cart.subtotal') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->orderProducts as $orderProduct)
                            @include('store.components.account.orderProduct', ['product' => $orderProduct])
                        @endforeach
                        </tbody>
                    </table>
                <div class="d-flex flex-column order-totals mt-2" >
                    @if($order->total_price_with_discount !== $order->total_price)
                <p class="cart-subtotal  d-flex justify-content-between">
                    <span>{{ trans('interface.checkout.total.subtotal') }}</span>
                    <span data-title="Subtotal"><span class="rp-Price-amount amount"><bdi><span
                                    class="rp-currencySymbol">{{ trans('interface.trLira') }}</span>{{$order->total_price}}</bdi></span>
                    </span>
                </p>
                <p class=" d-flex justify-content-between">
                    <span>{{ trans('interface.checkout.total.discount') }}</span>
                    <span data-title="Subtotal"><span class="rp-Price-amount amount"><bdi><span
                                    class="rp-currencySymbol">{{ trans('interface.trLira') }}</span>{{$order->total_price - $order->total_price_with_discount}}</bdi></span>
                    </span>
                </p>
                    @endif
                <p class="d-flex justify-content-between">
                    <span>{{ trans('interface.checkout.total.total') }}</span>
                    <span data-title="Total"><strong>{{ trans('interface.trLira') }}{{$order->total_price_with_discount}}</strong>
                    </span>
                </p>
                </div>
            </div>
{{--        </div>--}}
    </div>
{{--</div>--}}
@endif
