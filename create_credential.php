<?php
include_once("admin/config.php");
include_once("admin/database.php");
include_once("admin/funciones.php");

$id_persona=$_POST["id_persona"];
$es_titular=$_POST["es_titular"];

/*$id_persona=101146;
$es_titular=false;*/

//$id_persona=2;
$url=$url_ws."?Modo=7&Usuario=$usuario_ws&Persona=$id_persona";
//var_dump($url);
$jsonData = json_decode(file_get_contents($url),true);
/*$resp=file_get_contents($url);
$jsonData = json_decode($resp,true);*/
//var_dump($jsonData);

$resp="no hay jsonData";
if($jsonData){

  //var_dump($jsonData);
  //echo $jsonData;

  //$es_titular llega como un string
  $imagen="";
  if($es_titular=="true" and $_SESSION["user"]["imagen"]!=""){
    $imagen='admin/usuarios/'.$_SESSION["user"]["imagen"];
  }

  $resp=[
    "apellido"    =>$jsonData["Apellido"],
    "nombre"      =>$jsonData["Nombre"],
    "foto_perfil" =>$imagen,
    //"nombre_apellido" =>$apellido.", ".$nombre,
    "caracter"    =>$jsonData["Caracter"],
    "plan"        =>$jsonData["Plan"],
    "dni"         =>$jsonData["Documento"],
    "coseguro"    =>$jsonData["Coseguro"],
    "token"       =>$jsonData["Token"],
  ];
  //$token="a28e8f33";

  /*$apellido="BELETZKI";
  $nombre="JORGE RICARDO ROBERTO";
  $nombre_apellido=$apellido.", ".$nombre;
  $caracter="Titular";
  $plan="A";
  $beneficiario="28833213";*/
  //$coseguro="Coseguro";

  echo json_encode([
    "json_ok"=>1,
    "resp"=>$resp
  ]);
}else{
  echo json_encode([
    "json_ok"=>0,
    "resp"=>$resp
  ]);
}
?>