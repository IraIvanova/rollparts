@extends('store.base')

@section('bodyContent')
    <section id="main-content" >

        <div class="grey-bg">
            <div class="container container-xxxl">
        @include('store.components.breadcrumbs')
        <div id="product-108"
             class="product type-product post-108 status-publish first instock product_cat-air-filters product_cat-sanex product_cat-tires-chains product_tag-mercedes product_tag-rims product_tag-tires has-post-thumbnail sale taxable shipping-taxable purchasable product-type-simple">

            <div class="brator-product-header-layout-area desing-one">
                <div class="container-xxxl container-xxl container">
                    <div class="row">
                        <div class="brator-product-header-layout w-100">
                            <div class="brator-product-header-layout-img">
                                @include('store.components.imagesGallery')
                            </div>
                            <div class="brator-product-layout-header-content">
                                <div class="brator-product-hero-content">
                                    <div class="brator-product-hero-content-info">
                                        <div class="brator-product-hero-content-brand">
                                            <a href=""
                                               rel="tag">{{$brand['name']}}</a></div>
                                        <div class="brator-product-hero-content-title">
                                            <h1>{{ $name }}</h1>
                                        </div>
                                        @if($prices['discount_amount'])
                                            <div class="brator-product-hero-content-review">
                                                <div
                                                    class="product-batch off-batch">{{$prices['discount_amount']}}
                                                    % Off
                                                </div>
                                            </div>
                                        @endif
                                        <div class="brator-product-hero-content-price">
                                            <h6>
                                                @if((float)$prices['discount_amount'])
                                                        <span class="woocommerce-Price-amount amount color-red"><span
                                                                        class="woocommerce-Price-currencySymbol">$</span>{{ $prices['discounted_price'] }}</span>
                                                      <span class="woocommerce-Price-amount amount px-2 color-grey line-through font-size-20px"><span
                                                                        class="woocommerce-Price-currencySymbol">$</span>{{ $prices['price'] }}</span>
                                                @else
                                                    <span class="woocommerce-Price-amount amount"><span
                                                            class="woocommerce-Price-currencySymbol">$</span>{{ $prices['price'] }}</span>
                                                @endif
                                            </h6>
                                        </div>
                                        <div>
                                            <h6 class="font-size-14px my-2 pb-2 border-bottom">
                                                @if($active)
                                                    <span class="status-circle active-status"></span>
                                                    <span class="stock pl-3">{{ $quantity }} pcs in stock</span>
                                                @else
                                                    <span class="status-circle passive-status"></span>
                                                    <span class="pl-3">Out of stock</span>
                                                @endif
                                            </h6>
                                        </div>

                                        <div class="">
                                            <p>Manufacturer code: <b>{{ $mnfCode }}</b></p>
                                        </div>
                                    </div>
                                    <div class="brator-product-hero-content-add-to-cart border-bottom">

                                            <div class="brator-product-single-cart-count-add">
                                                <div class="quantity brator-product-single-cart-count">

                                                    <div
                                                        class="item-quantity tt-input-counter js-counter brator-brator-cart-list-items-qty">
                                                        <span class="minus-btn amount-btn">–</span>
                                                        <input type="number" id="quantity"
                                                               class="input-text qty text" name="quantity" value="1"
                                                               aria-label="Product quantity" size="4" min="1" max="1000"
                                                               step="1" placeholder="" inputmode="numeric"
                                                               autocomplete="off">
                                                        <span class="plus-btn amount-btn">+</span>
                                                    </div>
                                                </div>
                                                <div class="brator-product-single-cart-add">
                                                    <input type="hidden" value="{{route('addToCart')}}" id="add-route" />

                                                    <button type="button" name="add-to-cart" id="addToCart"
                                                            class="button add_to_cart_button alt" data-product="{{$id}}">Add
                                                        to cart
                                                    </button>
                                                </div>
                                            </div>

                                    </div>

                                    <div class="brator-product-single-light-info-area">
                                        <div class="brator-product-single-light-info">
                                            <div class="brator-product-single-light-info-s">
                                                <h5>Tags:</h5>
                                                <a href="https://brator-main.smartdemowp.com/product-tag/mercedes/">mercedes</a><a
                                                    href="https://brator-main.smartdemowp.com/product-tag/rims/">rims</a><a
                                                    href="https://brator-main.smartdemowp.com/product-tag/tires/">tires</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>
            <div class="brator-product-single-tab-area design-one-m">
                <div class="container-xxxl container-xxl container">
                    <div class="row">
                        <div class="col-xxl-8 col-md-12">
                            <div class="brator-product-single-tab-list js-tabs " id="tabs-product-content">
                                <div class="brator-product-single-tab-header js-tabs__header">
                                    <ul>
                                        <li><a class="js-tabs__title js-tabs__title-active" href="#" data-index="0">Description</a>
                                        </li>
                                        <li><a class="js-tabs__title" href="#" data-index="1">Additional information</a>
                                        </li>
                                        <li><a class="js-tabs__title" href="#" data-index="2">Reviews (1)</a></li>
                                    </ul>
                                </div>
                                <div class="js-tabs__content brator-product-single-tab-item" style="">

                                    <div class="product-description mb-3">
                                        {!! $description !!}
                                    </div>
                                </div>
                                <div class="js-tabs__content brator-product-single-tab-item" style="display: none;">
                                    <table class="woocommerce-product-attributes shop_attributes">
                                        <tbody>
                                        <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--weight">
                                            <th class="woocommerce-product-attributes-item__label">Weight</th>
                                            <td class="woocommerce-product-attributes-item__value">0.2 kg</td>
                                        </tr>
                                        <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--dimensions">
                                            <th class="woocommerce-product-attributes-item__label">Dimensions</th>
                                            <td class="woocommerce-product-attributes-item__value">4 × 5 × 0.5 cm</td>
                                        </tr>
                                        <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--attribute_pa_select-color">
                                            <th class="woocommerce-product-attributes-item__label">Color</th>
                                            <td class="woocommerce-product-attributes-item__value"><p>Red</p>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="js-tabs__content brator-product-single-tab-item" style="display: none;">
                                    <div id="reviews" class="woocommerce-Reviews brator-review-comment-area">
                                        <div class="brator-review-comment">
                                            <div class="brator-review-comment-count">
                                                <div class="brator-review">
                                                    <div class="star-rating" role="img"
                                                         aria-label="Rated 5.00 out of 5"><span style="width:100%">Rated <strong
                                                                class="rating">5.00</strong> out of 5</span></div>
                                                </div>
                                                <div class="brator-review-text">
                                                    <p>1 Review</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="comments" class="brator-review-comment-list">
                                            <div class="customer-comment">
                                                <div class="comment" id="comment-44">
                                                    <div class="brator-review-comment-single-item">
                                                        <div class="brator-review-comment-single-img">
                                                            <img alt=""
                                                                 src="https://secure.gravatar.com/avatar/763af4bb16fa4731d816aac188239aa2?s=70&amp;d=mm&amp;r=g"
                                                                 srcset="https://secure.gravatar.com/avatar/763af4bb16fa4731d816aac188239aa2?s=140&amp;d=mm&amp;r=g 2x"
                                                                 class="avatar avatar-70 photo" height="70" width="70"
                                                                 decoding="async"></div>
                                                        <div class="brator-review-comment-single-content">
                                                            <div class="brator-review">
                                                                <div class="star-rating" role="img"
                                                                     aria-label="Rated 5 out of 5"><span
                                                                        style="width:100%">Rated <strong class="rating">5</strong> out of 5</span>
                                                                </div>
                                                            </div>
                                                            <div class="brator-review-comment-single-title">
                                                                <h6>Quality Product &amp; Very Comfortable!</h6>
                                                                <p>Location,fantastic. Accommodation, fantastic. Host,
                                                                    fantastic. If you have a chance to book this
                                                                    beautiful cottage do not hesitate. You will be glad
                                                                    you did. Thank you alison for a great stay and we
                                                                    will definitely be returning.</p>
                                                            </div>
                                                            <div class="brator-review-comment-date">
                                                                <h6><a href="http://wp.brator.xyz" class="url"
                                                                       rel="ugc external nofollow">admin</a>on Nov 25,
                                                                    2021 </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- #comment-## -->
                                            </div>

                                        </div>

                                        <div id="review_form_wrapper" class="replay-inner">
                                            <div id="review_form" class="replay-form">
                                                <div id="respond" class="comment-respond">
                                                    <h5 class="tt-form__title">Customer Reviews <small><a rel="nofollow"
                                                                                                          id="cancel-comment-reply-link"
                                                                                                          href="/product/brand-name-cv10-satin-black-with-chrome/#respond"
                                                                                                          style="display:none;">Cancel
                                                                reply</a></small></h5>
                                                    <p class="must-log-in">You must be <a
                                                            href="https://brator-main.smartdemowp.com/my-account/">logged
                                                            in</a> to post a review.</p></div><!-- #respond -->
                                            </div>
                                        </div>

                                        <div class="clear"></div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection

@section('additionalScript')
    <script src="{{ asset('js/store/slick.min.js') }}"></script>
    <script src="{{ asset('js/store/fslightbox.js') }}"></script>
<script src="{{asset('js/store/product.js')}}"></script>
@endsection
