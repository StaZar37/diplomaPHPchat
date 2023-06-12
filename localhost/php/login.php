<?php

session_start();
include_once "config.php";
if (!empty($_POST)) { //Перевіряється, чи отримані дані з POST-запиту 
    $usrnm = mysqli_real_escape_string($conn, $_POST['usrnm']);
    $gmail = mysqli_real_escape_string($conn, $_POST['gmail']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (!empty($usrnm) && !empty($gmail) && !empty($password)) {
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE usrnm = '{$usrnm}' AND gmail = '{$gmail}' AND password = '{$password}'"); // Запит до бази даних, який вибирає користувачів з таблиці users за умовою, що їхнє ім'я користувача, адреса електронної пошти і пароль відповідають введеним значенням
        if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc(($sql));
            $status = "Активний зараз";
            $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}"); // Оновлюється, щоб встановити статус
            if ($sql2) {
                $_SESSION['unique_id'] = $row['unique_id'];
                echo "success";
            }
        } else {
            echo "Введено невiрно iм'я користувача, пошту чи пароль!";
        }
    } else {
        echo "Всi поля мають бути заповненi!";
    }
}

