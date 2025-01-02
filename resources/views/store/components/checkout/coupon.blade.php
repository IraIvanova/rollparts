<div class="return_option">
    <div class="woocommerce-form-coupon-toggle">

        <div class="woocommerce-info">
            Have a coupon? <a href="#" id="show-coupon">Click here to enter your code</a>
        </div>
    </div>

    <form class="checkout_coupon woocommerce-form-coupon d-none" id="checkout-form" method="post" style="">

        <p>If you have a coupon code, please apply it below.</p>

        <p class="form-row form-row-first">
            <label for="coupon_code" class="screen-reader-text">Coupon:</label>
            <input type="text" name="coupon_code" class="input-text" placeholder="Coupon code" id="coupon_code"
                   value="">
        </p>

        <p class="form-row form-row-last">
            <button type="submit" class="button" name="apply_coupon" value="Apply coupon">Apply coupon</button>
        </p>

        <div class="clear"></div>
    </form>
    <div class="woocommerce-notices-wrapper"></div>
</div>
