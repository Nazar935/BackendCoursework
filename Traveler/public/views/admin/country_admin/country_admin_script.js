document.querySelectorAll(".country-admin .country .delete-button").forEach((button) => {
    button.addEventListener("click", () => {
        const country = button.closest(".country");
        let id = country.dataset.id;

        fetch("/admin/country/", {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                country_id: id
            })
        }).then((data) => data.ok).then((ok) => {
            if (ok) {
                country.remove();
                Message.show("Країну успішно видалено", Message.neutral);
            }
        }).catch((err) => {
            console.log(err);
            Message.show("Помилка при видаленні країни", Message.negative);
        });
    });
});

/*
document.querySelectorAll(".country-admin .country .edit-button").forEach((button) => {
    button.addEventListener("click", () => {
        const country = button.closest(".country");
        let en_name = country.dataset.en_name;

        location.href = "/admin/country/" + en_name;
    })
});*/
