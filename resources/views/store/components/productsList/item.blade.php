<div
    class="rp-product-single-item-area rp-design product type-product ">
    @if($product->priceByCurrency->discount_amount)
    <div class="rp-product-single-item-info info-content-left">
        <div class="rp-product-single-item-info-right">
            <div class="off-batch">{{ trans('interface.product.discountAmount', ['amount' => $product->priceByCurrency->discount_amount]) }}</div>
        </div>
    </div>
    @endif

    <div class="rp-product-single-item-img">
        <a href="{{route('product', $product->slug)}}">
            <img loading="lazy" width="225" height="225"
                 src="{{getMainImagePath($images, $product->id)}}" alt="{{$product->translationByLanguage->name}}"> </a>
    </div>
    <div class="rp-product-single-item-mini">
{{--            <a href="{{route('catalog', ['brand' => $product['brand_slug']])}}" class="font-size-14px">{{$product['brand_name']}}</a>--}}
        <div class="rp-product-single-item-cat">
            <a href="{{route('product', $product->slug)}}">{{$product->translationByLanguage->name}}</a>
        </div>

        <div class="rp-product-single-item-price">
            @if($product->priceByCurrency->discount_amount)
                <p>
                <span class="rp-Price-amount amount color-red"><span
                        class="rp-currencySymbol">{{ trans('interface.trLira') }}</span>{{ $product->priceByCurrency->discounted_price }}</span>


                <span class="rp-Price-amount amount px-2 color-grey line-through font-size-20px"><span
                        class="rp-currencySymbol">{{ trans('interface.trLira') }}</span>{{ $product->priceByCurrency->price }}</span>
                </p>
            @else
                <span class="rp-Price-amount amount font-weight-bold"><span
                        class="rp-currencySymbol ">{{ trans('interface.trLira') }}</span>{{ $product->priceByCurrency->price }}</span>
            @endif
        </div>

        <div class="rp-product-single-item-btn">
            <button
                class="button add_to_cart_button" data-product="{{$product->id}}">
                {{ trans('interface.buttons.addToCart') }}
            </button>
        </div>
    </div>

</div>

