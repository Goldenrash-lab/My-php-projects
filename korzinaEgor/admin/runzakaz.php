<?php
if(isset($_GET['id']) && !empty($_GET['id']))
{
    require_once ("connect.php");
    $query1 = "UPDATE relation_order SET status = 1 WHERE id_client = {$_GET['id']}";
    mysqli_query($dbc,$query1) or die("EQ");
    $query2 = "SELECT id_bikes,kolvo FROM relation_order WHERE id_client = {$_GET['id']}";
    $rez2 = mysqli_query($dbc,$query2) or die("EQ2");
    while($row = mysqli_fetch_array($rez2)){
        $query3 = "UPDATE bikes SET kolvo = kolvo -".$row['kolvo']." WHERE id = {$row['id_bikes']}";
        mysqli_query($dbc,$query3) or die("EQ3");
    }
    header("location: orderadmin.php");
}