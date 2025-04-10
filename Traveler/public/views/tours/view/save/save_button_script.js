document.addEventListener('click', function(e) {
    if (e.target.closest('.save-button')) {
        const saveButton = e.target.closest('.save-button');

        const tourId = saveButton.dataset.tourId;
        console.log(tourId);

        const formData = new FormData();
        formData.append("tour_id", tourId);

        fetch("/tours/save", {
            method: "POST",
            body: formData
        }).then((response) => response.ok).then((ok) => {
            if (!ok)
                Message.show('Для збереження потрібно зареєструватися', Message.negative);
            else if (saveButton.classList.contains("saved")) {
                saveButton.classList.remove("saved");
                Message.show('Видалено зі списку "Збережено"', Message.negative);
            }
            else {
                saveButton.classList.add("saved");
                Message.show('Додано до списку "Збережено"', Message.neutral);
            }
        });
    }
});