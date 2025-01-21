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
                    .then(resp => {
                        if (resp.status === 201) {
                            const myModal = new bootstrap.Modal(document.getElementById('cartModal'), {});
                            document.getElementById('modal-cart-preview-content').innerHTML = resp.data.view;
                            myModal.show();
                            updateCartPreview(resp.data);
                        }
                    })
                    .catch((error) => {
                        const infoModal = new bootstrap.Modal(document.getElementById('infoModal'), {});
                        document.getElementById('info-message').innerHTML = error.response.data.error;
                        infoModal.show();
                        setTimeout(() => {
                            infoModal.hide()
                        }, 3000)
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
    let searchProducts = () => {
        const searchField = document.getElementById('prosearch');
        const resultsContainer = document.getElementById('search-results');
        const button = document.querySelector('.search-form button');

        // Clear results container initially
        resultsContainer.innerHTML = '';

        // Handle input in the search field
        searchField.addEventListener('input', () => {
            const query = searchField.value.trim();

            if (query.length > 2) {
                axios.post(searchField.dataset.route, { search: query })
                    .then(resp => {
                        console.log(resp.data);
                        resultsContainer.innerHTML = resp.data;

                        // Show results container
                        resultsContainer.style.display = 'block';
                    })
                    .catch(err => console.error('Error fetching search results:', err));
            } else {
                resultsContainer.style.display = 'none'; // Hide if input is too short
            }
        });

        // Close results container when clicking outside input or container
        document.addEventListener('click', (event) => {
            const isClickInside = searchField.contains(event.target) || resultsContainer.contains(event.target);
            if (!isClickInside) {
                resultsContainer.style.display = 'none';
            }
        });

        searchField.addEventListener("keyup", (e) => {
                if (e.keyCode === 13) {
                    location.href = `/catalog?search=${searchField.value}`;
                }
        });

        button.addEventListener('click', () => {
            location.href = `/catalog?search=${searchField.value}`;
        })

        // Ensure resultsContainer remains open when interacting with it
        resultsContainer.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent click from bubbling to document listener
        });
    }



    searchProducts();
    fixHeader();
    addToCart();
});
