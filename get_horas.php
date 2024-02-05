<?php
include_once("admin/config.php");
include_once("admin/database.php");
include_once("admin/funciones.php");

$url=$url_ws."?Modo=18&Usuario=$usuario_ws&EspecialidadMed=".$_POST["id_profesional"]."&Fecha=".$_POST["fecha"];
//echo $url;
//$jsonData = json_decode(file_get_contents($url),true);
$jsonData = file_get_contents($url);
//var_dump($jsonData);
echo $jsonData;