<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "config.php";
    $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $output = "";

    $sql1 = "SELECT * FROM users"; // Запит для отримання списку користувачів з таблиці users
    $query = mysqli_query($conn, $sql1);
    $users = [];



    $admin_id = $_SESSION['unique_id'];
    if ($admin_id != 1422956794) { // Перевірка чи теперешня сесія це адмін
        $user_checker = "krestik"; // Змінна для задання стилю в залежності від умови
        $admin_checker = ""; // Змінна для задання стилю в залежності від умови
        $user_checker2 = "d-none"; // Змінна для задання стилю в залежності від умови
    } else {
        $user_checker = ""; // Змінна для задання стилю в залежності від умови
        $user_checker2 = ""; // Змінна для задання стилю в залежності від умови
        $admin_checker = "krestik"; // Змінна для задання стилю в залежності від умови
    }
    if ($query) { // Перевірка наявності результатів запиту і заповнення масиву $users
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $users[strval($row['unique_id'])] = $row['usrnm']; //  Асоціативний масив з користувачами, де ключами є unique_id, а значеннями - usrnm
            }
        }
    }
    if ($incoming_id != 100000000) { // Запит для отримання повідомлень, залежно від значення incoming_id
        $sql = "SELECT message.*, outgoing.usrnm AS outgoing_username, incoming.usrnm AS incoming_username
        FROM message INNER JOIN users AS outgoing ON message.outgoing_msg_id = outgoing.unique_id
        INNER JOIN users AS incoming ON message.incoming_msg_id = incoming.unique_id
        WHERE (message.outgoing_msg_id = {$outgoing_id} AND message.incoming_msg_id = {$incoming_id})
        OR (message.outgoing_msg_id = {$incoming_id} AND message.incoming_msg_id = {$outgoing_id})
        ORDER BY message.msg_id";
    } else {
        $sql = "SELECT * FROM cgroup WHERE cgroup.chat_id = {$incoming_id}";
    }




    $query = mysqli_query($conn, $sql); // Запит до бд
    if ($query) {
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $check = $row['outgoing_msg_id']; // Для кожного рядка визначається змінна $check, яка містить значення поля outgoing_msg_id рядка
                if ($incoming_id == 100000000) {
                    $outgoing_username = $users[$row['outgoing_chat_id']];
                    $incoming_username = $users[$row['outgoing_chat_id']];
                    $check = $row['outgoing_chat_id'];
                } else {
                    $outgoing_username = $users[$row['outgoing_msg_id']];
                    $incoming_username = $users[$row['incoming_msg_id']];
                }
                if (intval($check) === intval($outgoing_id)) { // Цей рядок перевіряє, чи ідентифікатор відправника повідомлення, збережений у змінній $check, співпадає з ідентифікатором поточного відправника, збереженим у змінній $outgoing_id. 
                    // Наступні умови відповідають за зображення (дизайн відправника\отримувача) звичайного повідомлення, а також повідомлення з фото\відео\файлом у звичайному чаті та у груповому окремо
                    if (strpos($row['file_type'], 'image') !== false) {
                        $output .= '<div class="outgoing mess id-' . $row['msg_id'] . '">
                                        <div class="details d-flex">
                                            <p class="p-2 main-chat-user-msg-right">' . $outgoing_username . '<br>' . ' <span class="size-for-msg-text"><img src=" ../uploads/' . $row['file'] . '" class="message-image">' . $row['msg'] . '<a href="./php/delete-message.php?msg_id=' . $row['msg_id'] . '&incoming_id=' . $incoming_id  . '"  class="'  . $admin_checker . " " . $user_checker . '" value="' . $row['msg_id'] . '">&#x274C</a></span></p>
                                            
                                        </div>
                                    </div>';
                    } elseif (strpos($row['file_type'], 'video') !== false) {
                        $output .= '<div class="outgoing mess id-' . $row['msg_id'] . '">
                                        <div class="details d-flex">
                                            <p class="p-2 main-chat-user-msg-right">' . $outgoing_username . '<br>' . ' <span class="size-for-msg-text"><video src=" ../uploads/' . $row['file'] . '" class="message-video" controls ></video>' . $row['msg'] . '<a href="./php/delete-message.php?msg_id=' . $row['msg_id'] . '&incoming_id=' . $incoming_id  . '"  class="'  . $admin_checker . " " . $user_checker . '" value="' . $row['msg_id'] . '">&#x274C</a></span></p>
                                            
                                        </div>
                                    </div>';
                    } elseif (strpos($row['file_type'], 'application') !== false) {
                        $output .= '<div class="outgoing mess id-' . $row['msg_id'] . '">
                                        <div class="details d-flex">
                                            <p class="p-2 main-chat-user-msg-right">' . $outgoing_username . '<br>' . ' <span class="size-for-msg-text"><a href="../uploads/' . $row['file'] . '"  style="color: white; text-decoration: none" download>' . $row['file'] . '</a>
                                            ' . $row['msg'] . '<a href="./php/delete-message.php?msg_id=' . $row['msg_id'] . '&incoming_id=' . $incoming_id  . '"  class="'  . $admin_checker . " " . $user_checker . '" value="' . $row['msg_id'] . '">&#x274C</a></span></p>
                                        </div>
                                    </div>';
                        // 
                    } else {
                        $output .= '<div class="outgoing mess id-' . $row['msg_id'] . '">
                                        <div class="details d-flex">
                                            <p class="p-2 main-chat-user-msg-right">' . $outgoing_username . '<br>' . ' <span class="size-for-msg-text">' . $row['msg'] . '<a href="./php/delete-message.php?msg_id=' . $row['msg_id'] . '&incoming_id=' . $incoming_id  . '"  class="'  . $admin_checker . " " . $user_checker . '" value="' . $row['msg_id'] . '">&#x274C</a></span></p>
                                        </div>
                                    </div>';
                    }
                } else {
                    if (strpos($row['file_type'], 'image') !== false) {
                        $output .= '<div class="incoming mess id-' . $row['msg_id'] . '">
                                        <div class="details d-flex">
                                            <p class="p-2 main-chat-user-msg-left">' . $outgoing_username . '<br>' . ' <span class="size-for-msg-text"><img src=" ../uploads/' . $row['file'] . '"  class="message-image">' . $row['msg'] . '<a href="./php/delete-message.php?msg_id=' . $row['msg_id'] . '&incoming_id=' . $incoming_id  . '"  class="'  . $admin_checker . " " . $user_checker2 . '" value="' . $row['msg_id'] . '">&#x274C</a></span></p>
                                        </div>
                                    </div>';
                    } elseif (strpos($row['file_type'], 'video') !== false) {
                        $output .= '<div class="incoming mess id-' . $row['msg_id'] . '">
                                        <div class="details d-flex">
                                            <p class="p-2 main-chat-user-msg-left">' . $outgoing_username . '<br>' . ' <span class="size-for-msg-text">   <video src=" ../uploads/' . $row['file'] . '" class="message-video" controls></video>' . $row['msg'] . '<a href="./php/delete-message.php?msg_id=' . $row['msg_id'] . '&incoming_id=' . $incoming_id  . '"  class="'  . $admin_checker . " " . $user_checker2 . '" value="' . $row['msg_id'] . '">&#x274C</a></span></p>

                                        </div>
                                    </div>';
                    } elseif (strpos($row['file_type'], 'application') !== false) {
                        $output .= '<div class="incoming mess id-' . $row['msg_id'] . '">
                                        <div class="details d-flex">
                                            <p class="p-2 main-chat-user-msg-left">' . $outgoing_username . '<br>' . ' <span class="size-for-msg-text"><a href="../uploads/' . $row['file'] . '"  style="color: white; text-decoration: none" download>' . $row['file'] . '</a>
                                            ' . $row['msg'] . '<a href="./php/delete-message.php?msg_id=' . $row['msg_id'] . '&incoming_id=' . $incoming_id  . '"  class="'  . $admin_checker . " " . $user_checker2 . '" value="' . $row['msg_id'] . '">&#x274C</a></span></p>
                                        </div>
                                    </div>';
                        // 
                    } else {
                        $output .= '<div class="incoming mess id-' . $row['msg_id'] . '">
                                        <div class="details d-flex">
                                            <p class="p-2 main-chat-user-msg-left">' . $outgoing_username . '<br>' . ' <span class="size-for-msg-text">' . $row['msg'] . '<a href="./php/delete-message.php?msg_id=' . $row['msg_id'] . '&incoming_id=' . $incoming_id  . '"  class="'  . $admin_checker . " " . $user_checker2 . '" value="' . $row['msg_id'] . '">&#x274C </a></span></p>
                                        </div>
                                    </div>';
                    }
                }
            }

            echo $output;
        }
    }
} else {
    header("location: ../loginForm.php");
}
