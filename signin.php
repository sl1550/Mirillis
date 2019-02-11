
<?php //Логика
if( isset( $_SESSION['isLogged'] ) ){//выбрасываем юзера на фронт пейдж, если он уже залогинен
  header('Location: /');
}
$data = $_POST; //присваиваем переменной значение POST
if( isset( $data['do_signin'] ) )//проверяем, была ли нажата кнопка входа (в массиве должен появится ключ с именем кнопки входа)
{
  $errors = array(); //создаем массив для ошибок
  if( trim( $data['login'] ) == '' )//проверка на пустоту логина (тримаем, что бы исключить пробелы)
  {
    $errors[]='Enter username!'; //запоминаем ошибку
  }
  if( $data['password'] == '' )//проверка на пустоту пароля
  {
    $errors[] = 'Enter password!';//запоминаем ошибку
  }
  $user = R::findOne( 'users', 'login = ?', array( $data['login'] ) ); //ищем в базе пользователя с введенным логином
  if( $user ) //если пользователь с таким логином найден
  {
    if( password_verify( $data['password'], $user->password ) ) //проверяем совпадение паролей
    {
      $_SESSION['isLogged'] = true; //создаем сессию для юзера, на этом заканчиваем.
      $_SESSION['userId'] = $user->id;
      $_SESSION['userLogin'] = $user->login;

    } else
    {
      $errors[] = 'Incorrect password!';//запоминаем ошибку
      unset($data['password']); //сбрасываем неверное значение
    }

  } else //если пользователь с таким имененм не найден
  {
    $errors[] = 'Username not found!';  //запоминаем ошибку
    unset($data['login']); //сбрасываем неверное значение
    unset($data['password']); //сбрасываем неверное значение
  }
}
 ?>

<div id="signin" class="signin">


            <form name="signinform" id="signinform" action="?page=signin" method="POST">
              <div class="signinform-head">
                SIGN IN
              </div>
              <div class="signinform-content">
                	<a href="/" title="Mirillis" class="minilogo"><img src="img/flower.png" alt=""></a>
              	<p>
              		<label for="user_login">Username<br />
              		<input type="text" name="login" id="user_login" class="input" value="<?php if( isset( $data['login'] ) ){echo @$data['login'];} ?>" size="20" /></label>
              	</p>
              	<p>
              		<label for="user_pass">Password<br />
              		<input type="password" name="password" id="user_pass" class="input" value="<?php if( isset( $data['password'] ) ){echo @$data['password'];} ?>" size="20" /></label>
              	</p>
                <button type="submit" name="do_signin" id="do_signin"  class="mirabutton" value="">SIGN IN</button>
                <?php //результат
                if( $_GET['signedupnow'] == true ) //Если пользователь только что зарегистрировался и попал на страницу логина
                {
                  echo '<div id="notes" style="color: green;">You have signed up successfully. Sign in now!</div>'; //если пользователь пришел со страницы регистрации, предлагаем залогиниться
                }
                if( isset( $data['do_signin'] ) )//если была нажата кнопка логина
                {
                  if ( empty($errors) )//если ошибок нет - выводим уведомление
                  {
                    //echo '<div id="notes" style="color: green;">You have successfully signed in! Come to <a href="index.php">home page</a>!</div>'; //выводим уведомление о том, что все ок
                    header('Location: /'); //после успешного логина перекидываем на фронт пейдж
                  }
                  else//иначе, выводим ошибку
                  {
                    echo '<div id="notes" style="color: red;">' . array_shift($errors) . '</div>'; //выводим первую ошибку из множества
                  }
                }
                ?>
                  <div class="clearfix"></div>
              </div>
            </form>
      	</div>
