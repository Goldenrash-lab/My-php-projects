<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>infomation </title>
</head>
<body>
<?php
require_once("admin/connect.php");
if(isset($_GET['id']))
{
    $id = $_GET['id'];
    $query = "SELECT title,price, datecreate, kolvo,about,photo FROM bikes WHERE id = '$id'";
    $rez = mysqli_query($dbc,$query) or die("EQ");
    $row = mysqli_fetch_array($rez);
    $title = $row['title'];
    $price = $row['price'];
    $datecreate = $row['datecreate'];
    $kolvo = $row['kolvo'];
    $about = $row['about'];
    $photo = $row['photo'];
    if(empty($photo))
    {
        $photo = "nofoto.png";
    }
    echo"<table border='1'>
<tr>
<th>id</th>
<th>title</th>
<th>price</th>
<th>date</th>
<th>kolvo</th>
<th>about</th>
<th>photo</th>
</tr>
<tr>
<td>$id</td>
<td>$title</td>
<td>$price</td>
<td>$datecreate</td>
";
    if($kolvo == 0)
{
echo "<td>Нет на складе!</td>";
} else{
        echo "<td> {$kolvo}<br> <a href='basket.php?id={$id}&mode=add'>Купить!</a></td>";
}
echo "
<td>$about</td>
<td><img src='../images/$photo' width='200'></td>
</td>
</tr>
</table>";
    echo "<p><a href='outbike.php?page={$_GET['page']}'>Назад</a></p>";
    mysqli_close($dbc);
}else{
    echo "Недостачно данных для вывода информации!";
}

?>
</body>
</html>