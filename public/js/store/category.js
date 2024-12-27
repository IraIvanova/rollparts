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
        let form = document.querySelector('#filters-form');

        for (let checkbox of checkboxes) {
                checkbox.addEventListener("click", function (e) {
                    const inputs = document.getElementsByClassName('checkbox');
                    const checked = Array.from(inputs).filter(i => i.checked === true)
                    let searchParams = groupInputsByName(checked);

                    let url = new URL(form.action + '/?');
                    let params = new URLSearchParams(searchParams);

                    location.href = url + params.toString();
                });
        }
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

    hideOrExpandSubCategories();
    applyFilters();
});
