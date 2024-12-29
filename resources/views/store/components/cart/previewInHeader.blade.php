<div class="brator-cart-link">
    <a href="javascript:void(0)">
        <div class="brator-cart-icon click-item-count" id="cart-icon">
            <svg fill="#000000" width="52" height="52" version="1.1"
                 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                 x="0px" y="0px" viewBox="0 0 64 64">
                <g>
                    <path
                        d="M40.9,48.2c-3.9,0-7.1,3.3-7.1,7.3c0,4,3.2,7.3,7.1,7.3s7.1-3.3,7.1-7.3C48.1,51.5,44.9,48.2,40.9,48.2z M40.9,59.3c-2,0-3.6-1.7-3.6-3.8c0-2.1,1.6-3.8,3.6-3.8s3.6,1.7,3.6,3.8C44.6,57.6,42.9,59.3,40.9,59.3z"></path>
                    <path
                        d="M18.2,48.2c-3.9,0-7.1,3.3-7.1,7.3c0,4,3.2,7.3,7.1,7.3s7.1-3.3,7.1-7.3C25.4,51.5,22.2,48.2,18.2,48.2z M18.2,59.3c-2,0-3.6-1.7-3.6-3.8c0-2.1,1.6-3.8,3.6-3.8s3.6,1.7,3.6,3.8C21.9,57.6,20.2,59.3,18.2,59.3z"></path>
                    <path
                        d="M57.8,1.3h-6.4c-1.5,0-2.8,1.1-3,2.6l-1.8,13.2H7.3c-0.9,0-1.7,0.4-2.2,1.1c-0.5,0.7-0.7,1.6-0.5,2.4c0,0,0,0.1,0,0.1l6.1,18.9c0.3,1.2,1.4,2.1,2.8,2.1h29.5c2.2,0,4-1.6,4.3-3.8l4.6-33.2h6c1,0,1.8-0.8,1.8-1.8S58.8,1.3,57.8,1.3z M43.7,37.4 c-0.1,0.4-0.4,0.8-0.9,0.8h-29L8.1,20.6h37.9L43.7,37.4z"></path>
                </g>
            </svg>
            <span class="header-cart-count">{{$shoppingCart['totalItems']}}</span>
        </div>
        <b class="header-cart-total"><span class="woocommerce-Price-amount amount"><bdi><span
                        class="woocommerce-Price-currencySymbol">$</span>{{min($shoppingCart['totalWithDiscount'], $shoppingCart['totalPrice'])}}</bdi></span></b>

    </a>
    <div class="brator-cart-item-list" id="cart-preview">
        <div class="brator-cart-item-list-header">
            <h2>Cart <span class="header-cart-count2">({{$shoppingCart['totalItems']}} items)</span>
            </h2>
            <button class="brator-cart-close">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                     fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                </svg>
            </button>
        </div>
        <div class="widget_shopping_cart_content">
            @if($shoppingCart['totalItems'] === 0)
                <p class="woocommerce-mini-cart__empty-message">No products in the cart.</p>
            @else
                <ul class="woocommerce-mini-cart cart_list product_list_widget ">
                    @foreach($shoppingCart['products'] as $product)
                        <li class="single-item woocommerce-mini-cart-item mini_cart_item">
                            <div class="brator-cart-item-list-item">
                                <div class="brator-cart-item-list-item-img">
                                    <a href="{{route('product', $product['slug'])}}">
                                        <img width="85" height="85"
                                             src="{{ asset(isset($product['image']) ? 'storage' . $product['image'] : 'images/default.png' )}}"
                                             class="attachment-brator-cart-img-size size-brator-cart-img-size" alt=""
                                        > </a>
                                </div>
                                <div class="brator-cart-item-list-item-title">
                                    <div class="brator-cart-item-list-item-title-one">
                                        <a href="https://brator-main.smartdemowp.com/product/brand-name-cv10-satin-black-with-chrome/">
                                            <h2>{{$product['name']}}</h2></a>
                                        <div class="price-pdo">
                                            <h6>
                                                <span class="quantity">{{$product['amount']}} × <span
                                                        class="woocommerce-Price-amount amount"><bdi><span
                                                                class="woocommerce-Price-currencySymbol">$</span>{{min($product['price'], $product['discountedPrice'])}}</bdi></span></span>
                                            </h6>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="brator-cart-total-money">
                    <div class="woocommerce-mini-cart__total total brator-cart-total-header">
                        <strong>Subtotal:</strong> <span class="woocommerce-Price-amount amount"><bdi><span
                                    class="woocommerce-Price-currencySymbol">$</span>{{min($shoppingCart['totalWithDiscount'], $shoppingCart['totalPrice'])}}</bdi></span>
                    </div>
                    <div class="woocommerce-mini-cart__buttons brator-cart-total-action">
                        <a href="{{route('cart')}}" class="button wc-forward">View
                            cart</a><a href="{{route('checkout')}}"
                                       class="button checkout wc-forward">Checkout</a></div>
                </div>
            @endif
        </div>
    </div>
</div>
