const countrySelect = document.getElementById("country_select");
const citySelects = document.querySelectorAll(".city-select");
citySelects[0].classList.remove("hide");
citySelects[0].disabled = "";

countrySelect.onchange = function() {
    for (let i = 0; i < citySelects.length; i++)
        if (citySelects[i].dataset.countryId === countrySelect.value) {
            citySelects[i].classList.remove("hide");
            citySelects[i].disabled = "";
        }
        else {
            citySelects[i].classList.add("hide");
            citySelects[i].disabled = "disabled";
        }
}

const roomsTable = document.getElementById("rooms-table");
document.getElementById("add-room-button").onclick = function () {
    let roomsCount = roomsTable.querySelectorAll("tbody tr").length;

    let tr = document.createElement("tr");
    tr.innerHTML = `
        <td>
                                    <div>
                                        <div class="name">
                                            <input name="room_name[]">
                                        </div>
                                        <div class="description">
                                            <textarea name="room_description[]"></textarea>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <input name="room_photo_list[${roomsCount}][]" type="file" multiple>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="capacity">
                                            <span>
                                                <input name="room_capacity[]" type="number">
                                            </span>
                                            <span class="material-symbols-rounded cross-icon">close</span>
                                            <span class="material-symbols-rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240Zm80 0h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>
                                </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="room-facilities">
                                            <?php foreach ($roomFacilities as $facility) : ?>
                                                <div class="facility">
                                                    <label >
                                                        <input name="room_facilities[${roomsCount}][]" value="<?= $facility['facility_id']?>" type="checkbox">
                                                        <span class="icon-wrapper">
                                                            <img src="/files/static/facilities/<?= $facility['icon']?>" alt="<?= $facility['icon']?>">
                                                        </span>
                                                        <span class="text"><?= $facility['name']?></span>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="price">
                                            UAH
                                            <input name="room_price[]" type="text">
                                        </div>
                                    </div>
                                </td>
                                <td class="count-td">
                                    <div class="count">
                                        Кількість кімнат:
                                        <input name="room_count[]" type="number"/>
                                    </div>
                                    <div class="edit">
                                        <button type="button" class="room-delete-button">Del</button>
                                    </div>
                                </td>
    `;
    roomsTable.querySelector("tbody").appendChild(tr);
}

roomsTable.addEventListener("click", (e) => {
    if (e.target.classList.contains("room-delete-button")) {
        e.target.closest("tr").remove();
    }
});

new StarSelect(document.getElementById("star-select"));
new FacilitiesSelect(document.getElementById("tour-facilities"))
