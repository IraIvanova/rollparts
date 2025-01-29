<tr class="woocommerce-cart-form__cart-item brator-cart-list-items cart_item">
    <td class="brator-cart-list-items-title">
        <div class="img-cart">
            <a href="">

                <img decoding="async" width="85" height="85" src="{{ $product->product->getFirstMediaUrl() ?: asset('images/default.png') }}"
                     class="attachment-brator-cart-img-size size-brator-cart-img-size"
                     alt="" srcset=""></a>
        </div>
        <div class="prodct-info">
            <h5>
                <a href="{{route('product', $product->product->slug)}}">{{$product->product->translationByLanguage->name}}</a></h5>
        </div>
    </td>
    <td class="product-price" data-title="Price">
        <span class="sm-title">Price:</span>
        @if($product->discounted_price !== $product->price)
            <p>
                <span class="rollparts-Price-amount amount color-red"><span
                        class="rollparts-currencySymbol">{{ trans('interface.trLira') }}</span>{{ $product->discounted_price }}</span>


                <span class="rollparts-Price-amount amount px-2 color-grey line-through"><span
                        class="rollparts-currencySymbol">{{ trans('interface.trLira') }}</span>{{ $product->price }}</span>
            </p>
        @else
            <span class="rollparts-Price-amount amount"><span
                    class="rollparts-currencySymbol">{{ trans('interface.trLira') }}</span>{{ $product->price }}</span>
        @endif
    </td>
    <td class="product-quantity" data-title="Quantity">
        <span class="sm-title">Amount:</span>
        <div class="quantity rollparts-product-single-cart-count">
              {{ $product->amount }}
        </div>
    </td>
    <td class="product-subtotal" data-title="Subtotal">
        <span class="sm-title">Total:</span>
        <p>
                <b class="rollparts-Price-amount amount"><span
                        class="rollparts-currencySymbol">{{ trans('interface.trLira') }}</span>{{ ($product->discounted_price ?: $product->price) * $product->amount }}</b>
        </p>
    </td>
</tr>
