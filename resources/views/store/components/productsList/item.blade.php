<div
    class="brator-product-single-item-area design-two product type-product ">
    @if($product['discount_amount'])
    <div class="brator-product-single-item-info info-content-left">
        <div class="brator-product-single-item-info-right">
            <div class="off-batch">{{$product['discount_amount']}}% Off</div>
        </div>
    </div>
    @endif

    <div class="brator-product-single-item-img">
        <a href="{{route('product', $product['slug'])}}">
            <img loading="lazy" width="225" height="225"
                 src="{{getMainImagePath($images, $product['id'])}}"
                 class="attachment-shop_catalog size-shop_catalog wp-post-image"> </a>
    </div>
    <div class="brator-product-single-item-mini">
        <div class="brator-product-single-item-cat">
            <a href="{{route('product', $product['slug'])}}">{{$product['name']}}</a>
        </div>
        <div class="brator-product-single-item-title">
            <h5><a href=""></a>
            </h5>
        </div>

        <div class="brator-product-single-item-price">
            @if($product['discount_amount'])
                <p>
                <span class="woocommerce-Price-amount amount color-red"><span
                        class="woocommerce-Price-currencySymbol">$</span>{{ $product['discounted_price'] }}</span>


                <span class="woocommerce-Price-amount amount px-2 color-grey line-through font-size-20px"><span
                        class="woocommerce-Price-currencySymbol">$</span>{{ $product['price'] }}</span>
                </p>
            @else
                <span class="woocommerce-Price-amount amount"><span
                        class="woocommerce-Price-currencySymbol">$</span>{{ $product['price'] }}</span>
            @endif
        </div>

        <div class="brator-product-single-item-btn">
            <button
                class="button add_to_cart_button" data-product="{{$product['id']}}">
                Add to cart
            </button>
        </div>
    </div>

</div>

