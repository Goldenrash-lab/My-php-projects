<?php
function db_connect($query){
    $dbc = @mysqli_connect("localhost","root","","EgorAjaxAuthor") or die("0");
    return mysqli_query($dbc,$query);
}
if(isset($_POST['login'],$_POST['pass']) && !empty($_POST['login']) && !empty($_POST['pass'])){
    $query = "SELECT name,tel,email FROM users WHERE login = '{$_POST['login']}' AND pass = sha1('{$_POST['pass']}')";
   $row = db_connect($query);
   if(!$row){
       echo $query;
       echo "0";
       exit;
   }
    if(mysqli_num_rows($row) == 1){
       $row1 = mysqli_fetch_array($row);
        echo "<h2>Добро пожаловать ".$row1['name']."!</h2><br>Ваше имя: ".$row1['name']."<br>Ваш телефон: ".$row1['tel']."<br>Ваш эмайл: ".$row1['email']."<br>Нажмите на кнопку чтобы увидеть всех членов нашего общества<br><button class='btn' id='show'>Показать</button>";
        exit;

    }else{
        echo "1";
        exit;
    }


}else{
   echo "2";
   exit;
}