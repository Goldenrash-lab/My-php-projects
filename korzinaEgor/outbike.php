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
    <title>OutBikes</title>
</head>
<body>
<?php
require_once("admin/connect.php");
$zapis = 3;
$queryZ = "SELECT id FROM bikes";
$rezz = mysqli_query($dbc,$queryZ) or die("EQZ");
$count_rows = mysqli_num_rows($rezz);
$count_pages = ceil($count_rows / $zapis);
if(isset($_GET['page']))
{
    $active_page = $_GET['page'];
}else
{
    $active_page = 1;
}
$skip = ($active_page-1)*$zapis;

$query = "SELECT id,title,price,datecreate,kolvo,about,photo FROM bikes limit $skip,$zapis";

$rez = mysqli_query($dbc,$query) or die("EQ");
echo "<table border='1'><tr>
<th>id</th>
<th>title</th>
<th>price</th>
<th>date</th>
<th>kolvo</th>
<th>about</th>
<th>photo</th>
<th>Подробней</th>
</tr>";
while($row = mysqli_fetch_array($rez))
{
    $id = $row['id'];
    $title = $row['title'];
    $price = $row['price'];
    $date = $row['datecreate'];
    $kolvo = $row['kolvo'];
    $about = $row['about'];
    $photo = $row['photo'];
    if(empty($photo))
    {
        $photo = "nofoto.png";
    }
    echo "<tr>
<td>$id</td>
<td>$title</td>
<td>$price</td>
<td>$date</td>";
    if($kolvo == 0)
    {
    echo "<td>Нет на складе!</td>";
    }else{
        echo "<td>$kolvo<a href='basket.php?id={$id}&mode=add&page={$active_page}'>Купить</a> </td>";
    }
    echo
"
<td>$about</td>
<td><img src='../images/$photo' width='200'></td>
<td><a href='info.php?id={$id}&page={$active_page}'>Подробнее</a></td>
</tr>";
}
echo "</table>";
echo "<table><tr>";

if($active_page == 1)
{
    echo "<td> < </td>";
    echo "<td> << </td>";
}else{
    echo "<td><a href='outbike.php?page=1'> < </a></td>";
    echo "<td><a href='outbike.php?page=".($active_page - 1)."'> << </a></td>";
}
for($i = 1; $i <= $count_pages; $i++)
{
    if($active_page == $i)
    {
        echo "<td> ".$i." </td>";
    }else{
        echo "<td><a href='outbike.php?page=".$i."'> $i </a></td>";
    }
}

if($active_page == $count_pages)
{
    echo "<td> >> </td>";
    echo "<td> > </td>";
}else{
    echo "<td><a href='outbike.php?page=".($active_page + 1)."'> >> </a></td>";
    echo "<td><a href='outbike.php?page=".$count_pages."'> > </a></td>";
}
echo "</tr></table><br><hr>";
if(isset($_SESSION['basket']) && count($_SESSION['basket']) > 0)//Проверяем ли существует корзина и количество товаров больше 0 то делаем вывод корзины
{
    echo "<table border='1'><tr>
<th>№</th>
<th>Фото</th>
<th>Название</th>
<th>Цена</th>
<th>Кол-во</th>
<th>Стоимость</th>
<th>Х</th>
</tr>";
    $total_sum=0;
    $num=1;
    foreach ($_SESSION['basket'] as $item)//Перебираем корзину, вычисляем стоимость каждого товара, накапливаем стоимости каждого товара
    {
        $cost = $item['price'] * $item['kolvo'];
        $total_sum += $cost;
        echo "<tr>
        <td>$num</td>
        <td><img src='images/{$item['photo']}' width='125px'></td>
        <td>{$item['title']}</td>
        <td>{$item['price']}</td>
        <td>{$item['kolvo']}</td>
        <td>$cost</td>
        <td><a href='basket.php?id={$item['id']}&mode=del' style='color: red'> X </a> </td>
        <tr>";
        $num++;//Увеличиваем счетчик
    }
    //Выводим общую сумму заказа и добавляем возможность очистить или заказать выбранные товары
    echo "<tr><th colspan='5'>Всего к оплате: </th>
<th colspan='2'>$total_sum</th></tr>";
    echo "<tr><th colspan='3'><a href='basket.php?mode=clear' style='color: red'>Очистить</a> </th>
<th colspan='4'><a href='order.php'>Заказать</a> </th></tr></table>";
}
mysqli_close($dbc);
?>
</body>
</html>