document.querySelector(".user-admin").addEventListener("click", function(e) {
    const blockButton = e.target.closest(".delete-button");
    if (blockButton) {
        const formData = new FormData();
        formData.append("user_id", blockButton.dataset.userId);

        fetch("user/block", {
            method: "POST",
            body: formData
        }).then(data => data.json()).then((user) => {
            const userElement = blockButton.closest(".user");
            const index = userElement.dataset.index;

            userElement.outerHTML = displayUser(user, index);
            if (user.blocked)
                Message.show(`Користувач "${user.username}" заблокований`, Message.neutral);
            else
                Message.show(`Користувач "${user.username}" розблокований`, Message.positive);
            fetch("/main/clear_message");
        }).catch((err) => {
            console.log(err);
            Message.show("Помилка під час виконання дії", Message.negative);
        });
    }
});

searchUsers();

const userSearchInput = document.querySelector(".user-admin input#user-search");
userSearchInput.addEventListener("input", function(e) {
    searchUsers(userSearchInput.value);
});

const userList = document.getElementById("user-list");
function searchUsers(searchText = "") {
    const formData = new FormData();
    formData.append("search_text", searchText);

    fetch("/user/json_search", {
        method: "POST",
        body: formData
    }).then(data => data.json()).then((userArray) => {
        userList.innerHTML = "";
        userArray.forEach((user, i) => {
            userList.innerHTML += displayUser(user, i + 1);
        });
    }).catch((err) => {
        Message.show("Помилка завантаження списку користувачів", Message.negative);
    });
}

function displayUser(user, index) {
    let res =  `
        <div class="user" data-index="${index}">
            <div class="index">${index}.</div>
            <a class="link" href="/user/view/${user.username}">
                <div class="pfp" style="background: ${user.picture.background}">
                    <span style="color: ${user.picture.font_color}">${user.picture.letter}</span>
                </div>
                <div class="name-wrapper">
                    <div class="name">${user.username}</div>`
    if (user.blocked)
        res += `<div class="blocked description">banned</div>`;
    res += `
                </div>
            </a>
            <div class="button-wrapper">`
    if (!user.is_admin) {
        res += `
                <button class="delete-button ${user.blocked? 'unblock' : ''}" data-user-id="${user['id']}">
                    `;

        if (user.blocked)
            res += `<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M240-440q-17 0-28.5-11.5T200-480q0-17 11.5-28.5T240-520h480q17 0 28.5 11.5T760-480q0 17-11.5 28.5T720-440H240Z"/></svg>`;
        res += `
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q54 0 104-17.5t92-50.5L228-676q-33 42-50.5 92T160-480q0 134 93 227t227 93Zm252-124q33-42 50.5-92T800-480q0-134-93-227t-227-93q-54 0-104 17.5T284-732l448 448Z"/></svg>
                </button> 
        `;
    }
    res += `</div>
        </div>`;

    return res;
}