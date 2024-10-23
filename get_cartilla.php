<?php
include_once("admin/config.php");
include_once("admin/database.php");
include_once("admin/funciones.php");

/*$ficha=$_SESSION["user"]["ficha"];
$url=$url_ws."?Modo=6&Usuario=$usuario_ws&Ficha=$ficha";
//echo $url."<br>";
$jsonData = json_decode(file_get_contents($url),true);
$persona_id=$jsonData[0]["Data"][0]["Id"];*/
$persona_id=$_SESSION['persona_id'];
$dni=$_SESSION["user"]["dni"];

$url2=$url_ws."?Modo=10&Usuario=$usuario_ws&Persona=$persona_id&Documento=$dni";

$especialidad=$_POST["especialidad"];
if($especialidad!=0){
  $url2.="&Especialidad=$especialidad";
}
$servicios=$_POST["servicios"];
if($servicios!=0){
  $url2.="&TipoPrestador=$servicios";
}
$localidades=$_POST["localidades"];
if($localidades!=0){
  $url2.="&Localidad=$localidades";
}
//echo $url2;
//$jsonData = json_decode(file_get_contents($url2),true);
$jsonData = file_get_contents($url2);
//var_dump($jsonData);
echo $jsonData;