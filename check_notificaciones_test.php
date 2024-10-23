<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: *");
}
require "vendor/autoload.php";
require "admin/config.php";
require "admin/database.php";

use sngrl\PhpFirebaseCloudMessaging\Client;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Device;
use sngrl\PhpFirebaseCloudMessaging\Notification;

//$server_key = 'AAAAWv3X-68:APA91bHYHwsOQrKKs4fIIAx2K5e1hVCQJCa-IaQDnUa0TUz_MIkC_uesPqdoY0Yxt6CNPvpwf-dkLJ7NZhRin_H4qImiJI_Zs-ddD7ALdeWDaYhNSIo0LZR2LWvoOfroqpwBMBMJtKfR';
$server_key = 'AAAAPCs4egE:APA91bHgPHlkhjUTg-iD6AzE98bC0TChxwNP6c_MkWJb-ofO8BBaqA90JZlotsUX_bOI5u54tCK3jZfevnLqG-s8XpXB3TCa9rMDy8Ciu4xCGJC5gc34PXxrbBvYpqPjI-TIrnX4aJtM';//cuenta firebase Tecno

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT u.email,n.asunto,n.mensaje,u.token_app,nl.id FROM notificaciones n INNER JOIN notificaciones_lecturas nl ON nl.id_notificacion=n.id INNER JOIN usuarios u ON nl.id_usuario=u.id WHERE notif_push=1 AND enviada=0 AND nl.fecha_hora<=NOW() AND id_usuario=20";
foreach ($pdo->query($sql) as $row) {

  //var_dump($row);
  
  $titulo=$row["asunto"];
  $cuerpo=$row["mensaje"];

  $client = new Client();
  $client->setApiKey($server_key);
  $client->injectGuzzleHttpClient(new \GuzzleHttp\Client());
 
  $message = new Message();
  $message->setPriority('high');
  $message->addRecipient(new Device($row["token_app"]));
  $message
    ->setNotification(new Notification($titulo, $cuerpo))
    ->setData(['title' => $titulo,'body' => $cuerpo, 'notification_foreground' => 'true'])
  ;

  $response = $client->send($message);
  var_dump($response);
  
  echo "<h2>Notificacion con token</h2>";
  echo $row["asunto"]." -> ".$row["mensaje"];
  echo "<h3>Enviada a:</h3>";
  echo "<h4> email: ".$row["email"]." </h4>";
  echo "<p><b>token:</b> ".$row["token_app"]." </p>";
  echo "<h3>Respuesta Firebase</h3>";
  echo "response->getStatusCode(): ";
  var_dump($response->getStatusCode());
  $response_content=$response->getBody()->getContents();
  $response_content=json_decode($response_content,true);
  //var_dump($response_content);
  echo "<br>response_content[success]: ";
  var_dump($response_content["success"]);

  if($response_content["success"]==1 and $response->getStatusCode()==200){
    $sql2 = "UPDATE notificaciones_lecturas SET enviada = 1 WHERE id = ?";
    $q2 = $pdo->prepare($sql2);
    $q2->execute(array($row['id']));
    echo "<br>".$sql2;
    $afe2=$q2->rowCount();
    echo "<br>Afe: ".$afe2;
  }
}
Database::disconnect();
$pdo = null; // Libera la referencia en la variable local

?>