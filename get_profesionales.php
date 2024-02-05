<?php
include_once("admin/config.php");
include_once("admin/database.php");
include_once("admin/funciones.php");

$url=$url_ws."?Modo=16&Usuario=$usuario_ws&Policlinico=".$_POST["id_policlinico"]."&Especialidad=".$_POST["id_especialidad"];
//echo $url;
//$jsonData = json_decode(file_get_contents($url),true);
$jsonData = file_get_contents($url);
//var_dump($jsonData);
echo $jsonData;