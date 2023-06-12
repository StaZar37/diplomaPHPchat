
let password = document.querySelector(".fa-eye"),
    pswrField = document.querySelector("input[name='password']")

password.onclick = () => { // При кліку на елемент його тип змінюється на протилежний, в залежності від умови, а також додається або видаляється класс active
    if (pswrField.type == "password") {
        pswrField.type = "text";
        password.classList.add("active");
    } else {
        pswrField.type = "password";
        password.classList.remove("active");
    }
}