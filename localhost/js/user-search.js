let searchBar = document.querySelector(".search input"),
    magnifier = document.querySelector(".search button"),
    usersList = document.querySelector(".scrol-block"),
    userBox = document.querySelector(".chat-box"); // Звернення до елементів HTML 


magnifier.onclick = () => { // При кліку на елемент, пошувоий рядок стає активним
    searchBar.focus();
    searchBar.value = "";
}

searchBar.onkeyup = () => { // Спрацьовує при натисканні
    let searchTerm = searchBar.value; 

    if (searchTerm != "") {
        searchBar.classList.add("active");
    } else {
        searchBar.classList.remove("active");
    }

    let xhr = new XMLHttpRequest(); // XMLHttpRequest використовується для виконання асинхронних HTTP-запитів.
    xhr.open("POST", "../php/search.php", true); // Відкриває з'єднання із сервером, виконується POST-запит до URL, true вказує на асинхронне виконання запиту.
    xhr.onload = () => { // Обробник буде викликаний, коли відповідь від сервера буде повністю завантажена.
        if (xhr.readyState === XMLHttpRequest.DONE) { // Перевірка чи відповідь сервера повністю завантажена
            if (xhr.status === 200) { // Чи статус успішний?
                let data = xhr.response; // Отримується відповідь від сервера
                usersList.innerHTML = data; // Вміст елемента - ця відповідь сервера

            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // Заголовок запиту, в якому вказується тип відправленого контенту
    xhr.send("searchTerm=" + searchTerm); // Запит відправляється на сервер разом із пошуковим терміном, який передається як параметр searchTerm
}


setInterval(() => {
    let xhr = new XMLHttpRequest(); // XMLHttpRequest використовується для виконання асинхронних HTTP-запитів.
    xhr.open("GET", "../php/users.php", true); // Відкриває з'єднання із сервером, виконується POST-запит до URL, true вказує на асинхронне виконання запиту.
    xhr.onload = () => { // Обробник буде викликаний, коли відповідь від сервера буде повністю завантажена.
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                if (!searchBar.classList.contains("active")) { // Якщо елемент searchBar не має класу active, то оновлюється вміст елементу usersList
                    usersList.innerHTML = data;
                }


            }
        }
    }
    xhr.send();
}, 500); // Функція працює кожні 0.5 секунди



