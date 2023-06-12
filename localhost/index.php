<?php
session_start();
include_once "./php/config.php";
if (!isset($_SESSION['unique_id'])) {
    header("location: ./loginForm.php");
}

?>
<!-- Перевірка на авторизацію користувачем, якщо зайшов в цьому браузері в аккаунт, то буде одразу редірект на головну -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="./styles/User_chat-style.css">
    <link rel="stylesheet" href="./media/media-user-chat.css">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-...YOUR-INTEGRITY-CODE-HERE..." crossorigin="anonymous" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Chat KN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!-- bootstrap (framework JS) -->

    <script>
        let redirected = false;

        function redirectOnResize() { // Функція, що перевіряє розмір вікна браузера та наявність параметра "user_id" у URL-адрес та перенапрявляє згідно з умовою
            if (window.innerWidth < 768 && !redirected && !hasUserId()) {
                window.location.href = "mobiledialogs.php";
                redirected = true;
            } else if (window.innerWidth >= 768 && redirected) {
                redirected = false;
                window.location.href = "index.php";
            }
        }

        function hasUserId() { // Перевіряє наявність параметра "user_id" у URL-адресі
            let urlParams = new URLSearchParams(window.location.search); // Отримання всіх параметрів URL і ->
            return urlParams.has("user_id"); // Перевіряє, чи є серед них "user_id"
        }
        window.addEventListener("resize", redirectOnResize); // При зміні розміру вікна браузера спрацьовує функція
        window.onload = redirectOnResize; // При повному завантаженні сторінки  спрацьовує функція
    </script>

</head>

<body>
    <!-- Фоновi частинки -->
    <div id="particles-js"></div>

    <!-- Шапка сторiнки -->

    <header>

        <?php
        include_once "./php/config.php";

        $que = mysqli_query($conn, "SELECT * FROM users");

        if ($que) {
            if (mysqli_num_rows($que) > 0) {

                while ($row5 = mysqli_fetch_assoc($que)) {
                    if ($row5['mute_time'] != 0) {
                        if ($row5['mute_time']  < time()) {
                            $row5['muted_status'] = 'Не заглушено';
                            $sql = mysqli_query($conn, "UPDATE users SET muted_status = '{$row5['muted_status']}', mute_time = 0 WHERE unique_id = {$row5['unique_id']}");
                        }
                    }
                }
            }
        }

        $user_id = mysqli_real_escape_string($conn, $_GET['user_id']); // Отримання айді співрозмовника
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
        $unique_id = $_SESSION['unique_id']; // Отримання айді поточної сесії
        $group_chat_id = 100000000;
        if ($sql) {
            if (mysqli_num_rows($sql) > 0) {
                $row = mysqli_fetch_assoc(($sql));
            }
        } else {
            $ans = "Оберiть чат для спiлкування";
        }

        $sql1 = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$unique_id}");
        if (mysqli_num_rows($sql1) > 0) {
            $row1 = mysqli_fetch_assoc(($sql1));
        }
        if ($user_id) { // Перевіряє, чи вдалося отримати $user_id
            $chat_area = "d-flex";  // Змінна, що використовується як стиль, при тій чи іншій умові
            $back_arrow = "d-block"; // Змінна, що використовується як стиль, при тій чи іншій умові
        } else {
            $chat_area = "d-none"; // Змінна, що використовується як стиль, при тій чи іншій умові
            $back_arrow = "d-none"; // Змінна, що використовується як стиль, при тій чи іншій умові
        }

        $muted_status = mysqli_query($conn, "SELECT muted_status FROM users WHERE unique_id = '{$unique_id}'");
        $row2 = mysqli_fetch_assoc($muted_status);

        if ($row2['muted_status'] == 'Не заглушено') { // Перевірка на змогу писати повідомлення користувачем
            $mute = '';
        } elseif ($row2['muted_status'] == 'Заглушено') {
            if ($user_id == $group_chat_id) { // Прибирання можливості писати тільки в груповому чаті
                $mute = 'hidden';
            }
        }
        $input_checker = "hidden";
        $smile_check1 = "hidden";
        $smile_check2 = "hidden";
        $smile_check3 = "hidden";


        if (isset($_SESSION['unique_id'])) { // Перевірка чи існує unique_id
            $admcheck = $_SESSION['unique_id'];

            if ($admcheck == 1422956794 && $user_id && $user_id != $group_chat_id) { // Перевірка на айді адміна, якщо виконуються умови, то використовують ту чи іншу змінну
                $input_checker = "";
                $smile_check1 = "";
                $muted_status = mysqli_query($conn, "SELECT muted_status FROM users WHERE unique_id = '{$user_id}'");
                $row3 = mysqli_fetch_assoc($muted_status);

                if ($row3['muted_status'] == 'Не заглушено') {
                    $input_checker = "";
                    $checker_status = "d-block";
                    $smile_check2 = "";
                } elseif ($row3['muted_status'] == 'Заглушено') {
                    $input_checker = "hidden";
                    $checker_status = 'd-none';
                    $smile_check3 = "";
                }
            } else {
                // $del_user = "d-none";
            }
        }

        ?>



        <div class="container-fluid">
            <div class="row">

                <div class="col-0 col-xl-3 col-lg-3 col-md-3 col-sm-0 col-xs-0  block-under-search">
                    <div class="d-flex align-items-center justify-content-between ms-1">
                        <div class="header-above-search mt-1">
                            <!-- echo $row1['name']   Виведення змінної як класу, або як певних даних -->
                            <?php echo $row1['name']  ?> <br>
                            <h6 class="small-text-under-name-left"><?php echo $row1['status'] ?></h6>
                        </div>
                        <a href="./php/logout.php?logout_id=<?php echo $row1['unique_id'] ?>"><span class="logout text-end material-symbols-outlined">logout</span></a>
                    </div>
                    <div class="search d-flex mb-2">
                        <input type="text" placeholder="Введіть Ім'я користувача...">
                        <button class="magnifier"><span class="material-symbols-outlined">search</span></button>
                    </div>
                </div>
                <div class="col-12 col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12  header-right-side pt-2  align-items-center">
                    <div class=" <?php echo $back_arrow ?>"> <a href="./index.php" class="back_arrow  ms-2">&#8630;</a>
                        <a href="./mobiledialogs.php" class="back_arrow_mobile ms-2">&#8630;</a>
                    </div>

                    <a class="delete_user me-4 mt-1" value="<?php echo $user_id; ?>" <?php echo $smile_check1 ?>>&#x274C</a>
                    <a type="submit" class="mute_user me-4 mt-4" value="<?php echo $user_id; ?>" <?php echo $smile_check2 ?>>&#129296;</a>
                    <a type="submit" class="unmute_user me-4 mt-4" value="<?php echo $user_id; ?>" <?php echo $smile_check3 ?>>&#128516;</a>
                    <input type="text" id="timerInput" class="mt-4 inputTime <?php echo $checker_status ?>" <?php echo $input_checker ?>>

                    <div class="ms-4">

                        <?php
                        if ($user_id == $group_chat_id) {
                            $ans = "Загальний чат";
                            echo $ans;
                        } elseif ($row['name'] == "") {
                            echo $ans;
                        } else {
                            echo $row['name'];
                        }
                        ?>
                    </div>
                    <div class="small-text-under-name-right ms-4"><?php echo $row['status'] ?></div>
                </div>
            </div>
        </div>
    </header>




    <main>
        <!-- Усi чати -->

        <div class=" d-flex flex-column">
            <div class="row gx-0">
                <div class="col-0 col-xl-3 col-lg-3 col-md-3 col-sm-0 col-xs-0 ">
                    <div class="scrol-block">
                        <div class="krr pt-2">Loading...</div>
                    </div>
                </div>


                <!-- Обраний чат -->

                <div class="col-12 col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12  <?php echo $chat_area  ?> chat-area align-items-center ">

                    <div class="chat-box-mes">


                    </div>
                    <div class="bg-for-emoji" onmouseover="changeBgClass()" onmouseout="resetBgClass()">
                    </div>

                    <form class="sendmesstr mt-4 justify-content-center d-flex" id="elementToHide">
                        <div class="block_message d-flex align-items-center">
                            <input type="text" name="outgoing_id" value="<?php echo $_SESSION['unique_id'];  ?> " hidden>
                            <input type="text" name="incoming_id" value="<?php echo $user_id;  ?> " hidden>
                            <p class="emoji" onmouseover="changeBgClass()" onmouseout="resetBgClass()" <?php echo $mute ?>>&#x263A;</p>
                            <input type="text" name="message" class="input-field" placeholder="Введіть повідомлення тут..." <?php echo $mute ?>>
                            <a class="enter material-symbols-outlined" <?php echo $mute ?>>send</a>
                            <p class="staple mt-2" onclick="changeMarkdown()" onmouseout="resetMarkdown()" <?php echo $mute ?>>&#128279;</p>
                        </div>
                        <div class="bg-for-markdown" onmouseover="changeMarkdown()" onmouseout="resetMarkdown()">
                            <div class="dropdown-content">
                                <input type="file" id="file-input" name="file">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <!-- bootstrap (framework JS) -->



    <script src="./js/emoji_photo_video.js"></script>
    <script src="./js/mute-user.js"></script>
    <script src="./js/delete-user.js"></script>
    <script src="./js/chat.js"></script>
    <script src="./js/user-search.js"></script>
    <script src="./js/particles.js"></script>


</body>

</html>