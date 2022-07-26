<?php
function db_connect($query){
    $dbc = @mysqli_connect("localhost","root","","EgorAjaxAuthor") or fail("Ошибка подключения!");
    return mysqli_query($dbc,$query);
}
function fail($msg){
    die(json_encode(array("status" => "fail","msg" => $msg)));
}
function success($msg){
    die(json_encode(array("status" => "success","msg" => $msg)));
}
if(isset($_POST['login'],$_POST['pass']) && !empty($_POST['login']) && !empty($_POST['pass'])){
    $query = "SELECT name,tel,email FROM users WHERE login = '{$_POST['login']}' AND pass = sha1('{$_POST['pass']}')";
    $rez = db_connect($query);
    if(!$rez){
        fail("Ошибка запроса!");
        exit;
    }else{
        if(mysqli_num_rows($rez) == 1){
            $row = mysqli_fetch_array($rez);
           echo json_encode(array(
                "name" => $row['name'],
                "tel" => $row['tel'],
                "email" => $row['email']
            ));
           exit;
        }else{
            fail("Неверный логин или пароль!");
            exit;
        }
    }
}else{
    fail("Неверно введены данные!");
    exit;
}
