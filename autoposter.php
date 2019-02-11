<form action="?page=autoposter" method="post">
    <p>
      <input type="password" name="magic">
    </p>
    <p>
    <input type="radio" name="target" value="chernopolyeNash" checked>
    Чернополье 2 га Наш (1 500 000 р.)
    </p>
    <input type="radio" name="target" value="kizilovkaBuzaev">
    Кизиловка 45 соток ИЖС Бузаев (1 500 000 р.)
    </p>
    <br>
    <input type="submit" name="Publish" value="Publish">
</form>

<?php
/*Список групп*/
$groupIds = array(
    'Крым: недвижимость объявления. Отдых у моря. (<a href="https://vk.com/coolvideos">URL</a>)' => -16488605,
    'Недвижимость Крым (<a href="https://vk.com/domikcrimea">URL</a>)' => -29254246,
    /*'Недвижимость. Крым. Симферополь Аренда.Продажа. (<a href="https://vk.com/public122997290">URL</a>)' => -122997290,*/ //Размещает сам риелтор
    'Недвижимость Крыма | Оформление | Продажа (<a href="https://vk.com/takt_crimea">URL</a>)' => -15912865,
    'Недвижимость в Крыму, объявления без посредников (<a href="https://vk.com/club52993806">URL</a>)' => -52993806,
    'Продажа недвижимости в Крыму. (<a href="https://vk.com/crea_takt">URL</a>)' => -20373276,
    'Недвижимость Крым | Симферополь | Севастополь (<a href="https://vk.com/nedvizhimostcr">URL</a>)' => -96437186,
    'Объявления Недвижимость Симферополь и весь Крым (<a href="https://vk.com/domacrimea">URL</a>)' => -74407605,
    'Недвижимость Крым Севастополь Симферополь Ялта (<a href="https://vk.com/nedvizhimost_krym_sevastopol">URL</a>)' => -120046688,
    'Недвижимость Севастополя, Крым | объявления (<a href="https://vk.com/vsevasdom">URL</a>)' => -13246086,
    'Недвижимость Крыма (<a href="https://vk.com/real_estate_krum">URL</a>)'=> -52111009,
    'Продажа недвижимости в Крыму (<a href="https://vk.com/club24454360">URL</a>)' => -24454360,
    'Продажа недвижимости в Крыму (<a href="https://vk.com/s7sprodat">URL</a>)' => -87836366,
    'Аренда и продажа недвижимости в Крыму (<a href="https://vk.com/arenda_krim2016">URL</a>)' => -118957855,
    'Продажа недвижимости в Крыму (<a href="https://vk.com/kypitkrim">URL</a>)' => -152960422);
// группы 0, 2, 6, 14 - с предложкой
if($_SESSION['userLogin'] == 'sl1550' && $_POST['Publish'] == 'Publish'){


    /*Выбираем объявление*/
    switch ($_POST['target']) {
        case 'chernopolyeNash':
            $message = '⚠ТРАССА СИМФЕРОПОЛЬ - КЕРЧЬ, 53-й КИЛОМЕТР⚠

        Продам земельный участок площадью в 2 гектара. Располагается в Белогорском районе вдоль самой крупной транспортной артерии Республики Крым, на 53-м километре трассы Симферополь - Керчь. Местоположение живописное и очень выгодное, с точки зрения логистики и проходимости автотранспорта. Ширина земельного участка - 65 метров, длина - 330 метров. Через земельный участок проходит линия электропередачи, что позволяет без проблем подключится к сети. Также рядом имеются природные водоемы, грунтовые воды залегают на малой глубине. Расстояние до Белогорска - 10 километров. Документы оформлены в полном соответствии с законодательством Российской Федерации (кадастровый паспорт с установленными границами + свидетельство о государственной регистрации права).

        ✅  Цена - 1 500 000 р. ✅

        Разумный торг уместен.

        Контактный номер телефона: +7 978 790 97 30 / +7 978 090 15 50';
            $attachment = 'photo267003060_429445304,photo267003060_429445323,photo267003060_429445347,photo267003060_429445367,photo267003060_429445382,photo267003060_429445396,photo267003060_429445418';
            break;

          case 'kizilovkaBuzaev':
            $message = '⚠БЕЛОГОРСКИЙ РАЙОН, СЕЛО КИЗИЛОВКА, ИЖС 45 СОТОК⚠

Продам массив из 3-х земельных участков общей площадью 45 соток в селе Кизиловка Белогорского района по улице Лесной (Лесная 7, 9, 11). Земельные участки расположены в живописном месте, окружены горами, рядом лес. В непосредственной близости с земельными участками проходит линия электропередачи, что позволяет беспрепятственно подключится с электрической сети. С водообеспечением проблем нет, грунтовые воды залегают на малой глубине. До районного центра - города Белогорска - 10 км. Вид разрешенного использования земельных участков - индивидуальное жилищное строительство. Документы оформлены в полном соответствии с законодательством Российской Федерации. Являюсь собственником всех 3-х земельных участков.

✅ Цена за 3 участка - 1 500 000 р. ✅

Разумный торг уместен.

Контактный номер телефона: +7 978 090 15 50';
            $attachment ='photo267003060_429445568,photo267003060_429445633,photo267003060_429445688,photo267003060_429445763,photo267003060_429445839,photo267003060_429445849';
            break;

        default: //обнуляем сообщение, если нет подходящего кейса
            $message = NULL;
            break;
    }

    if( isset( $message ) ){ //Проверяем правильность выбранного кейса
        $vk = new VK\Client\VKApiClient('5.80'); //инициализируем SDK
        $result = array(); //Создаем массив с результатами отправок
        $URLs = array(); //Создаем массив с URL-ами результата

        $attachmentIdsArray = explode(',', $attachment); // Разбиваем строку с адресами приложенных фотографий на элементы в виде нового массива
        foreach ($attachmentIdsArray as &$item) {// Отсекаем у каждого элемента 'photo267003060_' (тип приложения и ID хозяина). В данном случае, начинаем читать ID фотографии с 15 символа. Может изменяться в зависимости от ID хозяина и типа приложения.
          $item = substr($item, 15);
        }
        unset($item);// убираем ссылку на переменную &$item (особенность foreach)

          /*Выполняем задание для каждой группы*/
        foreach ($groupIds as $name => $id) {
            $suggestsCheck = $vk->wall()->get($_POST['magic'] . '34564b65bbad6dc81d8e8f2bb37960df39ae26e68b1db8cb6f8686c5dc8be991edfd959216ab', array( // Делаем запрос на проверку предложенных постов в группе (что бы не спамить в предложку одинаковыми постами)
                'owner_id' => $id,
                'filter' => 'suggests'));

            usleep(500000); // задержка 0,5 секунды во избежание частых запросов

            $photoIds = array();// Создаем массив для записи ID первой фотографии в каждом предложенном посте (это будет индикатор индентичности предложенных записей)
            foreach ($suggestsCheck['items'] as $key) { // Вытягиваем из ответа ID первой фотографии в каждом предложенном посте (полная структура выглядит как $suggestsCheck['items'][n]['attachments'][0]['photo']['id'], где n - порядковый номер предложенного поста)
              $photoIds[]= $key['attachments'][0]['photo']['id'];
            }

            $aE = false; //Already exists (уже существует) - флаг для проверки среди предложенных публикаций повторения предлагаемой
            foreach ($photoIds as $photoId) { // В массиве с ID первых фотографий в каждом предложенном посте проверяем наличие ID первой фотографии предлагаемого поста
              if($photoId == $attachmentIdsArray[0]){ // Если найдено совпадение ID первой фотографии в предложенном ранее и предлагаемом посте - устанавлиеваем флаг в позицию true, т.е. совпадение найдено, и прерываем цикл проверки
                $aE = true;
                break;
              }
            }

            if ($aE == false){ //Если совпадений обнаружено не было, публикуем пост
              try{ //Пробуем опубликовать, в случае ошибки пропускаем итерацию, выводим текст ошибки
              $response = $vk->wall()->post($_POST['magic'] . '34564b65bbad6dc81d8e8f2bb37960df39ae26e68b1db8cb6f8686c5dc8be991edfd959216ab', array(
                  'owner_id' => $id,
                  'friends_only' => 0,
                  'from_group' => 0,
                  'message' => $message,
                  'attachment' => $attachment));
              $result[] = $response; //записываем результат (id поста)
              $URLs[] = 'https://vk.com/public' . substr($id, 1) . '?w=wall-' . substr($id, 1) . '_' . $response['post_id'];// формируем URL
              }
              catch(Exception $e){
                $result[] = $e->getMessage();//В случае ошибки в результаты записываем текст ошибки
                $URLs[] = 'error';// Вместо URL сообщаем об ошибке
              }

            }

            usleep(500000); //задержка 0,5 секунды во избежание частых запросов
        }
        /* Результат выполнения задания */
        unset($_POST);// очищаем массив POST
        echo '<pre>';
        print_r($result); //печатаем всю структуру результата
        echo '</pre>';
        foreach ($URLs as $number => $URL) {//Формируем список URL опубликованных постов
            if($URL != 'error'){//Если пост успешно сформировался - выводим на него ссылку
            echo '<a href="' . $URL . '"> This is a link nubmer' . $number . '</a><br>'; //печатаем URL постов
          }
        }
    }else{//Был выбран неверный кейс
        echo '<p style="color: red;">Wrong switch case. Your case is' . $_POST['target'] . '.</p>';
    }

}else{//Либо пользователь только что зашел на страницу, либо он не зашел под необходимой учеткой, либо все вместе
    echo '<p style="color: green;">Set your case and click "Publish".</p>';
    echo '<p>Publics list:</p>';
    foreach ($groupIds as $name => $id) {//выводим список групп для публикации
        echo '<p>' . $name . '</p>';
    }
}
/* ПРОВЕРОЧНАЯ ОТПРАВКА НА СВОЮ СТЕНУ
$response = $vk->wall()->post($permToken, array(
  'owner_id' => 267003060,
  'friends_only' => 0,
  'from_group' => 0,
  'message' => $message,
  'attachment' => $attachment));

  print_r($response);*/



  /*ОТПРАВКА СООБЩЕНИЯ В ЛИЧКУ
  $response = $vk->messages()->send($permToken, array(
    'user_id' => 277839998,
    'peer_id' => 277839998,
    'message' => 'Это сообщение отправлено через скрипт.',
    'attachment' => 'photo267003060_456242055'));

    print_r($response);*/



  /*ПОЛУЧЕНИЕ ТОКЕНА ЧЕРЕЗ IMPLICIT FLOW
  $vk = new VK\Client\VKApiClient('5.80');
  $oauth = new VK\OAuth\VKOAuth('5.80');

  $client_id = '6624792';
  $redirect_uri = 'api.vk.com/blank.html';
  $display = VK\OAuth\VKOAuthDisplay::PAGE;
  $scope = array(VK\OAuth\Scopes\VKOAuthUserScope::WALL, VK\OAuth\Scopes\VKOAuthUserScope::MESSAGES, VK\OAuth\Scopes\VKOAuthUserScope::GROUPS, VK\OAuth\Scopes\VKOAuthUserScope::OFFLINE);
  $state = 'KJ9R5iWQWfvLcMSoeJIs';
  $revoke_auth = true;

  $browser_url = $oauth->getAuthorizeUrl(VK\OAuth\VKOAuthResponseType::TOKEN, $client_id, $redirect_uri, $display, $scope, $state, null, $revoke_auth);
  echo '<a href="' . $browser_url . '">GET TOKEN</a>';
  */


  /*СТАРЫЙ БЛОК ПУБЛИКАЦИИ
  if($suggestsCheck['count'] == 0){ //Если предложенных постов нет - посылаем пост в предложку
      $response = $vk->wall()->post($permToken, array(
          'owner_id' => $id,
          'friends_only' => 0,
          'from_group' => 0,
          'message' => $message,
          'attachment' => $attachment));
      $result[] = $response;
      $URLs[] = 'https://vk.com/public' . substr($id, 1) . '?w=wall-' . substr($id, 1) . '_' . $response['post_id'];
  }*/
?>
