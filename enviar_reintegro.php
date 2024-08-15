<?php
include_once("admin/config.php");
include_once("admin/database.php");
include_once("admin/funciones.php");

/*var_dump($_POST);
var_dump($_FILES);*/

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tipoReintegro = "";
if ($_POST["id_tipo_reintegro"]==11) {
	$tipoReintegro = "CONSULTAS MÉDICAS";
} else if ($_POST["id_tipo_reintegro"]==7) {
	$tipoReintegro = "LABORATORIO";
} else if ($_POST["id_tipo_reintegro"]==6) {
	$tipoReintegro = "ÓPTICA";
} else if ($_POST["id_tipo_reintegro"]==12) {
	$tipoReintegro = "PRÁCTICAS MÉDICAS";
} else if ($_POST["id_tipo_reintegro"]==4) {
	$tipoReintegro = "PRESTACIONES ODONTOLÓGICAS";
}

$pdo->beginTransaction();

$ok=0;

$sql = "INSERT INTO reintegros (id_afiliado,id_tipo_reintegro,id_usuario) VALUES (?,?,?)";
$q = $pdo->prepare($sql);
$q->execute([$_POST["id_afiliado"],$_POST["id_tipo_reintegro"],$_SESSION["user"]["id"]]);
$afe=$q->rowCount();

if($afe==1){

  $id_reintegro = $pdo->lastInsertId();
  $cantArchivos=0;
  $cantArchivosSubidos=0;
  $aAdjuntosMail=[];

  foreach ($_FILES as $key => $value) {
    //var_dump($value);
    if (is_uploaded_file($value['tmp_name'])) {
      $cantArchivos++;
      $nombre_imagen=$value['name'];
      //INGRESO ARCHIVOS EN EL DIRECTORIO
      $directorio = "img/reintegros/$id_reintegro/";
      //$path = "sample/path/newfolder";

      if (!file_exists($directorio)) {
          mkdir($directorio, 0777, true);
      }

      $subidaOK=move_uploaded_file($value['tmp_name'], $directorio.$nombre_imagen);
      //$ruta_completa_imagen = $directorio.$nombreFinalArchivo;
      //var_dump($subidaOK);
      
      if($subidaOK){
        //INSERTO DATOS EN LA TABLA ADJUNTOS ORDEN_COMPRA
        $sql = "INSERT INTO reintegros_imagenes (id_reintegro,imagen) VALUES (?,?)";
        $q = $pdo->prepare($sql);
        $q->execute([$id_reintegro,$nombre_imagen]);
        $afe=$q->rowCount();

        if($afe==1){
          $cantArchivosSubidos++;

          $aAdjuntosMail[]=[
            "ruta"      =>$directorio."/".$nombre_imagen,
            "fileName"  =>$nombre_imagen,
          ];
        }
      }else{
        if($value['error']){
          return "Ha ocurrido un error: Cod. ".$value['error'];
        }
      }
    }
  }
}
if($cantArchivos==$cantArchivosSubidos){
  $remitente="Reintegros OSPIA PBA";

  if($_SESSION["user"]["email"]=="axelbritzius@gmail.com"){
    $destinatarios=[
      "axelbritzius@gmail.com"=> $remitente,
    ];
  }else{
    $destinatarios=[
      "reintegros@ospiaprovincia.org"=> $remitente,
    ];
  }
  
  //$destinatarios=["nelson.murstein@gmail.com"=> $remitente,];
  $asunto="Reintegros OSPIA";
  $email="";
  if(isset($_SESSION["user"]["email"])){
    $email=$_SESSION["user"]["email"];
  }
  $texto_email="Lamentablemente no contamos con su direccion de email";
  if($email!="" and !empty($email)){
    $texto_email="Su dirección de email para responder es: $email";
  }

  $cuerpo="Hola ".$remitente."!
  
  El afiliado ".$_POST["nombre_afiliado"]." (DNI ".$_SESSION["user"]["dni"].") ha solicitado un reintegro de ".$tipoReintegro." por medio de la app.
  
  $texto_email

  Adjunto la documentación requerida.
  
  GRACIAS!";

  $envio=enviarMail($cuenta_envio="reintegros", $destinatarios, $asunto, $cuerpo, $aAdjuntosMail);
  //$envio=0;
  //var_dump($envio);
  if($envio){
    $ok=1;

    $asunto="Reintegros OSPIA";
    $mensaje="Un reintegro ha sido enviado con éxito";

    if($_SESSION["user"]["notif_push"]){
      $fecha_hora=date("Y-m-d H:i",strtotime(date("Y-m-d H:i")."+2 minute"));
      //$fecha_hora=date("Y-m-d H:i",strtotime(date("Y-m-d H:i")));

      $sql = "INSERT INTO notificaciones (asunto, mensaje, fecha_hora, ejecutada) VALUES (?,?,'$fecha_hora',0)";
      $q = $pdo->prepare($sql);
      $q->execute(array($asunto,$mensaje));
      $id_notificacion = $pdo->lastInsertId();

      $sql = "INSERT INTO notificaciones_lecturas (id_notificacion, id_usuario, fecha_hora, enviada, leida) VALUES (?,?,'$fecha_hora',0,0)";
      $q = $pdo->prepare($sql);
      $q->execute(array($id_notificacion,$_SESSION["user"]["id"]));
      $afe=$q->rowCount();
      //echo "<br>Afe: ".$afe;
    }
    
    $pdo->commit();
  }else{
    $pdo->rollBack();
  }
}

Database::disconnect();

echo $ok;