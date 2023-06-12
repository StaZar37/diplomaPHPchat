<?php
session_start();
include_once "config.php";
$outgoing_id = $_SESSION['unique_id'];
$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']); // Змінна, за допомогою якої відбувається пошуковий запит (searchTerm - пошуковий термін) 
$output = "";
$sql = mysqli_query($conn, "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} AND (name LIKE '%{$searchTerm}%')"); // Запит до бази даних, що вибирає всіх користувачів, виключаючи поточного користувача  і з ім'ям, яке відповідає пошуковому термін

if (mysqli_num_rows($sql) > 0) {
    include "data.php";
} else {
    $output .= "<div class='pt-2 krr'>
                Немає користувачів із таким ім'ям
                </div>";
}
echo $output;
