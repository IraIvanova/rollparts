<div
    class="brator-product-single-item-area rollparts-design product type-product ">
    @if($product['discount_amount'])
    <div class="brator-product-single-item-info info-content-left">
        <div class="brator-product-single-item-info-right">
            <div class="off-batch">{{ trans('interface.product.discountAmount', ['amount' => $product['discount_amount']]) }}</div>
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
            <a href="{{route('catalog', ['brand' => $product['brand_slug']])}}" class="font-size-14px">{{$product['brand_name']}}</a>
        <div class="brator-product-single-item-cat">
            <a href="{{route('product', $product['slug'])}}">{{$product['name']}}</a>
        </div>

        <div class="brator-product-single-item-price">
            @if($product['discount_amount'])
                <p>
                <span class="rollparts-Price-amount amount color-red"><span
                        class="rollparts-currencySymbol">{{ trans('interface.trLira') }}</span>{{ $product['discounted_price'] }}</span>


                <span class="rollparts-Price-amount amount px-2 color-grey line-through font-size-20px"><span
                        class="rollparts-currencySymbol">{{ trans('interface.trLira') }}</span>{{ $product['price'] }}</span>
                </p>
            @else
                <span class="rollparts-Price-amount amount font-weight-bold"><span
                        class="rollparts-currencySymbol ">{{ trans('interface.trLira') }}</span>{{ $product['price'] }}</span>
            @endif
        </div>

        <div class="brator-product-single-item-btn">
            <button
                class="button add_to_cart_button" data-product="{{$product['id']}}">
                {{ trans('interface.buttons.addToCart') }}
            </button>
        </div>
    </div>

</div>

