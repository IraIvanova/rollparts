<div class="return_option">
    @if(!$couponCode)
    <div class="woocommerce-form-coupon-toggle">

        <div class="woocommerce-info">
            Have a coupon? <a href="#" id="show-coupon">Click here to enter your code</a>
        </div>
    </div>
    @endif
    <form class="checkout_coupon woocommerce-form-coupon @if(!session()->has('result') && !$couponCode) d-none @endif "
          id="coupon-form" method="post" action="{{$couponCode ? route('removeCoupon') : route('applyCoupon')}}">
        @csrf
        <p >If you have a coupon code, please apply it below.</p>

        <p class="form-row form-row-first">
            <label for="coupon_code" class="screen-reader-text">Coupon:</label>
            <input type="text" name="coupon" required class="input-text @if(session()->has('result')) error @endif " placeholder="Coupon code" id="coupon_code"
                   value="{{session('enteredCoupon') ?? $couponCode}}">
        </p>

        <p class="form-row form-row-last">
            <button type="submit" class="button" name="apply_coupon">{{ $couponCode ? 'Delete coupon' : 'Apply coupon' }}</button>
        </p>

        <div id="result" class="clear error bold">{{ session('result') }}</div>
    </form>
</div>
