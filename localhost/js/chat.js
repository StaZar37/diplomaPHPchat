let form = document.querySelector(".sendmesstr"),
    sendBtn = document.querySelector(".enter"),
    inputField = document.querySelector(".input-field"),
    chatBox = document.querySelector(".chat-box-mes"),
    fileInput = document.querySelector("#file-input");

form.onsubmit = (e) => {
    e.preventDefault(); // Запобігає надсиланню форми під час події submit.
}



function send() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/insert-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                inputField.value = "";
                fileInput.value = "";
                scrollToBottom(); // Функція яка опускається до низу чату
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}

sendBtn.onclick = () => {
    send();
}

document.addEventListener("keydown", function (event) { // При неатисканнi ентеру надсилається повiдомлення
    if (event.key === "Enter") {
        send();
    }
});

chatBox.onmouseenter = () => { // Коли курсор в межах елементу, додається клас active
    chatBox.classList.add("active");
}

chatBox.onmouseleave = () => { // Коли курсор за межами елементу, видаляється клас active
    chatBox.classList.remove("active");
}

chatBox.addEventListener("touchstart", () => { // При дотику додається клас active
    chatBox.classList.add("active");
});
chatBox.addEventListener("touchend", () => { // Коли дотика немає клас видаляється active
    chatBox.classList.remove("active");
});

setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/get-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let chatBox2 = $(".chat-box-mes");
                let data = xhr.response;
                let tempElement = $('<div></div>');
                tempElement.html(data); // Огортаємо наші дані додатковим тегом div

                let newMessages = tempElement.find('div.mess').filter(function () { // Знаходить всі елементи div з класом "mess" всередині tempElement, фільтрує їх
                    let id = $(this).attr('class').split(' ')[2]; // У функції зворотного виклику отримується id елементу, який є третім класом у списку класів елементу. Перевіряється, чи існує елемент з класом, який складається з значення id в chatBox2
                    return !chatBox2.find('.' + id).length; // Перевіряєм присутність повідомлень в chatBox
                });

                chatBox2.append(newMessages); // Додаємо нові повідомлення в chatBox 
                if (!chatBox2.hasClass("active")) { // Перевірка наявності классу active в chatBox2
                    scrollToBottom();
                }
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}, 500);

function scrollToBottom() {  // Функція яка опускається до низу чату
    chatBox.scrollTop = chatBox.scrollHeight;
}

