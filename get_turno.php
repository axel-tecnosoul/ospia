<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: *");
}

include_once("admin/config.php");
include_once("admin/database.php");
include_once("admin/funciones.php");

$telefono=$_SESSION["user"]["celular"];
$fechaHora=urlencode($_POST["fecha"]." ".$_POST["hora"]);
$url=$url_ws."?Modo=19&Usuario=$usuario_ws&Persona=".$_POST["id_afiliado"]."&EspecialidadMed=".$_POST["id_profesional"]."&FechaHora=".$fechaHora."&Telefono=".$telefono;
//echo $url;
//$jsonData = json_decode(file_get_contents($url),true);
$jsonData = file_get_contents($url);
$jsonData = json_decode($jsonData,true);
//var_dump($jsonData);

if($jsonData["Ok"]=="true"){
  /*var_dump($jsonData);
  var_dump($jsonData->IdTurno);*/
  // insert data
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $asunto="Turnos OSPIA";
  $mensaje="El turno ID # ".$jsonData["IdTurno"]." ha sido creado con éxito";

  if($_SESSION["user"]["notif_push"]){
    //$fecha_hora=date("Y-m-d H:i",strtotime(date("Y-m-d H:i")."+2 minute"));
    $fecha_hora=date("Y-m-d H:i",strtotime(date("Y-m-d H:i")));

    $sql = "INSERT INTO notificaciones (asunto, mensaje, fecha_hora, ejecutada) VALUES (?,?,'$fecha_hora',0)";
    $q = $pdo->prepare($sql);
    $q->execute(array($asunto,$mensaje));
    $id_notificacion = $pdo->lastInsertId();

    $sql = "INSERT INTO notificaciones_lecturas (id_notificacion, id_usuario, fecha_hora, enviada, leida) VALUES (?,?,'$fecha_hora',0,0)";
    $q = $pdo->prepare($sql);
    $q->execute(array($id_notificacion,$_SESSION["user"]["id"]));
    $afe=$q->rowCount();
  }
  //echo "<br>Afe: ".$afe;

  /*
  $server_key = 'AAAAPCs4egE:APA91bHgPHlkhjUTg-iD6AzE98bC0TChxwNP6c_MkWJb-ofO8BBaqA90JZlotsUX_bOI5u54tCK3jZfevnLqG-s8XpXB3TCa9rMDy8Ciu4xCGJC5gc34PXxrbBvYpqPjI-TIrnX4aJtM';//dato a configurar
  
  $client = new Client();
  $client->setApiKey($server_key);
  $client->injectGuzzleHttpClient(new \GuzzleHttp\Client());
  
  $token=$_SESSION["user"]["token_app"];
  $token_pc_desarrollo="1234";

  if($token==$token_pc_desarrollo){
    $token="d4wH8vKITHWExx2hWzFAYW:APA91bGdpDYIJEBefPaf_bC5jY88rGi0_hi4nOWQoGZkCcyATL2vsHbwS-XtUVtoDP5DJAAA8YbPBR3lYayZPVe74oR5ibg3ng01-gFukykhi8kes-mUuv02KQ2Kct12-63BPjIXj4wm";
  }

  //echo $token;
  $message = new Message();
  $message->setPriority('high');
  $message->addRecipient(new Device($token));
  $message
    ->setNotification(new Notification($asunto, $mensaje))
    ->setData(['key' => 'value']);

  $response = $client->send($message);
  //var_dump($response);
  
  //echo "<h2>Notificacion con token</h2>";
  //echo $row["asunto"]." -> ".$row["mensaje"];
  //echo "<h3>Enviada a:</h3>";
  //echo "<h4> email: ".$row["email"]." </h4>";
  //echo "<p><b>token:</b> ".$row["token_app"]." </p>";
  //echo "<h3>Respuesta Firebase</h3>";
  //echo "response->getStatusCode(): ";
  //var_dump($response->getStatusCode());
  $response_content=$response->getBody()->getContents();
  $response_content=json_decode($response_content,true);
  //var_dump($response_content);
  //echo "<br>response_content[success]: ";
  //var_dump($response_content["success"]);

  if($response_content["success"]==1 and $response->getStatusCode()==200){
    $sql = "INSERT INTO notificaciones (asunto, mensaje, fecha_hora, ejecutada) VALUES (?,?,NOW(),0)";
    $q = $pdo->prepare($sql);
    $q->execute(array($asunto,$mensaje));
    $id_notificacion = $pdo->lastInsertId();

    $sql = "INSERT INTO notificaciones_lecturas (id_notificacion, id_usuario, fecha_hora, enviada, leida) VALUES (?,?,NOW(),1,0)";
    $q = $pdo->prepare($sql);
    $q->execute(array($id_notificacion,$_SESSION["user"]["id"]));
    $afe=$q->rowCount();
    //echo "<br>Afe: ".$afe;
  }*/

  Database::disconnect();
  $pdo = null; // Libera la referencia en la variable local
}

//echo $jsonData["Ok"];
echo json_encode($jsonData);