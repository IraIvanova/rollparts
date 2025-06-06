@extends('store.base')

@section('metaTitle')
    {{ trans('interface.meta.title.checkout') }}
@endsection
@section('metaDescription')
    {{ trans('interface.meta.description.checkout') }}
@endsection

@section('bodyContent')
    <section id="main-content" class="container container-xxxl py-5">
        <input type="hidden" id="loadReviewBlock" value="{{route('loadOrderReviewBlock')}}">
        <div class="wrapper">
            @guest
                <div class="row">
                    <div class="col-12 col">
                        <div class="">
                        <span>
                            {!! trans('interface.checkout.isReturningCustomer', ['loginUrl' => route('login')]) !!}
                        </span>
                        </div>
                    </div>
                </div>
            @endguest

            <div class="row1 mt-4">
                @include('store.components.checkout.coupon')
            </div>
                <form method="post" action="{{route('createOrder')}}" id="orderForm">
            <div class="row">
                <div class="col-md-8 col">
                    <h2 class="mb-4">{{ trans('interface.checkout.billingDetails') }}</h2>

                        @csrf
                        <h5>
                            {{ trans('interface.checkout.contactDetails') }}
                        </h5>
                        @include('store.components.account.clientInfo', ['isCart' => true])
                        <h5 class="mt-5">{{trans('interface.checkout.shippingDetails')}}</h5>
                        @include('store.components.account.addresses')
                        <div class="form-row form-row-wide mt-2">
                            <label for="additionalNotes"
                                   class="">{{trans('interface.checkout.additionalNotes')}}</label>
                            <textarea class="input-text rp-form-row-Input" rows="6"
                                      name="additionalNotes"
                                      id="additionalNotes" placeholder="">{{ old('additionalNotes') }}</textarea>
                        </div>
                </div>
                <div class="col-lg-4">
                    <div class="order_box_price">
                        <div class="payment_list">
                            <h2 id="order_review_heading"
                                class="order_title">{{trans('interface.checkout.yourOrder')}}</h2>
                            <div id="reviewBlock">
                                @include('store.components.checkout.orderReview')
                            </div>
                        </div>

                        <div class="payment_list_item">
                            <div class="payment_list_item">
                                <div id="payment" class="payment_list_item">
                                    <div class="form-row place-order">
                                        <div class="">
                                            <div class="payment_list_item">
                                                <div class="payment_options shipping payment_methods methods">
                                                    <div class="form-group">
                                                        <input id="payment_method_online" type="radio"
                                                               class="input-radio radio_group payment-radio"
                                                               name="paymentMethod" value="online"
                                                               checked="checked">
                                                        <label for="payment_method_online">{{ trans('interface.checkout.creditCard') }}</label>
                                                    </div>

                                                    <div class="form-group">
                                                        <input id="payment_method_bank" type="radio"
                                                               class="input-radio radio_group payment-radio"
                                                               name="paymentMethod" value="bank_transfer">
                                                        <label for="payment_method_bank">{{ trans('interface.checkout.method.bankTransfer') }}</label>
                                                        <div class="payment_box">
                                                            <p>{{ trans('interface.checkout.paymentDesc') }}</p>
                                                        </div>
                                                        @include('store.components.checkout.requisites', ['hide' => true])
                                                    </div>
                                                </div>

                                                <div class="">
                                                    {!! trans('interface.checkout.privacyConfirmation', ['privacyUrl' => route('infoPrivacy')]) !!}
                                                </div>

                                                <button type="button" class="button button-fill-one w-100"
                                                        id="placeOrder">{{trans('interface.checkout.makeOrder')}}</button>
                                                <div class="d-flex mt-4 payments-img">
                                                    <img loading="lazy" alt="Iyzico" class="mr-1"
                                                         src="{{asset('images/payments/iyzico.png')}}">
                                                    <img loading="lazy" alt="Visa"
                                                         src="{{asset('images/payments/visa.png')}}">
                                                </div>
                                                <div id="warningDiv"
                                                     class="div-info @if(!$errors->any())d-none @endif alertDiv mt-3 w-100 text-center">
                                                    @if($errors->any())
                                                        @foreach ($errors->all() as $error)
                                                            <p>{{ $error }}</p>
                                                        @endforeach
                                                    @endif
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
                </form>
        </div>
    </section>
@endsection

@section('additionalScript')
    <script src="{{ asset('js/store/checkout.js') }}"></script>
@endsection

