const searchBar = document.querySelector('#search-bar');
const searchFiltersArray = searchBar.querySelectorAll('.search-bar-header');
let currentTab = null;
const selectedArray = [null, null, null];

const searchInputs = [
    searchBar.querySelector('.date-input'),
    searchBar.querySelector('.days-input'),
    searchBar.querySelector('.tourists-input')
];

//

//

function changeSelected(i, selected, selected_eng = null, animated = true) {
    i -= 2;
    searchInputs[i].dataset.value = selected.toString().replaceAll("/", "-");

    if (searchInputs[i].classList.contains('days-input'))
        selected = daysToString(selected);
    if (searchInputs[i].classList.contains('tourists-input'))
        selected = touristsToString(selected);

    if (animated) {
        closeTab(currentTab);
        if (searchInputs[i] !== searchInputs[searchInputs.length - 1])
            setTimeout(() => {
                openTab(searchInputs[i + 1]);
            }, 300);
    }

    searchInputs[i].querySelector(".search-bar-header .text").textContent = selected;
}


searchBar.querySelector(".search-button button").onclick = () => search();
function search() {
    const searchParams = new URLSearchParams();
    for (let i = 0; i < searchInputs.length; i++) {
        const value = searchInputs[i].dataset.value ?? null;
        const name = searchInputs[i].dataset.name;
        if (value)
            searchParams.append(name, value);
    }

    location.replace(window.location.pathname + "?" + searchParams.toString() + "#rooms");
}

document.querySelectorAll(".search-bar > *").forEach((element, i) => {
    if ('search' in element.dataset) {
        const value = element.dataset.search;

        if (element.classList.contains("select")) {
            const buttonsArray = element.querySelectorAll(".option");
            for (let j = 0; j < buttonsArray.length; j++)
                if (buttonsArray[j].dataset.option === value) {
                    changeSelected(i, buttonsArray[j].querySelector(".text").textContent , value, false);
                    buttonsArray[j].classList.add("selected");
                    break;
                }
        } else if (element.classList.contains("date-input")) {
            const year = parseInt(value.substring(6, 10));
            const month = parseInt(value.substring(3, 5));
            const day = parseInt(value.substring(0, 2));
            selectedDate = new Date(year, month - 1, day);
            changeSelected(i + 2, value.replaceAll("-", "/"), null, false);
        } else {
            changeSelected(i + 2, value, null, false);
            searchBar.children[i].querySelector(".number-input input").value = value;
        }
    }

});
