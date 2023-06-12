<?php

session_start();
include_once "config.php";

if (isset($_POST['mute_user']) && isset($_POST['muteTime'])) { // Перевіряє, чи була надіслана форма з полем user_delete
    $user_id = $_POST['mute_user']; // Отримання айді юзера
    $sql = "SELECT muted_status FROM users WHERE unique_id = '{$user_id}'";

    $time_duration = $_POST['muteTime']; // Отримання часу на який заглушили користувача
    $starttime = time(); // Отримання поточного часу
    $endtime = $starttime + $time_duration;

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);
        $mutedStatus = $row['muted_status'];


        if ($mutedStatus == 'Заглушено') {
            $newStatus = 'Не заглушено';
        } elseif ($mutedStatus == 'Не заглушено') {
            $newStatus = 'Заглушено';
        } elseif ($mutedStatus = ' ') {
            $newStatus = 'Не заглушено';
        }
    }
    $query = "UPDATE users SET muted_status = '{$newStatus}', mute_time = '{$endtime}' WHERE unique_id = '{$user_id}'"; // Зміна статусу на протилежний

    $query_run = mysqli_query($conn, $query);
    if ($query_run) {
        header("location: ../index.php");
    } else {
        header("location: ../index.php");
    }
}
