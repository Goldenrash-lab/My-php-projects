<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
require_once ("connect.php");
//SELECT items.name as item_name,price,kolvo,fullcont,photo,categories.name AS cat_name,categories.id as cat_id from items INNER JOIN categories ON items.idcat = categories.id - Запрос формирует представление с двух таблиц и имеет натуральный тип связи INNER JOIN при котором будет выбраны только взаимосвязанные строки

//SELECT items.name as item_name,price,kolvo,fullcont,photo,categories.name AS cat_name,categories.id as cat_id from items LEFT JOIN categories ON items.idcat = categories.id Оператор LEFT JOIN выбирает все строки с левой таблицы а с правой только взаиио связанные

//SELECT items.name as item_name,price,kolvo,fullcont,photo,categories.name AS cat_name,categories.id as cat_id from items RIGHT JOIN categories ON items.idcat = categories.id Оперратор RIGHT JOIN выбирает все строки с правой таблицы а с левой только взаимо связанные

//SELECT name,tel,email,adres,comment,title,price,photo,id_client,relation_order.kolvo AS rel_kolvo, date_order from client INNER JOIN relation_order on client.id = relation_order.id_client INNER JOIN bikes ON relation_order.id_bikes = bikes.id WHERE status = 0 ORDER BY relation_order.date_order DESC, relation_order.id_client ASC
$query = "SELECT name,tel,email,adres,comment,title,price,photo,id_client,relation_order.kolvo AS rel_kolvo, date_order from client INNER JOIN relation_order on client.id = relation_order.id_client INNER JOIN bikes ON relation_order.id_bikes = bikes.id WHERE status = 0 ORDER BY relation_order.date_order DESC, relation_order.id_client ASC";
$rez = mysqli_query($dbc,$query) or die("EQ");
echo "<table border='1'>";


$num = 1;
$total_sum= 0;
$count_rows = 1;
$change_client = 0;//Переменная отслеживает смену клиентов и изначально инициализируеться нулем который никогда не будет айди
while($row = mysqli_fetch_array($rez)){

    if($change_client != $row['id_client']) {//Отслеживаем смену клиента и если клиент меняеться выводим шапку клиента их трех строк

$count_rows = 1;
        echo "
<tr>
<th>№</th>
<th>Имя клиента</th>
<th>Телефон клиента</th>
<th>Адрес клиента</th>
<th>Комментарии к заказу</th>
<th>Дата заказа</th>
<th colspan='2'>Управление</th>
</tr>";
        echo "<tr>
<td>$num</td>
<td>{$row['name']}</td>
<td>{$row['tel']}</td>
<td>{$row['adres']}</td>
<td>{$row['comment']}</td>
<td>{$row['date_order']}</td>
<td><a href='runzakaz.php?id={$row['id_client']}'>Выполнить</a> </td>
<td><a href='delzakaz.php?id={$row['id_client']}&name={$row['name']}'>Удаление</a></td>
</tr>";

        echo "<tr>
<th colspan='2'>Фото товара</th>

<th>Название товара</th>
<th>Цена товара</th>
<th>Количество товара</th>
<th colspan='3'>Стоимость</th>

</tr>";

        $change_client = $row['id_client'];
        $num++;
        $query2 = "SELECT id_bikes FROM relation_order WHERE id_client = {$row['id_client']}";
        $rez2 = mysqli_query($dbc,$query2) or die("EQ2");
        $count_item = mysqli_num_rows($rez2);
        $total_sum = 0;

    }
    $cost = $row['price']*$row['rel_kolvo'];
    $total_sum += $cost;
    echo "<tr>
<td colspan='2'><img src='../images/{$row['photo']}' width='200'></td>
<td>{$row['title']}</td>
<td>{$row['price']}</td>
<td>{$row['rel_kolvo']}</td>
<td colspan='3'>$cost</td>
</tr>";
    if($count_item == $count_rows) {//Если количество товаров равняеться количеству строк, то выводим общую стоимость
        echo "<tr><th colspan='5'>Всего к оплате: </th><th colspan='3'>$total_sum</th></tr>";
    }
    $count_rows++;


}
echo "</table>";
mysqli_close($dbc);
?>
</body>
</html>