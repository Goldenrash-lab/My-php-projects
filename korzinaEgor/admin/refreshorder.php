<?php
if(isset($_GET['id']) && !empty($_GET['id']))
{
    require_once ('connect.php');
    $query = "UPDATE relation_order SET status = 0,date_order = now() WHERE id_client = {$_GET['id']}";
    // $query;
    mysqli_query($dbc,$query) or die("EQ");
    $query2 = "SELECT kolvo,id_bikes FROM relation_order WHERE id_client = {$_GET['id']}";
    $rez2 = mysqli_query($dbc,$query2) or die("EQ2");
    while($row = mysqli_fetch_array($rez2)){
        $query3 = "UPDATE bikes SET kolvo = kolvo + {$row['kolvo']} WHERE id = {$row['id_bikes']}";
        mysqli_query($dbc,$query3) or die("EQ3");
    }
    header('location: orderadmin.php');

}