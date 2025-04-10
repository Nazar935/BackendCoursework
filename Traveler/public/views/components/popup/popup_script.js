class Popup {
    static element = window.document.getElementById("popup");
    static isOpen = false;

    static show(content) {
        this.element.querySelector(".content").innerHTML = content;
        this.element.classList.add("show");
        this.isOpen = true;
        window.addEventListener("keydown", popupKeydown);
    }

    static close() {
        this.isOpen = false;
        this.element.classList.remove("show");
        this.element.classList.add("hide");
        setTimeout(() => this.element.classList.remove("hide"), 500);
        window.removeEventListener("keydown", popupKeydown);
    }
}

Popup.element.addEventListener("click", (e) => {
    if (!e.target.closest("#popup .window") && Popup.isOpen)
        Popup.close();
});

Popup.element.querySelector(".close-button").addEventListener("click", () => Popup.close());

function popupKeydown(e) {
    if (e.key === "Escape") {
        e.preventDefault();
        Popup.close();
    }
}