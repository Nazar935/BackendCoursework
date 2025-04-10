document.getElementById("fake-booking-button").addEventListener("click", () => {
    document.getElementById("rooms").scrollIntoView({
        behavior: "smooth"
    });
});

const tourPhotoList = document.getElementById("tour-photo-list");
tourPhotoList.querySelectorAll("button").forEach((button) => {
    button.addEventListener("click", (e) => {
        const imgArray = tourPhotoList.querySelectorAll("img");
        const targetImg = e.target.closest("button").querySelector("img");
        const photoArray = [];
        let photoIndex = 0;

        imgArray.forEach((photo, index) => {
            photoArray.push(photo.src);
            if (photo.src === targetImg.src)
                photoIndex = index;
        });

        show_slider(photoArray, photoIndex);
    });
});

document.querySelector(".tour-view .info-header .share").addEventListener("click", () => {
    const url = window.location.origin + window.location.pathname;
    navigator.clipboard.writeText(url).then(() => {
        Message.show("Посилання скопійовано в буфер обміну", Message.positive);
    }).catch(() => {
        Message.show("Помилка при спробі копіювання", Message.negative);
    });
});
