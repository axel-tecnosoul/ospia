<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: *");
}

include_once("admin/config.php");
include_once("admin/database.php");
include_once("admin/funciones.php");
require "vendor/autoload.php";

use sngrl\PhpFirebaseCloudMessaging\Client;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Device;
use sngrl\PhpFirebaseCloudMessaging\Notification;

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$claveRDM = random_int(100000, 999999);

$sql = "INSERT INTO `personas_habilitadas`(`id_usuario`, `nombre_completo`, `dni`, `email`, `celular`, `clave`) VALUES (?,?,?,?,?,?);";
$q = $pdo->prepare($sql);
$q->execute(array($_POST["id_usuario"],$_POST["nombre_completo"],$_POST["dni"],$_POST["email"],$_POST["celular"],$claveRDM));

Database::disconnect();

$asunto="OSPIA PBA - Nueva Persona Habilitada";
$cuerpo="Ha sido habilitado/a para ingresar a la APP de OSPIA Provincia. Por favor accedé con la siguiente contraseña: ".$claveRDM;
$destinatarios=[$_POST['email']];
$envio=enviarMail($cuenta_envio="bbdd", $destinatarios, $asunto, $cuerpo);

echo 0;