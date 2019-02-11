<?php require_once('head.php'); ?>
<?php require_once('menu.php'); ?>
<?php require_once('db.php'); ?>
<?php require('vendor/autoload.php'); ?>
<?php head(); ?>
<body>
    <header>
        <div class="logo">
            <a href="/"><img class="graficlogo" src="img/logo.png" alt="logo"></a>
        </div>
        <nav>
            <div class="topnav" id="myTopnav">
              <?php menu('top'); ?>
            </div>
        </nav>
    </header>
    <main>
        <?php
            $page = (isset($_GET['page'])) ? $_GET['page'] : null;
            if( $page ) {
                if ( file_exists("$page.php")){
                  require_once("$page.php");
                } else {
                  require_once('404.php');
                }
            } else {
                require_once 'home.php';
            }
        ?>
    </main>
    <footer>
        <nav>
            <?php menu('bot'); ?>
        </nav>
        <div class="logo">
            <a href="/"><img class="graficlogo" src="img/logo.png" alt=""></a>
        </div>
        <div class="social">
            <a href="#"><img src="img/social/em.png" alt=""></a>
            <a href="#"><img src="img/social/face.png" alt=""></a>
            <a href="#"><img src="img/social/goo.png" alt=""></a>
            <a href="#"><img src="img/social/inst.png" alt=""></a>
            <a href="#"><img src="img/social/pint.png" alt=""></a>
        </div>
        <p>
            Levchenko Sergei, 2018 (c)
        </p>
    </footer>
    <script src="js/script.js"></script>
</body>
</html>
