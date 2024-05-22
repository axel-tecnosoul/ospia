<?php
include_once("admin/config.php");
require 'admin/database.php';

//var_dump($_SESSION);

if(!isset($_SESSION['user']["token_app"])){// or $_SESSION['user']["token_app"]==""
  //header("Location: page-login.php");
  if(isset($_SESSION['nueva_app']) and in_array($_SESSION['nueva_app'],[0,1])){
    $nueva_app=$_SESSION['nueva_app'];
  }else{
    $nueva_app=1;
  }
  header("Location: check_token_app.php?nueva_app=".$nueva_app);
  //die("Morimos aca");
}
//die("O morimos aca");
if (isset($_SESSION['user']['requiere_cambio_clave']) and $_SESSION['user']['requiere_cambio_clave'] == 1) {
	header("Location: primer-cambio.php");
}?>
<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>OSPIA APP</title>
    <meta name="description" content="ospia">
    <meta name="keywords" content="" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="manifest" href="__manifest.json">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
</head>

<body class="bg1">

     <!-- App Header -->
   
    <!-- * App Header -->

 
    <!-- App Capsule -->
    <div id="appCapsule" class="pt-0"><?php
    //var_dump($_SESSION["titular"])?>

        <div class="login-form mt-1">
            <div class="section animate__animated animate__zoomIn">
                <img src="assets/img/logo.png" alt="image" width="95%" id="logo">
            </div>
            <br>
            <div class="login-form">
                <div class="section">
                    <h3 class="animate__animated animate__zoomIn">¿Qué servicio buscas hoy?</h3>
                </div>
            </div>
			<a class="a1boton" href="credencial.php">
				<button type="button" class="btn btn-secondary1 btn-lg me-1 mb-1 animate__animated animate__backInRight">
					<ion-icon name="card-outline"></ion-icon>
					MI CREDENCIAL
				</button>
			</a>
			<a class="a1boton" href="turnos.php">
				<button type="button" class="btn btn-secondary1 btn-lg me-1 mb-1 animate__animated animate__backInRight">
					<ion-icon name="calendar-outline"></ion-icon>
					TURNOS
				</button>
			</a>
			<a class="a1boton" href="cartilla.php">
				<button type="button" class="btn btn-secondary1 btn-lg me-1 mb-1 animate__animated animate__backInRight">
					<ion-icon name="search-circle-outline"></ion-icon>
					CARTILLA MEDICA
				</button>
			</a>
			
			 <a class="a1boton" href="autorizaciones.php">
				  <button type="button" class="btn btn-secondary1 btn-lg me-1 mb-1 animate__animated animate__backInRight">
					  <ion-icon name="newspaper-outline"></ion-icon>
					  AUTORIZACIONES
				  </button>
			 </a>
			
			
			<?php
      if ($_SESSION['user']['id'] == 1 or $_SESSION['user']['id'] == 20){?>
       
        
        <a class="a1boton" href="#">
          <button type="button" class="btn btn-secondary1 btn-lg me-1 mb-1 animate__animated animate__backInRight">
            <ion-icon name="disc-outline"></ion-icon>
              PROGRAMAS MEDICOS
          </button>
        </a>
        <a class="a1boton" href="#">
          <button type="button" class="btn btn-secondary1 btn-lg me-1 mb-1 animate__animated animate__backInRight">
            <ion-icon name="people-circle-outline"></ion-icon>
            NUESTROS PROFESIONALES
          </button>
        </a><?php
        if($_SESSION["titular"]==1){?>
          <a class="a1boton" href="#">
            <button type="button" class="btn btn-secondary1 btn-lg me-1 mb-1 animate__animated animate__backInRight">
              <ion-icon name="people-outline"></ion-icon>
              MIS APORTES
            </button>
          </a><?php
        }
      }?>
            <!-- 
			<button type="button" class="btn btn-secondary1 btn-lg me-1 mb-1 animate__animated animate__backInRight">
                  <ion-icon name="newspaper-outline"></ion-icon>
                  <a class="a1boton" href="autorizaciones.php">AUTORIZACIONES</a>
            </button>
			 -->
			<a class="a1boton" href="reintegros.php">
				<button type="button" class="btn btn-secondary1 btn-lg me-1 mb-1 animate__animated animate__backInRight">
					  <ion-icon name="cash-outline"></ion-icon>
					  REINTEGROS
				</button>
			</a><?php
      if($_SESSION["titular"]==1){?>
        <a class="a1boton" href="personas-habilitadas.php">
          <button type="button" class="btn btn-secondary1 btn-lg me-1 mb-1 animate__animated animate__backInRight">
            <ion-icon name="person-outline"></ion-icon>
            PERSONAS HABILITADAS
          </button>
        </a><?php
      }?>
			  <!-- 
              <button type="button" class="btn btn-secondary1 btn-lg me-1 mb-1 animate__animated animate__backInRight">
                  <ion-icon name="disc-outline"></ion-icon>
                  <a class="a1boton" href="#">PROGRAMAS MEDICOS</a>
              </button>
			  <button type="button" class="btn btn-secondary1 btn-lg me-1 mb-1 animate__animated animate__backInRight">
                  <ion-icon name="people-circle-outline"></ion-icon>
                  <a class="a1boton" href="#">NUESTROS PROFESIONALES</a>
              </button>
			  <button type="button" class="btn btn-secondary1 btn-lg me-1 mb-1 animate__animated animate__backInRight">
                  <ion-icon name="people-outline"></ion-icon>
                  <a class="a1boton" href="#">MIS APORTES</a>
              </button>
			  -->
			  <?php
            $pdo = Database::connect();
            $sql = " SELECT COUNT(l.id) AS cant_notificaciones FROM notificaciones_lecturas l inner join notificaciones n on n.id = l.id_notificacion WHERE l.enviada=1 AND l.leida=0 AND l.id_usuario = ".$_SESSION['user']['id'];
            $stmt = $db->prepare($sql);
            $result = $stmt->execute();
            $row = $stmt->fetch();
            $class="";
            if ($row["cant_notificaciones"]>0){
              $class="text-danger";
            }
            Database::disconnect();?>
			<a class="a1boton" href="notificaciones.php">
				<button type="button" class="btn btn-secondary1 btn-lg me-1 mb-1 animate__animated animate__backInRight">
					<ion-icon name="notifications-circle-outline" class="<?=$class?>"></ion-icon>
					PANEL DE NOTIFICACIONES
				</button>
            </a>
            
    <!-- * App Capsule -->

    <!-- App Bottom Menu --><?php
    include_once("footer.php")?>
    <!-- * App Bottom Menu -->

    <!-- ============== Js Files ==============  -->
    <!-- Bootstrap -->
    <script src="assets/js/lib/bootstrap.min.js"></script>
    <!-- jQuery Js File -->
    <script src="assets/js/lib/jquery-3.4.1.min.js"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Splide -->
    <script src="assets/js/plugins/splide/splide.min.js"></script>
    <!-- ProgressBar js -->
    <script src="assets/js/plugins/progressbar-js/progressbar.min.js"></script>
    <!-- Base Js File -->
    <script src="assets/js/base2.js"></script>

    <script>
      $(document).ready(function () {
        var counter=0;
        $("#logo").on("click",function(){
          counter++;
          if(counter==5){
            alert("<?=$_SESSION['user']["token_app"]?>")
            counter=0;
          }
        })
      });
    </script>

</body>

</html>