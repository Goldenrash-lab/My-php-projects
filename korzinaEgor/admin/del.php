<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete item</title>
</head>
<body>
<?php
if(isset($_GET['id'],$_GET['title']) && !empty($_GET['id']) && !empty($_GET['title']))
{
?>
<h2>Вы действительно хотите удалить товар <?= $_GET['title']?></h2>
<form method="post" action="del.php">
    <input type="radio" name="del" checked value="yes">Да<br>
    <input type="radio" name="del" value="no">Нет<br>
    <input type="hidden" name="id" value="<?= $_GET['id']?>">
    <input type="submit" name="enter" value="Удалить"><br>
</form>
<?php
}elseif(isset($_POST['del'],$_POST['enter'],$_POST['id']) && !empty($_POST['id']))
{
    require_once ("connect.php");
    $query = "DELETE FROM bikes WHERE id = '{$_POST['id']}'";
    mysqli_query($dbc,$query) or die("EQ");
    echo "Вы успешно удалили товар!<br><a href='indexbike.php'>Назад</a>";
    mysqli_close($dbc);
}
else{
    echo "Удаление невозможно!<br><a href='indexbike.php'>Назад</a>";
}
?>
</body>
</html>