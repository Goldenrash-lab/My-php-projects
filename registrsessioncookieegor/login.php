<?php
session_start();
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LogIn</title>
</head>
<body>
<?php
if(!isset($_POST['enter']))
{
?>
<form action="login.php" method="post" align="center">
    <label>Логин</label><br>
    <input type="text" name="login"><br>
    <label>Пароль</label><br>
    <input type="password" name="pass"><br>
    <input type="submit" name="enter" value="Войти"><br>
</form>
</body>
<?php
}
elseif (isset($_POST['login'],$_POST['pass'],$_POST['enter']) && !empty($_POST['login']) && !empty($_POST['pass']))
{
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    require_once ('admin/connect.php');
    $query = "SELECT id,name,email,tel,photo FROM user WHERE login = '$login' AND password = sha1('$pass')";

    $rez = mysqli_query($dbc,$query) or die('EQ');
    if(mysqli_num_rows($rez) == 1)
    {
        $row = mysqli_fetch_array($rez);
        $id = $row['id'];
        $name = $row['name'];
        $email = $row['email'];
        $tel = $row['tel'];
        $photo = $row['photo'];
        if(empty($photo))
        {
            $photo = "nofoto.png";
        }
        echo "<h2>Вы успешно авторизировались!</h2><br>Ваш id - $id<br>Ваше имя - $name<br>Ваш e-mail - $email<br>Ваш телефон - $tel<br>Ваше фото - <img src='images/$photo' width='300px'> ";
        setcookie("userid",$id,time()+60*60*24*30*3);
        setcookie("username",$name,time()+60*60*24*30*3);
        setcookie("photo",$photo,time()+60*60*24*30*3);
        $_SESSION['userid'] = $id;
        $_SESSION['username'] = $name;
        $_SESSION['photo'] = $photo;
        echo "<a href='outuser.php' style='color: red'>Секретная инфа!</a>";
    }
    else{
        echo "Вы ввели неверный пароль!<br><a href='login.php'>Назад</a>";
    }
    mysqli_close($dbc);
}
else
{
    echo "Вы ввели некоректно данные!<br><a href='login.php'>Назад</a> ";
}
?>
</html>