const slider = document.querySelector(".photo-slider");
const current_photo_element = slider.querySelector(".current-photo");
const switch_element = slider.querySelector(".switch");
let photo_array = [];
let current_index = -1;
function show_slider(photo_list, photo_index) {
    window.addEventListener("keydown", sliderKeydown);

    slider.classList.add("show", "show-animation");
    setTimeout(() => {
        slider.classList.remove("show-animation");
    }, 500);
    photo_array = photo_list;
    switch_element.innerHTML = "";
    createSwitch(photo_array.length);

    current_photo_element.innerHTML = "";
    current_index = -1;
    showPhoto(photo_index);
}


document.querySelector(".photo-slider button.close").onclick = hide_slider;
function hide_slider() {
    //enableScroll();
    window.removeEventListener("keydown", sliderKeydown, false);

    slider.classList.add("hide");
    setTimeout(() => {
        slider.classList.remove("show", "hide");
        current_photo_element.innerHTML = "";
    }, 500);
}

function sliderKeydown(e) {
    if (e.keyCode > 31 && e.keyCode < 41)
        e.preventDefault();

    switch (e.key) {
        case "Escape":
            hide_slider();
            break;

        case "ArrowLeft":
            e.preventDefault();
            prevPhoto();
            break;

        case "ArrowRight":
            e.preventDefault();
            nextPhoto();
            break;
    }
}

document.querySelector(".photo-slider .left").onclick = prevPhoto;
function prevPhoto() {
    let nextIndex = current_index - 1;
    if (nextIndex < 0)
        nextIndex = photo_array.length - 1;

    showPhoto(nextIndex);
}

document.querySelector(".photo-slider .right").onclick = nextPhoto;
function nextPhoto() {
    let nextIndex = current_index + 1;
    if (nextIndex >= photo_array.length)
        nextIndex = 0;

    showPhoto(nextIndex);
}

function showPhoto(index) {
    const n = photo_array.length;
    if (current_index < 0)
        current_photo_element.innerHTML = `<img draggable="false" src="${photo_array[index]}">`;
    else {
        if ((index > current_index && !(index === n - 1 && current_index === 0)) || (index === 0 && current_index === n - 1))
            current_photo_element.classList.add("hide-left");
        else
            current_photo_element.classList.add("hide-right");

        let current_index_copy = current_index;
        setTimeout(() => {
            current_photo_element.classList.remove("hide-left", "hide-right");

            current_photo_element.innerHTML = `<img draggable="false" src="${photo_array[index]}">`;
            if ((index > current_index_copy && !(index === n - 1 && current_index_copy === 0)) || (index === 0 && current_index_copy === n - 1))
                current_photo_element.classList.add("show-right");
            else
                current_photo_element.classList.add("show-left");

            setTimeout(() => {
                current_photo_element.classList.remove("show-left", "show-right");
            }, 300);
        }, 300);
    }


    let current_switch_button = switch_element.children[current_index];
    if (current_index >= 0)
    {
        current_switch_button.classList.remove("current");
        current_switch_button.innerHTML = `<i class="material-icons">radio_button_unchecked</i>`;
    }

    current_switch_button = switch_element.children[index];
    current_switch_button.classList.add("current");
    current_switch_button.innerHTML = `<i class="material-icons">radio_button_checked</i>`;

    current_index = index;
}

function createSwitch(n) {
    for (let i = 0; i < n; i++)
    {
        let button = document.createElement("button");
        button.innerHTML = `<i class="material-icons">radio_button_unchecked</i>`;

        button.onclick = function () {
            if (current_index !== i)
                showPhoto(i);
        }

        switch_element.appendChild(button);
    }
}

/*
function preventDefault(e) {
    e.preventDefault();
}

function preventDefaultForScrollKeys(e) {
    if (e.keyCode > 31 && e.keyCode < 41) {
        preventDefault(e);
        return false;
    }
}

let supportsPassive = false;
try {
    window.addEventListener("test", null, Object.defineProperty({}, 'passive', {
        get: function () { supportsPassive = true; }
    }));
} catch(e) {}

let wheelOpt = supportsPassive ? { passive: false } : false;
let wheelEvent = 'onwheel' in document.createElement('div') ? 'wheel' : 'mousewheel';

function disableScroll() {
    window.addEventListener('DOMMouseScroll', preventDefault, false); // older FF
    window.addEventListener(wheelEvent, preventDefault, wheelOpt); // modern desktop
    window.addEventListener('touchmove', preventDefault, wheelOpt); // mobile
    window.addEventListener('keydown', preventDefaultForScrollKeys, false);
}

function enableScroll() {
    window.removeEventListener('DOMMouseScroll', preventDefault, false);
    window.removeEventListener(wheelEvent, preventDefault, wheelOpt);
    window.removeEventListener('touchmove', preventDefault, wheelOpt);
    window.removeEventListener('keydown', preventDefaultForScrollKeys, false);
}*/
