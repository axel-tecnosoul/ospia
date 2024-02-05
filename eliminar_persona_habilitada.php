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

$sql = "DELETE FROM `personas_habilitadas` WHERE id = ? ";
$q = $pdo->prepare($sql);
$q->execute(array($_POST["id"]));

Database::disconnect();

echo 0;