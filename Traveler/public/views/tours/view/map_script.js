const hotelLocation = [`<?= $tour['location_longitude'] ?>`, `<?= $tour['location_latitude'] ?>`];

const map = L.map("map-component").setView(hotelLocation, 8);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "&copy; OpenStreetMap contributors"
}).addTo(map);

const customIcon = L.icon({
    iconUrl: "/files/static/pin.svg",
    iconSize: [40, 40],
    iconAnchor: [20, 40],
    popupAnchor: [0, -40]
});

L.marker(hotelLocation, { icon: customIcon }).addTo(map)
    .bindPopup(`
                <div class="custom-popup">
                    <img src="/files/tours/pictures/<?= $tour['photo_list'][0] ?>"/>
                    <div class="popup-right">
                        <div class="name"><?= $tour['name'] ?></div>
                        <div class="stars">
                            <?php for ($i = 0; $i < $tour['stars']; $i++) : ?>
                                <span class="material-symbols-rounded">star</span>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            `, { className: "custom-popup-wrapper" })
    .openPopup();

