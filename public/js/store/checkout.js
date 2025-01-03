document.addEventListener("DOMContentLoaded", () => {
    let showCouponCode = () => {
        const coupon = document.getElementById('show-coupon');
        const couponFieldDiv = document.getElementById('checkout-form');

        coupon.addEventListener('click', () => {
            couponFieldDiv.classList.remove('d-none');
        });
    }

    const requiredFields = document.querySelectorAll('.validate-required .input-text');

    for (let field of requiredFields) {
        field.addEventListener('input', () => {
            if (field.value.trim()) {
                field.parentElement.classList.remove('invalid');
            }
        })
    }

    let createOrder = () => {
        const btn = document.getElementById('placeOrder');
        const form = document.getElementById('orderForm');
        const warningDiv = document.getElementById('warningDiv');

        btn.addEventListener('click', (e) => {
            warningDiv.innerHTML = '';
            let isValid = true;

            requiredFields.forEach(field => {
                field.parentElement.classList.remove('invalid');
            });

            requiredFields.forEach(field => {
                if (field.type === 'email') {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    console.log(emailRegex.test(field.value.trim()))
                    if (!emailRegex.test(field.value.trim())) {
                        isValid = false;
                        field.parentElement.classList.add('invalid');
                        warningDiv.innerHTML += `<p>Provide correct email!</p>`;
                    }
                } else {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.parentElement.classList.add('invalid');
                    }
                }
            });

            if (!isValid) {
                warningDiv.innerHTML += `<p>Fill out all required fields!</p>`;
                warningDiv.classList.remove('d-none');
                return;
            }

            form.submit();
        });
    }

    showCouponCode();
    createOrder();
});
