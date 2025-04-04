<div>
    <div class="form-row form-row-wide validate-required">
        <label for="country" class="">{{trans('interface.checkout.country')}}*</label>
        <input type="text" class="input-text rp-form-row-Input"
               name="country"
               id="country" readonly value="{{trans('interface.turkey')}}">
    </div>
    <div class="row justify-content-between px-3">
        <div class="form-row form-row-wide validate-required w-50">
            <label for="province" class="">{{trans('interface.checkout.province')}}*</label>
            <select class="input-text rp-form-row-Input province" name="province_id"
                    id="province" data-route="{{route('getDistrictsList')}}">
                <option value="">{{trans('interface.checkout.selectProvince')}}</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}"
                            @if($user?->shippingAddress?->province_id === $province->id) selected @endif>{{ $province->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-row form-row-wide validate-required w-50">
            <label for="district" class="">{{trans('interface.checkout.district')}}<span
                    class="required" title="required">*</span></label>
            <select class="input-text rp-form-row-Input" name="district_id" id="district">
                @if(!empty($shippingDistricts))
                    @foreach ($shippingDistricts as $district)
                        <option value="{{ $district['id'] }}"
                                @if($user->shippingAddress?->district_id === $district['id']) selected @endif>{{ $district['name'] }}</option>
                    @endforeach
                @else
                    <option value="">{{trans('interface.checkout.selectDistrict')}}</option>
                @endif
            </select>
        </div>
    </div>
    <div class="row justify-content-between px-3">
        <div class="form-row form-row-wide validate-required w-75 @error('address_line1') invalid @enderror">
            <label for="address" class="">{{trans('interface.checkout.addressLine')}}*</label>
            <input type="text" class="input-text rp-form-row-Input w-100"
                   name="address_line1"
                   id="address"
                   value="{{ $user?->shippingAddress?->address_line1 ?? old('address_line1') ?? '' }}">
        </div>
        <div class="form-row form-row-wide validate-required w-25 @error('zip') invalid @enderror">
            <label for="zip" class="">{{trans('interface.checkout.zipCode')}}*</label>
            <input type="text" class="input-text rp-form-row-Input w-100"
                   name="zip"
                   id="zip" value="{{ $user?->shippingAddress?->zip ?? old('zip') ?? ''}}">
        </div>
    </div>
    <div class="form-row form-row-wide sameAddress d-flex">
        <input type="checkbox" class="checkbox" id="sameAddress"
               name="billingSameAsShippingAddress" checked>
        <label for="sameAddress"><b>{{trans('interface.checkout.sameAddress')}}</b></label>
    </div>
</div>
<div id="billingAddressFields" class="d-none">
    <h5 class="mt-5">{{trans('interface.checkout.billingDetails')}}</h5>
    <div class="form-row form-row-wide validate-required">
        <label for="billingCountry" class="">{{trans('interface.checkout.country')}}*</label>
        <input type="text" class="input-text rp-form-row-Input"
               name="billing_country"
               id="billingCountry" value="{{ trans('interface.turkey') }}" readonly>
    </div>
    <div class="row px-3 justify-content-between">
        <div class="form-row form-row-wide validate-required w-50">
            <label for="billingProvince" class="">{{trans('interface.checkout.province')}}
                *</label>
            <select class="input-text rp-form-row-Input province" name="billing_province_id"
                    id="billingProvince" data-route="{{route('getDistrictsList')}}">
                <option value="">{{trans('interface.checkout.selectProvince')}}</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}"
                            @if($user?->billingAddress?->province_id === $province->id) selected @endif>{{ $province->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-row form-row-wide validate-required w-50">
            <label for="billingDistrict" class="">{{trans('interface.checkout.district')}}<span
                    class="required" title="required">*</span></label>
            <select class="input-text rp-form-row-Input" name="billing_district_id"
                    id="billingDistrict">
                @if(!empty($billingDistricts))
                    @foreach ($billingDistricts as $district)
                        <option value="{{ $district['id'] }}"
                                @if($user->billingAddress?->district_id === $district['id']) selected @endif>{{ $district['name'] }}</option>
                    @endforeach
                @else
                    <option value="">{{trans('interface.checkout.selectDistrict')}}</option>
                @endif
            </select>
        </div>
    </div>
    <div class="row justify-content-between px-3">
        <div class="form-row form-row-wide validate-required w-75 @error('billing_address_line1') invalid @enderror">
            <label for="billingAddress" class="">{{trans('interface.checkout.addressLine')}}
                *</label>
            <input type="text" class="input-text rp-form-row-Input w-100"
                   name="billing_address_line1"
                   id="billingAddress"
                   value="{{ $user?->billingAddress?->address_line1 ?? old('billing_address_line1') ?? ''}}">
        </div>
        <div class="form-row form-row-wide validate-required w-25 @error('billing_zip') invalid @enderror">
            <label for="billingZip" class="">{{trans('interface.checkout.zipCode')}}*</label>
            <input type="text" class="input-text rp-form-row-Input w-100"
                   name="billing_zip"
                   id="billingZip"
                   value="{{ $user?->billingAddress?->zip ?? old('billing_zip') ?? ''}}">
        </div>
    </div>
</div>
