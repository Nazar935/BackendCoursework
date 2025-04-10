class StarSelect {
    value = null;
    constructor(element, callback_function = null, name = "stars") {
        this.name = name;
        this.element = element;
        this.input = element.querySelector("input");

        this.buttons = Array.from(element.querySelectorAll("button"));

        for (let i = 2; i < this.buttons.length + 1; i++) {
            this.buttons[i - 1].addEventListener("click", (e) => {
                this.changeValue(i);
            });
        }

        this.callback_function = callback_function;
        if (this.input.value)
            this.changeValue(parseInt(this.input.value))
    }

    changeValue(value) {
        value = Math.ceil(Math.min(5, Math.max(2, value)));
        if (this.value === value) {
            this.clear();
            return;
        }

        this.value = value;
        this.input.value = value;

        for (let i = 0; i < 5; i++) {
            if (i < value)
                this.buttons[i].classList.add("selected");
            else
                this.buttons[i].classList.remove("selected");
        }

        if (this.callback_function)
            this.callback_function();
    }

    clear(value) {
        if (!this.value)
            return;
        this.value = null;
        this.input.value = "";
        for (let i = 0; i < 5; i++)
            this.buttons[i].classList.remove("selected");

        if (this.callback_function)
            this.callback_function();
    }
}