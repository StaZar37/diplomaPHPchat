<?php

session_start();
include_once "config.php";
$name = mysqli_real_escape_string($conn, $_POST['name']); // Отримання змінної, а потім її екранування, тобто перетворення спец. символів, які можуть вплинути на структуру SQL-запиту 
$usrnm = mysqli_real_escape_string($conn, $_POST['usrnm']); // Отримання змінної, а потім її екранування, тобто перетворення спец. символів, які можуть вплинути на структуру SQL-запиту 
$gmail = mysqli_real_escape_string($conn, $_POST['gmail']); // Отримання змінної, а потім її екранування, тобто перетворення спец. символів, які можуть вплинути на структуру SQL-запиту 
$password = mysqli_real_escape_string($conn, $_POST['password']); // Отримання змінної, а потім її екранування, тобто перетворення спец. символів, які можуть вплинути на структуру SQL-запиту 

if (!empty($name) && !empty($usrnm) && !empty($gmail) && !empty($password)) { // Перевірка, чи всі поля не є пустими

    if (filter_var($gmail, FILTER_VALIDATE_EMAIL)) { // Перевірка, чи значення змінної "$gmail" є валідною електронною поштою
        $sql = mysqli_query($conn, "SELECT gmail FROM users WHERE gmail = '{$gmail}'"); // Запит до бази даних 
        if (mysqli_num_rows($sql) > 0) { //  Перевірка чи існує вже користувач з таким самим "gmail"
            echo "$gmail - This gmail already exist";
        } else {
            $status = 'Активний зараз';
            $muted_status = 'Не заглушено';
            $mute_time = 0;
            $random_id = rand(time(), 10000000); // Випадкове число
            $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, name, usrnm, gmail, password, status, muted_status, mute_time) 
            VALUES ({$random_id}, '{$name}', '{$usrnm}', '{$gmail}', '{$password}', '{$status}', '{$muted_status}', '{$mute_time}') "); // Запит для вибору даних нового користувача з бази даних
            if ($sql2) { // Якщо запит виконався успішно
                $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE gmail = '{$gmail}'");
                if (mysqli_num_rows($sql3) > 0) {
                    $row = mysqli_fetch_assoc($sql3); // повертає асоціативний масив з отриманими даними
                    $_SESSION['unique_id'] = $row['unique_id'];
                    echo "success";
                }
            } else {
                echo "Щось пiшло не так...";
            }
        }
    } else {
        echo "$gmail - це не валiдний gmail";
    }
} else {
    echo "Всi поля мають бути заповненi!";
}
