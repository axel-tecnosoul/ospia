<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: *");
}
require "vendor/autoload.php";
require "admin/config.php";
require "admin/database.php";

/*use sngrl\PhpFirebaseCloudMessaging\Client;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Device;
use sngrl\PhpFirebaseCloudMessaging\Notification;*/

# composer require google/auth
use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;

function getAccessToken() {
    $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];
    #usar json del proyecto firebase correspondiente
    #ospia testing
    # $jsonKey = 'serviceAccountKey-ospiapbatesting-firebase-adminsdk-lbt4s-8db4ebc483.json';
    #ospia produccion
    $jsonKey = 'serviceAccountKey-app-ospiapba-582ebadcf1dc-ospianuevaapi.json';

    $credentials = new ServiceAccountCredentials($scopes, $jsonKey);
    $accessToken = $credentials->fetchAuthToken();
    
    if (!isset($accessToken['access_token'])) {
        throw new Exception('Failed to fetch access token');
    }
    
    return $accessToken['access_token'];
}


function sendMessage($token, $payload) {
  $accessToken = getAccessToken();
  #ajustar url
  #testing
  #$url = 'https://fcm.googleapis.com/v1/projects/ospiapbatesting/messages:send';
  #prod
  $url = 'https://fcm.googleapis.com/v1/projects/app-ospiapba/messages:send';

  $client = new Client();
  $response = $client->post($url, [
      'headers' => [
          'Authorization' => 'Bearer ' . $accessToken,
          'Content-Type' => 'application/json',
      ],
      'json' => [
          'message' => [
              'token' => $token,
              'notification' => $payload['notification'],
              'data' => array_merge($payload['data'], [
                  'notification_foreground' => 'true'
              ])
          ]
      ]
  ]);

  return $response->getBody()->getContents();
}

//$server_key = 'AAAAWv3X-68:APA91bHYHwsOQrKKs4fIIAx2K5e1hVCQJCa-IaQDnUa0TUz_MIkC_uesPqdoY0Yxt6CNPvpwf-dkLJ7NZhRin_H4qImiJI_Zs-ddD7ALdeWDaYhNSIo0LZR2LWvoOfroqpwBMBMJtKfR';
//$server_key = 'AAAAPCs4egE:APA91bHgPHlkhjUTg-iD6AzE98bC0TChxwNP6c_MkWJb-ofO8BBaqA90JZlotsUX_bOI5u54tCK3jZfevnLqG-s8XpXB3TCa9rMDy8Ciu4xCGJC5gc34PXxrbBvYpqPjI-TIrnX4aJtM';//cuenta firebase Tecno
$server_key = 'AAAAwX7IHbg:APA91bGGqGNPBel8rfonJYgx7Cu6wvFu_Y-0aaVzOjL_0mUAhI8Jxomfm0yuVmhdBHS03O7R9WMhAq0QTE2J_OdJYOyUGxq3KcDf8mVpMJQZgsgS4ow47917vebcvLjgm50lZQzktLhf'; //cuenta firebase ospia


//$token = 'DEVICE_REGISTRATION_TOKEN';
//$regIdfijo ="dAjpcZYFQ2OLjVlKiG8QA1:APA91bEhPcjmBIoIzAPmUbQZ1qfURpjRrpyb1oyUKN7p-hcTcluz4BlhR0XxJHpESar0g_XZm_0JK6xWeoaEnZ7KGpYVI8N-x0jvub8OA9LHayyXgQeqrt7x4ReZHl9AhB7J8FFlPlBN";
//$token="dZUJa92BTpeqEn2N5K6Q6f:APA91bFoyajam2ETs4cEhFLVLHV2-V5ONRXElIlX-AT0jikiyasmCLffU1bdcQagPmGlMVzV_Ut_FAjCN2nxdJza9A1CsAtT-70h2mJKngULCpb-tWGJhN6hXqipdA719kh_eqevuvJ1";

//$token=$_GET['fcmToken'];

//print_r ($_GET);
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT u.email,n.asunto,n.mensaje,u.token_app,nl.id FROM notificaciones n INNER JOIN notificaciones_lecturas nl ON nl.id_notificacion=n.id INNER JOIN usuarios u ON nl.id_usuario=u.id WHERE notif_push=1 AND enviada=0 AND nl.fecha_hora<=NOW() AND token_app IS NOT NULL AND token_app NOT IN ('1234','BLACKLISTED')";
foreach ($pdo->query($sql) as $row) {

  /*echo "<pre>";
  var_dump($row);
  echo "</pre>";*/
  
  $titulo=$row["asunto"];
  $cuerpo=$row["mensaje"];
  $token=$row["token_app"];

  $payload = [
      'notification' => [
          'title' => $titulo,//'Firebase HTTPv1 API',
          'body' => $cuerpo,//'Mensaje con Nueva api !'
      ],
      'data' => [
          'key1' => 'value1',
          'key2' => 'value2'
      ]
  ];

  try {
    $json_result = sendMessage($token, $payload);

    $result=json_decode($json_result,true);

    if(isset($result["name"])){
      $sql2 = "UPDATE notificaciones_lecturas SET enviada = 1 WHERE id = ?";
      $q2 = $pdo->prepare($sql2);
      $q2->execute(array($row['id']));
      echo "<br>".$sql2;
      $afe2=$q2->rowCount();
      echo "<br>Afe: ".$afe2;
    }
    
  } catch (Exception $e) {

    
    // Manejo del error
    $json_result="<font color='red'>Se ha producido un error:" . $e->getMessage()."</font>";
    // Registrar el error en el archivo de log
    error_log($e->getMessage());
  }

  echo "<h2>Notificacion con token</h2>";
  echo $titulo." -> ".$cuerpo;
  echo "<h3>Enviada a:</h3>";
  echo "<h4> email: ".$row["email"]." </h4>";
  echo "<p><b>token:</b> ".$token." </p>";
  echo "<h3>Respuesta Firebase</h3>";
  /*echo "response->getStatusCode(): ";
  var_dump($response->getStatusCode());
  $response_content=$response->getBody()->getContents();
  $response_content=json_decode($response_content,true);
  //var_dump($response_content);
  echo "<br>response_content[success]: ";
  var_dump($response_content["success"]);*/
  echo "<p>result: ".$json_result."</p>";

  //echo $result["name"];

  /*$client = new Client();
  $client->setApiKey($server_key);
  $client->injectGuzzleHttpClient(new \GuzzleHttp\Client());
 
  $message = new Message();
  $message->setPriority('high');
  $message->addRecipient(new Device($row["token_app"]));
  $message
    ->setNotification(new Notification($titulo, $cuerpo))
    ->setData(['title' => $titulo,'body' => $cuerpo, 'notification_foreground' => 'true']);

  $response = $client->send($message);
  var_dump($response);*/
  
}
Database::disconnect();

?>