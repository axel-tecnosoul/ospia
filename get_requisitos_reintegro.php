<?php
include_once("admin/config.php");
include_once("admin/database.php");
include_once("admin/funciones.php");

$url=$url_ws."?Modo=26&Usuario=$usuario_ws&TipoReintegro=$_POST[id_tipo_reintegro]";
//echo $url;
//$jsonData = json_decode(file_get_contents($url),true);
$jsonData = file_get_contents($url);
//var_dump($jsonData);
echo $jsonData;