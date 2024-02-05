<?php
include_once("admin/config.php");
include_once("admin/database.php");
include_once("admin/funciones.php");

$prestador_id=$_POST["prestador_id"];
$url=$url_ws."?Modo=11&Usuario=$usuario_ws&Prestador=$prestador_id";
//echo $url;
//$jsonData = json_decode(file_get_contents($url),true);
$jsonData = file_get_contents($url);
//var_dump($jsonData);
echo $jsonData;