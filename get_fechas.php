<?php
include_once("admin/config.php");
include_once("admin/database.php");
include_once("admin/funciones.php");

$url=$url_ws."?Modo=17&Usuario=$usuario_ws&EspecialidadMed=".$_POST["id_profesional"]."&Persona=".$_POST["id_afiliado"];
//echo $url;
//$jsonData = json_decode(file_get_contents($url),true);
$jsonData = file_get_contents($url);
//var_dump($jsonData);
echo $jsonData;