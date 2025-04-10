class PriceFilter {
    value = null;

    offsetLeft = 0;
    offsetRight = 0;

    constructor(element, callback_function = null, name = "price_range") {
        this.name = name;
        this.element = element;
        this.callback_function = callback_function;

        this.rangeLeftBound = 0;
        this.rangeRightBound = 40000;
        this.step = 500;
        this.rangeCoefficient = 100 / ((this.rangeRightBound - this.rangeLeftBound) / this.step);

        const middleLine = this.element.querySelector(".price-range .middle");
        const middleShadow = this.element.querySelector(".price-range .middle-shadow");
        const leftStick = this.element.querySelector(".price-range .left");
        const rightStick = this.element.querySelector(".price-range .right");
        const transformTranslateXOffset = 10;
        leftStick.addEventListener("mousedown", (e) => {
            e.preventDefault();
            const leftStickMove = (e) => {
                const middleLineLength = middleShadow.getBoundingClientRect().width;
                const leftStickLength = leftStick.getBoundingClientRect().width;
                const leftBound = middleShadow.getBoundingClientRect().left - transformTranslateXOffset;
                const rightBound = (rightStick.getBoundingClientRect().left + rightStick.getBoundingClientRect().right) / 2 - transformTranslateXOffset;

                const mouseX = Math.min(rightBound, Math.max(e.pageX, leftBound));
                let leftOffset = Math.max(0, Math.floor((mouseX - leftBound - (leftStickLength / 2)) / middleLineLength * 100 / this.rangeCoefficient) * this.rangeCoefficient);
                leftStick.style.left = `${leftOffset}%`;
                middleLine.style.left = `${leftOffset}%`;

                this.offsetLeft = leftOffset;
                this.calculateValue();
            }
            leftStickMove(e);
            const windowMouseUpLeft = (e) => {
                window.removeEventListener("mousemove", leftStickMove);
                window.removeEventListener("mouseup", windowMouseUpLeft);
                this.calculateValue(true);
            }
            window.addEventListener("mousemove", leftStickMove);
            window.addEventListener("mouseup", windowMouseUpLeft);
        });

        rightStick.addEventListener("mousedown", (e) => {
            e.preventDefault();
            const rightStickMove = (e) => {
                const middleLineLength = middleShadow.getBoundingClientRect().width;
                const rightStickLength = rightStick.getBoundingClientRect().width;
                const leftBound = (leftStick.getBoundingClientRect().left + leftStick.getBoundingClientRect().right) / 2 + transformTranslateXOffset;
                const rightBound = middleShadow.getBoundingClientRect().right + transformTranslateXOffset;

                const mouseX = Math.min(rightBound, Math.max(e.pageX, leftBound));
                const rightOffset = Math.max(0, Math.floor((rightBound - (mouseX + (rightStickLength / 2))) / middleLineLength * 100 / this.rangeCoefficient) * this.rangeCoefficient);
                rightStick.style.right = `${rightOffset}%`;
                middleLine.style.right = `${rightOffset}%`;

                this.offsetRight = rightOffset;
                this.calculateValue();
            }
            rightStickMove(e);

            window.addEventListener("mousemove", rightStickMove);
            const windowMouseUpRight = (e) =>  {
                window.removeEventListener("mousemove", rightStickMove);
                window.removeEventListener("mouseup", windowMouseUpRight);
                this.calculateValue(true);
            }
            window.addEventListener("mouseup", windowMouseUpRight);
        });
    }

    calculateValue(call = false) {
        this.value = {
            left: (this.rangeLeftBound + (this.rangeRightBound - this.rangeLeftBound) * this.offsetLeft / 100),
            right: (this.rangeRightBound - (this.rangeRightBound - this.rangeLeftBound) * this.offsetRight / 100)
        }

        const textLeft = this.element.querySelector(".price-text .left");
        textLeft.textContent = "UAH ";
        textLeft.textContent += this.value.left.toLocaleString("en-US", {
            maximumFractionDigits: 0
        });

        const textRight = this.element.querySelector(".price-text .right");
        if (this.offsetRight === 0) {
            textRight.textContent = "UAH 40,000+";
            this.value.right = 999999999;
        }
        else {
            textRight.textContent = "UAH ";
            textRight.textContent += this.value.right.toLocaleString("en-US", {
                maximumFractionDigits: 0
            });
        }

        this.value = JSON.stringify(this.value);
        if (this.callback_function && call)
            this.callback_function();
    }

    clear() {
        this.value = null;
        this.offsetLeft = 0;
        this.offsetRight = 0;
        this.calculateValue();

        this.element.querySelector(".price-range .left").style.left = "0";
        this.element.querySelector(".price-range .right").style.right = "0";
        this.element.querySelector(".price-range .middle").style.left = "0";
        this.element.querySelector(".price-range .middle").style.right = "0";
    }
}