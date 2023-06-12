let form = document.querySelector(".signForm"),
    register = document.querySelector(".btnApplication"),
    errorText = document.querySelector(".error-txt");

form.onsubmit = (e) => {
    e.preventDefault(); // запобігає надсиланню форми під час події submit.
}

register.onclick = () => {
    let xhr = new XMLHttpRequest(); 
    xhr.open("POST", "../php/signup.php", true); 
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                if (data == "success") {
                    if (window.innerWidth > 768) { // Якщо розмір вікна ширший за 768 пікселів то редірект на ihdex.php
                        location.href = "../index.php";
                    } else {
                        location.href = "../mobiledialogs.php"; // Якщо розмір вікна менший за 768 пікселів то редірект на mobiledialogs.php
                    }
                } else {
                    errorText.style.display = "block"; // З'явлення помилки
                    errorText.textContent = data;

                }
            }
        }
    }
    let formData = new FormData(form); // Створення форми з даними, що відправляються на сервер
    xhr.send(formData); // Відправляється POST-запит на сервер з даними форми
}


