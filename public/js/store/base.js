document.addEventListener("DOMContentLoaded", () => {
    let axiosConfig = {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    };

    let fixHeader = () => {
        const scrollHeader = document.getElementById('scroll-menu');
        const mainHeader = document.getElementById('main-menu');

        window.addEventListener('scroll', () => {
            const headerHeight = mainHeader.offsetHeight;

            if (window.scrollY > headerHeight) {
                scrollHeader.classList.add('fixed');
            } else {
                scrollHeader.classList.remove('fixed');
            }
        });
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
                        if (resp.status === 201) {
                            let cartModalLabel = document.getElementById('cartModalLabel');
                            cartModalLabel.children[0].innerText = resp.data.name;
                            let myModal = new bootstrap.Modal(document.getElementById('cartModal'), {});
                            myModal.show();

                            updateCartPreview(resp.data);
                        } else {
                            alert('smth went wrong!');
                        }
                    })
            })
        }
    }

    let prepareFormData = (data) => {
        const formData = new FormData();

        for (let key in data) {
            formData.append(key, data[key])
        }

        return formData
    }

    const cartIcon = document.getElementById('cart-icon');
    const cartPreview = document.getElementById('cart-preview');

    const toggleCartPreview = () => {
        cartPreview.classList.toggle('visible');
    };

    cartIcon.addEventListener('click', (event) => {
        event.stopPropagation();
        toggleCartPreview();
    });

    document.addEventListener('click', (event) => {
        if (cartPreview.classList.contains('visible') && !cartPreview.contains(event.target)) {
            cartPreview.classList.remove('visible');
        }
    });

    cartPreview.addEventListener('click', (event) => {
        event.stopPropagation();
    });

    const mobileMenu = document.getElementById('slide-sidebar-menu');
    const openMenuBtns = document.getElementsByClassName('mobile-menu-icon');
    const closeMenuBtn = document.getElementById('slide-menu-close');
    const scrollHeader = document.getElementById('scroll-menu');

    for (let openMenuBtn of openMenuBtns) {
        // Open menu
        openMenuBtn.addEventListener('click', function () {
            mobileMenu.classList.add('open');
            document.body.style.overflow = 'hidden';
            scrollHeader.classList.remove('fixed');
        });
    }

    // Close menu
    closeMenuBtn.addEventListener('click', function () {
        mobileMenu.classList.remove('open');
        document.body.style.overflow = '';


    });

    // Close menu when clicking outside of it (optional)
    document.addEventListener('click', function (event) {
        if (!mobileMenu.contains(event.target) && !Array.from(openMenuBtns).some(btn => btn.contains(event.target))) {
            mobileMenu.classList.remove('open');
            document.body.style.overflow = '';
        }
    });

    let updateCartPreview = (data) => {
        const cartCounter = document.getElementsByClassName('header-cart-count')[0];
        const cartContainer = document.getElementById('cart-preview-content')

        cartCounter.innerText = data.totalItems;
        cartContainer.innerHTML = data.view;
    }

    fixHeader();
    addToCart();
});
