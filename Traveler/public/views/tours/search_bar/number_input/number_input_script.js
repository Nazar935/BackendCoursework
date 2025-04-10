let valueArray = [];

document.querySelectorAll(".number-input").forEach((numberInput) => {
    const input = numberInput.querySelector("input");

    numberInput.querySelector(".minus-button").addEventListener("click", () => {
        let value = checkValue(input, -1);

        value = value.toString();
        if (input.value !== value)
            input.dataset.edited = "true";
        input.value = value;

    });
    numberInput.querySelector(".plus-button").addEventListener("click", () => {
        let value = checkValue(input, +1);

        value = value.toString();
        if (input.value !== value)
            input.dataset.edited = "true";
        input.value = value;
    });
    input.addEventListener("input", () => {
        input.dataset.edited = "true";
    })
    numberInput.querySelector(".select-button").addEventListener("click", () => {
        let value = checkValue(input, 0);

        value = value.toString();
        input.value = value;
        input.dataset.edited = "true";
        if (input.closest(".days-input"))
            changeSelected(3, value);
        else
            changeSelected(4, value);
    });
    numberInput.closest(".number-select").querySelector(".clear").addEventListener("click", () => {
        input.dataset.edited = "";
        input.value = "3";
    });
});

function checkValue(input, offset) {
    let value = parseInt(input.value);
    const inputMin = parseInt(input.min);
    const inputMax = parseInt(input.max);

    if (!value)
        return inputMin;

    value += offset;
    if (value < inputMin)
        return inputMin;
    if (value > inputMax)
        return inputMax;
    return value;
}

function daysToString(days)
{
    let stringDays = "";
    const value = parseInt(days);
    if (value % 100 >= 5 && value % 100 <= 20)
        stringDays = "днів";
    else if (value % 10 === 1)
        stringDays = "день";
    else
        stringDays = "дні";

    return `${value} ${stringDays}`;
}

function touristsToString(tourists)
{
    let stringTourists = "";
    const value = parseInt(tourists);
    if (value % 100 >= 5 && value % 100 <= 20)
        stringTourists = "туристів";
    else if (value % 10 === 1)
        stringTourists = "турист";
    else
        stringTourists = "туристи";

    return `${value} ${stringTourists}`;
}