document.addEventListener("change", function (e) {
    if (e.target.type !== "file")
        return;

    let input = e.target;
    input.closest(".display-wrapper").querySelector("i").textContent = "edit";
    input.closest(".image-wrapper").classList.add("hide-controllers");

    let displayTarget = input.closest(".image-wrapper").querySelector(".bg .display-target");
    displayTarget.style.display = "inherit";
    input.closest(".image-wrapper").querySelector(".bg .src-target").src = URL.createObjectURL(input.files[0]);

    if (displayTarget.nodeName === "VIDEO") {
        displayTarget.load();
    }
});