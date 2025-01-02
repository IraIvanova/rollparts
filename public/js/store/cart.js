document.addEventListener("DOMContentLoaded", () => {
    let axiosConfig = {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    };

    let changeProductAmountInCart = () => {
        const qntButtons = document.getElementsByClassName('amount-btn');
        const addRoute = document.getElementById('add-route').value;
        const removeRoute = document.getElementById('remove-route').value;

        for (const btn of qntButtons) {
            btn.addEventListener('click', () => {
                let route = btn.classList.contains('plus-btn') ? addRoute : removeRoute;
                const data = {productId: btn.parentElement.dataset.product};

                if (btn.classList.contains('remove-full')) {
                    data.removeOne = false;
                }

                axios.post(route, prepareFormData(data), axiosConfig)
                    .then((resp) => {
                        location.reload();
                    })
            });
        }
    }

    let prepareFormData = (data) => {
        const formData = new FormData();

        for (let key in data) {
            formData.append(key, data[key])
        }

        return formData
    }

    let showCouponCode = () => {
        const coupon = document.getElementById('show-coupon');
        const couponFieldDiv = document.getElementById('checkout-form');

        coupon.addEventListener('click', () => {
            couponFieldDiv.classList.remove('d-none');
        });
    }

    changeProductAmountInCart();
});
