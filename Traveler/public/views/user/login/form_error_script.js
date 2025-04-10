document.addEventListener("click", function (e) {
    if (e.target.closest(".remove-error")) {
        e.target.closest(".form-error-wrapper").classList.add("hide");
    }
});
