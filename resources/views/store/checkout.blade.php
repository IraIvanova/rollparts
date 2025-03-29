@extends('store.base')

@section('metaTitle'){{ trans('interface.meta.title.checkout') }}@endsection
@section('metaDescription'){{ trans('interface.meta.description.checkout') }}@endsection

@section('bodyContent')
    <section id="main-content" class="container container-xxxl py-5">
        <div class="wrapper">
            <div class="row">
                <div class="col-12 col">
                    <div class="">
                        <span>
                            Returning customer? <a href="{{ route('login') }}" class="font-weight-bold">Click here to login</a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="row1 mt-4">
                   @include('store.components.checkout.coupon')
            </div>
            <div class="row">
                <div class="col-md-8 col">
                    <h2 class="mb-4">Billing details</h2>
                    <form method="post" action="{{route('createOrder')}}" id="orderForm">
                        @csrf
                        <h5>Contact details</h5>
                        <div>
                            <div class="row px-3">
                                <div class="form-row form-row-wide validate-required w-50">
                                    <label for="firstName" class="">First name*</label>
                                    <input type="text" class="input-text rp-form-row-Input"
                                           name="name"
                                           id="firstName" placeholder="" value="{{$user->name ?? ''}}">
                                </div>
                                <div class="form-row form-row-wide validate-required w-50">
                                    <label for="lastName" class="">Last name*</label>
                                    <input type="text" class="input-text rp-form-row-Input"
                                           name="lastName"
                                           id="lastName" placeholder="" value="{{$user->lastName ?? ''}}">
                                </div>
                            </div>
                            <div class="form-row form-row-wide validate-required">
                                <label for="phone" class="">Phone*</label>
                                <input type="text" class="input-text rp-form-row-Input"
                                       name="phone"
                                       id="phone" placeholder="" value="{{$user->phone ?? ''}}">
                            </div>
                            <div class="form-row form-row-wide validate-required">
                                <label for="email" class="">Email*</label>
                                <input type="email" class="input-text rp-form-row-Input"
                                       name="email"
                                       id="email" placeholder="" value="{{$user->email ?? ''}}" required>
                            </div>
                            <div class="form-row form-row-wide validate-required">
                                <label for="identity" class="">{{trans('identityId')}}*</label>
                                <input type="text" class="input-text rp-form-row-Input"
                                       name="identity"
                                       id="identity" placeholder="" value="{{$user->identity ?? ''}}" required>
                            </div>
                        </div>
                        <h5 class="mt-5">Address details</h5>
                        <div>
                            <div class="form-row form-row-wide validate-required">
                                <label for="country" class="">Country*</label>
                                <input type="text" class="input-text rp-form-row-Input"
                                       name="country"
                                       id="country" placeholder="" value="Turkey">
                            </div>
                            <div class="row px-3">
                                <div class="form-row form-row-wide validate-required w-50">
                                    <label for="province" class="">Province*</label>
                                    <select class="input-text rp-form-row-Input" name="province_id" id="province" data-route="{{route('getDistrictsList')}}">
                                        <option value="">Select a province</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-row form-row-wide validate-required w-50">
                                    <label for="district" class="">District<span class="required" title="required">*</span></label>
                                    <select class="input-text rp-form-row-Input" name="district_id" id="district">
                                        <option value="">Select a district</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row px-3">
                                <div class="form-row form-row-wide validate-required w-75">
                                    <label for="address" class="">Address*</label>
                                    <input type="text" class="input-text rp-form-row-Input"
                                           name="address_line1"
                                           id="address" placeholder="" value="">
                                </div>
                                <div class="form-row form-row-wide validate-required w-25">
                                    <label for="zip" class="">Postal Code*</label>
                                    <input type="text" class="input-text rp-form-row-Input"
                                           name="zip"
                                           id="zip" placeholder="" value="">
                                </div>
                            </div>
                            <div class="form-row form-row-wide">
                                <label for="additionalNotes" class="">Additional notes</label>
                                <textarea class="input-text rp-form-row-Input" rows="6"
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
                                <div id="payment" class="payment_list_item">
                                    <div class="form-row place-order">
                                        <div class="">
                                            <div class=""><p>Your personal data will be
                                                    used to process your order, support your experience throughout this
                                                    website, and for other purposes described in our <a href=""
                                                                                                        class=""
                                                                                                        target="_blank">privacy
                                                        policy</a>.</p>
                                            </div>
                                        </div>

                                        <button type="button" class="button button-fill-one w-100" id="placeOrder">Place order</button>
                                        <div id="warningDiv" class="div-info d-none alertDiv mt-3 w-100 text-center">
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

