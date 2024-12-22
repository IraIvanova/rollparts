document.addEventListener("DOMContentLoaded", () => {
    $('.preview-group').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        vertical: true,
        focusOnSelect: true,
    });

    let clickOnPreview = () => {
        let preview = document.getElementsByClassName('preview-img');

        for (let p_img of preview) {
            p_img.addEventListener('click', () => {
                Array.from(preview).map(x => x.classList.remove('selected'))
                let gallery = document.getElementById('main-gallery');
                gallery.src = p_img.dataset.imgsrc;
                gallery.dataset.index = p_img.dataset.index;
                p_img.classList.add('selected');
            })
        }
    }

    let openGalleryByClickOnMainImage = () => {
        document.getElementById('main-gallery').addEventListener('click', () => {
            let preview = document.getElementsByClassName('preview-img');
            const activeImage = document.querySelector('.preview-img.selected');
            const [firstPart, secondPart] = splitArray(Array.from(preview), activeImage.dataset.index);
            const reorderPreviews = secondPart.concat(firstPart)

            var lightbox = new FsLightbox();
            lightbox.props.sources = reorderPreviews.map((x) => x.dataset.imgsrc);
            lightbox.open();
        })
    }

    let splitArray = (arr, index) => {
        const firstPart = arr.slice(0, index);
        const secondPart = arr.slice(index);
        return [firstPart, secondPart];
    }

    clickOnPreview();
    openGalleryByClickOnMainImage();
});
