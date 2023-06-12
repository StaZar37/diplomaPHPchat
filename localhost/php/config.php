<?php
$conn = mysqli_connect('localhost', 'root', '', 'chat'); // Зв'язок з бд, по її даним
if (!$conn) { 
    echo "Connect" . mysqli_connect_error();
} 
