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
    <title>Корзина</title>
</head>
<body>
<?php
if(isset($_SESSION['basket']) && count($_SESSION['basket']) > 0)
{
    require_once ("admin/connect.php");
///////////////////////
    if(isset($_POST['send']))
    {
        //print_r($_POST);
        for($i=0; $i < count($_SESSION['basket']); $i++)
        {
            $nameElement="count".$_SESSION['basket'][$i]['id'];//Получаем название елемента в массиве пост так как тэг <input type='number'  name='count{$tmp['id']}' min='1' max='{$row['kolvo']}' value='{$tmp['kolvo']}'> его название состоит из слова каунт и айди заказанного товара, каждый клиент будет заказывать сови товары поэтому количество и название елементов инпут будет разное
            //echo "<br>$nameElement";
            $_SESSION['basket'][$i]['kolvo'] = $_POST[$nameElement];//Перезаписываем каждого товара даже если оно не менялось
        }
    }
    ///////////////////////////
    echo "<form  action='order.php' method='post'>";
    echo "<table border='1'><tr>
<th>№</th>
<th>Фото</th>
<th>Название</th>
<th>Цена</th>
<th>Кол-во</th>
<th>Стоимость</th>
<th>Х</th>
</tr>";

$total_sum = 0;
$num =1;
foreach ($_SESSION['basket'] as $tmp) {
    $cost = $tmp['price'] * $tmp['kolvo'];
    $total_sum += $cost;
    ////////////////////
    $query = "SELECT kolvo FROM bikes WHERE id = '{$tmp['id']}'";
    $rez = mysqli_query($dbc,$query) or die("EQ");
    $row = mysqli_fetch_array($rez);
    ////////////////////
    echo "<tr>
<td>$num</td>
<td><img src='images/{$tmp['photo']}' width='200'></td>
<td>{$tmp['title']}</td>
<td>{$tmp['price']}</td>
<td><input type='number'  name='count{$tmp['id']}' min='1' max='{$row['kolvo']}' value='{$tmp['kolvo']}'> </td>
<td>$cost</td>
<td><a href='basket.php?id={$tmp['id']}&mode=del&script=order' style='color: red'>X</a></td>
</tr>";
    $num++;
}
echo "<tr><th colspan='5'>Всего к оплате:</th>
<th colspan='2'>$total_sum</th></tr>";
echo "
<th colspan='3'><a href='basket.php?mode=clear' style='color: red'>Очистить</a></th>
<th colspan='4'><a href='order2.php' style='color: green'>Заказать</a></th></tr>";
echo "<tr><th colspan='7'><input type='submit' name='send' value='Пересчитать'></th></tr></table>";
echo "</form>";
}//else{
//    header('location: outbike.php');
//}
?>
</body>
</html>