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
if(!isset($_POST['send'])) {
    ?>
    <form action="regist.php" method="post" enctype="multipart/form-data" align="center">
        <label>Введите имя</label><br>
        <input type="text" name="name" <?php if (isset($_GET['name'])){echo "value ='".$_GET['name']."'";}?>><br>
        <label>Введите e-mail</label><br>
        <input type="text" name="email"><br>
        <label>Введите номер телефона</label><br>
        <input type="text" name="tel" <?php if(isset($_GET['tel'])){echo "value = '".$_GET['tel']."'";}?>><br>
        <label>Введите логин</label><br>
        <input type="text" name="login" <?php if (isset($_GET['login'])){echo "value = '".$_GET['login']."'";}?>><br>
        <label>Введите пароль</label><br>
        <input type="password" name="pass"><br>
        <label>Повторите пароль</label><br>
        <input type="password" name="pass1"><br>
        <label>Выберите аватар</label>
        <input type="file" name="photo"><br>
        <input type="submit" name="send" value="Зарегистровались"><br>
    </form>
    <?php
}
elseif(isset($_POST['send'],$_POST['name'],$_POST['email'],$_POST['tel'],$_POST['login'],$_POST['pass'])
&& !empty($_POST['name'])
&& !empty($_POST['email'])
&& !empty($_POST['tel'])
&& !empty($_POST['login'])
&& !empty($_POST['pass'])
&& $_POST['pass'] == $_POST['pass1'])
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    require_once ('admin/connect.php');
    $queryE = "SELECT id FROM user WHERE email = '$email'";
    $rezE = mysqli_query($dbc,$queryE) or  die('EQemail');
    if(mysqli_num_rows($rezE) > 0)
    {
        echo "Такой e-mail уже зарегистрирован!<br><a href='regist.php?name=".$name."&tel=".$tel."&login=".$login."'>Back</a> ";
    }
    else{
        if($_FILES['photo']['error'] == 0)
        {
            $filenameTMP = $_FILES['photo']['tmp_name'];
            $fileName = time().$_FILES['photo']['name'];
            move_uploaded_file($filenameTMP,"images/$fileName");
            $query = "INSERT INTO user (name,email,tel,login,password,photo) VALUES ('$name','$email','$tel','$login',sha1('$pass'),'$fileName')";
        }
        else{
            $query = "INSERT INTO user (name,email,tel,login,password) VALUES ('$name','$email','$tel','$login',sha1('$pass')";

        }

        mysqli_query($dbc,$query) or die('EQ');

        echo "Вы успешно зарегистрировались!<br><a href='regist.php'>Back</a> ";
    }

}else{
    echo "Вы ввели неправильно данные!<br><a href='regist.php'>Попробовать еще раз!</a> ";
    mysqli_close($dbc);
}
?>
</body>
</html>