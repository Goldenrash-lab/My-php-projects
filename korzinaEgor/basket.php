<?php
session_start();
//Добавление товара
if(isset($_GET['id'],$_GET['mode']) && !empty($_GET['id']) && $_GET['mode'] == "add")//Проверяем если существует айди и мод адд то пользователь хочет добавить товар в корзину
{
    $exist = false;//Статусная переменная ъранит значение фолс если товар в корзине не существует
    if(!isset($_SESSION['basket']))//Проверяем если корзина не сущетвует
    {
        $_SESSION['basket'] = array();//То создаем корзину пустым динам массивом
    }
    if(count($_SESSION['basket']) > 0)//Если товара в корзине больше нуля
    {
        for($i = 0; $i < count($_SESSION['basket']); $i++)// то перебираем товары в корзине
        {
            if($_SESSION['basket'][$i]['id'] == $_GET['id'])// И если айди товара совпадает с айди полученым по ссылке то это значит что товар в корзине уже существует а значит увеличиваем его количемтво
            {
                    $_SESSION['basket'][$i]['kolvo']++;// Увеличиваем количество товара на 1
                    $exist = true;// Помечаем что товар существует
                    break;// останавливаем поиск в корзине так как товар найден по айди
            }
        }
    }
    if(!$exist)// Если статусная переменная не поменяла свое значение то это значит что данный товар в корзине не существует а значит нужно добавить тип товара в корзину
    {
        require_once ("admin/connect.php");
        $query = "SELECT title,price,photo FROM bikes WHERE id = '{$_GET['id']}'";// Выбираем необходимые данные о товаре
        $rez = mysqli_query($dbc,$query) or die("EQ");
        $row = mysqli_fetch_array($rez);
        if(empty($row['photo']))
        {
            $row['photo'] = "nofoto.png";
        }
        //Добавляем в корзину новым елементом тип товара в количестве 1 штука
        $_SESSION['basket'][]= array(
            "id" => $_GET['id'],
            "title" => $row['title'],
            "price" => $row['price'],
            "photo" => $row['photo'],
            "kolvo" => 1);

    }
}
if(isset($_GET['mode']) && $_GET['mode'] == "clear" && isset($_SESSION['basket']))
{
    unset($_SESSION['basket']);//Функция unset уничтожает и  разыименовывает переменную и высвобождает память с под нее
}
//Удаляем один тип товара
if(isset($_GET['id'],$_GET['mode'],$_SESSION['basket']) && !empty($_GET['id']) && $_GET['mode'] == "del" && count($_SESSION['basket']) > 0)
{
    for($i = 0; $i < count($_SESSION['basket']);$i++)
    {
        if($_SESSION['basket'][$i]['id'] == $_GET['id'])
        {
            unset($_SESSION['basket'][$i]);
            break;
        }
    }
    $items = array();
    foreach ($_SESSION['basket'] as $tmp)
    {
        if(!empty($tmp)){
            $items[]= $tmp;
        }
    }
    unset($_SESSION['basket']);
    $_SESSION['basket'] = array();
    $_SESSION['basket'] = $items;
    unset($items);
}





if(isset($_GET['script']) && $_GET['script'] == 'order' && count($_SESSION['basket']) > 0)
{
    header('location: order.php');
}else {


    if (isset($_GET['page']) && !empty($_GET['page'])) {
        header("location: outbike.php?page={$_GET['page']}");

    } else {
        header("location: outbike.php");

    }
}
//print_r($_SESSION['basket']);
