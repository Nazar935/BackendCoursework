let maxID = 0;
document.querySelectorAll(".question").forEach((question) => {
    if (maxID < +question.id)
        maxID = +question.id;
});
const questionChecked = new Array(maxID + 1).fill(false);

document.querySelectorAll(".question").forEach((question) => {
    setBasicClick(question);
});

function setBasicClick(question) {
    question.querySelector(".question-header").onclick = function () {
        if (questionChecked[+question.id])
            closeAnswer(+question.id);
        else
            showAnswer(+question.id);
    }
}

function showAnswer(id) {
    //console.log("showAnswer");
    const question = document.getElementById(id);

    if (!questionChecked[id]) {
        answerResize(question);
    }

}

function closeAnswer(id) {
    //console.log("closeAnswer");
    const question = document.getElementById(id);

    if (questionChecked[question.id]) {
        const answer = question.querySelector(".answer");

        questionChecked[question.id] = false;

        answer.style.height = `${answer.getBoundingClientRect().height}px`;
        setTimeout(() => {
            question.classList.remove("show-answer");
            question.classList.add("hide-answer");

            answer.style.height = "0";

            setTimeout(() => {
                answer.style.height = "";
                answer.style.opacity = "0";
                answer.style.display = "none";
                answer.style.transition = "";
                question.classList.remove("hide-answer");
            }, 300);
        }, 10);
    }
}

function answerResize(question, currentHeight = false) {
    questionChecked[+question.id] = true;
    question.classList.add("show-answer");

    const questionHeight = question.querySelector(".question-header").getBoundingClientRect().height;
    question.querySelectorAll(".buttons, .drag-wrapper").forEach((buttons) => {
        buttons.style.height = `${questionHeight}px`;
    });

    let answer = question.querySelector(".answer");

    let answerCopy = document.createElement("div");
    answerCopy.classList.add("answer");
    answerCopy.innerHTML = answer.innerHTML;
    question.querySelector(".question-wrapper").appendChild(answerCopy);

    setTimeout(() => {
        answer = question.querySelector(".answer:last-child");

        answer.style.opacity = "0";
        answer.style.position = "absolute";
        answer.style.display = "block";
        answer.style.transition = "";

        setTimeout(() => {
            const height = answer.getBoundingClientRect().height;
            answer.remove();

            answer = question.querySelector(".answer");

            if (currentHeight)
                answer.style.height = `${answer.getBoundingClientRect().height}px`;
            else
                answer.style.height = "0";

            answer.style.opacity = "1";
            answer.style.position = "";
            answer.style.display = "block";
            answer.style.transition = "height 0.3s cubic-bezier(0.76, 0, 0.24, 1)";

            setTimeout(() => {
                answer.style.height = `${height}px`;
            }, 25);
            setTimeout(() => {
                answer.style.height = ``;
            }, 300);
        }, 25);
    }, 25);

}