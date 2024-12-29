document.addEventListener("DOMContentLoaded", () => {

    let fixHeader = () => {
        const scrollHeader = document.getElementById('scroll-menu');
        const mainHeader = document.getElementById('main-menu');

        window.addEventListener('scroll', () => {
            const headerHeight = mainHeader.offsetHeight;

            console.log(window.scrollY, headerHeight)
            if (window.scrollY > headerHeight) {
                scrollHeader.classList.add('fixed');
            } else {
                scrollHeader.classList.remove('fixed');
            }
        });
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

    fixHeader();
});
