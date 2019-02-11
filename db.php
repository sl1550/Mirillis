<?php require_once('libs/rb.php'); //подключаем RedBeans

R::setup( 'mysql:host=aweb.mysql.ukraine.com.ua;dbname=aweb_junior',
        'aweb_junior', '5pxkuh4r' ); //соединяемся с БД
session_start(); //разрешаем сессии

 ?>
