searchFiltersArray.forEach((header) => {
    header.addEventListener('click', (e) => {
        const tab = header.parentElement;

        if (currentTab !== tab)
            openTab(tab);
        else
            closeTab(tab);
    });
});

window.addEventListener('click', (e) => {
    if (currentTab && !currentTab.contains(e.target)) {
        if (currentTab.classList.contains("number-select")) {
            const input = currentTab.querySelector("input");
            let value = checkValue(input, 0);

            value = value.toString();
            input.value = value;

            if (input.dataset.edited === "true") {
                const searchBarHeader = currentTab.querySelector(".search-bar-header");
                for (let i = 0; i < searchFiltersArray.length; i++)
                    if (searchBarHeader === searchFiltersArray[i])
                        if (input.closest(".days-input"))
                            changeSelected(3, value, null, false);
                        else
                            changeSelected(4, value, null, false);
            }
        }
        closeTab(currentTab);
    }
});

function openTab(tab) {
    if (tab !== null) {
        if (tab.classList.contains("city-select"))
            openCityTab();

        tab.querySelector(".search-bar-header").classList.add("open");
        tab.querySelector(".drop-down").classList.remove('hide');
        setTimeout(() => {
            tab.querySelector(".drop-down").classList.add('active');
        }, 25);
    }

    if (currentTab && currentTab !== tab)
        closeTab(currentTab);

    currentTab = tab;
}

function closeTab(tab) {
    if (tab !== null) {
        tab.querySelector(".search-bar-header").classList.remove("open");
        tab.querySelector(".drop-down").classList.remove('active');
        setTimeout(() => {
            tab.querySelector(".drop-down").classList.add('hide');
        }, 300);
    }

    if (currentTab === tab) {
        currentTab = null;
    }

}