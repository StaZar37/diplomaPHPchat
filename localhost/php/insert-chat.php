<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "config.php";
    $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $file = $_FILES['file'];

    // Опрацювання повідомлень в залежності був файл чи ні,а також в яку бд його зберігати (групового чату/особистого)
    if (!empty($message) || !empty($file['name'])) { // Перевірка на те, чи не пусті рядок повідомлення чи контейнер для файлу

        if ($incoming_id != 100000000) {
            $fileName = "";
            $fileType = "";
            if (!empty($file['name'])) {
                // Якщо файл є, опрацьовуємо його 
                $fileName = time() . '_' . $file['name'];
                $targetPath = "../uploads/" . $fileName; // Шлях, куді зберігається файл
                $fileTmpName = $file['tmp_name'];
                $fileType = $file['type']; // Тип файлу
                if (move_uploaded_file($fileTmpName, $targetPath)) { // Функція завантаження файлу

                    $sql = mysqli_query($conn, "INSERT INTO message (incoming_msg_id, outgoing_msg_id, msg, file, file_type)
                                                VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', '{$fileName}', '{$fileType}')");
                } else {
                }
            } else {
                $sql = mysqli_query($conn, "INSERT INTO message (incoming_msg_id, outgoing_msg_id, msg, file, file_type)
                                            VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', '{$fileName}', '{$fileType}')");
            }
        } else {
            $fileName = "";
            if (!empty($file['name'])) {
                $fileName = time() . '_' . $file['name'];
                $targetPath = "../uploads/" . $fileName;
                $fileTmpName = $file['tmp_name'];
                $fileType = $file['type'];
                if (move_uploaded_file($fileTmpName, $targetPath)) {
                    $sql = mysqli_query($conn, "INSERT INTO cgroup (chat_id, outgoing_chat_id, msg, file, file_type)
                                                VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', '{$fileName}', '{$fileType}')");
                } else {
                }
            } else {
                $sql = mysqli_query($conn, "INSERT INTO cgroup (chat_id, outgoing_chat_id, msg, file, file_type)
                                            VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', '{$fileName}', '{$fileType}')");
            }
        }
    }
} else {
    header("location: ../loginForm.php");
}
