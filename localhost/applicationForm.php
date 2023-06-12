<?php
session_start();
if (isset($_SESSION['unique_id'])) {
  header("location: ./index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Bruno+Ace+SC&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="./styles/applicationForm-styles.css">
  <link rel="stylesheet" href="./media/media-signup.css">
  <title>Форма реєстрації</title>

</head>

<body>
  <div class="container">
    <div class="leftPage">
      <img src="/Image/log.png" alt="LOGO">
    </div>
    <div class="rightPage">
      <div class="block">
        <h1>Зареєструватися</h1>

        <div class="error-txt"></div>
        <form action="./php/signup.php" method="post" class="signForm">

          <div class="input-container">
            <i class="fa fa-user icon"></i>
            <input class="input-field" type="text" placeholder="Ім'я" name="name" required>
          </div>

          <div class="input-container">
            <i class="fa fa-user icon"></i>
            <input class="input-field" type="text" placeholder="Ім'я користувача" name="usrnm" required>
          </div>

          <div class="input-container">
            <i class="fa fa-envelope icon"></i>
            <input class="input-field" type="text" placeholder="Пошта" name="gmail" required>
          </div>

          <div class="input-container">
            <i class="fa fa-key icon"></i>
            <input class="input-field" type="password" placeholder="Пароль" name="password" required>
            <i class="fa fa-eye"></i>
          </div>
          <div class="btn">
            <button type="submit" class="btnApplication">Зареєструватися</button>
            <button type="button" class="btnLogin" onclick="window.location.href = './loginForm.php';">Увійти</button>
          </div>
        </form>

      </div>
    </div>
  </div>
  <script src="./js/signup.js"></script>
  <script src="./js/password-hide.js"></script>
</body>

</html>