class FacilitiesSelect {
    value = null;
    valueArray = [];

    constructor(element, callback_function = null, name = "tour_facilities") {
        this.element = element;
        this.name = name;
        this.callback_function = callback_function;

        const checkboxArray = this.element.querySelectorAll('input[type="checkbox"]');
        checkboxArray.forEach(checkbox => {
            if (checkbox.checked)
                this.changeValue(checkbox);
            checkbox.addEventListener("change", (e) => {
                this.changeValue(checkbox);
            });
        });
    }

    changeValue(checkbox) {
        const check = checkbox.closest(".check");
        check.classList.toggle("checked");
        const facility = check.dataset.facilityId;

        let isRemoved = false;
        for (let i = 0; i < this.valueArray.length; i++)
            if (this.valueArray[i] === facility) {
                isRemoved = true;
                this.valueArray.splice(i, 1);
                break;
            }

        if (!isRemoved)
            this.valueArray.push(facility);
        this.value = JSON.stringify(this.valueArray);
        if (this.valueArray.length === 0)
            this.value = null;

        if (this.callback_function)
            this.callback_function();
    }

    clear() {
        const checkboxArray = this.element.querySelectorAll('.check');
        checkboxArray.forEach(checkbox => checkbox.classList.remove("checked"));

        this.value = null;
        if (this.callback_function)
            this.callback_function();
    }
}