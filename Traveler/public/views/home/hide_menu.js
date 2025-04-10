const header = document.querySelector(".header");
const footer = document.querySelector(".footer");
const leftArrow = document.querySelector(".arrows button.left");
const rightArrow = document.querySelector(".arrows button.right");
const  arrowWrapper = document.querySelector(".arrows .button-wrapper");
const headerHeight = 50;
const footerHeight = 25;
const sleepTime = 4;

const components = [header, footer, leftArrow, rightArrow];

components.forEach((component) => {
    component.style.transition = "transform .3s cubic-bezier(0.76, 0, 0.24, 1)";
});

//header.style.transform = `translate(0, -${headerHeight + 1}px)`;
//footer.style.transform = `translate(0, ${footerHeight + 1}px)`;



let headerMoveTime = null;
let footerMoveTime = null;
let mouseX = 0;
let mouseY = 0;
let headerIntervalFl = false;
let footerIntervalFl = false;

let intervalFl = false;
let moveTime = null;

document.addEventListener("mousemove", documentAction);
document.addEventListener("click", documentAction);

function documentAction(e) {
    const screenWidth = window.innerWidth;
    const screenHeight = window.innerHeight;

    mouseX = e.clientX;
    mouseY = e.clientY;

    //document.querySelector(".footer").textContent = `X: ${mouseX}; Y: ${mouseY}; `;

    moveTime = new Date();

    if (!intervalFl)
    {
        document.body.style.cursor = "default";

        components.forEach((component) => {
            component.style.transform = "translate(0, 0)";
        });

        intervalFl = true;
        let interval = setInterval(() => {
            if (((new Date() - moveTime) / 1000 >= sleepTime) && (mouseY > headerHeight) && (screenHeight - mouseY > footerHeight)) {
                const arrowWidth = arrowWrapper.getBoundingClientRect().width;
                console.log(arrowWidth);
                header.style.transform = `translate(0, -${headerHeight + 1}px)`;
                footer.style.transform = `translate(0, ${footerHeight + 1}px)`;
                leftArrow.style.transform += `translate(-${arrowWidth + 1}px, 0)`;
                rightArrow.style.transform += `translate(${arrowWidth + 1}px, 0)`;
                document.body.style.cursor = "none";
                intervalFl = false;
                clearInterval(interval);
            }
        }, 100);
    }

    /*if (mouseY / screenHeight < 1 / 8) {
        header.style.transform = "translate(0, 0)";
        headerMoveTime = new Date();
    } else {
        //header.style.transform = `translate(0, -${headerHeight + 1}px)`;

    }
    if (mouseY / screenHeight > 9 / 10) {
        footer.style.transform = "translate(0, 0)";
        footerMoveTime = new Date();
    } else {
        //footer.style.transform = `translate(0, ${footerHeight + 1}px)`;
        if (!footerIntervalFl)
        {
            footerIntervalFl = true;
            let interval = setInterval(() => {
                if (((new Date() - footerMoveTime) / 1000 >= sleepTime) && (screenHeight - mouseY > footerHeight)) {
                    footer.style.transform = `translate(0, ${footerHeight + 1}px)`;
                    footerIntervalFl = false;
                    clearInterval(interval);
                }
            }, 100);
        }
    }*/
}

/*document.addEventListener("mouseleave", function () {
    header.style.transform = `translate(0, -${headerHeight + 1}px)`;
    footer.style.transform = `translate(0, ${footerHeight + 1}px)`;
});*/
