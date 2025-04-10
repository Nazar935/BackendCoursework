

document.querySelectorAll(".booking .delete-button").forEach(button => {
    const booking_id = button.closest('.booking').dataset.bookingId;
    button.addEventListener("click", () => {
        const formData = new FormData();
        formData.append("booking_id", booking_id);
        fetch("/checkout/delete", {
            method: "POST",
            body: formData
        }).then(data => data.ok).then((ok) => {
            location.reload();
        }).catch((err) => {
            Message.show("Помилка під час спроби відмінити бронювання", Message.negative);
        });
    });
});