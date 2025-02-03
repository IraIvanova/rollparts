@extends('store.base')

@section('metaTitle'){{ trans('interface.meta.title.account') }}@endsection
@section('metaDescription'){{ trans('interface.meta.description.account') }}@endsection

@section('bodyContent')
    <div class="container-xxxl container mt-5">
        <div class="">
        <h2 class="mb-4">My Account</h2>

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
            <div class="row">
               <div class="col-lg-6 col-md-12">
                   <h5 class="mt-5">Contact details</h5>
                <form class="rp-form of-form-login login" action="{{ route('process-register') }}" method="post">
                    <div class="@error('email') error @enderror   form-row form-row-wide">
                        <label for="username">{{ trans('interface.form.email') }}<span class="required" aria-hidden="true">*</span>
                        </label>
                        <input type="email" disabled class="of-Input  input-text" name="email" id="username" value="{{$user->email}}" required>
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="@error('phone') error @enderror   form-row form-row-wide">
                        <label for="phone">{{ trans('interface.form.phone') }}<span class="required" aria-hidden="true">*</span>
                        </label>
                        <input type="tel" class="of-Input  input-text" name="phone" id="phone" value="{{$user->phone}}" required >
                        @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="@error('name') error @enderror   form-row form-row-wide">
                        <label for="name">{{ trans('interface.form.name') }}<span class="required" aria-hidden="true">*</span>
                        </label>
                        <input type="text" class="of-Input  input-text" name="name" id="name" value="{{$user->name}}" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="@error('lastName') error @enderror   form-row form-row-wide">
                        <label for="lastName">{{ trans('interface.form.lastName') }}<span class="required" aria-hidden="true">*</span>
                        </label>
                        <input type="text" class="of-Input  input-text" name="lastName" id="lastName" value="{{$user->lastName}}" required>
                        @error('lastName')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <p class="form-row">
                        <button type="submit" class=" button of-form-login__submit">{{ trans('interface.buttons.update') }}</button>
                    </p>
                    @csrf
                </form>
               </div>
                <div class="col-lg-6 col-md-12">
                <h5 class="mt-5">Address details</h5>
                <form class="of-form-login login">
                    <div class="form-row validate-required">
                        <label for="country" class="">Country*</label>
                        <input type="text" class="input-text"
                               name="country"
                               disabled
                               id="country" placeholder="" value="Turkey">
                    </div>
                    <div class="row px-3">
                        <div class="form-row validate-required w-50">
                            <label for="province" class="">Province*</label>
                            <select class="input-text" name="province_id" id="province" data-route="{{route('getDistrictsList')}}">
                                <option value="">Select a province</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-row validate-required w-50">
                            <label for="district" class="">District<span class="required" title="required">*</span></label>
                            <select class="input-text" name="district_id" id="district">
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
                    <p class="form-row">
                        <button type="submit" class=" button of-form-login__submit">{{ trans('interface.buttons.saveAddress') }}</button>
                    </p>
                </form>
                </div>
            </div>
            </div>

            <!-- Orders Tab -->
            <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
{{--                <h4>Orders</h4>--}}
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
