@extends('store.base')

@section('bodyContent')
    <section id="main-content" class="container container-xxxl py-5">
        <div>
            @include('store.components.breadcrumbs')
            <div class="">
                <div class="woocommerce-notices-wrapper"></div>
                <div class="brator-cart-header-area">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Shopping Cart</h3>
                        </div>
                    </div>
                </div>
                <div class="brator-cart-area">
                    <div class="row">
                        <div class="col-xl-8 col-lg-12">
                            <div class="brator-cart-info">
                                <div class="brator-cart-h">
                                    <h3>Your Cart</h3>
                                </div>
                                <form class="woocommerce-cart-form" action="" method="post">
                                    <table
                                        class="shop_table shop_table_responsive cart woocommerce-cart-form__contents brator-cart-list"
                                        cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th class="product-name">Product</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-quantity">Quantity</th>
                                            <th class="product-subtotal">Subtotal</th>
                                            <th class="product-remove"><span
                                                    class="screen-reader-text">Remove item</span></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($products as $product)
                                            @include('store.components.cart.item')
                                        @endforeach
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-7 col-12">
                            <div class="cart-collaterals cart-total-area">
                                <div class="cart_totals ">

                                    <div class="cart-total-header">
                                        <h2>Order Summary <span class="header-cart-count2">(1 item)</span>
                                        </h2>
                                    </div>

                                    <h2>Cart totals</h2>

                                    <table cellspacing="0" class="shop_table shop_table_responsive">

                                        <tbody>
                                        <tr class="cart-subtotal">
                                            <th>Subtotal</th>
                                            <td data-title="Subtotal"><span class="woocommerce-Price-amount amount"><bdi><span
                                                            class="woocommerce-Price-currencySymbol">$</span>18.00</bdi></span>
                                            </td>
                                        </tr>
                                        <tr class="order-total">
                                            <th>Total</th>
                                            <td data-title="Total"><strong><span
                                                        class="woocommerce-Price-amount amount"><bdi><span
                                                                class="woocommerce-Price-currencySymbol">$</span>18.00</bdi></span></strong>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <div class="wc-proceed-to-checkout">
                                        <div class="cart-total-process">
                                            <a href="https://brator-main.smartdemowp.com/checkout/" class="wc-forward">
                                                Proceed To Checkout </a>
                                        </div>
                                    </div>

                                    <div class="cart-total-accpect-payment">
                                        <p>Accept Payment Methods</p>
                                        <img decoding="async"
                                             src="https://brator-main.smartdemowp.com/wp-content/themes/brator/assets/images//payment-cart.png"
                                             alt="Payment Gateway">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
