<?php
require ("param.php");
if(isset($_POST['country']) && !empty($_POST['country'])){
    $query = "INSERT INTO country (country) VALUE ('{$_POST['country']}')";
    $rez = db_connect($query);
    if(!$rez){
        fail("Ошибка запроса!");
        exit;
    }
        success("Успешно добавлено!");
        exit;
}else{
    fail("Неверно введены данные!");
    exit;
}