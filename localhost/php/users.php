<?php

session_start(); // Початок або відновлення PHP-сесії.
include_once "config.php"; // Підключення файлу з конфігураціями
$outgoing_id = $_SESSION['unique_id']; // Отримання значення "unique_id"
$sql = mysqli_query($conn, "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id}"); // Запит до бд,  для вибору всіх записів з таблиці users, де значення unique_id не дорівнює $outgoing_id
$output = '<div class="chat-box block-with-border"> 
<div class="users_list">
    <a class="d-flex align-items-center justify-content-between" href="index.php?user_id=100000000">
        <div class="ps-3 pt-3">
            <span class="user-chat-name"><b>Group chat<br></b></span>
            <p class="user-msg">' . $you . $msg . '</p>
        </div>
    </a>
</div>
</div>'; // Створення загального чату
if (mysqli_num_rows($sql) == 0) { //  Перевірка, чи кількість рядків у результаті запиту дорівнює 0
    $output .= "Немає користувачів з якими можна спілкуватися";
} elseif (mysqli_num_rows($sql) > 0) {
    include "data.php"; // Підключення файлу з даними
}
echo $output; // Вивід змінної, яку певним чином використають у файлі user-search.js
