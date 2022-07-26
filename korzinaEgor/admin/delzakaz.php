<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Удаление товара</title>
</head>
<body>
<?php
if(isset($_GET['id'],$_GET['name']) && !empty($_GET['id'])) {
    ?>
    <form action="delzakaz.php" method="post">
        <h2>Вы дейсвительно хотите удалить заказ по имени <?php echo $_GET['name']; ?>?</h2>
        <input type="radio" name="del" checked value="yes">Да
        <input type="radio" name="del" value="no">Нет
        <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
        <input type="submit" name="send" value="Удалить"><br>
    </form>
    <?php
}elseif (isset($_POST['send'],$_POST['del'],$_POST['id']) && !empty($_POST['id']) && $_POST['del'] == "yes")
{
    require_once ("connect.php");
    $query = "DELETE FROM relation_order WHERE id_client = {$_POST['id']}";
    mysqli_query($dbc,$query) or die("EQ");
    echo "Удаление успешно выполнено!<br><a href='orderadmin.php'>Назад</a>";
    mysqli_close($dbc);
}else{
    echo"Удаление отменено!<br><a href='orderadmin.php'>Назад</a>";
}
?>
</body>
</html>