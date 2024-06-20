<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Log the start of the script execution
$bytes=file_put_contents('cron_debug.log', "Script started at: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

// Your script logic here
if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: *");
}

/*
// Lee el contenido del archivo
$contenidoJson = file_get_contents($jsonKey);

var_dump($contenidoJson);

// Verifica si la lectura fue exitosa
if ($contenidoJson === false) {
    //die('No se pudo leer el archivo JSON');
    $contenidoJson='No se pudo leer el archivo JSON';
}
//die();

*/

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
    //$jsonKey = 'https://ospiaprovincia.org/serviceAccountKey-app-ospiapba-582ebadcf1dc-ospianuevaapi.json';
    $jsonKey = '/home5/rxhvjzic/public_html/serviceAccountKey-app-ospiapba-582ebadcf1dc-ospianuevaapi.json';

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

//print_r ($_GET);
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//$sql = "SELECT u.email,n.asunto,n.mensaje,u.token_app,nl.id FROM notificaciones n INNER JOIN notificaciones_lecturas nl ON nl.id_notificacion=n.id INNER JOIN usuarios u ON nl.id_usuario=u.id WHERE notif_push=1 AND enviada=0 AND nl.fecha_hora<=NOW() AND token_app IS NOT NULL AND token_app NOT IN ('1234','BLACKLISTED')";

$sql = "SELECT u.email,n.asunto,n.mensaje,u.token_app,nl.id FROM notificaciones n INNER JOIN notificaciones_lecturas nl ON nl.id_notificacion=n.id INNER JOIN usuarios u ON nl.id_usuario=u.id WHERE notif_push=1 AND enviada=0 AND nl.fecha_hora<=NOW() AND token_app IS NOT NULL AND token_app NOT IN ('1234','BLACKLISTED')";
$c=$c2=0;
$txtDebug="";
foreach ($pdo->query($sql) as $row) {
  $c++;

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
      $c2++;
      $sql2 = "UPDATE notificaciones_lecturas SET enviada = 1 WHERE id = ?";
      $q2 = $pdo->prepare($sql2);
      $q2->execute(array($row['id']));
      echo "<br>".$sql2;
      $afe2=$q2->rowCount();
      echo "<br>Afe: ".$afe2;
    }
    
  } catch (Exception $e) {

    // Manejo del error
    $json_result="<font color='red'>";
    
    $json_result.="</br>Mensaje de error: " . $e->getMessage();
    $json_result.="</br>Código de error: " . $e->getCode();
    $json_result.="</br>Archivo: " . $e->getFile();
    $json_result.="</br>Línea: " . $e->getLine();
    //$json_result.="</br>Rastreo de la pila:" . $e->getTraceAsString();
    
    $json_result.="</font>";

    // Registrar el error en el archivo de log
    error_log($e->getMessage());
  }

  /*echo "<h2>Notificacion con token</h2>";
  echo $titulo." -> ".$cuerpo;
  echo "<h3>Enviada a:</h3>";
  echo "<h4> email: ".$row["email"]." </h4>";
  echo "<p><b>token:</b> ".$token." </p>";
  echo "<h3>Respuesta Firebase</h3>";
  echo "<p>result: ".$json_result."</p>";*/

  $txtDebug.="<h2>Notificacion con token</h2>";
  $txtDebug.=$titulo." -> ".$cuerpo;
  $txtDebug.="<h3>Enviada a:</h3>";
  $txtDebug.="<h4> email: ".$row["email"]." </h4>";
  $txtDebug.="<p><b>token:</b> ".$token." </p>";
  $txtDebug.="<h3>Respuesta Firebase</h3>";
  $txtDebug.="<p>result: ".$json_result."</p>";
  

  /*echo "response->getStatusCode(): ";
  var_dump($response->getStatusCode());
  $response_content=$response->getBody()->getContents();
  $response_content=json_decode($response_content,true);
  //var_dump($response_content);
  echo "<br>response_content[success]: ";
  var_dump($response_content["success"]);*/
  
}

echo $txtDebug;

$resumen_ejecucion="$c2 de $c push enviados";
//$resumen_ejecucion.="<br><br>".$contenidoJson;
if(!$bytes){
  $resumen_ejecucion.="<br><br>No anduvo escribir en cron_debug.log";
}
$resumen_ejecucion.="<br><br>".$txtDebug;

$sql = "SELECT resumen_ejecucion FROM cron_log ORDER BY id DESC LIMIT 1;";
$q = $pdo->prepare($sql);
$q->execute();
$row = $q->fetch();

if($row["resumen_ejecucion"]!=$resumen_ejecucion){
  $sql2 = "INSERT INTO cron_log (cron,resumen_ejecucion) VALUES ('check_notificaciones',?)";
  $q2 = $pdo->prepare($sql2);
  $q2->execute([$resumen_ejecucion]);
  echo "<br>".$sql2;
  $afe2=$q2->rowCount();
  echo "<br>".$afe2;
}

Database::disconnect();

// Log the end of the script execution
file_put_contents('cron_debug.log', "Script ended at: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
?>