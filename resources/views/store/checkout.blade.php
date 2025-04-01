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
                            {!! trans('interface.checkout.isReturningCustomer', ['loginUrl' => route('login')]) !!}
                        </span>
                    </div>
                </div>
            </div>

            <div class="row1 mt-4">
                   @include('store.components.checkout.coupon')
            </div>
            <div class="row">
                <div class="col-md-8 col">
                    <h2 class="mb-4">{{ trans('interface.checkout.billingDetails') }}</h2>
                    <form method="post" action="{{route('createOrder')}}" id="orderForm">
                        @csrf
                        <h5>
                            {{ trans('interface.checkout.contactDetails') }}
                        </h5>
                        <div>
                            <div class="row px-3">
                                <div class="form-row form-row-wide validate-required w-50">
                                    <label for="firstName" class="">{{ trans('interface.checkout.firstName') }}*</label>
                                    <input type="text" class="input-text rp-form-row-Input"
                                           name="name"
                                           id="firstName" placeholder="" value="{{$user->name ?? session('client.name') ?? ''}}">
                                </div>
                                <div class="form-row form-row-wide validate-required w-50">
                                    <label for="lastName" class="">{{ trans('interface.checkout.lastName') }}*</label>
                                    <input type="text" class="input-text rp-form-row-Input"
                                           name="lastName"
                                           id="lastName" placeholder="" value="{{$user->lastName ?? session('client.lastName') ?? ''}}">
                                </div>
                            </div>
                            <div class="form-row form-row-wide validate-required">
                                <label for="phone" class="">{{ trans('interface.checkout.phone') }}*</label>
                                <input type="text" class="input-text rp-form-row-Input"
                                       name="phone" pattern="^(\+?905|05|5)[0-9]{9}$" required
                                       id="phone" placeholder="" value="{{$user->phone ?? session('client.phone') ?? ''}}">
                            </div>
                            <div class="form-row form-row-wide validate-required">
                                <label for="email" class="">Email*</label>
                                <input type="email" class="input-text rp-form-row-Input"
                                       name="email"
                                       id="email" placeholder="" value="{{$user->email ?? session('client.email') ?? ''}}" required>
                            </div>
                            <div class="form-row form-row-wide validate-required">
                                <label for="identity" class="">{{trans('interface.checkout.identityId')}}*</label>
                                <input type="text" class="input-text rp-form-row-Input"
                                       name="identity"
                                       id="identity" placeholder="" value="{{$user->identity ?? session('client.identity') ?? ''}}" required>
                            </div>
                        </div>
                        <h5 class="mt-5">{{trans('interface.checkout.shippingDetails')}}</h5>
                        <div>
                            <div class="form-row form-row-wide validate-required">
                                <label for="country" class="">{{trans('interface.checkout.country')}}*</label>
                                <input type="text" class="input-text rp-form-row-Input"
                                       name="country"
                                       id="country" placeholder="" value="{{trans('interface.turkey')}}">
                            </div>
                            <div class="row px-3">
                                <div class="form-row form-row-wide validate-required w-50">
                                    <label for="province" class="">{{trans('interface.checkout.province')}}*</label>
                                    <select class="input-text rp-form-row-Input province" name="province_id" id="province" data-route="{{route('getDistrictsList')}}">
                                        <option value="">{{trans('interface.checkout.selectProvince')}}</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-row form-row-wide validate-required w-50">
                                    <label for="district" class="">{{trans('interface.checkout.district')}}<span class="required" title="required">*</span></label>
                                    <select class="input-text rp-form-row-Input" name="district_id" id="district">
                                        <option value="">{{trans('interface.checkout.selectDistrict')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row px-3">
                                <div class="form-row form-row-wide validate-required w-75">
                                    <label for="address" class="">{{trans('interface.checkout.addressLine')}}*</label>
                                    <input type="text" class="input-text rp-form-row-Input"
                                           name="address_line1"
                                           id="address" value="{{ $user->shippingAddress?->address ?? session('client.shippingAddress.address_line1') ?? '' }}">
                                </div>
                                <div class="form-row form-row-wide validate-required w-25">
                                    <label for="zip" class="">{{trans('interface.checkout.zipCode')}}*</label>
                                    <input type="text" class="input-text rp-form-row-Input"
                                           name="zip"
                                           id="zip" value="{{ $user->shippingAddress?->address ?? session('client.shippingAddress.zip') ?? ''}}">
                                </div>
                            </div>
                            <div class="form-row form-row-wide sameAddress d-flex">
                                <input type="checkbox" class="checkbox" id="sameAddress" name="billingSameAsShippingAddress" checked>
                                <label for="sameAddress"><b>{{trans('interface.checkout.sameAddress')}}</b></label>
                            </div>
                        </div>
                        <div  id="billingAddressFields" class="d-none">
                            <h5 class="mt-5">{{trans('interface.checkout.billingDetails')}}</h5>
                            <div class="form-row form-row-wide validate-required">
                                <label for="billingCountry" class="">{{trans('interface.checkout.country')}}*</label>
                                <input type="text" class="input-text rp-form-row-Input"
                                       name="billing_country"
                                       id="billingCountry" placeholder="" value="Turkey">
                            </div>
                            <div class="row px-3">
                                <div class="form-row form-row-wide validate-required w-50">
                                    <label for="billingProvince" class="">{{trans('interface.checkout.province')}}*</label>
                                    <select class="input-text rp-form-row-Input province" name="billing_province_id" id="billingProvince" data-route="{{route('getDistrictsList')}}">
                                        <option value="">{{trans('interface.checkout.selectProvince')}}</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-row form-row-wide validate-required w-50">
                                    <label for="billingDistrict" class="">{{trans('interface.checkout.district')}}<span class="required" title="required">*</span></label>
                                    <select class="input-text rp-form-row-Input" name="billing_district_id" id="billingDistrict">
                                        <option value="">{{trans('interface.checkout.selectDistrict')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row px-3">
                                <div class="form-row form-row-wide validate-required w-75">
                                    <label for="billingAddress" class="">{{trans('interface.checkout.addressLine')}}*</label>
                                    <input type="text" class="input-text rp-form-row-Input"
                                           name="billing_address_line1"
                                           id="billingAddress" value="{{ $user->billingAddress?->address ?? session('client.billingAddress.address_line1') ?? ''}}">
                                </div>
                                <div class="form-row form-row-wide validate-required w-25">
                                    <label for="billingZip" class="">{{trans('interface.checkout.zipCode')}}*</label>
                                    <input type="text" class="input-text rp-form-row-Input"
                                           name="billing_zip"
                                           id="billingZip" value="{{ $user->billingAddress?->address ?? session('client.billingAddress.zip') ?? ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-row form-row-wide mt-2">
                            <label for="additionalNotes" class="">{{trans('interface.checkout.additionalNotes')}}</label>
                            <textarea class="input-text rp-form-row-Input" rows="6"
                                      name="additionalNotes"
                                      id="additionalNotes" placeholder=""></textarea>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="order_box_price">
                        <div class="payment_list">
                            <h2 id="order_review_heading" class="order_title">{{trans('interface.checkout.yourOrder')}}</h2>
                            @include('store.components.checkout.orderReview')

                        </div>

                        <div class="payment_list_item">
                            <div class="payment_list_item">
                                <div id="payment" class="payment_list_item">
                                    <div class="form-row place-order"><div class="">
                                            <div class="">
                                                {!! trans('interface.checkout.privacyConfirmation', ['privacyUrl' => route('infoPrivacy')]) !!}
                                            </div>

                                        <button type="button" class="button button-fill-one w-100" id="placeOrder">{{trans('interface.checkout.makeOrder')}}</button>
                                            <div class="d-flex mt-4 payments-img">
                                                <img class="mr-1" src="{{asset('images/payments/iyzico.png')}}">
                                                <img src="{{asset('images/payments/visa.png')}}">
                                            </div>
                                        <div id="warningDiv" class="div-info @if(!session('error'))d-none @endif alertDiv mt-3 w-100 text-center">
                                            @if(session('error')) {{session('error')}} @endif
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

