<?php
function menu($pos){
  echo '<a href="/">HOME</a>
        <a href="#">NEWS</a>
        <a href="#">CONTACT</a>
        <a href="#">ABOUT</a>';
  if( $pos == 'top' && isset( $_SESSION['isLogged'] ) ){ //если это топ меню и юзер залогинен, скрываем регистрацию и логин, выводим логаут
  echo '<a href="?page=profile"><i class="fas fa-user"></i> ' . mb_strtoupper($_SESSION['userLogin']) . '</a>
        <a href="?page=logout"><i class="fas fa-sign-out-alt"></i> SIGN OUT</a>
        <a id="menu" href="#" class="icon"><i class="fas fa-bars"></i></a>';
  }elseif ($pos == 'top' && !isset( $_SESSION['isLogged'] )) {//если это топ меню и юзер не залогинен, выводим регистрацию и логин
    echo '<a href="?page=signin">SIGN IN</a>
          <a href="?page=signup">SIGN UP</a>
          <a id="menu" href="#" class="icon"><i class="fas fa-bars"></i></a>';
  }
}
 ?>
