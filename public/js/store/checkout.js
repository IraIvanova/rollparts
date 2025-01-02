document.addEventListener("DOMContentLoaded", () => {
    let showCouponCode = () => {
        const coupon = document.getElementById('show-coupon');
        const couponFieldDiv = document.getElementById('checkout-form');

        coupon.addEventListener('click', () => {
            couponFieldDiv.classList.remove('d-none');
        });
    }

    showCouponCode();
});
