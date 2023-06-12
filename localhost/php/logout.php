<?php

session_start();


if (isset($_SESSION['unique_id'])) {
    include_once "config.php";
    $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']); // Ідентифікатор для вихідного запиту
    if (isset($logout_id)) { // Перевіряється, чи logout_id встановлено
        $status = "Неактивний зараз";
        $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$logout_id}"); // Оновлення статусу
        if ($sql) {
            session_unset(); // Сесія очищається
            session_destroy(); // Сесія знищується
            header("location: ../loginForm.php"); // Перенаправлення на сторінку входу
        }
    } else {
        header("location: ../index.php");
    }
} else {
    header("location: ../loginForm.php");
}
