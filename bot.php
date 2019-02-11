<?php


$tokens = [
    'VK_TOKEN' => 'eb2cfc7787938ecc8ff424f92e1272e710c84ea19f0bcbae0500f8a79b5437cd69a24348591c8c635f',
    'VK_SECRET_TOKEN' => 'ytujdjhbvytxnjltkfnmbzytcrferelfnttb',
    'VK_CONFIRMATION_CODE' => 'a5306'
];
$data = json_decode(file_get_contents('php://input'));
if(!$data){
    echo '$data is empty.';
}

switch($data->type){

    case 'confirmation':
      if($data->secret !== $tokens['VK_SECRET_TOKEN'] ){
        echo 'Secret token does not match.';
        break;
      }
      echo $tokens['VK_CONFIRMATION_CODE'];
      break;

    case 'message_new':
      if($data->secret !== $tokens['VK_SECRET_TOKEN'] ){
        echo 'Secret token does not match.';
        break;
      }
      $request_params = array(
              'user_id' => $data->object->user_id,
              'message' => 'Тест',
              'access_token' => $tokens['VK_TOKEN'],
              'v' => '5.69'
      );
      file_get_contents('https://api.vk.com/method/messages.send?' . http_build_query($request_params));
      echo 'ok';
      break;

}





?>
