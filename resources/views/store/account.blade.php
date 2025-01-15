@extends('store.base')

@section('bodyContent')
    <div class="container-xxxl container mt-5">
        <div class="woocommerce">
        <h1 class="mb-4">My Account</h1>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="accountTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="account-details-tab" data-bs-toggle="tab" data-bs-target="#account-details" type="button" role="tab" aria-controls="account-details" aria-selected="true">
                    Account Details
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab" aria-controls="orders" aria-selected="false">
                    Orders
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3" id="accountTabsContent">
            <!-- Account Details Tab -->
            <div class="tab-pane fade show active" id="account-details" role="tabpanel" aria-labelledby="account-details-tab">
                <form class="woocommerce-form woocommerce-form-login login" action="{{ route('process-register') }}" method="post">
                    <div class="@error('email') error @enderror woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="username">{{ trans('interface.form.email') }}<span class="required" aria-hidden="true">*</span>
                        </label>
                        <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="username" value="{{$user->email}}" required>
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="@error('phone') error @enderror woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="phone">{{ trans('interface.form.phone') }}<span class="required" aria-hidden="true">*</span>
                        </label>
                        <input type="tel" class="woocommerce-Input woocommerce-Input--text input-text" name="phone" id="phone" value="{{$user->phone}}" required >
                        @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="@error('name') error @enderror woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="name">{{ trans('interface.form.name') }}<span class="required" aria-hidden="true">*</span>
                        </label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="name" id="name" value="{{$user->name}}" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="@error('lastName') error @enderror woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="lastName">{{ trans('interface.form.lastName') }}<span class="required" aria-hidden="true">*</span>
                        </label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="lastName" id="lastName" value="{{$user->lastName}}" required>
                        @error('lastName')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <p class="form-row">
                        <button type="submit" class="woocommerce-button button woocommerce-form-login__submit">{{ trans('interface.buttons.update') }}</button>
                    </p>
                    @csrf
                </form>
                <h2>Addresses</h2>
                @foreach($addresses as $address)
                    {{--TODO add btn to change address--}}
                    <li class="list-group-item">
                        {{ $address->getFullAddress }}
                    </li>
                @endforeach
            </div>

            <!-- Orders Tab -->
            <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                <h4>Orders</h4>
                @if($orders->isEmpty())
                    <p>You have no orders yet.</p>
                @else
                        @foreach($orders as $order)
                            @include('store.components.account.order')
                        @endforeach
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection
