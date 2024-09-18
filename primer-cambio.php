<?php 
require("admin/config.php"); 
require 'admin/database.php';
if(!isset($_SESSION["user"])){
  header("Location: page-login.php");
}
$submitted_username = ''; 
if(!empty($_POST)){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $tabla="usuarios";
  $id=$_SESSION['user']['id'];
  if($_SESSION['titular']==0){
    $tabla="personas_habilitadas";
    $id=$_SESSION['user']['id_persona_habilitada'];
  }
  $sql = "UPDATE $tabla set clave = ?, requiere_cambio_clave = 0 where id = ?";
  $q = $pdo->prepare($sql);
  $q->execute([$_POST['clave1'],$id]);
  $_SESSION['user']['requiere_cambio_clave'] = 0;
  Database::disconnect();
  header("Location: index.php"); 
  die("Redirecting to: index.php"); 
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
</head>

<body class="bg1">
  <!-- 
  <div id="loader">
      <div class="spinner-border text-primary" role="status"></div>
  </div> -->
  <!-- * loader -->
  <!-- App Capsule -->
  <div id="appCapsule" class="pt-0">
    <div class="login-form mt-1">
      <div class="section animate__animated animate__zoomIn">
        <img src="assets/img/logo.png" alt="image" width="95%">
      </div>
			<br>
      <div class="section mt-1 animate__animated animate__fadeInRight">
        <h3>Por favor, modificá tu contraseña</h3>
      </div>
      <div class="section mt-1 mb-5 animate__animated animate__fadeInRight">
        <form action="primer-cambio.php" method="post">
          <div class="form-group boxed">
            <div class="input-wrapper">
              <input type="password" class="form-control" name="clave1" id="password" placeholder="Contraseña">
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i>
            </div>
          </div>
          <div class="form-group boxed">
            <div class="input-wrapper">
              <input type="password" class="form-control" name="clave2" id="confirm_password" placeholder="Repetir Contraseña" autocomplete="off">
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i>
            </div>
          </div>
          <div class="button">
            <button type="submit" class="btn btn-primary btn-block btn-lg bt4">Modificar</button>
          </div>
        </form>
      </div>
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
	<script>
	var password = document.getElementById("password")
	  , confirm_password = document.getElementById("confirm_password");

	function validatePassword(){
	  if(password.value != confirm_password.value) {
		confirm_password.setCustomValidity("Las claves no coinciden");
	  } else {
		confirm_password.setCustomValidity('');
	  }
	}

	password.onchange = validatePassword;
	confirm_password.onkeyup = validatePassword;
	</script>
</body>
</html>