<div class="return_option">
    @if(!$couponCode)
    <div class="rp-form-coupon-toggle">
        <div class="div-info">
            Have a coupon? <a href="#" id="show-coupon">Click here to enter your code</a>
        </div>
    </div>
    @endif
    <form class="checkout_coupon rp-form-coupon rp-form-card @if(!session()->has('result') || !$couponCode) d-none @endif "
          id="coupon-form" method="post" action="{{$couponCode ? route('removeCoupon') : route('applyCoupon')}}">
        @csrf
        <p >If you have a coupon code, please apply it below.</p>
        <div class="d-flex">
        <p>
            <label for="coupon_code" class="screen-reader-text">Coupon:</label>
            <input type="text" name="coupon" required class="input-text rp-form-row-Input @if(session()->has('result')) error @endif " placeholder="Coupon code" id="coupon_code"
                   value="{{session('enteredCoupon') ?? $couponCode}}">
        </p>
            <button type="submit" class="button button-fill-one" name="apply_coupon">{{ $couponCode ? 'Delete coupon' : 'Apply coupon' }}</button>
        </div>

        <div id="result" class="clear error bold">{{ session('result') }}</div>
    </form>
</div>
