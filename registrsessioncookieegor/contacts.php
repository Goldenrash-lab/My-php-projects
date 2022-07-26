<?php
session_start();
if(isset($_COOKIE['userid'],$_COOKIE['username'],$_COOKIE['photo']))
{
    $_SESSION['userid'] = $_COOKIE['userid'];
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['photo'] = $_COOKIE['photo'];
}
if(isset($_SESSION['userid'],$_SESSION['username'],$_SESSION['photo'])) {
    ?>
    <!doctype html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
    <?php
    echo "Добро пожаловать {$_SESSION['username']}!<img src='images/{$_SESSION['photo']}' width='80px' style='border-radius: 10px'>";
    echo "<h1> Секретный номер <br> 0664136612</h1>";
    ?>
    <a href="outuser.php">Список</a><br>
    <a href="exit.php" style="color: red">Выход</a>
    </body>
    </html>
    <?php
}
else{
    echo "<h1>404 page not found</h1>";
}