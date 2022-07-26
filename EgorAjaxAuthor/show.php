<?php
function db_connect($query){
    $dbc = @mysqli_connect("localhost","root","","EgorAjaxAuthor");
    return mysqli_query($dbc,$query);
}
if(isset($_POST['mode']) && $_POST['mode'] == "show"){
    $num = 1;
    $query = "SELECT name,tel,email FROM users";
    $rez = db_connect($query);
    if(!$rez){
        echo "0";
        exit;
    }else{
        echo "<table border='1'>
<tr>
<th>№</th>
<th>Имя</th>
<th>Телефон</th>
<th>Эмайл</th>
</tr>";
        while($row = mysqli_fetch_array($rez)){

            echo "<tr>
<td>$num</td>
<td>{$row['name']}</td>
<td>{$row['tel']}</td>
<td>{$row['email']}</td>
</tr>";
            $num++;
        }

    }

}else{
    echo "1";
    exit;
}