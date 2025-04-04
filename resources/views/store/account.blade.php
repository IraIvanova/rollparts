@extends('store.base')

@section('metaTitle'){{ trans('interface.meta.title.account') }} @endsection
@section('metaDescription'){{ trans('interface.meta.description.account') }} @endsection

@section('bodyContent')
    <div class="container-xxxl container mt-5">
        <div class="wrapper">
            <h2 class="mb-4">{{ trans('interface.account.title') }}</h2>

            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs" id="accountTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="account-details-tab" data-bs-toggle="tab"
                            data-bs-target="#account-details" type="button" role="tab" aria-controls="account-details"
                            aria-selected="true">
                        {{ trans('interface.account.details') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button"
                            role="tab" aria-controls="orders" aria-selected="false">
                        {{ trans('interface.account.orders') }}
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content mt-3" id="accountTabsContent">
                <!-- Account Details Tab -->
                <div class="tab-pane pb-5 fade show active" id="account-details" role="tabpanel"
                     aria-labelledby="account-details-tab">
                    <div>

                        <form action="{{ route('client.update') }}" method="post">
                            <div class="row">
                                <div class="col-lg-6 clo-md-12">
                                    <h5 class="mt-5 mb-3">{{ trans('interface.checkout.contactDetails') }}</h5>
                                    @include('store.components.account.clientInfo', ['isCart' => false])
                                    <div id="warningDiv"
                                         class="div-info @if(!$errors->any())d-none @endif alertDiv mt-3 w-100 text-center">
                                        @if($errors->any())
                                            @foreach ($errors->all() as $error)
                                                <p>{{ $error }}</p>
                                            @endforeach
                                        @endif
                                    </div>
                                    <p class="form-row mt-4">
                                        <button type="submit" class="button button-fill-one of-form-login__submit">{{ trans('interface.buttons.update') }}</button>
                                    </p>
                                </div>
                                <div class="col-lg-6 clo-md-12">
                                    <h5 class="mt-5 mb-3">{{trans('interface.checkout.shippingDetails')}}</h5>
                                    @include('store.components.account.addresses')
                                </div>
                            </div>
                            @csrf

                        </form>
                    </div>
                </div>

                <!-- Orders Tab -->
                <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                    <div class="p-2 mt-5">
                    @if($orders->isEmpty())
                        <h4 class="mb-5">{{ trans('interface.account.noOrders') }}</h4>
                    @else
                        @foreach($orders as $order)
                            @include('store.components.account.order')
                        @endforeach
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additionalScript')
    <script src="{{ asset('js/store/checkout.js') }}"></script>
@endsection
