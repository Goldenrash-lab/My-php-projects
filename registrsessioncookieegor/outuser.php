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
        <title>Вывод</title>
    </head>
    <body>
    <?php
    echo "Добро пожаловать {$_SESSION['username']}!<img src='images/{$_SESSION['photo']}' width='80px' style='border-radius: 10px'>";
    require_once('admin/connect.php');
    $query = "SELECT id,name,email,tel,login,photo FROM user";
    $rez = mysqli_query($dbc, $query) or die("EQ");
    echo "<table border = '1'><tr>
<th>id</th>
<th>Name</th>
<th>E-mail</th>
<th>Telephone</th>
<th>Login</th>
<th>Photo</th>
</tr>";
    while ($row = mysqli_fetch_array($rez)) {
        $id = $row['id'];
        $name = $row['name'];
        $email = $row['email'];
        $tel = $row['tel'];
        $login = $row['login'];
        $photo = $row['photo'];
        if (empty($photo)) {
            $photo = "nofoto.png";
        }
        echo "<tr>
<td>$id</td>
<td>$name</td>
<td>$email</td>
<td>$tel</td>
<td>$login</td>
<td><img src='images/$photo' width='150px'></td>
</tr>";
    }
    echo "</table>";
    echo "<a href='contacts.php'>Контакты</a><br>";
    echo "<a href='exit.php' style='color: red'>Выход</a>";
    mysqli_close($dbc);
    ?>
    </body>
    </html>
    <?php
}else{
    echo "404 page not found";
}