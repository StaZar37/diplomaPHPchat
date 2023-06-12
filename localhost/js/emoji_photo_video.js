loadAllEmoji();

function loadAllEmoji() { // Функція завантаження емоджі за допомогою циклу та верстки
    let emoji = '';
    for (let i = 128512; i <= 129488; i++) {
        emoji += `<a href="#" onclick="getEmoji(this)">&#${i};</a>`;
    }
    document.querySelector('.bg-for-emoji').innerHTML = emoji;
}

function getEmoji(control) { // Вставлення емоджі в рядок вводу
    document.querySelector('.input-field').value += control.innerHTML;
}

let timeoutId;

function changeBgClass() { // Додавання классу з відображенням фону для емоджі
    let bgElement = document.querySelector('.bg-for-emoji');
    bgElement.classList.add('changed');
    clearTimeout(timeoutId);
}

function resetBgClass() { // Зникнення класу через певний час, після того, як курсор покинув потрібну область
    timeoutId = setTimeout(function () {
        let bgElement = document.querySelector('.bg-for-emoji');
        bgElement.classList.remove('changed');
    }, 500);
}
function changeMarkdown() { // Додавання классу з відображенням контейнеру для вставки файлу
    let bgElement = document.querySelector('.bg-for-markdown');
    bgElement.classList.add('changed');
    clearTimeout(timeoutId);
}

function resetMarkdown() { // Зникнення класу через певний час, після того, як курсор покинув потрібну область
    timeoutId = setTimeout(function () {
        let bgElement = document.querySelector('.bg-for-markdown');
        bgElement.classList.remove('changed');
    }, 500);
}

