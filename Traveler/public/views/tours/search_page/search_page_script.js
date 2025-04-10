const scrollElement = document.querySelector(".scroll-bar");
const toursList = document.querySelector('.search-page .search-results.small-tour-list');
const selectedCountry =  document.querySelector('.search-bar .country-select').dataset.search ?? null;
const selectedCity =  document.querySelector('.search-bar .city-select').dataset.search ?? null;
let filtersArray = [];

const searchParams = new URLSearchParams(window.location.search);
searchParams.delete("country");
searchParams.delete("city");
let searchGetURL = searchParams.toString();
if (searchGetURL)
    searchGetURL = "?" + searchGetURL;

let isLoading = false;
let hasMore = true;

scrollElement.addEventListener('scroll', (e) => {
    if (toursList.scrollTop + toursList.clientHeight > toursList.scrollHeight - 100)
        loadTours();
});

loadTours();

function loadTours() {
    if (isLoading || !hasMore)
        return;

    let formData = new FormData();

    if (selectedCountry)
        formData.append("country", selectedCountry);
    if (selectedCity)
        formData.append("city", selectedCity);
    filtersArray.forEach((filter) => {
        if (filter.value)
            formData.append(filter.name, filter.value);
    });

    let pageCount = toursList.querySelectorAll(".page").length;
    formData.append("page", pageCount.toString());

    isLoading = true;
    fetch("/tours/json_search", {
        method: "POST",
        body: formData
    }).then(data => data.json()).then((tours) => {
        /*console.log(tours);
        return;*/
        if (tours.length === 0)
            hasMore = false;

        if (tours.length === 0 && pageCount === 0) {
            Message.show("За даним запитом не знайдено турів", Message.negative);
            toursList.querySelector(".placeholder").style.display = "inherit";
        } else
            toursList.querySelector(".placeholder").style.display = "none";

        let page = document.createElement("div");
        page.classList.add("page", "show");

        for (let i = 0; i < tours.length; i++) {
            let tourHTML = `
                    <div class="tour-wrapper">
                        <button class="save-button ${tours[i].is_saved ? 'saved' : ''}" data-tour-id="${tours[i].tour_id}">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#FF8C00" viewBox="0 -960 960 960" ><path d="M480-147q-14 0-28.5-5T426-168l-69-63q-106-97-191.5-192.5T80-634q0-94 63-157t157-63q53 0 100 22.5t80 61.5q33-39 80-61.5T660-854q94 0 157 63t63 157q0 115-85 211T602-230l-68 62q-11 11-25.5 16t-28.5 5Zm-38-543q-29-41-62-62.5T300-774q-60 0-100 40t-40 100q0 52 37 110.5T285.5-410q51.5 55 106 103t88.5 79q34-31 88.5-79t106-103Q726-465 763-523.5T800-634q0-60-40-100t-100-40q-47 0-80 21.5T518-690q-7 10-17 15t-21 5q-11 0-21-5t-17-15Zm38 189Z"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M480-147q-14 0-28.5-5T426-168l-69-63q-106-97-191.5-192.5T80-634q0-94 63-157t157-63q53 0 100 22.5t80 61.5q33-39 80-61.5T660-854q94 0 157 63t63 157q0 115-85 211T602-230l-68 62q-11 11-25.5 16t-28.5 5Z"/></svg>
                            </span>
                        </button>
                        <a class="tour" href="/tours/view/${tours[i].link}${searchGetURL}">
                            <div class="cover">
                                <img src="/files/tours/pictures/${tours[i].photo_list[0]}" alt="slider-photo-4"/>
                            </div>
                            <div class="tour-info">
                                <div class="name-wrapper">
                                    <div class="stars">`;
            for (let j = 0; j < tours[i].stars; j++)
                tourHTML += `<span class="material-symbols-rounded">star</span>`;
            tourHTML +=
                `   
                                    </div>
                                    <div class="name">${tours[i].name}</div>
                                    <div class="description">${tours[i].address}</div>
                                </div>
                                <div class="price-wrapper">
                                    <div class="description">За 1 ніч для 1 туриста від </div>
                                    <div class="price">${tours[i].min_price}</div>
                                </div>
                            </div>
                        </a>
                    </div>
                `;
            page.innerHTML += tourHTML;

            setTimeout(() => page.classList.remove("show"), 300);
        }
        toursList.appendChild(page);
        isLoading = false;
    });
}

function filtersChanged() {
    if (isLoading) {
        setTimeout(() => filtersChanged(), 100);
        return;
    }

    const pages = toursList.querySelectorAll(".page");
    pages.forEach(page => page.classList.add("remove"));
    setTimeout(() => {
        toursList.querySelectorAll(".page").forEach(page => page.remove());
        hasMore = true;
        loadTours();
    }, 300);
}
