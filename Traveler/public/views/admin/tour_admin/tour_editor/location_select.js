const searchBar = document.querySelector('#search-bar');
const searchFiltersArray = searchBar.querySelectorAll('.search-bar-header');
let currentTab = null;
const selectedArray = [null, null];

const searchInputs = [
    searchBar.querySelector('.country-select'),
    searchBar.querySelector('.city-select')
];

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