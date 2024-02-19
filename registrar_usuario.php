<?php
include_once("admin/config.php");
include_once("admin/database.php");
include_once("admin/funciones.php");

$dni=trim($_POST["dni"]);
$fecha_nacimiento=trim($_POST["fecha_nacimiento"]);
$fecha_nacimiento_ws=date("d/m/Y",strtotime($fecha_nacimiento));
$email=trim($_POST["email"]);
$token=trim($_POST["token"]);

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT id FROM usuarios WHERE email=?";
$q = $pdo->prepare($sql);
$q->execute([$email]);
$count = $q->rowCount();
if($count==0){
  $sql = "SELECT id,email FROM usuarios WHERE fecha_nacimiento=? AND dni=?";
  $q = $pdo->prepare($sql);
  $q->execute([$fecha_nacimiento,$dni]);
  $count = $q->rowCount();
  if($count==0){

    $url=$url_ws."?Modo=5&Usuario=$usuario_ws&FechaNacimiento=$fecha_nacimiento_ws&Documento=$dni&email='$email'";
    //echo $url;
    $jsonData = json_decode(file_get_contents($url),true);
    //var_dump($jsonData);
    $ok=0;
    if(isset($jsonData["Ok"]) and $jsonData["Ok"]=="true"){

      $nombre_apellido=$jsonData["Nombre"]." ".$jsonData["Apellido"];
      $clave=generarPasswordRandom();

      $pdo->beginTransaction();

      $sql = "INSERT INTO usuarios (nombre_apellido,fecha_nacimiento,dni,email,clave,ficha,persona_id,token_app,requiere_cambio_clave) VALUES (?,?,?,?,?,?,?,?,1)";
      $q = $pdo->prepare($sql);
      $q->execute([$nombre_apellido,$fecha_nacimiento,$dni,$email,$clave,$jsonData["Ficha"],$jsonData["Persona_Id"],$token]);
      $count = $q->rowCount();
      //var_dump($count);

      if($count==1){

        $destinatarios=[
          $email=> $nombre_apellido,
        ];
        $asunto="Bienvendio a la APP de OSPIA";
        $cuerpo="Hola ".$jsonData["Nombre"]."!
        
        Bienvenido a nuestra APP. “Si estás aquí sos parte de O.S.P.I.A. Provincia”

        Acá encontrarás tu credencial digital, la cartilla de prestadores y las últimas novedades.
        Podrás también solicitar turnos en consultorios propios, autorizaciones y reintegros.
        Tu clave temporal de ingreso es: $clave (podrás modificarla en el primer inicio)
        
        EMPECEMOS!";

        $envio=enviarMail($cuenta_envio="bbdd", $destinatarios, $asunto, $cuerpo);
        //var_dump($envio);
        if($envio){
          $ok=1;
          $pdo->commit();
        }else{
          $pdo->rollBack();
        }
      }
    }else{
      $ok=3;//usuario no encontrado
    }
  }else{
    $mail_encontrado=0;
    foreach($q->fetchAll(PDO::FETCH_ASSOC) as $data){
      //var_dump($data["email"]);
      if($email==$data["email"]){
        $mail_encontrado=1;
      }
    }
    if($mail_encontrado==1){
      $ok=2;//email encontrado
    }else{
      $ok=4;//email NO encontrado
    }
  }
} else {
  $ok=2;//email encontrado
}

Database::disconnect();

echo $ok;