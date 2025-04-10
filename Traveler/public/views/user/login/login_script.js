document.querySelectorAll(".password input").forEach((input) => {
    input.oninput = checkPasswordInput(input);
});

function checkPasswordInput(input) {
    return function () {
        if (input.value.length > 0)
            input.classList.add("focus");
        else
            input.classList.remove("focus");
    }
}

const removeErrorButton = document.querySelector("#remove-error");
if (removeErrorButton) {
    document.querySelectorAll(".password input").forEach((input) => {
        checkPasswordInput(input)();
    })
}


