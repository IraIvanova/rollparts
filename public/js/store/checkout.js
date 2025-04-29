document.addEventListener("DOMContentLoaded", () => {
    let showCouponCode = () => {
        const coupon = document.getElementById('show-coupon');
        const couponFieldDiv = document.getElementById('coupon-form');

        coupon && coupon.addEventListener('click', () => {
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

        btn && btn.addEventListener('click', (e) => {
            warningDiv.innerHTML = '';
            let isValid = true;

            requiredFields.forEach(field => {
                field.parentElement.classList.remove('invalid');
            });

            requiredFields.forEach(field => {
                if (field.offsetParent === null) return;

                if (field.type === 'email') {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
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

    function loadDistricts() {
        // const districtSelect = document.getElementById("district");
        // const provinceSelect = document.getElementById("province");
        // const districtSelects = document.getElementsByClassName("district");
        const provinceSelects = document.getElementsByClassName("province");

        for (let provinceSelect of provinceSelects) {
            provinceSelect.addEventListener('change', () => {
                const selectedProvinceId = provinceSelect.value;
                let districtSelect = provinceSelect.parentElement.nextElementSibling.children[1];
                console.log(districtSelect)
                districtSelect.innerHTML = '<option value="">Select a district</option>';

                if (!selectedProvinceId) return;

                axios.post(provinceSelect.dataset.route, {
                    provinceId: selectedProvinceId
                })
                    .then(response => {
                        const districts = response.data;
                        districts.forEach(district => {
                            const option = document.createElement("option");
                            option.value = district.id; // Use district ID as the value
                            option.textContent = district.name; // Display district name
                            districtSelect.appendChild(option);
                        });
                    })
            })
        }
    }

    let toggleBillingAddressBlock = () => {
        const sameAddressCheckbox = document.getElementById("sameAddress");
        const billingAddressFields = document.getElementById("billingAddressFields");

        sameAddressCheckbox.addEventListener("change", () => {
            if (sameAddressCheckbox.checked) {
                billingAddressFields.classList.add("d-none");
            } else {
                billingAddressFields.classList.remove("d-none");
            }

        });
    }

    let decideIfValidationRequired = () => {
        let billingInputsForValidation = document.getElementsByClassName('validate-if-visible');

        for (let input of billingInputsForValidation) {
            input.classList.toggle('validate-required');
        }
    }

    let loadReviewBlock = () => {
        const route = document.getElementById('loadReviewBlock').value;
        const reviewBlock = document.getElementById('reviewBlock');
        const paymentTypes = document.getElementsByClassName('payment-radio');

        for (let paymentType of paymentTypes) {
            paymentType.addEventListener('change', () => {
                axios.post(route, {
                    paymentMethod: paymentType.value
                })
                    .then(resp => {
                        reviewBlock.innerHTML = resp.data;
                    })
            });
        }
    }

    loadDistricts();
    showCouponCode();
    createOrder();
    toggleBillingAddressBlock();
    loadReviewBlock();
});
