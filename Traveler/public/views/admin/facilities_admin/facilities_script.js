document.getElementById("tour-facility-add-button").addEventListener("click", function() {
    const facilityData = [
        '/facility/add/tour_facility',
        'Додати до зручностей готелю'
    ];
    showFacilityEditor(...facilityData);
});

document.querySelectorAll(".tour-facility").forEach((facility) => {
    facility.querySelector(".edit-button").addEventListener("click", function() {
        const facilityData = [
            '/facility/edit/tour_facility',
            'Змінити зручність готелю',
            facility.dataset.id,
            facility.dataset.name,
            "/files/facilities/" + facility.dataset.iconPath
        ];
        showFacilityEditor(...facilityData);
    });

    facility.querySelector(".delete-button").addEventListener("click", function() {
        const formData = new FormData();
        formData.append("facility_id", facility.dataset.id);

        fetch("/facility/delete/tour_facility", {
            method: "POST",
            body: formData
        }).then((data) => data.ok).then((ok) => {
            if (ok)
                location.replace("/admin");
        });
    });
});

document.getElementById("room-facility-add-button").addEventListener("click", function() {
    const facilityData = [
        '/facility/add/room_facility',
        'Додати до зручностей кімнати'
    ];
    showFacilityEditor(...facilityData);
});

document.querySelectorAll(".room-facility").forEach((facility) => {
    facility.querySelector(".edit-button").addEventListener("click", function() {
        const facilityData = [
            '/facility/edit/room_facility',
            'Змінити зручність кімнати',
            facility.dataset.id,
            facility.dataset.name,
            "/files/facilities/" + facility.dataset.iconPath
        ];
        showFacilityEditor(...facilityData);
    });

    facility.querySelector(".delete-button").addEventListener("click", function() {
        const formData = new FormData();
        formData.append("facility_id", facility.dataset.id);

        fetch("/facility/delete/room_facility", {
            method: "POST",
            body: formData
        }).then((data) => data.ok).then((ok) => {
            if (ok)
                location.replace("/admin");
        });
    });
});

function showFacilityEditor(form_action, header, id = "", name = "", icon_path = "") {
    let popupContent = `
        <form class="facility-popup" method="POST" action="${form_action}" enctype="multipart/form-data" onsubmit="formSubmit(this, event)">
            <h2>${header}</h2>
            <div class="new-facility">
                <div class="display-wrapper file-input small">`;

    if (icon_path)
        popupContent += `
            <div class="image-wrapper hide-controllers">
                <label for="new-tour-facility-img" class="hide">
                    <i class="material-icons">edit</i>
                    <input id="new-tour-facility-img" name="facility_icon" type="file"/>
                </label>
                <div class="bg">
                    <div class="filter"></div>
                    <img class="src-target display-target" src="${icon_path}" alt="<?= $country['en_name']?>-cover"/>
                </div>
            </div>
        `
    else
        popupContent += `
            <div class="image-wrapper">
                <label for="new-tour-facility-img" class="hide">
                    <i class="material-icons">add_photo_alternate</i>
                    <input id="new-tour-facility-img" name="facility_icon" type="file"/>
                </label>
                <div class="bg">
                    <div class="filter"></div>
                    <img class="src-target display-target" src="" alt="icon" style="display: none"/>
                </div>
            </div>
        `

    popupContent += `
                </div>
                <div class="input-wrapper">
                    <input class="text-input" value="${name}" type="text" name="facility_name" placeholder="Назва" autocomplete="off" spellcheck="false"/>
                </div>
                <input name="facility_id" value="${id}" style="display: none">
            </div>
            <div class="form-error-wrapper hide" id="form-error">
                <div class="error">
                    <i>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" ><path d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240Zm40 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                    </i>
                    <div class="text-wrapper">
                        Error
                    </div>
                </div>
                <div class="button-wrapper">
                    <button type="button" class="remove-error">
                        <i class="material-icons">close</i>
                    </button>
                </div>
            </div>
            <button class="accent-button">
                <span>Зберегти</span>
                <i class="material-icons">task_alt</i>
            </button>
        </form>
    `;

    Popup.show(popupContent);
}

function formSubmit(form, e) {
    const file_input = form.querySelector("input[type=file]");
    const text_input = form.querySelector("input[type=text]");

    if (!(file_input.files && file_input.files[0]))
        showError(form, "Додайте іконку");
    else if (file_input.files[0].type !== "image/svg+xml")
        showError(form, "Іконка має бути .svg");
    else if (file_input.files[0].size / 1024 > 10)
        showError(form, "Іконка має бути <= 10 Кб");
    else if (text_input.value.length === 0)
        showError(form, "Додайте назву");
    else if (text_input.value.length > 256)
        showError(form, "Назва перевищує 256 символів");
    else
        return;
    e.preventDefault();
}

function showError(form, text) {
    const errorElement = form.querySelector(".form-error-wrapper");
    if (errorElement) {
        errorElement.classList.remove("hide");
        errorElement.querySelector(".text-wrapper").textContent = text;
    }
}