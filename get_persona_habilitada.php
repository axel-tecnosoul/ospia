<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: *");
}

include_once("admin/config.php");
include_once("admin/database.php");
include_once("admin/funciones.php");

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$ok=1;
//$claveRDM = random_int(100000, 999999);
$claveRDM=generarPasswordRandom();

$email=$_POST['email'];

$sql = "SELECT id FROM usuarios WHERE email=?";
$q = $pdo->prepare($sql);
$q->execute([$email]);
$count = $q->rowCount();
if($count==0){

  $sql2 = "SELECT id FROM personas_habilitadas WHERE email=?";
  $q2 = $pdo->prepare($sql2);
  $q2->execute([$email]);
  $count2 = $q2->rowCount();
  if($count2==0){

    $sql = "INSERT INTO personas_habilitadas (id_usuario, nombre_completo, dni, email, celular, clave) VALUES (?,?,?,?,?,?)";
    $q = $pdo->prepare($sql);
    $q->execute(array($_POST["id_usuario"],$_POST["nombre_completo"],$_POST["dni"],$email,$_POST["celular"],$claveRDM));

    $asunto="OSPIA PBA - Nueva Persona Habilitada";
    $cuerpo="Ha sido habilitado/a para ingresar a la APP de OSPIA Provincia. Por favor accedé con la siguiente contraseña: ".$claveRDM;
    $destinatarios=[$email];
    $envio=enviarMail($cuenta_envio="bbdd", $destinatarios, $asunto, $cuerpo);

    $ok=0;
  }
}

Database::disconnect();
$pdo = null; // Libera la referencia en la variable local

echo $ok;