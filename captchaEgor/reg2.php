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
    <title>Reg2</title>
</head>
<body>
<?php
if(!isset($_POST['send'])) {
    ?>
    <form action="reg2.php" method="post" enctype="multipart/form-data">
        <label>Введите ваше имя</label><br>
        <input type="text" name="name" <?php if(isset($_GET['name'])){ echo "value = '".$_GET['name']."'"; }?>><br>
        <label>Введите ваш логин</label><br>
        <input type="text" name="login" <?php if(isset($_GET['login'])){ echo "value = '".$_GET['login']."'"; }?>><br>
        <label>Введите ваш e-mail</label><br>
        <input type="text" name="email"><br>
        <label>Введите ваш номер телефона</label><br>
        <input type="text" name="tel" <?php if(isset($_GET['tel'])){ echo "value = '".$_GET['tel']."'"; }?>><br>
        <label>Введите ваше пароль</label><br>
        <input type="password" name="pass"><br>
        <label>Повторите пароль</label><br>
        <input type="password" name="pass1"><br>
        <label>Выберите аватар</label><br>
        <input type="file" name="photo"><br>
        <label>Решите уровнение</label><br>
        <img src="captcha2.php"><br>
        <input type="text" name="captcha" placeholder="Введите ответ"><br>
        <input type="submit" name="send" value="Зарегистрироваться"><br>

    </form>
    <?php
}elseif(isset($_POST['send'],$_POST['name'],$_POST['login'],$_POST['email'],$_POST['tel'],$_POST['pass'],$_POST['captcha']) && !empty($_POST['name'])
&& !empty($_POST['login']) && !empty($_POST['email']) && !empty($_POST['tel']) && !empty($_POST['pass']) && $_POST['pass'] == $_POST['pass1'] && !empty($_POST['captcha']))
{
    //echo $_SESSION['sum']."--".$_POST['captcha'];
    if($_SESSION['sum'] == $_POST['captcha']) {
        $name = $_POST['name'];
        $login = $_POST['login'];
        $email = $_POST['email'];
        $tel = $_POST['tel'];
        $pass = $_POST['pass'];
        require_once('admin/connect.php');
        $queryE = "SELECT id FROM client WHERE email = '$email'";
        $rezE = mysqli_query($dbc, $queryE) or die("EQE");
        if (mysqli_num_rows($rezE) > 1) {
            echo "Такой емайл уже существует<br><a href='reg2.php?name={$name}&login={$login}&tel={$tel}'>Назад</a>";
        } else {
            if ($_FILES['photo']['error'] == 0) {
                $filenameTMP = $_FILES['photo']['tmp_name'];
                $filename = time() . $_FILES['photo']['name'];
                move_uploaded_file($filenameTMP, "images/$filename");
                $query = "INSERT INTO client (name, login, tel, email, pass, photo) VALUES ('$name','$login','$tel','$email',sha1('$pass'),'$filename')";
            } else {
                $query = "INSERT INTO client (name, login, tel, email, pass,) VALUES ('$name','$login','$tel','$email',sha1('$pass'))";
            }

            mysqli_query($dbc,$query) or die("EQ");
            echo "Вы успешно зарегистрировались!";
            mysqli_close($dbc);
        }
    } else{
    echo "Вы неверно решили уровнение!";
    }
}else{

    echo "Вы ввели данные ек все данные или неверно!";
}
?>
</body>
</html>