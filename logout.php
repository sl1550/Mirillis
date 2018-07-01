<?php

unset($_SESSION['isLogged']); //удаляем данные о сессии
unset($_SESSION['userId']);
unset($_SESSION['userLogin']);
header('Location: /'); //переходим на главную
 ?>
