<div
    class="rollparts-product-single-item-area rollparts-design product type-product ">
    @if($product->discount_amount)
    <div class="rollparts-product-single-item-info info-content-left">
        <div class="rollparts-product-single-item-info-right">
            <div class="off-batch">{{$product->discount_amount}}% Off</div>
        </div>
    </div>
    @endif

    <div class="rollparts-product-single-item-img">
        <a href="{{route('product', $product->slug)}}">
            <img loading="lazy" width="225" height="225"
                 src="{{getMainImagePath($images, $product->id)}}"
                 class=" "> </a>
    </div>
    <div class="rollparts-product-single-item-mini">
            <a href="{{route('catalog', ['brand' => $product->brand_slug])}}" class="font-size-14px">{{$product->brand_name}}</a>
        <div class="rollparts-product-single-item-cat">
            <a href="{{route('product', $product->slug)}}">{{$product->name}}</a>
        </div>

        <div class="rollparts-product-single-item-price">
            @if($product->discount_amount)
                <p>
                <span class="rollparts-Price-amount amount color-red"><span
                        class="rollparts-currencySymbol">$</span>{{ $product->discounted_price }}</span>


                <span class="rollparts-Price-amount amount px-2 color-grey line-through font-size-20px"><span
                        class="rollparts-currencySymbol">$</span>{{ $product->price }}</span>
                </p>
            @else
                <span class="rollparts-Price-amount amount font-weight-bold"><span
                        class="rollparts-currencySymbol ">$</span>{{ $product->price }}</span>
            @endif
        </div>

        <div class="rollparts-product-single-item-btn">
            <button
                class="button add_to_cart_button" data-product="{{$product->id}}">
                Add to cart
            </button>
        </div>
    </div>

</div>

