const searchBar = document.querySelector('#search-bar');
const searchFiltersArray = searchBar.querySelectorAll('.search-bar-header');
let currentTab = null;
const selectedArray = [null, null, null, null, null];
const searchHeaders = ['Країна', 'Місто', 'Дата', 'Дні', 'Туристи'];
const searchEngHeaders = ['country', 'city', 'date', 'days', 'tourists']

function changeSelected(i, selected, selected_eng = null, animated = true) {
    if (i === 0) {
        removeSelected(1);
        changeSelected(1, null, null, false);
    }


    if (!selected) {
        selectedArray[i] = null;
        //searchBar.children[i].querySelector('.selected').classList.remove('selected');
        searchBar.children[i].querySelector(".search-bar-header .text").textContent = searchHeaders[i];
        searchBar.children[i].querySelector(".clear").classList.add('hide');
        return;
    }

    if (selected_eng) {
        selectedArray[i] = selected_eng;
    }
    else
        selectedArray[i] = selected;

    if (i === 3)
        selected = daysToString(selected);
    else if (i === 4)
        selected = touristsToString(selected);

    if (animated) {
        closeTab(currentTab);
        if (i < 4) {
            setTimeout(() => {
                openTab(searchBar.children[i + 1]);
            }, 300);
        }
    }


    /*if ((i === 3 || i === 4) && !("edited" in searchBar.children[i].querySelector("input").dataset))
        return;*/
    searchBar.children[i].querySelector(".search-bar-header .text").textContent = selected;
    searchBar.children[i].querySelector(".clear").classList.remove('hide');
}

function search() {
    const searchParams = new URLSearchParams();
    for (let i = 0; i < selectedArray.length; i++)
        if (selectedArray[i])
            if (i === 2) {
                searchParams.append(searchEngHeaders[i], selectedArray[i].replaceAll("/", "-"));
            } else
                searchParams.append(searchEngHeaders[i], selectedArray[i]);

    location.replace("/tours/search?" + searchParams.toString());
}


searchBar.querySelector(".search-button button").addEventListener("click", () => {
    search();
});

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
            changeSelected(i, value.replaceAll("-", "/"), null, false);
        } else {
            changeSelected(i, value, null, false);
            searchBar.children[i].querySelector(".number-input input").value = value;
        }
    }

});

document.querySelectorAll(".search-bar .drop-down .clear").forEach((clearButton, i) => {
    clearButton.addEventListener("click", () => {
        changeSelected(i, null);
        const selected = searchBar.children[i].querySelector(".selected");
        //console.log(selected);
        if (selected) {
            selected.classList.remove('selected');
            if (selected.closest(".date-picker"))
                selectedDate = null;
        }

        closeTab(currentTab);
    })
})

