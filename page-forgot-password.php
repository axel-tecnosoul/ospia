<?php
	require("admin/config.php"); 
	require 'admin/database.php';
	require 'admin/funciones.php';
	/*require("admin/PHPMailer/class.phpmailer.php");
	require("admin/PHPMailer/class.smtp.php");*/
	$mensaje="";
	if(!empty($_POST)){ 
		$claveRDM = random_int(100000, 999999);
		
		$pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "UPDATE `usuarios` set `clave` = ?, requiere_cambio_clave = 1 where email = ?";
    $q = $pdo->prepare($sql);
    $q->execute([$claveRDM,$_POST['email']]);
    $afe=$q->rowCount();
		
    if($afe==1){
      $asunto="Recupero de Cuenta";
      $cuerpo="Recibimos una solicitud para recuperar tu clave de acceso a la APP de OSPIA Provincia. Por favor accedé temporalmente con la siguiente contraseña y luego modificala: ".$claveRDM;
      $destinatarios=[$_POST['email']];
      /*$smtpHost = "";  //agregar
      $smtpUsuario = "";  //agregar
      $smtpClave = "";  //agregar
      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->SMTPAuth = true;
      $mail->Port = 465; 
      $mail->SMTPSecure = 'ssl';
      $mail->IsHTML(true); 
      $mail->CharSet = "utf-8";
      $mail->Host = $smtpHost; 
      $mail->Username = $smtpUsuario; 
      $mail->Password = $smtpClave;
      $mail->From = ""; //agregar
      $mail->FromName = "OSPIA APP";
      $mail->AddAddress($_POST['email']); 
      $mail->Subject = $asunto; 
      $mensajeHtml = nl2br($cuerpo);
      $mail->Body = "{$mensajeHtml} <br /><br />"; 
      $mail->AltBody = "{$cuerpo} \n\n"; 
        
      $mail->Send();*/

      $envio=enviarMail($cuenta_envio="bbdd", $destinatarios, $asunto, $cuerpo);
      //var_dump($envio);
      //$envio=false;
      if($envio){
        $mensaje="Ingrese a su casilla de correo y siga las indicaciones";
        //$pdo->commit();
      }else{
        //$pdo->rollBack();
        $mensaje="Ha fallado el envío del mail";
      }
    }else{
      $mensaje="No se ha encontrado la casilla de correo";
    }

    //header("Location: main-login.php"); 
    //die("Redirecting to: main-login.php"); 
  } 
?>
<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>OSPIA APP Olvidaste la contraseña</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 5, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="manifest" href="__manifest.json">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head><?php
if(isset($_GET["token"])){
  $token=$_GET["token"];
}?>

<body class="bg1">

    <!-- 
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader no-border transparent position-absolute">
        <div class="left animate__animated animate__fadeInRight">
            <a href="page-login.php?token=<?=$token?>" class="headerButton goBack">
              <ion-icon name="chevron-back-outline"></ion-icon>VOLVER
            </a>
        </div>
        <div class="pageTitle"></div>
        <div class="right animate__animated animate__fadeInRight">
            <a href="page-login.php?token=<?=$token?>" class="headerButton">Ingreso</a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="login-form animate__animated animate__fadeInRight">
            <div class="section">
                <h2>Olvidaste tu contraseña?</h2>
                <h4>Colocá tu E-mail para recuperar tu cuenta</h4>
            </div>
            <div class="section mt-2 mb-5">
                <form action="page-forgot-password.php?token=<?=$token?>" method="post">
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="email" class="form-control" name="email" placeholder="Email">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="button">
                        <button type="submit" class="btn btn-primary btn-block btn-lg bt4">Reiniciar</button>
                    </div>
                </form>
            </div><?php
            if($mensaje!=""){?>
              <div class="section">
                  <h3><?=$mensaje?></h3>
              </div><?php
            }?>
        </div>
    </div>
    <!-- * App Capsule -->
    <!-- ============== Js Files ==============  -->
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

</body>

</html>