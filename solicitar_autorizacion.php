<?php
include_once("admin/config.php");
include_once("admin/database.php");
include_once("admin/funciones.php");

/*var_dump($_POST);
var_dump($_FILES);*/
$autorizacion="";
if(isset($_GET["autorizacion"])){
  $autorizacion=$_GET["autorizacion"];
}
$url=$url_ws."?Modo=28&Autorizacion=".$autorizacion;

echo $url;
//$jsonData = json_decode(file_get_contents($url),true);
$jsonData = file_get_contents($url);
$jsonData = json_decode($jsonData,true);
//var_dump($jsonData);
$ok=0;
if($jsonData["Ok"]=="true"){
  $ok=1;
}
echo $ok;