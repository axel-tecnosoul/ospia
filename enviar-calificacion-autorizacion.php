<?php
include_once("admin/config.php");
include_once("admin/database.php");
include_once("admin/funciones.php");

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "INSERT INTO `calificaciones_autorizaciones`(`codigo_autorizacion`, `nivel_atencion_recibida`, `cobraron_copago`, `calificacion_prestador`) VALUES (?,?,?,?)";
$q = $pdo->prepare($sql);
$q->execute([$_POST["codAut"],$_POST["atencion"],$_POST["copago"],$_POST["prestador"]]);

$url=$url_ws."?Modo=27&Tipo=1&Autorizacion=".$_POST["codAut"];
$jsonData = json_decode(file_get_contents($url),true);

Database::disconnect();
header("Location: autorizaciones.php");
