<?php
session_start();
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
    <link rel="stylesheet" href="./styles/mobile-dialog.css">
    <link rel="stylesheet" href="./media/media-user-chat-mobile.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-...YOUR-INTEGRITY-CODE-HERE..." crossorigin="anonymous" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Chat KN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!-- bootstrap (framework JS) -->
</head>

<body>
    <!-- Фоновi частинки -->
    <div id="particles-js"></div>
    <!-- Шапка сторiнки -->

    <header>

        <?php
        include_once "./php/config.php"; // Файл конфігурацій
        $user_id = mysqli_real_escape_string($conn, $_GET['user_id']); // Отримання з URL рядка параметр user_id

        $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}"); // Запит до бд, обирає рядок з таблиці users, де unique_id = {$user_id}

        if ($sql) { // Перевіряє, чи вдалося виконати запит $sql
            if (mysqli_num_rows($sql) > 0) { // перевіряє, чи було отримано хоча б один рядок
                $row = mysqli_fetch_assoc(($sql)); // повертає асоціативний масив з отриманими даними
            }
        } else {
            $ans = "Оберiть чат для спiлкування";
        }

        $sql1 = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
        if (mysqli_num_rows($sql1) > 0) {
            $row1 = mysqli_fetch_assoc(($sql1));
        }

        ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12  block-under-search">
                    <div class="d-flex align-items-center justify-content-between ms-1">
                        <div class="header-above-search mt-1">
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

            </div>
        </div>

    </header>




    <main>
        <!-- Усi чати -->

        <!-- <div class="d-flex"> -->
        <div class="row">
            <div class="col-12">
                <div class="scrol-block">
                    <div class="krr pt-2">Loading...</div>
                </div>
            </div>
        </div>
        <!-- </div> -->

    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <!-- bootstrap (framework JS) -->

    <script src="./js/delete-user.js"></script>
    <script src="./js/chat.js"></script>
    <script src="./js/user-search.js"></script>
    <script src="./js/particles.js"></script>
</body>

</html>