<tr class="woocommerce-cart-form__cart-item brator-cart-list-items cart_item">
    <td class="brator-cart-list-items-title">
        <div class="img-cart">
            <a href="">
                <img decoding="async" width="85" height="85" src=""
                     class="attachment-brator-cart-img-size size-brator-cart-img-size"
                     alt="" srcset=""></a>
        </div>
        <div class="prodct-info">
            <h5>
                <a href="{{route('product', $product['slug'])}}">{{$product['name']}}</a></h5>
            <a href="https://brator-main.smartdemowp.com/product/brand-name-cv10-satin-black-with-chrome/">Edit</a>
        </div>
    </td>
    <td class="product-price" data-title="Price">
        @if($product['discountedPrice'])
            <p>
                <span class="woocommerce-Price-amount amount color-red"><span
                        class="woocommerce-Price-currencySymbol">$</span>{{ $product['discountedPrice'] }}</span>


                <span class="woocommerce-Price-amount amount px-2 color-grey line-through"><span
                        class="woocommerce-Price-currencySymbol">$</span>{{ $product['price'] }}</span>
            </p>
        @else
            <span class="woocommerce-Price-amount amount"><span
                    class="woocommerce-Price-currencySymbol">$</span>{{ $product['price'] }}</span>
        @endif
    </td>
    <td class="product-quantity" data-title="Quantity">
        <div class="quantity brator-product-single-cart-count">

            <div
                class="item-quantity tt-input-counter js-counter brator-brator-cart-list-items-qty" data-product="{{$product['id']}}">
                <span class="minus-btn amount-btn">–</span>
                <input type="number"
                       class="input-text qty text"
                       name="amount"
                       value="{{$product['amount']}}" size="4"
                       min="1" step="1" placeholder=""
                       inputmode="numeric" autocomplete="off">
                <span class="plus-btn amount-btn">+</span>
            </div>
        </div>
    </td>
    <td class="product-subtotal" data-title="Subtotal">
            <p>
                <span class="woocommerce-Price-amount amount"><span
                        class="woocommerce-Price-currencySymbol">$</span>{{ ($product['discountedPrice'] ?: $product['price']) * $product['amount'] }}</span>
            </p>
    </td>
    <td class="product-remove brator-cart-list-items-removed" data-product="{{$product['id']}}">
        <button type="button"
           class="remove amount-btn remove-full">
            <svg class="bi bi-x" xmlns="http://www.w3.org/2000/svg"
                 width="16" height="16" fill="currentColor"
                 viewBox="0 0 16 16">
                <path
                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
            </svg>
        </button></td>
</tr>