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
    <title>Document</title>
</head>
<body>
<?php
if (isset($_SESSION['basket']) && count($_SESSION['basket']) > 0) {
if(!isset($_POST['send']))
{
?>
<form method="post" action="order2.php">
    <label>Ваше имя</label><br>
    <input type="text" name="name"><br>
    <label>Ваш телефон</label><br>
    <input type="text" name="tel"><br>
    <label>Ваш эмайл</label><br>
    <input type="text" name="email"><br>
    <label>Введите адрес</label><br>
    <textarea name="adres"></textarea><br>
    <label>Комментарии к заказу</label><br>
    <textarea name="comment"></textarea><br>


    <?php


        echo "<table border='1'><tr>
<th>№</th>
<th>Фото</th>
<th>Название</th>
<th>Цена</th>
<th>Количество</th>
<th>Стоимость</th>
</tr>";
        $total_sum = 0;
        $num = 1;
        foreach ($_SESSION['basket'] as $tmp) {
            $cost = $tmp['price'] * $tmp['kolvo'];
            $total_sum += $cost;
            echo "<tr>
<td>$num</td>
<td><img src='images/{$tmp['photo']}' width='200'></td>
<td>{$tmp['title']}</td>
<td>{$tmp['price']}</td>
<td>{$tmp['kolvo']}</td>
<td>$cost</td>
</tr>";
            $num++;
        }
        echo "<tr><th colspan='5'>Всего оплате: </th>
<th colspan='1'>$total_sum</th></tr></table>";

    ?>
    <input name="send" type="submit" value="Заказать"><br></form>
    <?php
    }elseif(isset($_POST['send'],$_POST['name'],$_POST['tel'],$_POST['email'],$_POST['adres'],$_POST['comment'])
    && !empty($_POST['name']) && !empty($_POST['tel']) && !empty($_POST['email']) && !empty($_POST['adres']))
    {
        require_once ("admin/connect.php");
        $query = "INSERT INTO client (name, tel, email, adres, comment) VALUES ('{$_POST['name']}','{$_POST['tel']}','{$_POST['email']}','{$_POST['adres']}','{$_POST['comment']}')";
        mysqli_query($dbc,$query) or die("EQ");
        $idclient = mysqli_insert_id($dbc);//Функция возвращает айди только что добавленной записи по идентификатору клиента. Функция работает после mysqli_query с запросом insert into
        foreach ($_SESSION['basket'] as $tmp)
        {
            $query2 = "INSERT INTO relation_order (id_client, id_bikes, kolvo, date_order) VALUES ('$idclient','{$tmp['id']}','{$tmp['kolvo']}',now())";
            //Функция now() добавляет текущую дату на момент выполнения запроса
            mysqli_query($dbc,$query2) or die("EQ2");
        }
        unset($_SESSION['basket']);
        $_SESSION['basket'] = array();
        echo "Ваш заказ принят! Нам менеджер с вами свяжеться!";
    }else{
    echo "Неправильно заполнили данные!";
}
}
    ?>

</body>
</html>