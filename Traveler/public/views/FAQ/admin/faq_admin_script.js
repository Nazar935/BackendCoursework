document.querySelectorAll(".question").forEach((question) => {
    setQuestionClicks(question);
});

function setQuestionClicks(question, isNew = false) {
    question.querySelector("button.delete").addEventListener("click", () => {
        deleteQuestion(question);
    });

    question.querySelector("button.edit").addEventListener("click", () => {
        editQuestion(question);
    });

    if (isNew)
        question.querySelector("button.undo").addEventListener("click", () => {
            question.remove();
        });
    else
        question.querySelector("button.undo").addEventListener("click", () => {
        undoEditQuestion(question);
    });

    if (isNew)
        question.querySelector("button.save").addEventListener("click", () => {
            saveNewQuestion(question);
        });
    else
        question.querySelector("button.save").addEventListener("click", () => {
        saveEditQuestion(question);
    });
}

document.querySelector(".add-button-wrapper button").addEventListener("click", () => {
    addQuestion();
});

function showAnswerQuick(question) {
    const answer = question.querySelector(".answer");
    questionChecked[+question.id] = true;

    answer.style.height = "100%";
    answer.style.opacity = "1";
    answer.style.position = "";
    answer.style.display = "block";
}

function deleteQuestion(question) {
    //question.classList.add("remove");
    setTimeout(() => {
        fetch("/faq/delete/" + question.id).then((data) => data.text()).then((text) => console.log(text));;
        location.reload();
    }, 300);
};

function editQuestion(question) {
    question.querySelector(".buttons.main").style.display = "none";
    question.querySelector(".buttons.edit").style.display = "flex";

    const header = question.querySelector(".question-header .text");
    const headerText = header.textContent.trim();
    header.style.display = "none";

    const input = document.createElement("input");
    input.value = headerText;
    input.classList.add("simple-input")
    input.name = "header-text";
    input.type = "text";
    input.placeholder = "Запитання";
    input.spellcheck = "false";
    input.addEventListener("click", (e) => {
        e.stopPropagation();
    });
    header.parentElement.appendChild(input);

    const answer = question.querySelector(".answer .text");
    const answerText = answer.textContent.trim();
    answer.style.display = "none";
    answer.parentElement.innerHTML += `<textarea class="simple-input" name="answer-text" placeholder="Відповідь" spellcheck="false">${answerText}</textarea>`;

    answerResize(question, true);
}

function undoEditQuestion(question) {
    question.querySelector(".buttons.main").style.display = "flex";
    question.querySelector(".buttons.edit").style.display = "none";
    question.querySelector("input").remove();
    question.querySelector("textarea").remove();
    question.querySelector(".question-header .text").style.display = 'block';
    question.querySelector(".answer .text").style.display = 'block';

    if (questionChecked[+question.id])
        answerResize(question, true);
}

function saveEditQuestion(question) {
    const questionText = question.querySelector(".question-header input").value;
    const answerText = question.querySelector(".answer textarea").value;

    if (!validQuestion(questionText, answerText))
        return;

    const formData = new FormData();
    formData.append("question", questionText);
    formData.append("answer", answerText);

    fetch("/faq/edit/" + question.id, {
        method: "POST",
        body: formData
    }).then((data) => data.text()).then((text) => {
        console.log(text);
        location.reload();
    });


    /*question.querySelector(".question-header .text").textContent = questionText;
    question.querySelector(".answer .text").innerHTML = answerText.replaceAll("\n", "<br/>");
    setTimeout(() => {
        undoEditQuestion(question);
    }, 100);*/
}

function addQuestion() {
    const newQuestion = document.createElement("div");
    newQuestion.classList.add("question");
    newQuestion.id = `${++maxID}`;
    questionChecked.push(true);

    newQuestion.innerHTML = `
    <div class="drag-wrapper">
        <button>
            <i class="material-icons">drag_indicator</i>
        </button>
    </div>
    <div class="question-wrapper">
        <div class="question-header">
            <div class="h2">
                <div class="icon question-mark">
                    <i class="material-icons">
                        <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#e8eaed"><path d="m480-80-10-120h-10q-142 0-241-99t-99-241q0-142 99-241t241-99q71 0 132.5 26.5t108 73q46.5 46.5 73 108T800-540q0 75-24.5 144t-67 128q-42.5 59-101 107T480-80Zm80-146q71-60 115.5-140.5T720-540q0-109-75.5-184.5T460-800q-109 0-184.5 75.5T200-540q0 109 75.5 184.5T460-280h100v54Zm-101-95q17 0 29-12t12-29q0-17-12-29t-29-12q-17 0-29 12t-12 29q0 17 12 29t29 12Zm-29-127h60q0-30 6-42t38-44q18-18 30-39t12-45q0-51-34.5-76.5T460-720q-44 0-74 24.5T344-636l56 22q5-17 19-33.5t41-16.5q27 0 40.5 15t13.5 33q0 17-10 30.5T480-558q-35 30-42.5 47.5T430-448Zm30-65Z"/></svg>
                    </i>
                </div>
                <div class="text" style="display: none">
                </div>
                <input class="simple-input" type="text" name="header-text" placeholder="Запитання" spellcheck="false"/>
            </div>
            <div class="icon arrow">
                <i class="material-icons">arrow_back_ios_new</i>
            </div>
        </div>
        <div class="answer">
            <div class="text" style="display: none">
            </div>
            <textarea class="simple-input" name="answer-text" placeholder="Відповідь" spellcheck="false"></textarea>
        </div>
    </div>
    <div class="buttons main" style="display: none">
        <div class="button-wrapper">
                                <button class="edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M200-400q-17 0-28.5-11.5T160-440q0-17 11.5-28.5T200-480h200q17 0 28.5 11.5T440-440q0 17-11.5 28.5T400-400H200Zm0-160q-17 0-28.5-11.5T160-600q0-17 11.5-28.5T200-640h360q17 0 28.5 11.5T600-600q0 17-11.5 28.5T560-560H200Zm0-160q-17 0-28.5-11.5T160-760q0-17 11.5-28.5T200-800h360q17 0 28.5 11.5T600-760q0 17-11.5 28.5T560-720H200Zm320 520v-66q0-8 3-15.5t9-13.5l209-208q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-380L655-172q-6 6-13.5 9t-15.5 3h-66q-17 0-28.5-11.5T520-200Zm300-223-37-37 37 37ZM580-220h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z"/></svg>
                                </button>
                            </div>
                            <div class="button-wrapper">
                                <button class="delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M280-120q-33 0-56.5-23.5T200-200v-520q-17 0-28.5-11.5T160-760q0-17 11.5-28.5T200-800h160q0-17 11.5-28.5T400-840h160q17 0 28.5 11.5T600-800h160q17 0 28.5 11.5T800-760q0 17-11.5 28.5T760-720v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM400-280q17 0 28.5-11.5T440-320v-280q0-17-11.5-28.5T400-640q-17 0-28.5 11.5T360-600v280q0 17 11.5 28.5T400-280Zm160 0q17 0 28.5-11.5T600-320v-280q0-17-11.5-28.5T560-640q-17 0-28.5 11.5T520-600v280q0 17 11.5 28.5T560-280ZM280-720v520-520Z"/></svg>
                                </button>
                            </div>
    </div>
    <div class="buttons edit" style="display: flex">
        <div class="button-wrapper">
                                <button class="save">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h447q16 0 30.5 6t25.5 17l114 114q11 11 17 25.5t6 30.5v447q0 33-23.5 56.5T760-120H200Zm560-526L646-760H200v560h560v-446ZM480-240q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM280-560h280q17 0 28.5-11.5T600-600v-80q0-17-11.5-28.5T560-720H280q-17 0-28.5 11.5T240-680v80q0 17 11.5 28.5T280-560Zm-80-86v446-560 114Z"/></svg>
                                </button>
                            </div>
                            <div class="button-wrapper">
                                <button class="undo">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M320-200q-17 0-28.5-11.5T280-240q0-17 11.5-28.5T320-280h244q63 0 109.5-40T720-420q0-60-46.5-100T564-560H312l76 76q11 11 11 28t-11 28q-11 11-28 11t-28-11L188-572q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l144-144q11-11 28-11t28 11q11 11 11 28t-11 28l-76 76h252q97 0 166.5 63T800-420q0 94-69.5 157T564-200H320Z"/></svg>
                                </button>
                            </div>
    </div>
    `

    const questions = document.querySelector(".questions");
    questions.insertBefore(newQuestion, questions.children[questions.children.length - 1]);

    setTimeout(() => {
        answerResize(newQuestion, true);
        newQuestion.querySelector("input").addEventListener("click", (e) => {
            e.stopPropagation();
        })
        setQuestionClicks(newQuestion, true);
        setBasicClick(newQuestion);

        setTimeout(() => {
            newQuestion.scrollIntoView({
                behavior: "smooth"
            });
        }, 350);
    }, 10);
}

function saveNewQuestion(question) {
    const questionText = question.querySelector(".question-header input").value;
    const answerText = question.querySelector(".answer textarea").value;

    if (!validQuestion(questionText, answerText))
        return;

    const formData = new FormData();
    formData.append("question", questionText);
    formData.append("answer", answerText);

    fetch("/faq/add/", {
        method: "POST",
        body: formData
    }).then((data) => data.text()).then((text) => {
        location.reload();
    });
}

function validQuestion(questionText, answerText) {
    if (questionText.length === 0)
        Message.show("Поле запитання не може бути пустим", Message.negative);
    else if (answerText.length === 0)
        Message.show("Поле відповіді не може бути пусти", Message.negative);
    else if (questionText.length > 255)
        Message.show("Довжина запитання не має перевищувати 255 символів", Message.negative);
    else if (answerText.length > 1024)
        Message.show("Довжина відповіді не має перевищувати 1024 символів", Message.negative);
    else
        return true;
    return false;
}