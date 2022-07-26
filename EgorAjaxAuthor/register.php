<?php
function db_connect($query){
    $dbc = @mysqli_connect("localhost","root","","EgorAjaxAuthor") or die("0");
    return mysqli_query($dbc,$query);
}
if(isset($_POST['name'],$_POST['login'],$_POST['tel'],$_POST['email'],$_POST['pass']) &&
!empty($_POST['name']) &&
!empty($_POST['login']) &&
!empty($_POST['tel']) &&
!empty($_POST['email']) &&
!empty($_POST['pass'])){
    $query = "INSERT INTO users (name, tel, email, pass, login) VALUES ('".$_POST['name']."','".$_POST['tel']."','".$_POST['email']."',sha1('".$_POST['pass']."'),'".$_POST['login']."')";
//    echo $query;
//    exit;
    $rezult = db_connect($query);
    if(!$rezult){
        echo"0";
        exit;
    }
    echo"1";
    exit;
}
