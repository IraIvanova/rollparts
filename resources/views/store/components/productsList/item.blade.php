<div
    class="brator-product-single-item-area design-two product type-product post-105 status-publish instock product_cat-custom-wheels product_cat-wheels-tires product_tag-rims product_tag-wheels has-post-thumbnail sale taxable shipping-taxable purchasable product-type-variable">
    @if($product['discount_amount'])
    <div class="brator-product-single-item-info info-content-left">
        <div class="brator-product-single-item-info-right">
            <div class="off-batch">{{$product['discount_amount']}}% Off</div>
        </div>
    </div>
    @endif
    <div class="brator-product-single-item-img">
        <a href="https://brator-main.smartdemowp.com/product/rfx2-brushed-titanium/">
            <img loading="lazy" width="225" height="225"
                 src="{{ asset(isset($images[0]) ? 'storage/' . $images[0]['file_path'] : 'images/default.png')}}"
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
            <p><span class="woocommerce-Price-amount amount"><span
                            class="woocommerce-Price-currencySymbol">$</span>{{$product['price']}}</span>
            </p>
        </div>

        <div class="brator-product-single-item-btn"><a
                href="https://brator-main.smartdemowp.com/product/rfx2-brushed-titanium/" data-quantity="1"
                class="button product_type_variable add_to_cart_button" data-product_id="105"
                data-product_sku="201902-0058" aria-label="" rel="nofollow">Select
                options</a></div>
    </div>

</div>

