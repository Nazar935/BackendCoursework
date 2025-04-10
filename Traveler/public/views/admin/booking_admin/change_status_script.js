document.querySelectorAll("button.change-status").forEach(button => {
    const booking_id = button.closest('.booking').dataset.bookingId;
    const status = button.dataset.status;
    button.addEventListener("click", () => {
        const formData = new FormData();
        formData.append("booking_id", booking_id);
        formData.append("status", status);

        fetch("/checkout/change_status", {
            method: "POST",
            body: formData
        }).then(data => data.ok).then((ok) => {
            if (ok)
                location.reload();
        }).catch((err) => {
            Message.show("Помилка при зміні статусу", Message.negative);
        });
    });
});