let muteBtn = document.querySelector(".mute_user"),
    mute_user_id = document.querySelector(".mute_user").getAttribute("value"),
    timerInput = document.getElementById("timerInput"),
    unmute_user_id = document.querySelector(".unmute_user");


muteBtn.onclick = () => {
    let muteTime = parseInt(timerInput.value); // Отримання секунд з поля для вводу
    if (isNaN(muteTime) || muteTime <= 0) { // Перевірка чи встановлено час, та чи більше він 0 секунд
        if (!timerInput.hasAttribute('hidden')) {
            alert("Час повинен бути більший 0 секунд");
            return;
        }

    }

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/mute-user.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                timerInput.value = "";
                console.log(data);
                alert('Користувача заглушено!');

            }
        }
    }
    xhr.send("mute_user=" + encodeURIComponent(mute_user_id) + '&muteTime=' + encodeURIComponent(muteTime)); // Надсилання POST-запиту на сервер з параметром mute_user та значенням user_id
}

function unmuteUser() { // Відміна заглушення, яка автоматично додається, після закінчення вказаного часу адміном
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/unmute-user.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                timerInput.value = "";
                console.log(data);
            }
        }
    }
    xhr.send("unmute_user=" + encodeURIComponent(mute_user_id)); // Запрос на сервер для знання заглушення користувача
}


unmute_user_id.onclick = () => {
    unmuteUser();
    alert('Користувач знову може спiлкуватися!');
}
