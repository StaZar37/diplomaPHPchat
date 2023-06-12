<?php

session_start();
include_once "config.php";
// З URL-параметрів отримуються значення incoming_id та msg_id за допомогою $_GET
$incoming_id = $_GET['incoming_id'];
$msg_id = $_GET['msg_id'];


if ($incoming_id != 100000000) {
    $sql = "DELETE FROM message WHERE msg_id = {$msg_id}"; // Видалення повідомлення з таблиці message 
} else {
    $sql = "DELETE FROM cgroup WHERE msg_id = {$msg_id}"; // Видалення повідомлення з таблиці cgroup
}
$dlt = mysqli_query($conn, $sql);
header("location: " . $_SERVER['HTTP_REFERER']); // Перенаправлення на сторінку, з якої був запит видалення
