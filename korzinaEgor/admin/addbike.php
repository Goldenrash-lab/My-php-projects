<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Добавление товара</title>
</head>
<body>
<?php
if(!isset($_POST['send'])) {
    ?>
    <form action="addbike.php" method="post" enctype="multipart/form-data">
        <label>Название товара</label><br>
        <input type="text" name="title"><br>
        <label>Цена товара</label><br>
        <input type="text" name="price"><br>
        <label>Дата производства</label><br>
        <input type="date" name="date"><br>
        <label>Количество товара</label><br>
        <input type="text" name="kolvo"><br>
        <label>Описание товара</label><br>
        <textarea placeholder="Описание" name="about"></textarea><br>
        <label>Выберите фото для товара</label><br>
        <input type="file" name="photo"><br>
        <input type="submit" name="send" value="Добавить"><br>

    </form>
    <?php
}elseif(isset($_POST['send'],$_POST['title'],$_POST['price'],$_POST['date'],$_POST['kolvo'],$_POST['about'])
&& !empty($_POST['title']) && !empty($_POST['price']) && !empty($_POST['date']) && !empty($_POST['kolvo']))
{
    $title = $_POST['title'];
    $price = $_POST['price'];
    $date = $_POST['date'];
    $kolvo = $_POST['kolvo'];
    $about = $_POST['about'];
    require_once ('connect.php');
    if($_FILES['photo']['error'] == 0)
    {
        $filenameTMP = $_FILES['photo']['tmp_name'];
        $fileName = time().$_FILES['photo']['name'];
        move_uploaded_file($filenameTMP,"../images/$fileName");
        $query = "INSERT INTO bikes (title, price, datecreate, kolvo, about, photo) VALUES ('$title','$price','$date','$kolvo','$about','$fileName')";
    }else{
        $query = "INSERT INTO bikes (title, price, datecreate, kolvo, about) VALUES ('$title','$price','$date','$kolvo','$about')";
    }
    echo "Вы успешно добавили товар!<a href='addbike.php'>Добавить еще!</a>";
    mysqli_query($dbc,$query) or die("EQ");

}else{
    echo "Товар не был добавлен!<br><a href='addbike.php'>Назад</a> ";
}
?>
</body>
</html>