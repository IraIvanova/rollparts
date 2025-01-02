<div id="order_review" class="woocommerce-checkout-review-order">
    <div class="payment_list_item">
        <div class="price_single_cost">
            @foreach($products as $product)
                <h5 class="cart_item">
                                            <span
                                                class="brator-checkout-order-name">{{$product['name']}}</span>

                    <strong class="product-quantity">× {{$product['amount']}}</strong>

                    @if($product['discountedPrice'])
                        <span class="brator-checkout-order-price product-total">
                        <span class="woocommerce-Price-amount amount px-2 color-grey line-through"><span
                                class="woocommerce-Price-currencySymbol">$</span>{{ $product['price'] }}</span>
                        <span
                            class="woocommerce-Price-amount amount"><span
                                    class="woocommerce-Price-currencySymbol">$</span>{{ $product['discountedPrice'] }}</span>
                        </span>



                    @else
                        <span class="brator-checkout-order-price product-total"><span
                                class="woocommerce-Price-amount amount"><span
                                    class="woocommerce-Price-currencySymbol">$</span>{{ $product['price'] }}</span></span>
                    @endif

                </h5>
            @endforeach
        </div>
        <div>
        </div>
    </div>
    <div class="payment_list_item">
        <div class="count_part cart-subtotal">
            <h5>Discount <span class="brator-checkout-order-price"><span
                        class="woocommerce-Price-amount amount"><bdi><span
                                class="woocommerce-Price-currencySymbol">$</span>{{$totalPrice - $totalWithDiscount}}</bdi></span></span>
            </h5>
        </div>
    </div>


    <div class="payment_list_item">
        <div class="count_part">
        </div>
    </div>
    <div class="payment_list_item">
        <div class="total_count order-total">
            <h4>Total <span class="brator-checkout-order-price"><strong><span
                            class="woocommerce-Price-amount amount"><bdi><span
                                    class="woocommerce-Price-currencySymbol">$</span>{{$totalWithDiscount}}</bdi></span></strong> </span>
            </h4>
        </div>
    </div>
</div>
