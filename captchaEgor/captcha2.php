<?php
session_start();
define('CAP_H',25);
define('CAP_W',150);
$num = rand(1,10);
$num2 = rand(1,10);
$znak = rand(1,3);
switch ($znak)
{
    case"1": $znak = "+";
    break;
    case"2": $znak = "-";
    break;
    case"3": $znak = "*";
    break;
}
$fraze = "$num $znak $num2 = ";
switch ($znak)
{
    case"+":
        $sum = $num + $num2;
        break;
    case"-":
        $sum = $num - $num2;
    break;
    case"*":
        $sum = $num * $num2;
}
$_SESSION['sum'] = $sum;
$img = imagecreatetruecolor(CAP_W,CAP_H);
$bg_color = imagecolorallocate($img,255,255,255);
$gr_color = imagecolorallocate($img,64,64,64);
$num_color = imagecolorallocate($img,0,0,0);
imagefilledrectangle($img,0,0,CAP_W,CAP_H,$bg_color);
for($i = 0; $i < 5; $i++)
{
    imageline($img,0,rand()%CAP_H,CAP_H,rand()%CAP_W,$gr_color);
}
for($i = 0;$i < 50;$i++)
{
    imagesetpixel($img,rand()%CAP_W,rand()%CAP_H,$gr_color);
}
imagettftext($img,20,1,10,CAP_H - 5,$num_color,"C:\OpenS\OSPanel\domains\captchaEgor\a_AssuanTitulStrDs.ttf",$fraze);
header("Content-type: image/png");
imagepng($img);
imagedestroy($img);
