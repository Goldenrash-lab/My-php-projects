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
    <title>Register</title>
</head>
<body>
<?php
if(!isset($_POST['send']))
{


?>
<form method="post" action="reg.php" enctype="multipart/form-data">
    <label>Введите имя</label><br>
    <input type="text" name="name" <?php if(!empty($_GET['name'])) {echo "value='".$_GET['name']."'";}?>><br>
    <label>Введите логин</label><br>
    <input type="text" name="login" <?php if(!empty($_GET['login'])) {echo "value='".$_GET['login']."'";}?> ><br>
    <label>Введите email</label><br>
    <input type="text" name="email"><br>
    <label>Введите телефон</label><br>
    <input type="text" name="tel" <?php if(!empty($_GET['tel'])) {echo "value='".$_GET['tel']."'";}?>><br>
    <label>Введите пароль</label><br>
    <input type="password" name="pass"><br>
    <label>Введите пароль ещё раз</label><br>
    <input type="password" name="pass1"><br>
    <label>Выберите аватар </label><br>
    <input type="file" name="photo"><br>
    <label>Введите символы отображаемые на картинке</label><br>
    <img src="captcha.php"><br>
    <input type="text" name="captcha" placeholder="Введите символы"><br>
    <input type="submit" name="send" value="Зарегистрироваться"><br>
</form>
<?php
}
elseif (isset($_POST['send'],$_POST['name'],$_POST['login'],$_POST['email'],$_POST['tel'],$_POST['pass'],$_POST['captcha']) && !empty($_POST['name']) && !empty($_POST['login']) && !empty($_POST['email']) && !empty($_POST['tel']) && !empty($_POST['pass']) && $_POST['pass'] == $_POST['pass1'] && !empty($_POST['captcha']))
{
    if($_POST['captcha'] == $_SESSION['fraze'])
    {


    $name = $_POST['name'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $pass = $_POST['pass'];
    require_once ('admin/connect.php');
    $queryE = "SELECT id FROM client WHERE email = '$email'";
    $rezE = mysqli_query($dbc,$queryE) or die("EQE");
    if(mysqli_num_rows($rezE) >= 1){
        echo "Такой эмайл уже существует!<br>";
        echo "<a href='reg.php?login={$login}&name={$name}&tel={$tel}'>Назад</a>";
    }else {
        if ($_FILES['photo']['error'] == 0) {
            $filenameTMP = $_FILES['photo']['tmp_name'];
            $fileName = time() . $_FILES['photo']['name'];
            move_uploaded_file($filenameTMP, "images/$fileName");
            $query = "INSERT INTO client (name, login, tel, email, pass,photo) VALUES ('$name','$login','$tel','$email',sha1('$pass'),'$fileName')";
        } else {
            $query = "INSERT INTO client (name, login, tel, email, pass) VALUES ('$name','$login','$tel','$email',sha1('$pass'))";

        }


        mysqli_query($dbc, $query) or die('EQ');
        echo "Вы успешно зарегистрировались!";
    }
    }else{
        echo"Неверно введена капча";
    }

}
else{
    echo "Вы ввели неверно данные!";
}
?>
</body>
</html>