<?php
session_start();
    ?>
    <!doctype html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
    <?php
    if(isset($_COOKIE['userid']))
    {
        setcookie("userid","",time()-3600);
    }
   if(isset($_COOKIE['username']))
   {
       setcookie("username","",time()-3600);

   }
   if(isset($_COOKIE['photo']))
   {
       setcookie("photo","",time()-3600);

   }
   if(isset($_COOKIE[session_name()]))
   {
       setcookie(session_name(),"",time()-3600);

   }
   $_SESSION = array();

   session_destroy();
   echo "Вы успешно вышли!<br><a href='outuser.php'>Проверка</a>";

    ?>
    </body>
    </html>