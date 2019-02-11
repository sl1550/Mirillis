<?php

if ( !isset( $_SESSION['isLogged'] ) )// при отсутствии сессии выкидываем на хоум пейдж
{
    header('Location: /');
}else{
  $user = R::load( 'users',$_SESSION['userId'] ); //находим по ID юзера всю информацию о нем
}
$data = $_POST; //присваиваем переменной значение POST
if ( isset( $data['profile_update'] ) ){
  $errors = array(); //создаем массив для ошибок
  if( strlen( $data['about'] ) > 280 ){//длина ОБО МНЕ макс 280 символов
    $errors[] = 'Maximum 280 characters for "About me"!';
  }
  if( preg_match("/^[0-9]{11}$/", trim( $data['tel'] )) == false && $data['tel'] != '' ){//проверяем, что бы телефонный номер был либо в 11 цифр, либо пустой, если пользователь предпочел его удалить
    $errors[] = 'Incorrect format of Tel. number. Only 11 digits is allowed!';
  }
  if( strlen( $data['address'] ) > 140 ){//длина адреса макс 140 символов
    $errors[] = 'Maximum 140 characters for Address!';
  }
  if( strlen( $data['vk'] ) > 140 ){//длина ссылки макс 140 символов
    $errors[] = 'Too long VK link (maximum 140 characters)!';
  }
  if( strlen( $data['fb'] ) > 140 ){//длина ссылки макс 140 символов
    $errors[] = 'Too long FB link (maximum 140 characters)!';
  }
  if( strlen( $data['inst'] ) > 140 ){//длина ссылки макс 140 символов
    $errors[] = 'Too long Instagram link (maximum 140 characters)!';
  }

  if ( $_FILES['profilepicture']['size'] != 0 ){//обрабатываем загрузку аватара, условие начала обработки - ненулевой размер файла.
    $picname = addslashes(basename($_FILES['profilepicture']['name']));//имя картинки, обработанное basename во избежание атак на файловую систему
    $picext = strtolower(end(explode('.', $picname)));//извлекаем формат изображения из названия. Разбиваем строку с именем на массив где 0 элемент - имя, 1 - формат. Возвращаем последний элемент массива(формат), преобразуем его в лоу кейс
    $pictype = $_FILES['profilepicture']['type'];//тип загруженной картинки (нам нужен image/jpeg)
    $pictmp = addslashes($_FILES['profilepicture']['tmp_name']);//путь к временному хранилищу картинки
    $picsize = $_FILES['profilepicture']['size'];//размер картинки в байтах
    $picerrormsg = $_FILES['profilepicture']['error'];
    if ( isset( $_POST['MAX_FILE_SIZE'] ) ){//Устанавливаем максимальный размер изображения через данные скрытого поля в форме загрузки изображения
        $maxsize = $_POST['MAX_FILE_SIZE'];
    }else{//Если на стороне браузера был задействован обход ограничения размера файла, устанавливаем ограничение явно
        $maxsize = 2097152;
    }
    if (!$pictmp){//проверяем, попал ли файл во временную директорию. Отсутствие файла говорит о неудачной загрузке
        $errors[] = 'Picture upload is failed. Maybe, picture was not choosed? Try again!';
    }
    if( $picsize > $maxsize ){//проверяем размер файла на превышение
        $errors[] = 'Maximum picture size is 2MiB!';
        unlink($pictmp); // удаляем изображение из временного хранилища
    }
    if ( $picerrormsg != 0 ){//проверяем наличие ошибки загрузки (при ошибке значение отличается от 0)
        $errors[] = 'Picture upload is failed. Try again!';
    }
    if ( $picext != 'jpg' && $picext != 'jpeg' ){//проверяем формат загруженного изображения
        $errors[] = 'Only *.jpg pictures is allowed!';
        unlink($pictmp); // удаляем изображение из временного хранилища
    }
        if( empty($errors) ){//если нет ошибок касательно изображения, идем далее
        //задаем максимальные размеры
        $maxwidth = 195;
        $maxheight = 195;
        list( $width_orig, $height_orig ) = getimagesize( $pictmp );//получаем оригинальные размеры из файла во временном хранилище
        // получение новых размеров
        $ratio_orig = $width_orig/$height_orig;
        if ($maxwidth/$maxheight > $ratio_orig) {
          $maxwidth = $maxheight*$ratio_orig;
        } else {
          $maxheight = $maxwidth/$ratio_orig;
        }
        // ресэмплирование
        $image_p = imagecreatetruecolor($maxwidth, $maxheight);
        $pic = imagecreatefromjpeg( $pictmp  );//создаем изображение из временного файла
        unlink($pictmp); //удаляем временное изображение
        unset($_FILES['profilepicture']);//удаляем данные об отправленном изображении
        imagecopyresampled($image_p, $pic, 0, 0, 0, 0, $maxwidth, $maxheight, $width_orig, $height_orig);//генерируем изображение в новом размере
        $picpatch = 'img/avatars/' . $user->login . '.jpg';//генерируем относительный путь (imagejpeg() не понимает абсолютного пути)
        imagejpeg($image_p, $picpatch, 100);//сохраняем объект из $image_p по пути $picpatch с качеством 100%
        $picpatch = '/' . $picpatch; //добавляем слэш для абсолютного пути
        $user->img = $picpatch;//сохраняем путь к картинке юзера в БД
    }
}//конец обработки загрузки аватара
  if ( empty($errors) ){//Если ошибок нет, записываем данные.
      $user->about = $data['about'];
      $user->tel = $data['tel'];
      $user->address = $data['address'];
      $user->vk = $data['vk'];
      $user->fb = $data['fb'];
      $user->inst = $data['inst'];
      R::store($user);
  }
}

?>
<div class="profile">
    <h2><?php echo ucfirst($_SESSION['userLogin']); ?> User Profile</h2>
    <hr>
    <form enctype="multipart/form-data" name="signinform" id="signinform" action="?page=profile" method="POST" >
        <div class="profile-details">
            <div class="photo">
                <p>Profile picture:</p>
                <div class="profile-picture">
                    <?php
                    if ( isset( $user->img ) ){
                        echo '<img src="' . $user->img . '">';
                    }else{
                        echo '<img src="/img/avatars/def_prof_pict.jpg">';
                    }
                    ?>
                </div>
                <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                <input name="profilepicture" id="selectedFile" type="file" style="position:absolute;visibility:hidden;"/>
                <input type="button" class="mirabutton" id="prof-pict-button" value="UPLOAD" onclick="selectedFile.click()">
                <p class="notification">Only *.jpg pictures is allowed.<br><br> Maximum picture size is 2MiB.<br><br> After uploading profile picture, you must update your profile!</p>
            </div>
            <div class="info">
                <p class="h3m">
                    General
                </p>
                <hr>
                <p>
                    <label for="login">Username: <br></label>
                    <input type="text" name="login" id="login" value="<?php echo $user->login; ?>" disabled>
                </p>
                <p>
                    <label for="email">About me<br>(max. - 280 char-s): <br></label>
                    <textarea class="about-me" rows="5" maxlength="280" name="about" id="about"><?php if ( isset($user->about) ){ echo $user->about;} ?></textarea>
                </p>
                <p class="h3m">
                    Contact info
                </p>
                <hr>
                <p>
                    <label for="email">E-mail: <br></label>
                    <input type="text" name="email" id="email" value="<?php echo $user->email; ?>" disabled>
                </p>
                <p>
                    <label for="tel">Tel. number<br>(11 digits): <br></label>
                    <span class="tel_add">+</span>
                    <input type="tel" name="tel" id="tel" value="<?php if ( isset($user->tel) ){ echo $user->tel;} ?>" pattern="[0-9]{11}" maxlength="11">
                </p>
                <p>
                    <label for="email">Address<br>(max. 140 char-s):<br></label>
                    <input type="text" name="address" id="address" value="<?php echo $user->address; ?>" maxlength="140">
                </p>
                <p class="h3m">
                    Socials
                </p>
                <hr>
                <p>
                    <label for="vk">VK link:<br></label>
                    <input type="url" name="vk" id="vk" value="<?php echo $user->vk; ?>" maxlength="140">
                </p>
                <p>
                    <label for="fb">FB link:<br></label>
                    <input type="url" name="fb" id="fb" value="<?php echo $user->fb; ?>" maxlength="140">
                </p>
                <p>
                    <label for="inst">Instagram link:<br></label>
                    <input type="url" name="inst" id="inst" value="<?php echo $user->inst; ?>" maxlength="140">
                </p>
            </div>
        </div>
        <button type="submit" name="profile_update" id="prof-upd-button"  class="mirabutton" value="">UPDATE PROFILE  </button>
        <?php //результат
        if( isset( $data['profile_update'] ) )
        {
          if ( empty($errors) )//если ошибок нет - выводим сообщение
          {
            echo '<div id="notes" style="color: green;">Profile updated successfully!</div>'; //выводим сообщение что все ок!
          }
          else//иначе, выводим ошибку
          {
            echo '<div id="notes" style="color: red;">' . array_shift($errors) . '</div>'; //выводим первую ошибку из множества
          }
        }
        ?>
    </form>
</div>

</div>
