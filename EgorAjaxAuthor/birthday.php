<?php
function db_connect($query){
    $dbc = @mysqli_connect("localhost","root","","EgorAjaxAuthor") or fail("EC");
    return mysqli_query($dbc,$query);
}
function fail($msg){
    die(json_encode(array("status" => "fail", "msg" => $msg)));
}
function success($msg){
    die(json_encode(array("status" => "success", "msg" => $msg)));
}
if(isset($_POST['name'],$_POST['data']) && !empty($_POST['name']) && !empty($_POST['data']) && $_POST['mode'] == "add"){
    $query = "INSERT INTO birthday (name, data) VALUES ('{$_POST['name']}','{$_POST['data']}')";
    $rez = db_connect($query);
    if(!$rez){
        fail("EQ");
        exit;
    }
    success("успех!");
    exit;
}