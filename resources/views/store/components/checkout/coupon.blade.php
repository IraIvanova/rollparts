<div class="return_option">
    @if(!$couponCode)
    <div class="rp-form-coupon-toggle">
        <div class="div-info">
            {!! trans('interface.checkout.haveCoupon') !!}
        </div>
    </div>
    @endif
    <form class="checkout_coupon rp-form-coupon rp-form-card @if(!session()->has('result') || !$couponCode) d-none @endif "
          id="coupon-form" method="post" action="{{$couponCode ? route('removeCoupon') : route('applyCoupon')}}">
        @csrf
        <p>{{ trans('interface.checkout.haveCouponLine2') }}</p>
        <div class="d-flex">
        <p>
            <label for="coupon_code" class="screen-reader-text">{{ trans('interface.checkout.coupon') }}:</label>
            <input type="text" name="coupon" required class="input-text rp-form-row-Input @if(session()->has('result')) error @endif " placeholder="{{ trans('interface.checkout.coupon') }}" id="coupon_code"
                   value="{{session('enteredCoupon') ?? $couponCode}}">
        </p>
            <button type="submit" class="button button-fill-one" name="apply_coupon">{{ trans( $couponCode ? 'interface.checkout.deleteCoupon' : 'interface.checkout.applyCoupon') }}</button>
        </div>
        <div id="result" class="clear error bold">{{ session('result') }}</div>
    </form>
</div>
