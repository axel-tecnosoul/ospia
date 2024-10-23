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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <style>
    .disabled{
      opacity: .65 !important;
    }
  </style>
</head>

<body class="bg1">
  <!-- App Header -->
  <!-- * App Header -->

  <!-- App Capsule -->
  <div id="appCapsule" class="pt-0"><?php
    //var_dump($_SESSION);
    //var_dump($_SESSION["titular"])
    
    //$plan="";
    $plan_valida="";
    if(isset($_SESSION["plan"])){
      //$plan="Plan ".$_SESSION["plan"];
      //$plan="Plan B";
      $plan_valida=$_SESSION["plan_valida"];
      //$plan_valida=2;
    }
    //var_dump($plan);

if ($_SESSION['user']['id']==20){
      //var_dump($_SESSION);
    }

    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = " SELECT COUNT(l.id) AS cant_notificaciones FROM notificaciones_lecturas l inner join notificaciones n on n.id = l.id_notificacion WHERE n.mostrar_en_app=1 AND l.enviada=1 AND l.leida=0 AND l.id_usuario = ".$_SESSION['user']['id'];
    $stmt = $db->prepare($sql);
    $result = $stmt->execute();
    $row = $stmt->fetch();
    $class_notificaciones="";
    if ($row["cant_notificaciones"]>0){
      $class_notificaciones="text-danger";
    }

    $aDesarrolladores=[1,20];
    $agregarBotonesEnDesarrollo=0;
    if (in_array($_SESSION['user']['id'],$aDesarrolladores)){
      $agregarBotonesEnDesarrollo=1;
    }

    $mostrarBotonesEnDesarrollo="";
    if($agregarBotonesEnDesarrollo==1){
      $mostrarBotonesEnDesarrollo="OR b.activo=0";
    }

    $query = "SELECT b.boton,b.href,b.ion_icon,b.solo_titular,bp.visible,bp.habilitado,bp.msj_mostrar,b.activo FROM botones b LEFT JOIN botones_x_plan bp ON bp.id_boton=b.id LEFT JOIN planes p ON bp.id_plan=p.id WHERE (bp.visible = 1 AND p.id = :plan_valida) $mostrarBotonesEnDesarrollo ORDER BY b.activo DESC, b.orden_aparicion ASC";
    $query_params = array(':plan_valida' => trim($plan_valida));
    try{
      $stmt = $db->prepare($query); 
      $result = $stmt->execute($query_params); 
    } catch(
      PDOException $ex){ die("Failed to run query: " . $ex->getMessage());
    }

    Database::disconnect();?>

    <div class="login-form mt-1">
      <div class="section animate__animated animate__zoomIn">
        <img src="assets/img/logo.png" alt="image" width="95%" id="logo">
      </div>
      <br>
      <div class="login-form">
        <div class="section">
          <h3 class="animate__animated animate__zoomIn">¿Qué servicio buscas hoy?</h3>
        </div>
      </div><?php
      $b=1;
      while($row=$stmt->fetch()){
        $boton=$row['boton'];
        if($row["solo_titular"]==1 && $_SESSION["titular"]==0){
          continue;
        }

        $href=$row['href'];

        $class=$class_icon="";
        if($row['habilitado']==="0"){//realizamos un chequeo estricto para que no tome NULL como si fuera igual a 0
          $class="disabled";
          $href="#";
        }
        
        if($boton=="Notifiaciones"){
          $class_icon=$class_notificaciones;
        }
        
        if($row["activo"]==0){
          $class="";
          if($b==1){
            $b=0;?>
            <h3 class="animate__animated animate__zoomIn">EN DESARROLLO</h3><?php
          }
        }?>
        <a class="a1boton <?=$class?>" href="<?=$href?>" data-msj="<?=$row['msj_mostrar']?>">
          <button  type="button" class="btn btn-secondary1 btn-lg me-1 mb-1 animate__animated animate__backInRight">
            <ion-icon name="<?=$row['ion_icon']?>" class="<?=$class_icon?>"></ion-icon>
            <?=strtoupper($boton)?>
          </button>
        </a><?php
      }

      /*if ($_SESSION['user']['id'] == 1 or $_SESSION['user']['id'] == 20){?>
        <h3 class="animate__animated animate__zoomIn">EN DESARROLLO</h3>
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
      }*/?>

    </div>

  </div>

  <div class="modal fade modalbox " id="funcionDeshabilitada" data-bs-backdrop="static" tabindex="-1" role="dialog" style="background-color: rgb(0 0 0 / 50%);">
    <div class="modal-dialog" role="document" style="top: 25%;left: 10%;width: 80%;min-width: 0;max-height: 30%;">
      <div class="modal-content" style="padding-top: 0;height: min-content;">
        <!-- <div class="modal-header">
          
        </div> -->
        <div class="modal-body" style="height: min-content;">
          <h3 class="modal-title" style="color:black">Únicamente plan A.</h3>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-primary btn-block btn-lg">OK</button> -->
          <a href="#" type="button" data-bs-dismiss="modal" class="btn btn-primary btn-block btn-lg">OK</a>
        </div>
      </div>
    </div>
  </div>

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

      $(document).on("click","#btnReintegros",function(){
        console.log(this.href);
        if(this.href==window.location.href+"#"){
          $("#funcionDeshabilitada").modal("show")
        }
      })

      $(document).on("click",".a1boton",function(){
        console.log(this.href);
        console.log(this.dataset.msj);
        if(this.href==window.location.href+"#"){
          let modal=$("#funcionDeshabilitada");
          modal.find(".modal-title").text(this.dataset.msj)
          modal.modal("show")
        }
      })
    });
  </script>
</body>
</html>