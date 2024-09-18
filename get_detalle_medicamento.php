<?php
include_once("admin/config.php");
/*include_once("admin/database.php");
include_once("admin/funciones.php");*/

$MedicamentoId=$_POST["medicamento_id"];

//http://www.ospiapba.org.ar/app_desarrollo/APP_ReqRes.asp?Modo=30&MedicamentoId=486
$url=$url_ws."?Modo=30&MedicamentoId=$MedicamentoId";
//echo $url."<br>";
$jsonData = file_get_contents($url);
//var_dump($jsonData);
echo $jsonData;