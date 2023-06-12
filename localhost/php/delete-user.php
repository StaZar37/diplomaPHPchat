<?php

session_start();
include_once "config.php";

if (isset($_POST['user_delete'])) { // Перевіряє, чи була надіслана форма з полем user_delete
    $user_id = $_POST['user_delete']; // Отримання айді юзера
    $query = "DELETE FROM users WHERE unique_id = '{$user_id}'"; // Запит на видалення користувача з бд

    $query_run = mysqli_query($conn, $query);
    if ($query_run) {
        header("location: ../index.php");
    } else {
        header("location: ../index.php");
    }
}
