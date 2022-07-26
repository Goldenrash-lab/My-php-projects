<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EditBike</title>
</head>
<body>
<?php
if(isset($_GET['id']) && !empty($_GET['id']))
{
    require_once ('connect.php');
    $query = "SELECT title, price, datecreate, kolvo, about, photo FROM bikes WHERE id = {$_GET['id']}";
    $rez = mysqli_query($dbc,$query) or die("EQ");
    $row = mysqli_fetch_array($rez);
?>
<form action="editbike.php" method="post" enctype="multipart/form-data">
    <label>Измените название</label><br>
    <input type="text" name="title" value="<?= $row['title'] ?>"><br>
    <label>Измените цену</label><br>
    <input type="text" name="price" value="<?= $row['price']?>"><br>
    <label>Измените дату</label><br>
    <input type="date" name="datecreate" value="<?= $row['datecreate']?>"><br>
    <label>Измените количество</label><br>
    <input type="text" name="kolvo" value="<?= $row['kolvo']?>"><br>
    <label>Измените описание</label><br>
    <textarea name="about"><?= $row['about']?></textarea><br>
    <label>Измените фото</label><br>
    <img src="../images/<?=$row['photo']?>" width="200">
    <input type="file"  name="newphoto"><br>
    <input type="hidden" value="<?=$row['photo']?>" name="oldphoto">
    <input type="hidden" value="<?=$_GET['id']?>" name="id">
    <input type="submit" name="send" value="Изменить"><br>

</form>


<?php
}elseif(isset($_POST['title'],$_POST['price'],$_POST['datecreate'],$_POST['kolvo'],$_POST['about'],$_POST['send'],$_POST['id'],$_POST['oldphoto'])
&& !empty($_POST['title'])
&& !empty($_POST['price'])
&& !empty($_POST['datecreate'])
&& !empty($_POST['kolvo'])
&& !empty($_POST['id']))
{
    require_once ("connect.php");
    if($_FILES['newphoto']['error'] == 0)
    {
        if($_POST['oldphoto'] != "nofoto.png"){
            @unlink("../images/{$_POST['oldphoto']}");
        }
        $filenameTMP = $_FILES['newphoto']['tmp_name'];
        $filename = time().$_FILES['newphoto']['name'];
        move_uploaded_file($filenameTMP,"../images/$filename");
        $query = "UPDATE bikes SET title = '{$_POST['title']}', price = '{$_POST['price']}', datecreate = '{$_POST['datecreate']}', kolvo = '{$_POST['kolvo']}', about = '{$_POST['about']}',photo = '{$_POST['oldphoto']}' WHERE id = '{$_POST['id']}'";

    }else{
        $query = "UPDATE bikes SET title = '{$_POST['title']}', price = '{$_POST['price']}', datecreate = '{$_POST['datecreate']}',about = '{$_POST['about']}' ,kolvo = '{$_POST['kolvo']}'  WHERE id = '{$_POST['id']}'";
    }
    mysqli_query($dbc,$query) or die("EQ!");
    echo"Вы успещно отредактировали товар!<br><a href='indexbike.php'>Назад</a>";
    mysqli_close($dbc);
}else{
    echo "Редактирование невозможно или отменено!<br><a href='indexbike.php'>Назад</a>";
}
?>
</body>
</html>