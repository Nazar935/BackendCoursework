const booking = document.querySelector(".booking");

booking.addEventListener('click', (e) => {
    const button = e.target.closest(".open-slider");
    if (button) {
        const photoArray = [];
        button.querySelectorAll("img").forEach((img) => {
            photoArray.push(img.src);
        });
        show_slider(photoArray, 0);
    }
});

const selectedOptions = [];
const roomIdArray = [];
document.querySelectorAll(".booking .select").forEach((select, i) => {
    selectedOptions.push(0);
    roomIdArray.push(select.dataset.roomId);
    select.querySelectorAll(".option").forEach((option) => {
        option.addEventListener("click", () => {
            selectedOptions[i] = option.dataset.optionId;
            updateRoomsCheckout();
        });
    });
});

let totalCapacity = 0;
function updateRoomsCheckout() {
    let roomNames = "";
    totalCapacity = 0;
    let totalPrice = 0;

    document.querySelectorAll(".booking .rooms-table tbody tr").forEach((room, i) => {
        if (selectedOptions[i] !== 0) {
            const name = room.querySelector(".name-field .name").textContent;
            roomNames += `
                <div class="room">
                    <span>${selectedOptions[i]}</span>
                    <span class="material-symbols-rounded cross-icon">close</span>
                    <span class="name">${name}</span>
                </div>
            `;

            const capacity = parseInt(room.querySelector(".capacity .text").textContent) * selectedOptions[i];
            totalCapacity += capacity;

            const price = parseInt(room.querySelector(".price").dataset.price) * selectedOptions[i];
            totalPrice += price;
        }
    });

    const checkout = document.querySelector(".booking .rooms-table tfoot");
    checkout.querySelector(".total-count .rooms").innerHTML = roomNames;
    checkout.querySelector(".total-capacity .text").innerHTML = totalCapacity;
    checkout.querySelector(".total-price .price").innerHTML = "UAH " + totalPrice.toLocaleString("en-US", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

document.querySelector(".booking .rooms-table tfoot .checkout").addEventListener("click", () => {
    const tourId = booking.dataset.tourId;
    const checkoutUrlParams = new URLSearchParams();

    const UrlSearchParams = new URLSearchParams(window.location.search);
    checkoutUrlParams.set("tour_id", tourId);

    const touristsParam = parseInt(UrlSearchParams.get("tourists") ?? 1);

    if (!UrlSearchParams.has("date")) {
        const date = new Date();
        const day = String(date.getDate()).padStart(2, "0");
        const month = String(date.getMonth() + 1).padStart(2, "0");
        const year = date.getFullYear();
        const formattedDate = `${day}-${month}-${year}`;

        checkoutUrlParams.set("date", formattedDate);
    } else {
        checkoutUrlParams.set("date", UrlSearchParams.get("date"));
    }
    checkoutUrlParams.set("days", UrlSearchParams.get("days") ?? 3);


    checkoutUrlParams.set("tourists", touristsParam.toString());

    let roomsIdParams = [];
    for (let i = 0; i < roomIdArray.length; i++)
        if (selectedOptions[i] > 0)
            roomsIdParams.push(`&room_id[]=${roomIdArray[i]}&room_count[]=${selectedOptions[i]}`);

    if (roomsIdParams.length === 0) {
        Message.show("Ви не обрали жодного номер", Message.negative);
        return;
    }
    if (totalCapacity < touristsParam) {
        Message.show("Ви обрали недостатню кількість номерів щоб помістити вашу компанію", Message.negative);
        return;
    }



    location.href = "/checkout/new?" + checkoutUrlParams + roomsIdParams.join("");
});