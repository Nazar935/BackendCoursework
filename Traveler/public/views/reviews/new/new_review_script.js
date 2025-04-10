const newReviewForm = document.getElementById("new-review-form");
const newReviewButton = document.getElementById("new-review-show-form");
const newReviewComponent = document.getElementById("new-review");
const newReveiwTextArea = document.getElementById("new-review-text");
let isFormOpen = false;

newReviewButton.onclick = showForm;
function showForm() {
    newReviewForm.classList.add("check-params");
    newReviewForm.classList.remove("hide");
    //console.log("---------");


    const widthBefore = newReviewButton.getBoundingClientRect().width;
    newReviewComponent.style.width = `${widthBefore + 2}px`;
    //console.log(`Width before: ${widthBefore}`);

    setTimeout(() => {
        //const widthAfter = newReviewForm.getBoundingClientRect().width;
        //console.log(`Width after: ${widthAfter}`);
        //newReviewComponent.style.width = `${widthAfter}px`;
        newReviewComponent.style.width = `100%`;

        setTimeout(() => {
            const heightBefore = newReviewButton.getBoundingClientRect().height;
            newReviewComponent.style.height = `${heightBefore}px`;
            //console.log(`Height before: ${heightBefore}`);

            const heightAfter = newReviewForm.getBoundingClientRect().height;
            console.log(heightAfter);
            newReviewForm.style.height = "0px";
            newReviewForm.classList.remove("check-params");
            setTimeout(() => {
                newReviewComponent.style.height = `${heightAfter + heightBefore}px`;
                newReviewForm.style.height = `${heightAfter}px`;
                //newReviewComponent.style.height = `100%`;
                //newReviewForm.style.height = `100%`;

                document.querySelector("#hide-review-form-button i").style.transform = "rotate(-90deg)";
                //console.log(`Height after: ${heightAfter}`);

                isFormOpen = true;
                switch_button_mode();

                setTimeout(() => {
                    newReviewComponent.style.height = "";
                    newReviewComponent.style.width = "100%";
                    newReviewForm.style.height = "";
                    newReviewForm.style.width = "100%";
                    newReveiwTextArea.focus();

                    newPhotoList.scrollIntoView({behavior: "smooth", block: "center"});
                    //newReviewButton.classList.add("hide");
                }, 300);
            }, 25);
        }, 325);
    }, 25);
}

document.querySelector("#hide-review-form-button").addEventListener("click", () => {
    const heightAfter = newReviewForm.getBoundingClientRect().height;
    newReviewForm.style.height = `${heightAfter}px`;
    document.querySelector("#hide-review-form-button i").style.transform = "rotate(90deg)";

    setTimeout(() => {
        newReviewForm.style.height = "0";
        isFormOpen = false;
        switch_button_mode();

        setTimeout(() => {
            const widthBefore = newReviewForm.getBoundingClientRect().width;
            newReviewComponent.style.width = `${widthBefore}px`;
            const widthAfter = newReviewButton.getBoundingClientRect().width;

            setTimeout(() => {
                newReviewComponent.style.width = `${widthAfter}px`;

                setTimeout(() => {
                    newReviewComponent.style.width = "";

                    newReviewForm.classList.add("hide");
                    newReviewForm.style.height = "";
                }, 300);
            }, 25);
        }, 300);
    }, 25);

});

function switch_button_mode() {
    let previousElement, nextElement;
    document.querySelectorAll("#new-review-show-form > span").forEach(el => {
        if (!el.classList.contains("hide"))
            previousElement = el;
        else
            nextElement = el;
    });


    if (isFormOpen)
        nextElement.style.top = "100%";
    else
        nextElement.style.top = "-100%";
    nextElement.classList.remove("hide");

    setTimeout(() => {
        if (isFormOpen)
            previousElement.style.top = "-100%";
        else
            previousElement.style.top = "100%";
        nextElement.style.top = "0";
        newReviewButton.classList.toggle("changed-bg");
        setTimeout(() => {
            previousElement.classList.add("hide");

            if (isFormOpen)
                newReviewButton.onclick = submitForm;
            else
                newReviewButton.onclick = showForm;
        }, 300);
    }, 25);

}

function showSlider(photoElement) {
    let photoArray = [];
    let photoIndex = 0;
    document.getElementById("new-photo-list").querySelectorAll(".photo-wrapper").forEach((photo, index) => {
        photoArray.push(photo.querySelector("img").src);
        if (photo === photoElement)
            photoIndex = index;
    });

    show_slider(photoArray, photoIndex);
}

const fileArray = [];
function addFile(file) {
    fileArray.push(file);

    const newPhoto = document.createElement("div");
    newPhoto.innerHTML = `<button class="delete-photo" type="button" onclick="deletePhoto(event)"><i class="material-icons">close</i></button>
                              <img src="${URL.createObjectURL(file)}" alt="test1.jpg"/>`;
    newPhoto.classList.add("photo-wrapper");
    newPhoto.onclick = () => showSlider(newPhoto);

    newPhotoList.insertBefore(newPhoto, addPhotoElement);
}


const addPhotoInput = document.getElementById("photo-list-input");
const addPhotoElement = addPhotoInput.closest(".add");
const newPhotoList = document.getElementById("new-photo-list");
addPhotoInput.addEventListener("change", () => {
    for (let i = 0; i < addPhotoInput.files.length; i++) {
        addFile(addPhotoInput.files[i]);
    }
});

function deletePhoto(ev) {
    ev.stopPropagation();
    const photoElement = ev.target.closest(".photo-wrapper");
    newPhotoList.querySelectorAll(".photo-wrapper").forEach((el, i) => {
        if (photoElement === el)
            fileArray.splice(i, 1);
    });

    photoElement.remove();
}

function submitForm() {
    const text = newReveiwTextArea.value;

    const formData = new FormData();
    formData.append("text", text);

    formData.append("photo_list[]", JSON.stringify([]));
    for (let i = 0; i < fileArray.length; i++)
        formData.append("photo_list[]", fileArray[i]);

    fetch("/reviews/add/", {
        method: "POST",
        body: formData
    }).then((data) => data.text()).then((text) => {
        console.log(text);
        location.replace("/reviews");
    });
}
