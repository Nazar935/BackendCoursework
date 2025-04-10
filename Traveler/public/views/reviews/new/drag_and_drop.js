
let dragCounter = 0;
newReviewComponent.addEventListener("dragenter", (event) => {
    dragCounter++;
    event.preventDefault();
    if (dragCounter === 1 && isFormOpen) {
        newReviewComponent.classList.add("drag");
        console.log("drag start");
    }

});

newReviewComponent.addEventListener("dragleave", (event) => {
    dragCounter--;
    event.preventDefault();
    if (!newReviewComponent.contains(event.relatedTarget) && dragCounter === 0) {
        endDragEvent();
    }
});

newReviewComponent.addEventListener("dragover", (event) => {
    event.preventDefault();
});

newReviewComponent.addEventListener("drop", (event) => {
    dragCounter = 0;
    event.preventDefault();
    const files = event.dataTransfer.files;
    for (let i = 0; i < files.length; i++) {
        addFile(files[i]);
    }
    endDragEvent();
});

function endDragEvent() {
    console.log("drag end");
    const dragImage = newReviewComponent.querySelector(".drag-image");
    dragImage.classList.remove("drag-end");
    dragImage.classList.add("drag-end");

    setTimeout(() => {
        newReviewComponent.classList.remove("drag");
        dragImage.classList.remove("drag-end");
    }, 300);
}

window.addEventListener("paste", (event) => {
    if (!isFormOpen)
        return;
    const clipboardItems = event.clipboardData || window.clipboardData;
    for (let i = 0; i < clipboardItems.files.length; i++) {
        addFile(clipboardItems.files[i]);
    }
});