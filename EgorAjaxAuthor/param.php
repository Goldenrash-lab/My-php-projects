<?php
function db_connect($query){
    $dbc = @mysqli_connect("localhost","root","","egorajaxauthor") or fail("Ошибка подключения!");
    return mysqli_query($dbc,$query);
}
function fail($msg){
    die(json_encode(array("status" => "fail", "msg" => $msg)));
}
function success($msg){
    die(json_encode(array("status" => "success", "msg" => $msg)));
}