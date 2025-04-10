document.querySelectorAll(".search-bar .select").forEach((select, i) => {
    const selectButtonsArray = select.querySelectorAll(".options button");
    selectButtonsArray.forEach((button) => {
        button.addEventListener("click", () => {
            if (selectedArray[i] !== null) {
                removeSelected(i);
                for (let j = 0; j < selectButtonsArray.length; j++)
                    if (selectButtonsArray[j].dataset.option === selectedArray[i]) {
                        if (selectButtonsArray[j] === button) {
                            setTimeout(() => {
                                closeTab(currentTab);
                                changeSelected(i, null);
                            }, 50);
                            return;
                        }
                        break;
                    }
            }

            button.classList.add("selected");
            setTimeout(() => {
                //closeTab(currentTab);
                changeSelected(i, button.querySelector(".text").textContent, button.dataset.option);
            }, 50);
        })
    });
});

const noCountryElement = document.querySelector(".search-bar .city-select .no-country");
const cityElement = document.querySelector(".search-bar .city-select .drop-menu");

function openCityTab() {
    for (let i = 0; i < cityElement.children.length; i++)
        cityElement.children[i].classList.add("hidden-options");

    if (selectedArray[0]) {
        for (let i = 0; i < cityElement.children.length; i++)
            if (cityElement.children[i].dataset.country === selectedArray[0]) {
                cityElement.children[i].classList.remove('hidden-options');
            }
    } else {
        noCountryElement.classList.remove('hidden-options');
    }
}

function removeSelected(i) {
    const select = document.querySelector(`.search-bar .select:nth-child(${i + 1})`);
    const selectButtonsArray = select.querySelectorAll(".options button");

    for (let j = 0; j < selectButtonsArray.length; j++)
        if (selectButtonsArray[j].dataset.option === selectedArray[i]) {
            selectButtonsArray[j].classList.remove('selected');
            break;
        }
}