document.addEventListener("DOMContentLoaded", () => {
    $('.categories-slider').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        focusOnSelect: true,
        arrows: true,
        responsive: [
            {
                breakpoint: 1400,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 5
                }
            },
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4
                }
            },
            {
                breakpoint: 1100,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 765,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    const makeSelect = document.getElementById('make');
    const modelSelect = document.getElementById('model');
    const yearSelect = document.getElementById('yearMnf');
    const searchButton = document.querySelector('.search-button');

    let handleMakeChange = () => {
        makeSelect.addEventListener('change', () => {
            axios.post(makeSelect.dataset.action, {
                makeId: makeSelect.value,
            })
                .then(resp => {
                    const models = resp.data.models;
                    const years = resp.data.years;
                    modelSelect.innerHTML = '';
                    yearSelect.innerHTML = '';

                    models.forEach((model, index) => {
                        modelSelect.innerHTML += `<option value="${model['id']}" ${index === 0 ? 'selected' : ''}>${model['model']}</option>`
                    });

                    years.forEach((year, yIndex) => {
                        yearSelect.innerHTML += `<option value="${year['id']}" ${yIndex === 0 ? 'selected' : ''}>${year['year']}</option>`
                    });

                    modelSelect.disabled = false;
                    yearSelect.disabled = false;
                    searchButton.disabled = false;
                })
        })
    }

    let handleModelChange = () => {
        modelSelect.addEventListener('change', () => {
            axios.post(modelSelect.dataset.action, {
                'modelId': modelSelect.value
            })
                .then(resp => {
                    const years = resp.data;
                    yearSelect.innerHTML = '';

                    years.forEach((year, index) => {
                        yearSelect.innerHTML += `<option value="${year['id']}" ${index === 0 ? 'selected' : ''}>${year['year']}</option>`
                    });
                })
        });
    }

    handleMakeChange();
    handleModelChange();
});
