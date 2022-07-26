<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index Bike</title>
</head>
<body>
<?php
require_once ("connect.php");
$query = "SELECT * FROM bikes";
$rez = mysqli_query($dbc,$query) or die("EQ");
echo "<table border='1'>
<tr>
<th>iD</th>
<th>Title</th>
<th>Price</th>
<th>Date</th>
<th>Kolvo</th>
<th>About</th>
<th>Photo
<th colspan='2'>Управление</th>
</tr>";
while($row = mysqli_fetch_array($rez))
{
    if(empty($row['photo']))
    {
        $row['photo'] = "nofoto.png";
    }
    echo "<tr>
<td>{$row['id']}</td>
<td>{$row['title']}</td>
<td>{$row['price']}</td>
<td>{$row['datecreate']}</td>
<td>{$row['kolvo']}</td>
<td>{$row['about']}</td>
<td><img src='../images/{$row['photo']}' width='200'></td>
<td><a href='editbike.php?id={$row['id']}'>Редактировать</a></td>
<td><a href='del.php?id={$row['id']}&title={$row['title']}'>Удалить</a></td>
</tr>";
}
?>
</body>
</html>