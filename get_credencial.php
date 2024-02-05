<?php
include_once("admin/config.php");
include_once("admin/database.php");
include_once("admin/funciones.php");

/*$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);*/

//$id_persona=$_POST["id_persona"];
$id_persona=101146;
//$id_persona=2;
$url=$url_ws."?Modo=7&Usuario=$usuario_ws&Persona=$id_persona";
//$jsonData = json_decode(file_get_contents($url),true);
$jsonData = file_get_contents($url);
//var_dump($jsonData);
echo $jsonData;
//echo '{ "Ok":"true", "Apellido": "BIEDULA", "Nombre": "JAVIER ANDRES", "Caracter": "Titular", "Documento": "26274432", "Coseguro": "Sin Coseguros", "Plan": "A"}';