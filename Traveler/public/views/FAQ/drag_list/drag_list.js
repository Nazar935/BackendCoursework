const list = document.querySelector(".questions");
let draggedItem = null;

list.addEventListener('mousedown', (e) => {
    const handle = e.target.closest('.drag-wrapper button');
    if (!handle) return;

    const item = handle.closest('.question');
    if (!item) return;

    item.setAttribute('draggable', 'true');

    item.addEventListener('dragstart', onDragStart);
    item.addEventListener('dragend', onDragEnd);
});

list.addEventListener('mouseup', (e) => {
    const item = e.target.closest('.question');
    if (item) {
        item.setAttribute('draggable', 'false');
    }
});

function onDragStart(e) {
    draggedItem = e.target;
    draggedItem.classList.add('dragging');
    //draggedItem.style.transform = "translateY(0)";
}

function onDragEnd() {
    const elementsArray = list.querySelectorAll(".question");
    for (let i = 0; i < elementsArray.length; i++)
        if (elementsArray[i] == draggedItem)
        {
            const formData = new FormData();
            formData.append("list_order", `${i + 1}`);

            fetch("/faq/changeListOrder/" + elementsArray[i].id, {
                method: "POST",
                body: formData
            }).then((data) => data.text()).then((text) => console.log(text));
        }
    document.body.style.cursor = "";
    draggedItem.classList.remove('dragging');
    draggedItem.setAttribute('draggable', 'false');
    draggedItem = null;
}

list.addEventListener('dragover', (e) => {
    e.preventDefault();

    const afterElement = getDragAfterElement(list, e.clientY);
    if (afterElement.offset < 0) {
        if (!afterElement.element.previousElementSibling.classList.contains("dragging") &&
            !afterElement.element.classList.contains("dragging")) {
            list.insertBefore(draggedItem, afterElement.element);
        }
    } else {
        if (!afterElement.element.classList.contains("dragging") &&
            !afterElement.element.nextElementSibling.classList.contains("dragging")) {
            //moveAnimation(draggedItem, afterElement.element);
            list.insertBefore(draggedItem, afterElement.element.nextElementSibling);

        }
    }
});


function getDragAfterElement(container, y) {
    const draggableElements = [...container.querySelectorAll(".question")];


    return draggableElements.reduce((closest, child) => {
        const box = child.getBoundingClientRect();
        if (y >= box.top && y <= (box.top + box.height / 2))
            return { offset: +1, element: child};
        else if (y > (box.top + box.height / 2) && y <= box.bottom)
            return { offset: -1, element: child};

        const offset = y - (box.top + box.height / 2);
        if (Math.abs(offset) < Math.abs(closest.offset)) {
            return { offset: offset, element: child };
        } else {
            return closest;
        }
    }, { offset: Number.POSITIVE_INFINITY });
}

