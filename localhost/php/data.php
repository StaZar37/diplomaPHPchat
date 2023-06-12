<?php
session_start();
while ($row = mysqli_fetch_assoc($sql)) {

    $sql2 = "SELECT * FROM message WHERE (incoming_msg_id = {$row['unique_id']}
            OR outgoing_msg_id = {$row['unique_id']}) AND (outgoing_msg_id = {$_SESSION['unique_id']}
            OR incoming_msg_id = {$_SESSION['unique_id']}) ORDER BY msg_id DESC LIMIT 1"; // Отримання останнього повідомлення між поточним користувачем і користувачем, що відповідає поточному рядку ($row['unique_id'])

    $query2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($query2);
    if (mysqli_num_rows($query2) > 0) {
        $result = $row2['msg'];
        if (!$result) {
            $result = $row2['file_type'];
        }
        // Вивід останнього повідомлення
    } else {
        $result = "Поки немає повiдомлень";
    }
    (strlen($result) > 60) ? $msg = substr($result, 0, 60) . '...' : $msg = $result; // Вивід рядка, точніше його перших 60 символів, якщо вони є, потім три крапки і рядом стає скритим

    ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "Ви: " : $you = ""; // Якщо айді останнього повідомлення теперішньої сесії, то до повідомлення в чаті додається слово "Ви"

    ($row['status'] == "Неактивний зараз") ? $offline = "offline" : $offline = ""; // Зміна статусу, якщо людина виходить з акаунту

    // Вивід кожного чату на екран

    $output .= '<div class="chat-box">
                        <div class="users_list">
                            <a class="d-flex align-items-center justify-content-between" href="index.php?user_id=' . $row['unique_id'] . '">
                                <div class="ps-3 pt-3">
                                    <span class="user-chat-name"><b>' . $row['name'] . '<br></b></span>
                                    <p class="user-msg">' . $you . $msg .  $result2 . '</p>
                                </div>
                                <div class="status-dot ' . $offline . ' material-symbols-outlined pe-3"><b>&#x2022;</b></div>
                            </a>
                        </div>
                    </div>';
}
