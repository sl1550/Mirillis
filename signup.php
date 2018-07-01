
<?php //Логика
if( isset( $_SESSION['isLogged'] ) ){//выбрасываем юзера на фронт пейдж, если он уже залогинен
  header('Location: /');
}
$data = $_POST; //присваиваем переменной значение POST
if( isset( $data['do_signup'] ) )//проверяем, была ли нажата кнопка регистрации (в массиве должен появится ключ с именем кнопки регистрации)
{
  //регистрируем
  $errors = array(); //создаем массив для ошибок
  if( trim( $data['login'] ) == '' )//проверка на пустоту логина (тримаем, что бы исключить пробелы)
  {
    $errors[]='Enter username!'; //запоминаем ошибку
  }
  if( strlen( $data['login'] ) < 6 )//проверка длины логина (минимум 6 символов)
  {
    $errors[]='Username must be at least 6 characters!'; //запоминаем ошибку
    unset($data['login']); //сбрасываем неверное значение
  }
  if( preg_match( "/^[A-Za-z0-9]+$/", $data['login'] ) == false )//проверка на допустимые символы (не тримаем, т.к. если будут пробелы, то о их недопустимости необходимо предупредить)
  {
    $errors[]='Username must contain only A-Z, a-z, 0-9 characters!'; //запоминаем ошибку
    unset($data['login']); //сбрасываем неверное значение
  }
  if( R::count( 'users', 'login = ?', array( $data['login'] ) ) > 0 )//проверка уникальности логина (минимум 6 символов)
  {
    $errors[]='Username is already in use!'; //запоминаем ошибку
    unset($data['login']); //сбрасываем неверное значение
  }
  if( trim( $data['email'] ) == '' )//проверка на пустоту e-mail (тримаем, что бы исключить пробелы)
  {
    $errors[]='Enter e-mail!'; //запоминаем ошибку
  }
  if( R::count( 'users', 'email = ?', array( $data['email'] ) ) > 0 )//проверка уникальности логина (минимум 6 символов)
  {
    $errors[]='E-mail is already in use!'; //запоминаем ошибку
    unset($data['email']); //сбрасываем неверное значение
  }
  if( $data['password'] == '' )//проверка на пустоту пароля (не тримаем, т.к. если будут пробелы, то о их недопустимости необходимо предупредить)
  {
    $errors[]='Enter password!'; //запоминаем ошибку
  }
  if( strlen( $data['password'] ) < 6 )//проверка длины пароля (минимум 6 символов)
  {
    $errors[]='Password must be at least 6 characters!'; //запоминаем ошибку
    unset($data['password']); //сбрасываем неверное значение
  }
  if( preg_match( "/^[A-Za-z0-9]+$/",$data['password'] ) == false )//проверка на допустимые символы пароля
  {
    $errors[]='Password must contain only A-Z, a-z, 0-9 characters!'; //запоминаем ошибку
    unset($data['password']); //сбрасываем неверное значение
  }
  if( $data['password_2'] != $data['password'] )//проверка равенства паролей
  {
    $errors[]='Passwords must not be different!'; //запоминаем ошибку
    unset($data['password']); //сбрасываем неверное значение
    unset($data['password_2']); //сбрасываем неверное значение
  }
  if ( empty($errors) )//если ошибок нет - регистрируем
  {
    //все ок, регистрируем
    $user = R::dispense('users'); //создаем новую запись в таблице users
    $user->login = $data['login']; //заполняем поле логин
    $user->email = $data['email']; //заполняем поле e-mail
    $user->password = password_hash($data['password'], PASSWORD_DEFAULT); //шифруем пароль алгоритмом bcrypt и заполняем им поле
    R::store($user); //сохраняем запись в таблице
    if( $data['autosignin'] == "on" ){ //если юзер выбрал чекбокс автоматической авториразии после регисрации - создаем сессию на основании проверенных данных для регистрации
        $_SESSION['isLogged'] = true;
        $_SESSION['userId'] = $user->id;
        $_SESSION['userLogin'] = $user->login;
    }

  }
}
 ?>

<div id="signup" class="signup">

            <form name="signupform" id="signupform" action="?page=signup" method="POST">
              <div class="signupform-head">
                SIGN UP
              </div>
              <div class="signupform-content">
                <a href="/" title="Mirillis" class="minilogo"><img src="img/flower.png" alt=""></a>
              	<p>
              		<label for="user_login">Username<br /> (must be at least 6 'A-Z, a-z, 0-9' characters)<br />
              		<input type="text" name="login" id="user_login" class="input" value="<?php if( isset( $data['login'] ) ){echo @$data['login'];} ?>" size="20" /></label>
              	</p>
                <p>
              		<label for="user_email">E-mail<br />
              		<input type="email" name="email" id="user_email" class="input" value="<?php if( isset( $data['email'] ) ){echo @$data['email'];} ?>" size="20" /></label>
              	</p>
              	<p>
              		<label for="user_pass">Password <br /> (must be at least 6 'A-Z, a-z, 0-9' characters)<br />
              		<input type="password" name="password" id="user_pass" class="input" value="<?php if( isset( $data['password'] ) ){echo @$data['password'];} ?>" size="20" /></label>
              	</p>
                <p>
              		<label for="user_pass2">Password (again)<br />
              		<input type="password" name="password_2" id="user_pass2" class="input" value="<?php if( isset( $data['password_2'] ) ){echo @$data['password_2'];} ?>" size="20" /></label>
              	</p>
                <p>
                    <input type="checkbox" name="autosignin" id="autosignin" checked>
                    <label for="autosignin">Sign in after sign up</label>
                </p>
              		<button type="submit" name="do_signup" id="do_signup"  class="mirabutton" value="">SIGN UP</button>
                  <?php //результат
                  if( isset( $data['do_signup'] ) )
                  {
                    if ( empty($errors) )//если ошибок нет - посылаем на форму логина или логиним сразу
                    {
                      if( $data['autosignin'] == "on" ){//если юзер выбрал чекбокс автологина - авторизуем и посылаем на хоумпейдж
                           header('Location: /');
                       }else{//иначе, посылаем на форму логина и предлагаем авторизоваться
                      header('Location: /?page=signin&signedupnow=true');
                        }
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
