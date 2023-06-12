let form = document.querySelector(".loginForm"),
    register = document.querySelector(".btnLogin"),
    errorText = document.querySelector(".error-txt");

form.onsubmit = (e) => {
    e.preventDefault(); // запобігає надсиланню форми під час події submit.
}

register.onclick = () => {
    let xhr = new XMLHttpRequest(); 
    xhr.open("POST", "../php/login.php", true); 
    xhr.onload = () => { 
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                if (data == "success") {
                    console.log(window.innerWidth)
                    if (window.innerWidth > 768) {
                        location.href = "../index.php";
                    } else {
                        location.href = "../mobiledialogs.php";
                    }
                } else {
                    errorText.textContent = data;
                    errorText.style.display = "block";
                }
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData); // POST-запрос будет отправлен на указанный URL.
}

