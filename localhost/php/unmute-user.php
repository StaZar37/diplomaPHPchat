<?php

session_start();
include_once "config.php";

if (isset($_POST['unmute_user'])) { // Перевіряє, чи була надіслана форма з полем user_delete
    $user_id = $_POST['unmute_user']; // Отримання айді юзера
    $sql = "SELECT muted_status FROM users WHERE unique_id = '{$user_id}'";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);
        $mutedStatus = $row['muted_status']; // Отримання статусу


        if ($mutedStatus == 'Заглушено') {
            $newStatus = 'Не заглушено';
        }
    }
    $query = "UPDATE users SET muted_status = '{$newStatus}', mute_time = 0 WHERE unique_id = '{$user_id}'"; // Зміна статусу на протилежний (в цій функції на 'Не заглушено')

    $query_run = mysqli_query($conn, $query);
    if ($query_run) {
        header("location: ../index.php");
    } else {
        header("location: ../index.php");
    }
}
