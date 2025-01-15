@if($order->orderProducts)
<div class="brator-cart-area">
    <div class="row">
        <div class="col-xl-8 col-lg-12">
            <div class="brator-cart-info">
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
                <div>
                <p class="cart-subtotal">
                    <th>Subtotal</th>
                    <td data-title="Subtotal"><span class="woocommerce-Price-amount amount"><bdi><span
                                    class="woocommerce-Price-currencySymbol">$</span>{{$order->total_price}}</bdi></span>
                    </td>
                </p>
                <p class="">
                    <th>Discount</th>
                    <td data-title="Subtotal"><span class="woocommerce-Price-amount amount"><bdi><span
                                    class="woocommerce-Price-currencySymbol">$</span>{{$order->total_price - $order->total_price_with_discount}}</bdi></span>
                    </td>
                </p>
                <p class="order-total">
                    <th>Total</th>
                    <td data-title="Total"><strong><span
                                class="woocommerce-Price-amount amount"><bdi><span
                                        class="woocommerce-Price-currencySymbol">$</span>{{$order->total_price_with_discount}}</bdi></span></strong>
                    </td>
                </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
