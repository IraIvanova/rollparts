@if($order->orderProducts)
<div class="brator-cart-area">
{{--    <div class="row">--}}
{{--        <div class="col-md-12 col-lg-8">--}}
            <div class="brator-cart-info ">
                <h6 class="mt-3">Order #{{$order->id}} - {{$order->created_at}}</h6>
                    <table
                        class="shop_table shop_table_responsive cart woocommerce-cart-form__contents brator-cart-list"
                        cellspacing="0">
                        <thead>
                        <tr>
                            <th class="product-name">Product</th>
                            <th class="product-price">Price</th>
                            <th class="product-quantity">Quantity</th>
                            <th class="product-subtotal">Subtotal</th>
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
                    <span>Subtotal</span>
                    <span data-title="Subtotal"><span class="woocommerce-Price-amount amount"><bdi><span
                                    class="woocommerce-Price-currencySymbol">$</span>{{$order->total_price}}</bdi></span>
                    </span>
                </p>
                <p class=" d-flex justify-content-between">
                    <span>Discount</span>
                    <span data-title="Subtotal"><span class="woocommerce-Price-amount amount"><bdi><span
                                    class="woocommerce-Price-currencySymbol">$</span>{{$order->total_price - $order->total_price_with_discount}}</bdi></span>
                    </span>
                </p>
                    @endif
                <p class="d-flex justify-content-between">
                    <span>Total</span>
                    <span data-title="Total"><strong>${{$order->total_price_with_discount}}</strong>
                    </span>
                </p>
                </div>
            </div>
{{--        </div>--}}
    </div>
{{--</div>--}}
@endif
