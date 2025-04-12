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
            modelSelect.innerHTML = '<option value="" selected disabled>Select model</option>';//todo server request
            yearSelect.innerHTML = '<option value="" selected disabled>Select engine</option>';
            yearSelect.disabled = true;
            searchButton.disabled = true;
        })
    }

    let handleModelChange = () => {
        // Reset engine select
        yearSelect.innerHTML = '<option value="" selected disabled>Select engine</option>';
        searchButton.disabled = true;

        const selectedMake = makeSelect.value;
        const selectedModel = modelSelect.value;

        if (selectedMake && selectedModel && carDatabase[selectedMake][selectedModel]) {
            // Enable engine select
            yearSelect.disabled = false;

            // Add engine options
            const engines = carDatabase[selectedMake][selectedModel];
            engines.forEach(engine => {
                const option = document.createElement('option');
                option.value = engine;
                option.textContent = engine;
                yearSelect.appendChild(option);
            });
        }
    }


    handleMakeChange();
    handleModelChange();
});
