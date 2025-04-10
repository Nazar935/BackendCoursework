const dateTableHeader = document.getElementById("date-table-header");
const dateTableBody = document.getElementById("date-table-body");
const monthArray = ['Січень', 'Лютий', 'Березень', 'Квітень', 'Травень', 'Червень', 'Липень', 'Серпень', 'Вересень', 'Жовтень', 'Листопад', 'Грудень'];
let dateTableMonth = new Date().getMonth() + 1;
let dateTableYear = new Date().getFullYear();
let selectedDate = null;
let isAnimated = false;

function setMonth(year, month) {
    setTableHeaderMonth(month, year);


    const monthLength = new Date(dateTableYear, dateTableMonth, 0).getDate();
    const previousMonthLength= new Date(dateTableYear, dateTableMonth - 1, 0).getDate();
    let firstDayOfTheWeek = new Date(dateTableYear, dateTableMonth - 1, 1).getDay();
    if (firstDayOfTheWeek === 0)
        firstDayOfTheWeek = 7;

    let daysOfTheWeekBefore = firstDayOfTheWeek - 1;
    let monthDays = monthLength;
    let n = 7 * 6;
    let i = 1;

    dateTableBody.closest(".date-panel").style.height = `${Math.ceil((daysOfTheWeekBefore + monthDays) / 7 + 1) * 36 + 12}px`;
    dateTableBody.innerHTML = "";

    while (n > 0) {
        if (n % 7 === 0)
            dateTableBody.appendChild(document.createElement("tr"));
        if (daysOfTheWeekBefore > 0) {
            let classArray = []
            const date = new Date(dateTableYear, dateTableMonth - 2, previousMonthLength - (firstDayOfTheWeek - 1) + i);
            if (selectedDate && selectedDate.getTime() === date.getTime())
                classArray.push("selected");
            classArray.push("disabled");

            dateTableBody.querySelector("tr:last-of-type").innerHTML += `<td><button class="${classArray.join(" ")}" onclick="datePick(this, event)" disabled>${previousMonthLength - (firstDayOfTheWeek - 1) + i}</button></td>`;
            daysOfTheWeekBefore--;
            if (daysOfTheWeekBefore === 0)
                i = 0;
        } else if (monthDays > 0) {
            let classArray = [];
            let disabled = "";
            const today = new Date().setDate(new Date().getDate() - 1);
            const date = new Date(dateTableYear, dateTableMonth - 1, i);
            if (date < today) {
                disabled = "disabled";
                classArray.push("disabled");
            }
            classArray.push("this-month");

            if (selectedDate && selectedDate.getTime() === date.getTime())
                classArray.push("selected");

            dateTableBody.querySelector("tr:last-of-type").innerHTML += `<td><button class="${classArray.join(" ")}" onclick="datePick(this, event)" ${disabled}>${i}</button></td>`;
            monthDays--;
            if (monthDays === 0)
                i = 0;
        } else {
            let classArray = [];
            const date = new Date(dateTableYear, dateTableMonth, i);
            if (selectedDate && selectedDate.getTime() === date.getTime())
                classArray.push("selected");
            classArray.push("disabled");

            dateTableBody.querySelector("tr:last-of-type").innerHTML += `<td><button class="${classArray.join(" ")}" onclick="datePick(this, event)" disabled>${i}</button></td>`;
        }
        i++;
        n--;
    }

    /*setTimeout(() => {
        const monthLength = new Date(dateTableYear, dateTableMonth, 0).getDate();
        let daysOfTheWeekBefore = new Date(dateTableYear, dateTableMonth - 1, 1).getDay();
        if (daysOfTheWeekBefore === 0)
            daysOfTheWeekBefore = 7;
        daysOfTheWeekBefore--;

        let monthDays = monthLength + daysOfTheWeekBefore;
        let weeks = Math.ceil(monthDays / 7);
        let  height = dateTableBody.children[weeks - 1].getBoundingClientRect().bottom
            - document.querySelector(".search-bar .drop-down .date-panel .table-header").getBoundingClientRect().top + 10;
        dateTableBody.closest(".date-panel").style.height = `${height}px`;
        alert("aboba");
    }, 10);*/
}

dateTableHeader.querySelector(".previous-month").addEventListener("click", () => {
    if (isAnimated)
        return;
    isAnimated = true;
    dateTableMonth--;
    if (dateTableMonth === 0) {
        dateTableYear--;
        dateTableMonth = 12;
    }
    adjustDateTableHeight();
    setTableHeaderMonth(dateTableMonth, dateTableYear, -1);


    let monthLength = new Date(dateTableYear, dateTableMonth, 0).getDate();
    const prevMonthLength= new Date(dateTableYear, dateTableMonth - 1, 0).getDate();
    let daysOfTheWeekBefore = new Date(dateTableYear, dateTableMonth - 1, 1).getDay();
    if (daysOfTheWeekBefore === 0)
        daysOfTheWeekBefore = 7;
    daysOfTheWeekBefore--;

    let maxDate = parseInt(dateTableBody.querySelector("tr:first-child td:first-child button").textContent);
    if (maxDate === 1)
        maxDate = monthLength + 1;

    let prevWeeks = 6 - Math.floor((daysOfTheWeekBefore + maxDate) / 7);
    //console.log(prevWeeks);

    let n = Math.ceil((42 - prevWeeks * 7) / 7) * 7;
    let newMonthArray = [];
    for (let i = n / 7 - 1; i >= 0; i--) {
        let tr = document.createElement("tr");

        let offsetI = n / 7 - i;
        let tempOffset;
        if (offsetI === 6)
            tempOffset = dateTableBody.getBoundingClientRect().height;
        else
            tempOffset = dateTableBody.children[offsetI].getBoundingClientRect().top - dateTableBody.getBoundingClientRect().top;
        tr.style.position = "absolute";
        tr.style.top = `${-tempOffset}px`;
        tr.style.width = "264px"
        tr.style.left = "-1px";
        newMonthArray.push(tr);
        //dateTableBody.insertBefore(tr, dateTableBody.firstChild);

        for (let j = 7; j >= 1; j--) {
            let t = maxDate - (n - (i * 7 + j) + 1);

            if (t < 1)
                tr.innerHTML = `<td><button class='disabled prev-month ${isSelected(prevMonthLength + t, -1)}' disabled onclick='datePick(this, event)'>${prevMonthLength + t}</button></td>` + tr.innerHTML;
            else
                tr.innerHTML = `<td><button class='disabled ${isSelected(t)}' disabled onclick='datePick(this, event)'>${t}</button></td>` + tr.innerHTML;

        }
    }

    let animationOffset;
    if (prevWeeks > 0)
        animationOffset = dateTableBody.children[6 - prevWeeks].getBoundingClientRect().top - dateTableBody.getBoundingClientRect().top;
    else
        animationOffset = dateTableBody.getBoundingClientRect().height;

    for (let i = 0; i < n / 7; i++)
        dateTableBody.insertBefore(newMonthArray[i], dateTableBody.firstChild);

    for (let i = 0; i < 12 - prevWeeks; i++)
        for (let j = 0; j < 7; j++)
            dateTableBody.querySelector(`tr:nth-child(${i + 1}) td:nth-child(${j + 1}) button`).style.transition
                = "0.6s cubic-bezier(0.76, 0, 0.24, 1)";

    setTimeout(() => {
        for (let i = 0; i < 12 - prevWeeks; i++) {
            dateTableBody.children[i].style.transform = `translateY(${animationOffset}px)`;
            //console.log(dateTableBody.children[i].style.transition);
        }

        for (let i = 0; i < 6; i++)
            for (let j = 0; j < 7; j++) {
                let button = dateTableBody.children[i].children[j].querySelector("button");
                if (button.classList.contains("this-month")) {
                    button.classList.remove("this-month");
                    button.classList.add("disabled");
                    button.classList.add("next-month");
                    button.disabled = true;
                } else if (!button.classList.contains("prev-month") || (button.classList.contains("prev-month") && i >= 4)) {
                    button.classList.add("this-month");
                    button.classList.remove("prev-month")

                    const today = new Date().setDate(new Date().getDate() - 1);
                    const date = new Date(dateTableYear, dateTableMonth - 1, parseInt(button.textContent));
                    if (date >= today) {
                        button.classList.remove("disabled");
                        button.disabled = false;
                    }
                }
            }
    },25);



    setTimeout(function () {
        console.log(dateTableBody.children[4].getBoundingClientRect());
        for (let i = 0; i < 12 - prevWeeks; i++)
            dateTableBody.children[i].style.transition = `unset`;

        setTimeout(() => {
            for (let i = 6; i < 12 - prevWeeks; i++)
                dateTableBody.lastElementChild.remove();

            console.log(dateTableBody.children[4].getBoundingClientRect());
            for (let i = 0; i < 6; i++) {
                dateTableBody.children[i].style.transform = ``;
                dateTableBody.children[i].style.position = ``;
                dateTableBody.children[i].style.top = ``;
            }
            setTimeout(() => {
                for (let i = 0; i < 6; i++)
                    dateTableBody.children[i].style.transition = ``;
                for (let i = 0; i < 6; i++)
                    for (let j = 0; j < 7; j++)
                        dateTableBody.querySelector(`tr:nth-child(${i + 1}) td:nth-child(${j + 1}) button`).style.transition = "0.1s cubic-bezier(0.76, 0, 0.24, 1)";
                isAnimated = false;
            }, 25);


            console.log(dateTableBody.children[4].getBoundingClientRect());
        }, 25);

    }, 300);
});

dateTableHeader.querySelector(".next-month").addEventListener("click", () => {
    if (isAnimated)
        return;

    isAnimated = true;
    dateTableMonth++;
    if (dateTableMonth > 12) {
        dateTableYear++;
        dateTableMonth = 1;
    }
    adjustDateTableHeight();
    setTableHeaderMonth(dateTableMonth, dateTableYear, 1);

    let monthLength = new Date(dateTableYear, dateTableMonth, 0).getDate();
    const previousMonthLength= new Date(dateTableYear, dateTableMonth - 1, 0).getDate();

    let maxDate = parseInt(dateTableBody.querySelector("tr:last-child td:last-child button").textContent);
    if (maxDate > 25)
        maxDate = 0;
    const prevWeeks = Math.ceil(maxDate / 7);

    let n = Math.ceil((42 - prevWeeks * 7) / 7) * 7;
    for (let i = 0; i < n / 7; i++) {
        let tr = document.createElement("tr");
        //tr.classList.add("next-month");
        dateTableBody.appendChild(tr);

        for (let j = 1; j <= 7; j++) {
            let t = i * 7 + j + maxDate;
            if (t > monthLength)
                tr.innerHTML += `<td><button class='disabled next-month ${isSelected(t - monthLength, + 1)}' disabled onclick='datePick(this, event)'>${t - monthLength}</button></td>`;
            else
                tr.innerHTML += `<td><button class='disabled ${isSelected(t)}' disabled onclick='datePick(this, event)'>${t}</button></td>`;
        }
    }

    let animationOffset;
    if (prevWeeks > 0)
        animationOffset = dateTableBody.children[6 - prevWeeks].getBoundingClientRect().top - dateTableBody.getBoundingClientRect().top;
    else
        animationOffset = dateTableBody.getBoundingClientRect().height;

    for (let i = 0; i < 12 - prevWeeks; i++)
        dateTableBody.children[i].style.transform = `translateY(${-animationOffset}px)`;

    for (let i = 6 - prevWeeks; i < 6; i++)
        for (let j = 0; j < 7; j++)
            dateTableBody.querySelector(`tr:nth-child(${i + 1}) td:nth-child(${j + 1}) button`).classList.remove("next-month");

    for (let i = 0; i < 12 - prevWeeks; i++)
        for (let j = 0; j < 7; j++)
            dateTableBody.querySelector(`tr:nth-child(${i + 1}) td:nth-child(${j + 1}) button`).style.transition
                = "0.6s cubic-bezier(0.76, 0, 0.24, 1)";

    setTimeout(() => {
        for (let i = 6 - prevWeeks; i < 12 - prevWeeks; i++)
            for (let j = 0; j < 7; j++) {
                let button = dateTableBody.children[i].children[j].querySelector("button");
                if (button.classList.contains("this-month")) {
                    button.classList.remove("this-month");
                    button.classList.add("disabled");
                    button.classList.add("prev-month");
                    button.disabled = true;
                } else if (!button.classList.contains("next-month")) {
                    button.classList.add("this-month");
                    button.classList.remove("disabled");
                    button.disabled = false;
                }
            }
    }, 25);


    setTimeout(() => {
        for (let i = 0; i < 12 - prevWeeks; i++) {
            dateTableBody.children[i].style.transition = `unset`;
        }
        setTimeout(() => {
            for (let i = 0; i < 6 - prevWeeks; i++)
                dateTableBody.children[0].remove();
            for (let i = 0; i < 6; i++)
                dateTableBody.children[i].style.transform = ``;
            setTimeout(() => {
                for (let i = 0; i < 6; i++)
                    dateTableBody.children[i].style.transition = ``;
                for (let i = 0; i < 6; i++)
                    for (let j = 0; j < 7; j++)
                        dateTableBody.querySelector(`tr:nth-child(${i + 1}) td:nth-child(${j + 1}) button`).style.transition = "0.1s cubic-bezier(0.76, 0, 0.24, 1)";
                isAnimated = false;
            }, 25);

        }, 25);


    }, 300);
});

function adjustDateTableHeight() {
    const monthLength = new Date(dateTableYear, dateTableMonth, 0).getDate();
    let daysOfTheWeekBefore = new Date(dateTableYear, dateTableMonth - 1, 1).getDay();
    if (daysOfTheWeekBefore === 0)
        daysOfTheWeekBefore = 7;
    daysOfTheWeekBefore--;

    let monthDays = monthLength + daysOfTheWeekBefore;
    let weeks = Math.ceil(monthDays / 7);
    let  height = dateTableBody.children[weeks - 1].getBoundingClientRect().bottom
        - document.querySelector(".search-bar .drop-down .date-panel .table-header").getBoundingClientRect().top + 9;

    const datePanel =  dateTableBody.closest(".date-panel");
    const datePanelHeightBefore = datePanel.getBoundingClientRect().height;
    datePanel.style.height = `${datePanelHeightBefore}px`;

    setTimeout(() => {
        datePanel.style.height = `${height}px`;
    }, 25);
}

function setTableHeaderMonth(month, year, animated = 0) {
    //console.log(dateTableYear, dateTableMonth);
    const currentMonth = new Date().getMonth() + 1;
    const currentYear = new Date().getFullYear();
    //console.log(dateTableMonth);
    if (month === currentMonth && year === currentYear)
        dateTableHeader.querySelector(".previous-month").disabled = "true";
    else
        dateTableHeader.querySelector(".previous-month").disabled = null;
    if ((year * 12 + month - (currentYear * 12 + currentMonth)) >= 12)
        dateTableHeader.querySelector(".next-month").disabled = "true";
    else
        dateTableHeader.querySelector(".next-month").disabled = null;

    if (!animated) {
        dateTableHeader.querySelector(".current-month .month .current").textContent = monthArray[dateTableMonth - 1];
        dateTableHeader.querySelector(".current-month .year .current").textContent = dateTableYear;
    } else {
        let element = dateTableHeader.querySelector(".current-month .month");
        let text = monthArray[dateTableMonth - 1];
        let forwards = animated > 0;
        headerAnimation(element, text, forwards);

        element = dateTableHeader.querySelector(".current-month .year");
        if (element.querySelector(".current").textContent !== year.toString())
            headerAnimation(element, year.toString(), forwards);
    }
    //dateTableHeader.querySelector(".current-month").textContent = `${monthArray[dateTableMonth - 1]} ${dateTableYear}`;
}

function headerAnimation(element, text, forwards) {
    //console.log(forwards);
    const beforeElement = element.querySelector(".current");
    const afterElement = element.querySelector(".animation");
    afterElement.textContent = text;

    let animation = "header-animation-backwards forwards 0.3s cubic-bezier(0.76, 0, 0.24, 1)";
    if (forwards) {
        animation = "header-animation-forwards forwards 0.3s cubic-bezier(0.76, 0, 0.24, 1)";
        afterElement.style.top = "100%";
    }
    beforeElement.style.animation = animation;
    afterElement.style.animation = animation;

    setTimeout(() => {
        beforeElement.textContent = text;
        beforeElement.style.animation = "";
        afterElement.style.animation = "";
        afterElement.style.top = "";
    }, 325);
}

function datePick(button, event) {
    event.stopPropagation();
    let tempSelectedDate = new Date(dateTableYear, dateTableMonth - 1, parseInt(button.textContent));
    if (`${tempSelectedDate}` === `${selectedDate}`) {
        selectedDate = null;
        changeSelected(2, null);
        closeTab(currentTab);
    } else {
        changeSelected(2, `${button.textContent.padStart(2, "0")}/${dateTableMonth.toString().padStart(2, "0")}/${dateTableYear}`);
        selectedDate = tempSelectedDate;
    }
    setMonth(dateTableYear, dateTableMonth);

    //closeTab(currentTab);
}

function isSelected(day, monthOffset = 0) {
    let month = dateTableMonth - 1 + monthOffset;
    const date = new Date(dateTableYear, month, day);
    if (selectedDate && selectedDate.getTime() === date.getTime())
        return "selected";
    return "";
}

document.querySelector(".date-input .search-bar-header").addEventListener("click", () => {
    if (currentTab)
        return;
    let tempSelectedDate = new Date(dateTableYear, dateTableMonth - 1);
    if (selectedDate) {
        tempSelectedDate = selectedDate;
        dateTableYear = selectedDate.getFullYear();
        dateTableMonth = selectedDate.getMonth() + 1;
    }

    setMonth(tempSelectedDate.getFullYear(), tempSelectedDate.getMonth() + 1);
});


document.addEventListener("DOMContentLoaded", () => {
    setMonth(dateTableYear, dateTableMonth);
})
