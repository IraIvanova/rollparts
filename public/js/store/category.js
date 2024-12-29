document.addEventListener("DOMContentLoaded", () => {
    let axiosConfig = {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    };

    let hideOrExpandSubCategories = () => {
        const arrows = document.querySelectorAll(".icon");

        arrows.forEach(arrow => {
            arrow.addEventListener("click", function (e) {
                e.preventDefault();
                const parentLi = arrow.closest("li");
                parentLi.classList.toggle("collapsed");

                const nestedUl = parentLi.querySelector("ul");
                if (nestedUl) {
                    if (nestedUl.style.display === "block" || !nestedUl.style.display) {
                        nestedUl.style.display = "none";
                    } else {
                        nestedUl.style.display = "block";
                    }
                }
            });
        });
    }

    let applyFilters = () => {
        const checkboxes = document.getElementsByClassName("checkbox");

        for (let checkbox of checkboxes) {
            checkbox.addEventListener("click", function (e) {
                location.href = getSelectedCheckboxAndSorting();
            });
        }
    }

    let sortProducts = () => {
        let select = document.getElementById('orderby');

        select.addEventListener('change', (e) => {
            location.href = getSelectedCheckboxAndSorting();
        })
    }

    let addToCart = () => {
        const buttons = document.getElementsByClassName('add_to_cart_button');
        const route = document.getElementById('cart-route').value;

        for (let btn of buttons) {
            btn.addEventListener('click', (e) => {
                e.preventDefault();

                const data = prepareFormData({
                    productId: btn.dataset.product
                });

                axios.post(route, data, axiosConfig)
                    .then((resp) => {
                        // const modal = new bootstrap.Modal(document.getElementById('cartModal'));
                        let myModal = new bootstrap.Modal(document.getElementById('cartModal'), {});
                        myModal.show();
                        // modal.show();
                    })
            })
        }
    }

    let getSelectedCheckboxAndSorting = () => {
        let form = document.querySelector('#filters-form');
        const inputs = document.getElementsByClassName('checkbox');
        const checked = Array.from(inputs).filter(i => i.checked === true)
        let searchParams = groupInputsByName(checked);

        let url = new URL(form.action + '/?');
        let params = new URLSearchParams(searchParams);
        params.set('sortby', document.getElementById('orderby').value);

        return url + params.toString();
    }

    let groupInputsByName = (inputs) => {
        return inputs.reduce((grouped, input) => {
            const name = input.name;

            if (!grouped[name]) {
                grouped[name] = [];
            }

            grouped[name].push(input.value);

            return grouped;
        }, {});
    }
    let prepareFormData = (data) => {
        const formData = new FormData();

        for (let key in data) {
            formData.append(key, data[key])
        }

        return formData
    }

    hideOrExpandSubCategories();
    applyFilters();
    sortProducts();
    addToCart();
});
