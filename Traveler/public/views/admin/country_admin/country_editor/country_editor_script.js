document.querySelector(".country-editor .add-city").addEventListener("click", function () {
    const citiesElement = document.querySelector(".country-editor .cities");
    const cityCount = citiesElement.children.length;

    const newCity = document.createElement("div");
    newCity.classList.add("city");
    newCity.innerHTML = `
        <div class="display-wrapper file-input small">
            <div class="image-wrapper">
                <label for="city-${cityCount}" class="hide">
                    <i class="material-icons">add_photo_alternate</i>
                    <input class="city-flag" id="city-${cityCount}" name="city_flag[]" type="file" accept="image/svg+xml"/>
                </label>
                <div class="bg">
                    <div class="filter"></div>
                    <img class="src-target display-target" src="" alt="cover" style="display: none"/>
                </div>
            </div>
        </div>
        
        <div class="middle">
            <input class="city-name" type="text" name="city_name[]" placeholder="Назва (UA)" autocomplete="off" spellcheck="false"/>
            <div class="input-wrapper input-with-icon">
                <span class="icon">/</span>
                <input class="city-link" type="text" name="city_link[]" placeholder="Назва (EN)" autocomplete="off" spellcheck="false"/>
            </div>
        </div>
        
        <div class="button-wrapper">
            <button type="button" class="city-delete">
                <i class="material-icons">delete</i>
            </button>
        </div>
    `;

    citiesElement.appendChild(newCity);
});

document.querySelector(".country-editor .cities").addEventListener("click", function (e) {
    if (e.target.closest("button.city-delete"))
        e.target.closest(".city").remove();
});

const countryForm = document.getElementById("country-form");
countryForm.addEventListener("submit", async function (e) {
    e.preventDefault();
    const ua_name = countryForm.querySelector("#ua_name").value;
    const en_name = countryForm.querySelector("#en_name").value;
    const en_name_previous_value = countryForm.querySelector("#en_name").dataset.previousValue ?? null;

    const flag = countryForm.querySelector("#flag").files[0] ?? null;
    const pattern = countryForm.querySelector("#pattern").files[0] ?? null;
    const video = countryForm.querySelector("#video").files[0] ?? null;
    const cover = countryForm.querySelector("#cover").files[0] ?? null;

    const serverFlag = countryForm.querySelector("#server-flag");
    const serverPattern = countryForm.querySelector("#server-pattern");
    const serverVideo = countryForm.querySelector("#server-video");
    const serverCover = countryForm.querySelector("#server-cover");

    const cityArray = [...countryForm.querySelectorAll(".cities .city")];

    if (validText(ua_name, "Назва українською", 50) &&
        validText(en_name, "Назва англійською", 50) &&
        await validUniq("Country", "en_name", en_name, en_name_previous_value, "Назва англійською") &&
        validFile(flag, "Прапор", "image/svg+xml", 10 * 1024, serverFlag) &&
        validFile(pattern, "Паттерн", "image/*", 100 * 1024, serverPattern) &&
        validFile(video, "Відео", "video/*", 50 * 1024 * 1024, serverVideo) &&
        validFile(cover, "Обкладинка", "image/*", 5 * 1024 * 1024, serverCover) &&
        await validCitiArray(cityArray))
        countryForm.submit();
});

function validText(text, fieldName, maxLength)
{
    if (text.length === 0)
        Message.show(`Поле "${fieldName}" пусте`, Message.negative);
    else if (text.length > maxLength)
        Message.show(`Поле "${fieldName}" не має бути довше ${maxLength} символів`, Message.negative);
    else
        return true;
    return false;
}

function validFile(file, fieldName, type, maxSize, serverValue) {
    if (!file && !serverValue)
        Message.show(`Додайте файл у поле "${fieldName}"`, Message.negative);
    else if (serverValue && !file)
        return true;
    else if (!file.type.startsWith(type.substring(0, type.length - 1)))
        Message.show(`Файл у полі "${fieldName}" повинен бути типу: ${type}`, Message.negative);
    else if (file.size > maxSize)
        Message.show(`Файл у полі "${fieldName}" не повинен перевищувати ${sizeToStr(maxSize)} `, Message.negative);
    else
        return true;
    return false;
}

function sizeToStr(size)
{
    const sizeNameArray = ["Б", "Кб", "Мб", "Гб"];

    for (let i = 0; i < sizeNameArray.length; i++) {
        if ((size >= Math.pow(1024, i)) && (size < Math.pow(1024, i + 1)))
            return `${size / Math.pow(1024, i)} ${sizeNameArray[i]}`;
    }
    return "err: too large";
}

async function validCitiArray(cityArray) {
    if (cityArray.length === 0) {
        Message.show("Країна повинна мати хоча б одне місто", Message.negative);
        return false
    } else {
        for (let i = 0; i < cityArray.length; i++)
            if (!await validCity(cityArray[i], i + 1))
                return false;
    }
    return true;
}

async function validCity(city, i) {
    let cityFlag = city.querySelector(".city-flag").files[0] ?? null;
    const serverCityFlag = city.querySelector(".server-city-flag");
    const cityName = city.querySelector(".city-name").value;
    const cityLink = city.querySelector(".city-link").value;
    const cityLinkPreviousValue = city.querySelector(".city-link").dataset.previousValue;

    if (!await validUniq("City", "link", cityLink, cityLinkPreviousValue, "Назва міста (EN)"))
        return false;
    if (!validFile(cityFlag, `Прапор міста №${i}`, 'image/svg+xml', 10 * 1024, serverCityFlag))
        return false;
    if (!validText(cityName, `Назва (UA) міста №${i}`, 64))
        return false;
    if (!validText(cityLink, `Назва (EN) міста №${i}`, 64))
        return false;

    return true;
}

async function validUniq(table, column, value, previousValue, columnName) {
    if (value === previousValue)
        return true;

    const formData = new FormData();

    formData.append("table", table);
    formData.append("column", column);
    formData.append("value", value);

    let json = await fetch("/api/is_unique", {
        method: "POST",
        body: formData
    });

    const res = await json.json();
    if (!res)
        Message.show(`Поле "${columnName}" повинно мати унікальне значення`, Message.negative);

    return res;
}

