document.querySelectorAll(".search-bar .select").forEach((select, i) => {
    const selectHeader = select.querySelector(".search-bar-header");
    const selectDropDown = select.querySelector(".drop-down");

    selectHeader.addEventListener("click", () => {
        if (select.dataset.active === "true") {
            closeSelect(select);
            return;
        }
        select.dataset.active = "true";
        selectHeader.classList.add("open");
        selectDropDown.classList.remove('hide');
        setTimeout(() => {
            selectDropDown.classList.add('active');
        }, 25);
    });

    window.addEventListener("click", (e) => {
        if (e.target.closest(".select") !== select)
            closeSelect(select);
    });


});

function closeSelect(select) {
    if (select.dataset.active === "false")
        return;

    select.dataset.active = "false";
    const selectHeader = select.querySelector(".search-bar-header");
    const selectDropDown = select.querySelector(".drop-down");

    selectHeader.classList.remove("open");
    selectDropDown.classList.remove('active');
    setTimeout(() => {
        selectDropDown.classList.add('hide');
    }, 300);
}

document.querySelectorAll(".search-bar .select").forEach((select) => {
    const selectOptions = select.querySelectorAll(".option");
    selectOptions.forEach((option) => {
        if (select.dataset.selectedId === option.dataset.optionId)
            selectOption(select, option);
        option.addEventListener("click", () => {
            selectOption(select, option);
            setTimeout(() => closeSelect(select), 100);
        });
    });
});

function selectOption(select, option) {
    select.querySelectorAll(".option").forEach((tempOption) => {
        if (tempOption.dataset.optionId === select.dataset.selectedId)
            tempOption.classList.remove("selected");
        if (tempOption.dataset.optionId === option.dataset.optionId) {
            tempOption.classList.add("selected");
            select.querySelector(".search-bar-header .text").textContent = option.dataset.optionName;
        }

    });
    select.dataset.selectedId = option.dataset.optionId;
}

