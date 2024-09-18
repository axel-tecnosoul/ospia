<?php
include_once("admin/config.php");
include_once("admin/database.php");
include_once("admin/funciones.php");

$ficha=$_SESSION["user"]["ficha"];

$plan_valida=$_SESSION['plan_valida'];
$persona_id=$_SESSION['persona_id'];

//http://www.ospiapba.org.ar/app_desarrollo/APP_ReqRes.asp?Modo=29&Persona=121600&PlanValida=1&Medicamento=&Droga=
$url=$url_ws."?Modo=29&Usuario=$usuario_ws&Persona=$persona_id&PlanValida=$plan_valida";
//echo $url."<br>";

$nombre=$_POST["nombre"];
if($nombre!=""){
  $url.="&Medicamento=".filter_var($nombre, FILTER_SANITIZE_STRING);
}
$droga=$_POST["droga"];
if($droga!=""){
  $url.="&Droga=".filter_var($droga, FILTER_SANITIZE_STRING);
}
//echo $url;
//$jsonData = json_decode(file_get_contents($url),true);
$jsonData = file_get_contents($url);
//var_dump($jsonData);
echo $jsonData;