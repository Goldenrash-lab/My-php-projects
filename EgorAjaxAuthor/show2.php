<?php
function db_connect($query){
    $dbc = @mysqli_connect("localhost","root","","EgorAjaxAuthor") or fail("Ошибка подключения!");
        return mysqli_query($dbc,$query);
}
function fail($msg){
    die(json_encode(array("status" => "fail","msg" =>$msg)));
}
function success($msg){
    die(json_encode(array("status" => "success","msg" =>$msg)));
}
if(isset($_POST['mode']) && !empty($_POST['mode']) && $_POST['mode'] == "show"){
    $query = "SELECT name,tel,email FROM users";
    $rez = db_connect($query);
    if(!$rez){
        fail("Ошибка запроса!");
        exit;
    }else{
        $users = [];
        $num = 1;
        while($row = mysqli_fetch_array($rez)){
            $users[] = array(
                "num" => $num,
                "name" => $row['name'],
                "tel" => $row['tel'],
                "email" =>$row['email']
        );
          $num++;
        }
        echo json_encode(array("users" => $users));
        exit;
    }
}else{
    fail("что-то пошло не так!");
    exit;
}