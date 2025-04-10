

let currentCountryI = 0;
//showCountry(countriesArray[currentCountryI]);

const leftButton = document.querySelector("#previous");
leftButton.onclick = function () {
    if (currentCountryI === 0)
        currentCountryI = countriesArray.length;
    currentCountryI--;
    showCountry(countriesArray[currentCountryI]);
    animation(leftButton);
}

const rightButton = document.querySelector("#next");
rightButton.onclick = function () {
    currentCountryI++;
    if (currentCountryI === countriesArray.length)
        currentCountryI = 0;
    showCountry(countriesArray[currentCountryI]);
    animation(rightButton);
}

function showCountry(country) {
    const slide = document.querySelector(".slider .video-bg .video");

    slide.style.transform = "scale(120%)";


    setTimeout(() => {
        slide.querySelector(".slide-text").href = country.link;
        slide.querySelectorAll(".slide-text *").forEach((element) => {
            element.textContent = country.name;
        });
        slide.querySelector(".slide-text .pattern").style.backgroundImage = `url("${country.letterPattern}")`;

        const video = slide.querySelector("video");
        video.pause();
        slide.querySelector("video source").src = country.backgroundVideo;
        video.load();
        video.play();

        slide.style.transform = "scale(100%)";
    }, 1000);
}

const videoBgElement = document.querySelector(".video-bg");
function animation(button) {
    const circlesParent = document.createElement("div");
    circlesParent.classList.add("circles");

    const n = 10;
    const sectionWidth = window.innerWidth / n;


    const circlesCenterX = button.getBoundingClientRect().x + button.getBoundingClientRect().width / 2;
    const circlesCenterY = button.getBoundingClientRect().y + button.getBoundingClientRect().height / 2;
    let circles = "";
    for (let i = 0; i < n + 1; i++)
        circles += `<circle cx="${circlesCenterX}px" cy="${circlesCenterY}px" style="transition-delay: ${0.05 * i}s" r="${i * sectionWidth + sectionWidth / 2}"></circle>`;


    circlesParent.innerHTML += `<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">${circles}</svg>`;
    videoBgElement.appendChild(circlesParent);

    setTimeout(() => {
        circlesParent.querySelectorAll("circle").forEach((circle) => {
            circle.style.strokeWidth = `${sectionWidth + 1}px`;
        });
    }, 10);
    setTimeout(() => {
        circlesParent.querySelectorAll("circle").forEach((circle) => {
            circle.style.strokeWidth = `0`;
        });
    }, 1000);
    setTimeout(() => {
        circlesParent.remove();
    }, 1800);
}