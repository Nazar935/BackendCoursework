const starSelect = new StarSelect(document.querySelector("#star-select"), filtersChanged);
const priceFilter = new PriceFilter(document.querySelector("#price-filter"), filtersChanged);
const tourFacilitiesSelect = new FacilitiesSelect(document.querySelector("#tour-facilities"), filtersChanged, "tour_facilities");
const roomFacilitiesSelect = new FacilitiesSelect(document.querySelector("#room-facilities"), filtersChanged, "room_facilities");
filtersArray.push(starSelect, priceFilter, tourFacilitiesSelect, roomFacilitiesSelect);

filtersArray.forEach((filter) => {
    filter.element.closest(".filter").querySelector(".clear").addEventListener("click", (e) => {
        filter.clear();
    });
});

document.querySelector(".filters .clear-all").addEventListener("click", (e) => {
    filtersArray.forEach(filter => {
        filter.clear();
    });
});