let deleteBtn = document.querySelector(".delete_user"),
    user_id = document.querySelector(".delete_user").getAttribute("value");

deleteBtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/delete-user.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                location.href = "../index.php";
            }
        }
    }
    xhr.send("user_delete=" + encodeURIComponent(user_id)); // Надсилання POST-запиту на сервер з параметром user_delete та значенням user_id
}