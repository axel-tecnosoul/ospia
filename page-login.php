<?php 
require_once("admin/config.php"); 
require_once 'admin/database.php';
if(isset($_GET["fcmToken"])){
  $token=$_GET["fcmToken"];
}
if(isset($_GET["token"])){
  $token=$_GET["token"];
}
if(isset($_POST["token"])){
  $token=$_POST["token"];
}

if(!isset($token)){
  //var_dump($token);
  header("Location: check_token_app.php");
}

if(!isset($token)){
  header("Location: check_token_app.php");
}
//echo $token;
$error = 0;
$submitted_username = ''; 
if(!empty($_POST)){ 
  //var_dump($_POST);
  
  $query = "SELECT id, nombre_apellido, fecha_nacimiento, dni, imagen, domicilio, id_provincia, email, celular, clave, cuit, alias, cbu, notif_push, notif_whatsapp, notif_email, ficha, persona_id, token_app, requiere_cambio_clave FROM usuarios WHERE email = :user";
  $query_params = array(':user' => trim($_POST['user'])); 
  
  try{
    $stmt = $db->prepare($query); 
    $result = $stmt->execute($query_params); 
  } catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
  
  $login_ok = false; 
  $row = $stmt->fetch();
  if($row){
    
    $check_pass = trim($_POST['pass']); 
    if($check_pass === $row['clave']){
      $login_ok = true;

      /*$pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "UPDATE usuarios set persona_id = ? where id = ?";
      $q = $pdo->prepare($sql);
      $q->execute([$jsonData["Persona_Id"],$row['id']]);
      
      Database::disconnect();*/
    }

    if(!$row['persona_id']){

      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $dni=trim($row["dni"]);
      $fecha_nacimiento=date("d/m/Y",strtotime(trim($row["fecha_nacimiento"])));
      $email=trim($row["email"]);

      $url=$url_ws."?Modo=5&Usuario=$usuario_ws&FechaNacimiento=$fecha_nacimiento&Documento=$dni&email='$email'";
      $jsonData = json_decode(file_get_contents($url),true);
      
      $sql = "UPDATE usuarios set persona_id = ? where id = ?";
      $q = $pdo->prepare($sql);
      $q->execute([$jsonData["Persona_Id"],$row['id']]);

      $row["persona_id"]=$jsonData["Persona_Id"];

      Database::disconnect();
    }

    if(!$row['token_app'] or $row['token_app']!=$_POST['token']){

      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      $sql = "UPDATE usuarios set token_app = ? where id = ?";
      $q = $pdo->prepare($sql);
      $q->execute([$_POST['token'],$row['id']]);

      $count = $q->rowCount();

      if($count==1){
        //echo $count." con token actualizado correctamente";
        $row['token_app']=$_POST['token'];
      }

      Database::disconnect();
    }

  }
  //var_dump($row);
  //die();
  if($login_ok){ 
    unset($row['clave']); 
    $_SESSION['user'] = $row;
	  $_SESSION['titular'] = 1;
    header("Location: index.php"); 
    die("Redirecting to: index.php"); 
  }else{
    $query2 = "SELECT ph.id id, ph.id_usuario, ph.nombre_completo, ph.dni, ph.email, ph.celular, ph.clave, u.id, u.nombre_apellido, u.fecha_nacimiento, u.imagen, u.domicilio, u.id_provincia, u.cuit, u.alias, u.cbu, u.cbte_cbu, u.notif_push, u.notif_whatsapp, u.notif_email, u.ficha, u.persona_id, u.token_app, u.requiere_cambio_clave, u.fecha_hora_alta FROM personas_habilitadas ph inner join usuarios u on u.id = ph.id_usuario WHERE ph.email = :user"; 
    $query_params2 = array(':user' => $_POST['user']); 
    
    try{ 
      $stmt2 = $db->prepare($query2); 
      $result2 = $stmt2->execute($query_params2); 
    } 
    catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
    $login_ok = false; 
    $row2 = $stmt2->fetch();
    if($row2){ 
      $check_pass2 = $_POST['pass']; 
      if($check_pass2 === $row2['clave']){
        $login_ok = true;
      } 
    }
    if($login_ok){ 
      unset($row2['clave']); 
      $_SESSION['user'] = $row2;  
      $_SESSION['titular'] = 0;
      header("Location: index.php"); 
      die("Redirecting to: index.php"); 
    }
    $error = 1;
    $submitted_username = htmlentities(trim($_POST['user']), ENT_QUOTES, 'UTF-8'); 
  }
}?>
<!doctype html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="theme-color" content="#000000">
  <title>OSPIA APP LOGIN</title>
  <meta name="description" content="Mobilekit HTML Mobile UI Kit">
  <meta name="keywords" content="bootstrap 5, mobile template, cordova, phonegap, mobile, html" />
  <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="manifest" href="__manifest.json">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head><?php

if(isset($_GET["fcmToken"])){
  $token=$_GET["fcmToken"];
}
if(isset($_POST["fcmToken"])){
  $token=$_POST["fcmToken"];
}
if(!isset($email)) $email="";
if(!isset($clave)) $clave="";?>
<body class="bg1">
  <!-- loader -->
  <!--<div id="loader">
      <div class="spinner-border text-primary" role="status"></div>
  </div>-->

  <!-- App Capsule -->
  <div id="appCapsule" class="pt-0">
    <h2>test</h2>
    <div class="login-form mt-1">
      <div class="section animate__animated animate__zoomIn">
        <img src="assets/img/logo.png" alt="image" width="95%" id="logo">
      </div>
      <div class="section mt-1 animate__animated animate__fadeInRight">
        <h1>Acceso</h1>
      </div>
      <div class="section mt-1 mb-5 animate__animated animate__fadeInRight">
        <form action="page-login.php" method="post" id="myForm">

          <input type="hidden" name="token" value="<?=$token?>">

          <div class="form-group boxed">
            <div class="input-wrapper">
              <input type="email" class="form-control" name="user" id="email1" placeholder="Email" value="<?=$email?>">
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i>
            </div>
          </div>

          <div class="form-group boxed">
            <div class="input-wrapper">
              <input type="password" class="form-control" name="pass" id="password1" placeholder="Clave" autocomplete="off" value="<?=$clave?>">
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i>
            </div>
          </div>

          <div class="form-links mt-2">
            <div>
              <a href="page-register.php?token=<?=$token?>">Registrate ahora</a>
            </div>
            <div><a href="page-forgot-password.php?token=<?=$token?>" class="text-muted">Olvidaste tu E-mail y/o contraseña?</a></div>
          </div>

          <div class="button">
            <button type="submit" class="btn btn-primary btn-block btn-lg bt4">Ingresar</button>
          </div>

        </form><?php
            
        if ($error == 1) { ?>
          <div class="section mt-1">
            <h4>E-mail y/o contraseña inválida</h4>
          </div><?php 
        }?>
      </div>
    </div>

  </div>
  <!-- * App Capsule -->

  <?php
  //var_dump($email);
  //var_dump($clave);
  if($email!="" and $clave!=""){?>
    <script>
      //console.log(document.getElementById("myForm"));
      document.getElementById("myForm").submit();
    </script><?php
  }
  ?>

  <!-- Modal Temporal -->
  <div class="modal fade modalbox animate__animated animate__fadeInRight" id="ModalAvisoTemporal" data-bs-backdrop="static" tabindex="-1" role="dialog" style="background-color: rgb(0 0 0 / 50%);">
    <div class="modal-dialog" role="document" style="top: 25%;left: 10%;width: 80%;min-width: 0;height: 30%;">
      <div class="modal-content" style="padding-top: 0;">
        <!-- <div class="modal-header">
          
        </div> -->
        <div class="modal-body" style="height: auto;">
          <h3 class="modal-title" style="color:black">Ahora disponible en Salto. Próximamente en tú localidad!!</h3>
        </div>
        <div class="modal-footer mt-2">
          <button type="button" class="btn btn-primary btn-block btn-lg" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- * Modal Temporal -->

  <!-- ============== Js Files ==============  -->
  <!-- jQuery Js File -->
  <script src="assets/js/lib/jquery-3.4.1.min.js"></script>
  <!-- Bootstrap -->
  <script src="assets/js/lib/bootstrap.min.js"></script>
  <!-- Ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <!-- Splide -->
  <script src="assets/js/plugins/splide/splide.min.js"></script>
  <!-- ProgressBar js -->
  <script src="assets/js/plugins/progressbar-js/progressbar.min.js"></script>
  <!-- Base Js File -->
  <script src="assets/js/base.js"></script>

  <script>
    $(document).ready(function () {
      //$("#ModalAvisoTemporal").modal("show")
	var counter=0;
      $("#logo").on("click",function(){
        counter++;
        if(counter==5){
          //alert("<?=$token?>")
          alert('<?=json_encode($_GET)?>')
          counter=0;
        }
      })
	
    });
  </script>

</body>

</html>