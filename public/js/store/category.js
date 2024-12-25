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

    hideOrExpandSubCategories();
});
