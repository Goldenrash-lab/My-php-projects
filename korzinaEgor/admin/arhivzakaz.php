<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Архив</title>
</head>
<body>
<?php
require_once ("connect.php");
$num = 1;
$total_sum = 0;
$query = "SELECT name,tel,email,adres,comment,relation_order.id_client,relation_order.kolvo AS rel_kolvo,relation_order.date_order,title,price,photo FROM client INNER JOIN relation_order ON client.id = relation_order.id_client INNER JOIN bikes ON relation_order.id_bikes = bikes.id WHERE relation_order.status = 1 ORDER BY relation_order.date_order DESC, relation_order.id_client ASC";
$rez = mysqli_query($dbc,$query) or die("EQ");

$count_rows = 1;
$change_client = 0;
echo "<table border='1'>";





while($row = mysqli_fetch_array($rez))
{


    if($change_client != $row['id_client'])
        {
    echo "<tr>
<th>№</th>
<th>Имя</th>
<th>Телефона</th>
<th>E-mail</th>
<th>Адрес</th>
<th>Комментарии</th>
<th>Дата заказа</th>
<th>Управление</th>
</tr>";

    echo "<tr>
<td>$num</td>
<td>{$row['name']}</td>
<td>{$row['tel']}</td>
<td>{$row['email']}</td>
<td>{$row['adres']}</td>
<td>{$row['comment']}</td>
<td>{$row['date_order']}</td>
<td><a href='refreshorder.php?id={$row['id_client']}'>Восстановить</a> </td>
</tr>";

    echo "
<tr>
<th>Фото</th>
<th>Название товара</th>
<th>Цена</th>
<th>Количество</th>
<th colspan='4'>Стоимость</th>
</tr>";


$change_client = $row['id_client'];
    $num++;
    $query2 = "SELECT id_bikes FROM relation_order WHERE id_client = {$row['id_client']}";
    $rez2 = mysqli_query($dbc,$query2) or die("EQ2");
    $count_item = mysqli_num_rows($rez2);
    $total_sum = 0;
        }
    $cost = $row['rel_kolvo']*$row['price'];
    $total_sum += $cost;

    echo "
<tr>
<td><img src='../images/{$row['photo']}' width='200'></td>
<td>{$row['title']}</td>
<td>{$row['price']}</td>
<td>{$row['rel_kolvo']}</td>
<td colspan='4'>$cost</td>
</tr>";
    if($count_item == $count_rows)
    {
        echo "<tr><th colspan='6'>Всего к оплате</th><th colspan='2'>$total_sum</th></tr>";
    }
    $count_rows++;
}
echo "</table>";
mysqli_close($dbc);
?>
</body>
</html>