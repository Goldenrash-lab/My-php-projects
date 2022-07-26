<?php
function db_connect($query){
    $dbc = @mysqli_connect("localhost","root","","EgorAjaxAuthor") or fale("Ошибка сервера!");
    return mysqli_query($dbc,$query);
}
function fale($msg){
    die( json_encode(array("status" => "fale","msg" => $msg)));
}
function success($msg){
    echo json_encode(array("status" => "success","msg" => $msg));
}
if(isset($_POST['name'],$_POST['tel'],$_POST['email'],$_POST['pass1'],$_POST['pass2'],$_POST['login']) &&
!empty($_POST['name']) &&
!empty($_POST['tel']) &&
!empty($_POST['email']) &&
!empty($_POST['pass1']) &&
!empty($_POST['pass2']) &&
!empty($_POST['login']) &&
$_POST['pass1'] == $_POST['pass2']){
    $query = "INSERT INTO users (name, tel, email, pass, login) VALUES ('".$_POST['name']."','".$_POST['tel']."','".$_POST['email']."',sha1('".$_POST['pass1']."'),'".$_POST['login']."')";
    $rez = db_connect($query);
    if(!$rez){
        fale("Ошибка запроса!");
    }
   success("Успех!");
    exit;

}