document.querySelectorAll(".save-button").forEach(button => {
    button.addEventListener("click", (e) => {
        button.closest(".tour-wrapper").remove();
    });
});

const blockButton = document.querySelector(".block-button");
if (blockButton) {
    blockButton.addEventListener("click", (e) => {
        const formData = new FormData();
        formData.append("user_id", blockButton.dataset.userId);
        fetch("/user/block", {
            method: "POST",
            body: formData
        }).then(data => data.text()).then((data) => {
            location.reload();
        });
    });
}