@extends('store.base')

@section('bodyContent')
    <section id="main-content" class="container container-xxxl py-5">
        <div class="wrapper woocommerce">
            <div class="row">
                <div class="col-12 col">
                    <div class="">
                        <span>
                            Returning customer? <a href="#" class="font-weight-bold">Click here to login</a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="row1 mt-4">
                <div class="">
                   @include('store.components.checkout.coupon')
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col">
                    <h2 class="mb-4">Billing details</h2>
                    <form method="post" action="{{route('createOrder')}}" id="orderForm">
                        @csrf
                        <h5>Contact details</h5>
                        <div>
                            <div class="row px-3">
                                <div class="form-row validate-required w-50">
                                    <label for="firstName" class="">First name*</label>
                                    <input type="text" class="input-text "
                                           name="name"
                                           id="firstName" placeholder="" value="">
                                </div>
                                <div class="form-row validate-required w-50">
                                    <label for="lastName" class="">Last name*</label>
                                    <input type="text" class="input-text "
                                           name="lastName"
                                           id="lastName" placeholder="" value="">
                                </div>
                            </div>
                            <div class="form-row  validate-required">
                                <label for="phone" class="">Phone*</label>
                                <input type="text" class="input-text "
                                       name="phone"
                                       id="phone" placeholder="" value="">
                            </div>
                            <div class="form-row  validate-required">
                                <label for="email" class="">Email*</label>
                                <input type="email" class="input-text"
                                       name="email"
                                       id="email" placeholder="" value="" required>
                            </div>
                        </div>
                        <h5 class="mt-5">Address details</h5>
                        <div>
                            <div class="form-row  validate-required">
                                <label for="country" class="">Country*</label>
                                <input type="text" class="input-text "
                                       name="country"
                                       id="country" placeholder="" disabled value="Turkey">
                            </div>
                            <div class="row px-3">
                                <div class="form-row validate-required w-50">
                                    <label for="province" class="">Province*</label>
                                    <select class="input-text" name="province" id="province" data-route="{{route('getDistrictsList')}}">
                                        <option value="">Select a province</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-row validate-required w-50">
                                    <label for="district" class="">District<span class="required" title="required">*</span></label>
                                    <select class="input-text" name="district" id="district">
                                        <option value="">Select a district</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row px-3">
                                <div class="form-row  validate-required w-75">
                                    <label for="address" class="">Address*</label>
                                    <input type="text" class="input-text "
                                           name="address_line1"
                                           id="address" placeholder="" value="">
                                </div>
                                <div class="form-row  validate-required w-25">
                                    <label for="zip" class="">Postal Code*</label>
                                    <input type="text" class="input-text "
                                           name="zip"
                                           id="zip" placeholder="" value="">
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="additionalNotes" class="">Additional notes</label>
                                <textarea class="input-text" rows="6"
                                          name="additionalNotes"
                                          id="additionalNotes" placeholder=""></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="order_box_price">
                        <div class="payment_list">
                            <h2 id="order_review_heading" class="order_title">Your order</h2>
                            @include('store.components.checkout.orderReview')
                        </div>
                        <div class="payment_list_item">
                            <div class="payment_list_item">
                                <div id="payment" class="payment_list_item woocommerce-checkout-payment">
                                    <div class="payment_options shipping wc_payment_methods payment_methods methods">

                                        <div class="form-group wc_payment_method payment_method_bacs">
                                            <input id="payment_method_bacs" type="radio" class="input-radio radio_group"
                                                   name="payment_method" value="bacs" checked="checked"
                                                   data-order_button_text="">
                                            <label for="payment_method_bacs">
                                                Direct bank transfer </label>
                                            <div class="payment_box payment_method_bacs">
                                                <p>Make your payment directly into our bank account. Please use your
                                                    Order ID as the payment reference. Your order will not be shipped
                                                    until the funds have cleared in our account.</p>
                                            </div>
                                        </div>

                                        <div class="form-group wc_payment_method payment_method_cheque">
                                            <input id="payment_method_cheque" type="radio"
                                                   class="input-radio radio_group" name="payment_method" value="cheque"
                                                   data-order_button_text="">
                                            <label for="payment_method_cheque">
                                                Check payments </label>
                                            <div class="payment_box payment_method_cheque" style="display: none;">
                                                <p>Please send a check to Store Name, Store Street, Store Town, Store
                                                    State / County, Store Postcode.</p>
                                            </div>
                                        </div>

                                        <div class="form-group wc_payment_method payment_method_cod">
                                            <input id="payment_method_cod" type="radio" class="input-radio radio_group"
                                                   name="payment_method" value="cod" data-order_button_text="">
                                            <label for="payment_method_cod">
                                                Cash on delivery </label>
                                            <div class="payment_box payment_method_cod" style="display: none;">
                                                <p>Pay with cash upon delivery.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row place-order">
                                        <noscript>
                                            Since your browser does not support JavaScript, or it is disabled, please
                                            ensure you click the <em>Update Totals</em> button before placing your
                                            order. You may be charged more than the amount stated above if you fail to
                                            do so. <br/>
                                            <button type="submit" class="button alt"
                                                    name="woocommerce_checkout_update_totals"
                                                    value="Update totals">Update totals
                                            </button>
                                        </noscript>

                                        <div class="woocommerce-terms-and-conditions-wrapper">
                                            <div class="woocommerce-privacy-policy-text"><p>Your personal data will be
                                                    used to process your order, support your experience throughout this
                                                    website, and for other purposes described in our <a href=""
                                                                                                        class="woocommerce-privacy-policy-link"
                                                                                                        target="_blank">privacy
                                                        policy</a>.</p>
                                            </div>
                                        </div>


                                        <button type="button" class="button alt w-100" id="placeOrder">Place order</button>

                                        <input type="hidden" id="woocommerce-process-checkout-nonce"
                                               name="woocommerce-process-checkout-nonce" value="1314b3a253"><input
                                            type="hidden" name="_wp_http_referer" value="/?wc-ajax=update_order_review">
                                        <div id="warningDiv" class="woocommerce-info d-none alertDiv mt-3 w-100 text-center">

                                        </div>
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

@section('additionalScript')
    <script src="{{ asset('js/store/checkout.js') }}"></script>
@endsection

