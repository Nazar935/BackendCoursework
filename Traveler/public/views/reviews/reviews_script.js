resize_reviews();
window.onresize = resize_reviews;

function resize_reviews() {
    document.querySelectorAll(".review .photo-list").forEach((photo_list) => {
        const photo_count = photo_list.children.length;
        const photolist_leftpadding = 50;
        const photolist_rightpadding = 50;
        const photolist_gap = 50;
        const photo_width = 100;
        const photo_max_count = Math.floor((photo_list.clientWidth -
            photolist_leftpadding - photolist_rightpadding + photolist_gap) / (photo_width + photolist_gap));

        for (let i = 0; i < Math.min(photo_count, photo_max_count); i++)
            photo_list.children[i].style.display = "block";
        for (let i = photo_max_count; i < photo_count; i++)
            photo_list.children[i].style.display = "none";

        for (let i = 0; i < photo_count; i++)
        {
            const text_element = photo_list.children[i].querySelector("div");
            if (text_element)
                text_element.remove();
        }

        if (photo_count > photo_max_count)
        {
            const last_photo = photo_list.children[photo_max_count - 1];

            let text_element = last_photo.querySelector("div");
            if (!text_element)
            {
                text_element = document.createElement("div");
                text_element.textContent = `+ ${photo_count - photo_max_count + 1}`;
                last_photo.appendChild(text_element);
            }
        }
    });

    document.querySelectorAll(".review .text:not(.hidden)").forEach((text_component) => {
        const text_component_copy = document.createElement("div");
        text_component_copy.classList.add("text", "hidden");
        text_component_copy.innerHTML += text_component.innerHTML;
        text_component_copy.style.webkitLineClamp = "unset";
        text_component.appendChild(text_component_copy);

        setTimeout(() => {
            const fullTextButton = text_component.closest(".review").querySelector(".full-text-button");
            if (text_component_copy.getBoundingClientRect().height !== text_component.getBoundingClientRect().height) {
                fullTextButton.style.display = "inherit";
            } else {
                fullTextButton.style.display = "none";
            }
            text_component_copy.remove();

        }, 25);
    });
}

document.querySelectorAll(".reviews .photo-list").forEach((photo_list) => {
    const photo_array = [];
    photo_list.querySelectorAll(".review-photo img").forEach((photo) => {
        photo_array.push(photo.src);
    });

    photo_list.querySelectorAll(".review-photo").forEach((photo_wrapper, photo_index) => {
        photo_wrapper.onclick = function () {
            show_slider(photo_array, photo_index);
        }
    });
});

document.querySelectorAll(".read-more").forEach((button) => {
    button.onclick = full_text;
});
function full_text(e) {
    const review_component = e.target.closest(".review");



    const text_component = e.target.closest(".review").querySelector(".text");
    text_component.style.height = `${text_component.getBoundingClientRect().height}px`;
    const text_component_copy = document.createElement("div");
    console.log(`before: ${text_component.getBoundingClientRect().height}`);
    text_component_copy.classList.add("text", "hidden");
    text_component_copy.innerHTML += text_component.innerHTML;
    text_component.appendChild(text_component_copy);

    setTimeout(() => {
        console.log(`after: ${text_component_copy.getBoundingClientRect().height}`);
        text_component.style.height = `${text_component_copy.getBoundingClientRect().height}px`;
        text_component_copy.remove();

        setTimeout(() => {
            text_component.style.height = "";
        }, 500);
    }, 25);

    const button_element = e.target.closest("button");
    const span_element = button_element.querySelector("span");
    button_element.classList.toggle("clicked");
    if (button_element.classList.contains("clicked"))
        span_element.textContent = "Read less";
    else
        span_element.textContent = "Read more";
    review_component.classList.toggle("full-text");
}

document.querySelectorAll(".delete-button").forEach((button) => {
    button.onclick = function () {
        const reviewElement =  button.closest(".review");
        const review_id = reviewElement.dataset.id;


        const formData = new FormData();
        formData.append("review_id", review_id);

        fetch("/reviews/delete/", {
            method: "POST",
            body: formData
        }).then((data) => data.text()).then((text) => {
            console.log(text);


        });

        const deleteIcon = document.createElement("div");
        deleteIcon.classList.add("delete-icon");
        deleteIcon.innerHTML = `<i class="material-icons">delete</i>`;

        reviewElement.classList.add("deleted");
        reviewElement.after(deleteIcon);

        setTimeout(() => {
            location.reload();
        }, 1000);
    }
})


const page = parseInt(document.querySelector(".page-slider").dataset.page);
const pagesCount = parseInt(document.querySelector(".page-slider").dataset.pagesCount);
const isModer = parseInt(document.querySelector(".page-slider").dataset.isModer);
const pageLink = isModer ? "admin" : "page";
const pageSlider = document.querySelector(".page-slider");
pageSlider.innerHTML = "";

if (page === 1) {
    pageSlider.innerHTML = `<a  class="left disabled" aria-disabled="true">
                    <i class="material-icons">keyboard_arrow_left</i>
                </a>`;
} else {
    pageSlider.innerHTML = `<a href="/reviews/${pageLink}/${page - 1}" class="left" aria-disabled="true">
                    <i class="material-icons">chevron_left</i>
                </a>`;
}


if (pagesCount <= 7) {
    for (let i = 1; i <= pagesCount; i++)
        pageSlider.innerHTML += `<a href="/reviews/${pageLink}/${i}">${i}</a>`;
} else {
    pageSlider.innerHTML += `<a href="/reviews/${pageLink}/1">1</a>`;

    if (page < 4) {
        for (let i = 2; i <= 5; i++)
            pageSlider.innerHTML += `<a href="/reviews/${pageLink}/${i}">${i}</a>`;
    } else {
        pageSlider.innerHTML += `<div class="middle-part">...</div>`;
        if (pagesCount - page >= 4) {
            for (let i = page - 1; i <= page + 1; i++)
                pageSlider.innerHTML += `<a href="/reviews/${pageLink}/${i}">${i}</a>`;
        }
    }

    if (pagesCount - page >= 4)
        pageSlider.innerHTML += `<div class="middle-part">...</div>`;
    else {
        for (let i = pagesCount - 4; i < pagesCount; i++)
            pageSlider.innerHTML += `<a href="/reviews/${pageLink}/${i}">${i}</a>`;
    }

    pageSlider.innerHTML += `<a href="/reviews/${pageLink}/${pagesCount}">${pagesCount}</a>`;
}


if (page === pagesCount) {
    pageSlider.innerHTML += `<a  class="right disabled" aria-disabled="true">
                    <i class="material-icons">keyboard_arrow_right</i>
                </a>`;
} else {
    pageSlider.innerHTML += `<a href="/reviews/${pageLink}/${page + 1}" class="right" aria-disabled="true">
                    <i class="material-icons">chevron_right</i>
                </a>`;
}


setTimeout(() => {
    pageSlider.querySelectorAll("a").forEach((button) => {
        if (button.text === page.toString())
            button.classList.add("current-page");
    });
}, 25);