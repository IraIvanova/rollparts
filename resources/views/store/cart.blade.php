@extends('store.base')

@section('metaTitle'){{ trans('interface.meta.title.cart') }}@endsection
@section('metaDescription'){{ trans('interface.meta.description.cart') }}@endsection

@section('bodyContent')
    <section id="main-content" class="container container-xxxl py-5">
        <div>
            <input type="hidden" value="{{route('removeFromCart')}}" id="remove-route"/>
            <input type="hidden" value="{{route('addToCart')}}" id="add-route"/>
            <div class="">
                <div class="rp-cart-header-area">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>{{ trans('interface.cart.shoppingCart') }}</h3>
                        </div>
                    </div>
                </div>
                @if(count($products) > 0)
                    <div class="">
                        <div class="row">
                            <div class="col-xl-8 col-lg-12">
                                <div class="rp-cart-info">

                                    <form class="cart-form" action="" method="post">
                                        <table
                                            class="shop_table cart rp-cart-list">
                                            <thead>
                                            <tr>
                                                <th class="product-name">{{ trans('interface.cart.item') }}</th>
                                                <th class="product-price">{{ trans('interface.cart.price') }}</th>
                                                <th class="product-quantity">{{ trans('interface.cart.qnt') }}</th>
                                                <th class="product-subtotal">{{ trans('interface.cart.subtotal') }}</th>
                                                <th class="product-remove"><span
                                                        class="screen-reader-text">{{ trans('interface.cart.removeItem') }}</span></th>
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
                                <div class="cart-total-area">
                                    <div class="cart_totals ">

                                        <div class="cart-total-header">
                                            <h2><span>{{ trans('interface.cart.summary') }}</span>
                                            </h2>
                                        </div>

                                        <h2>{{ trans('interface.cart.cartTotals') }}</h2>
                                        <table class="shop_table">

                                            <tbody>
                                            <tr class="cart-subtotal">
                                                <th>{{ trans('interface.checkout.total.subtotal') }}</th>
                                                <td data-title="Subtotal"><span class="rp-Price-amount amount"><bdi><span
                                                                class="rp-currencySymbol">{{ trans('interface.trLira') }}</span>{{$totalPrice}}</bdi></span>
                                                </td>
                                            </tr>
                                            <tr class="">
                                                <th>{{ trans('interface.checkout.total.discount') }}</th>
                                                <td data-title="Subtotal"><span class="rp-Price-amount amount"><bdi><span
                                                                class="rp-currencySymbol">{{ trans('interface.trLira') }}</span>{{$totalPrice - $totalWithDiscount}}</bdi></span>
                                                </td>
                                            </tr>
                                            <tr class="order-total">
                                                <th>{{ trans('interface.checkout.total.total') }}</th>
                                                <td data-title="Total"><strong><span
                                                            class="rp-Price-amount amount"><bdi><span
                                                                    class="rp-currencySymbol">{{ trans('interface.trLira') }}</span>{{$totalWithDiscount}}</bdi></span></strong>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <div class="proceed-to-checkout">
                                            <div class="cart-total-process">
                                                <a href="{{route('checkout')}}" class="primary-rp-button">
                                                    {{ trans('interface.cart.proceedToCheckout') }} </a>
                                            </div>
                                        </div>

                                        <div class="cart-total-accpect-payment">
                                            <p>{{ trans('interface.cart.paymentMethods') }}</p>
                                            <div class="d-flex mt-4 payments-img">
                                                <img class="mr-1" src="{{asset('images/payments/iyzico.png')}}">
                                                <img src="{{asset('images/payments/visa.png')}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row mt-5">
                        <div class="col-lg-12 col-md-12 col-sm-12 content-side">
                            <div class="blog-details-content">
                                <div class="page-content">
                                    <div class="">
                                        <div class="empty-cart-message">
                                            <div class="cart-empty div-info">
                                                <h5>{{ trans('interface.cart.empty') }}</h5>
                                            </div>
                                        </div>
                                        <p class="return-to-shop">
                                            <a class="button button-fill-one" href="/">{{ trans('interface.cart.returnHome') }}</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-10 col-sm-12">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </section>

@endsection

@section('additionalScript')
    <script src="{{ asset('js/store/cart.js') }}"></script>
@endsection
