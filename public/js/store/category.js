document.addEventListener("DOMContentLoaded", () => {
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



    let getSelectedCheckboxAndSorting = () => {
        let form = document.getElementById('filters-form');
        const inputs = document.getElementsByClassName('checkbox');
        const prices = document.getElementsByClassName('inputs');
        const checked = Array.from(inputs).filter(i => i.checked === true)
        let searchParams = groupInputsByName(checked);
        searchParams['carModels'] = document.getElementById('carModelsValue').value.split(',');

        let url = new URL(form.action + '/?');
        let params = new URLSearchParams(searchParams);
        params.set('sortby', document.getElementById('orderby').value);
        params.set('min', prices[0].value);
        params.set('max', prices[1].value);

        console.log(url, checked)

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

    let toggleFiltersOnMobile = () => {
        const filterHeader = document.getElementById('filterHeader');
        const filterContent = document.getElementById('filterContent');
        const toggleIcon = filterHeader.querySelector('.toggle-icon');

        // Toggle the filter content visibility
        filterHeader.addEventListener('click', () => {
            filterContent.classList.toggle('active');
            toggleIcon.classList.toggle('rotate');
        });
    }

    const rangeInputs = document.querySelectorAll(".range-inputs");
    const priceInputs = document.querySelectorAll(".inputs");
    const rangeProgress = document.querySelector(".progress");
    const priceGap = 1; // Minimum gap between min and max prices

    // Initialize progress bar position
    updateRangeProgress();

    // Add event listeners for price inputs
    priceInputs.forEach((input) => {
        input.addEventListener("input", handlePriceInput);
    });

    // Add event listeners for range inputs
    rangeInputs.forEach((input) => {
        input.addEventListener("input", handleRangeInput);
    });

    // Function to update the progress bar based on input values
    function updateRangeProgress() {
        const minPrice = parseInt(priceInputs[0].value, 10);
        const maxPrice = parseInt(priceInputs[1].value, 10);
        const maxRange = parseInt(rangeInputs[1].max, 10);

        // Calculate progress based on min and max values, dynamically adjusting positions
        const leftPercent = (minPrice / maxRange) * 100;
        const rightPercent = 100 - (maxPrice / maxRange) * 100;

        rangeProgress.style.left = leftPercent + "%";
        rangeProgress.style.right = rightPercent + "%";
    }

    // Handle input from price fields
    function handlePriceInput(e) {
        const minPrice = parseInt(priceInputs[0].value, 10);
        const maxPrice = parseInt(priceInputs[1].value, 10);
        const maxRange = parseInt(rangeInputs[1].max, 10);

        if (maxPrice - minPrice >= priceGap && maxPrice <= maxRange) {
            if (e.target.classList.contains("input-min")) {
                rangeInputs[0].value = minPrice;
            } else {
                rangeInputs[1].value = maxPrice;
            }
            updateRangeProgress();
        }
    }

    // Handle input from range sliders
    function handleRangeInput(e) {
        const minVal = parseInt(rangeInputs[0].value, 10);
        const maxVal = parseInt(rangeInputs[1].value, 10);

        if (maxVal - minVal < priceGap) {
            if (e.target.classList.contains("range-min")) {
                rangeInputs[0].value = maxVal - priceGap;
            } else {
                rangeInputs[1].value = minVal + priceGap;
            }
        } else {
            priceInputs[0].value = minVal;
            priceInputs[1].value = maxVal;
            updateRangeProgress();
        }
    }

    let sortByPrice = () => {
        let select = document.getElementById('pf-button');

        select.addEventListener('click', (e) => {
            location.href = getSelectedCheckboxAndSorting();
        })
    }

    sortByPrice();
    hideOrExpandSubCategories();
    applyFilters();
    sortProducts();
    toggleFiltersOnMobile();
});
