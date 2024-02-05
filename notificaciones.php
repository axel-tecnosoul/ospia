<?php
require("admin/config.php");
require 'admin/database.php';
if(!isset($_SESSION["user"])){
  header("Location: page-login.php");
}?>
<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>OSPIA APP Notificaciones</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 5, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="manifest" href="__manifest.json">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<style>
  .image-listview > li a.item:after{
    background-image: none;
  }
  .item :hover{
    cursor: pointer;
  }
</style>
<body class="bg1">
    <!-- App Header -->
    <div class="appHeader no-border transparent position-absolute">
    <div class="left animate__animated animate__fadeInRight">
      <a href="index.php" class="headerButton goBack">
        <ion-icon name="chevron-back-outline"></ion-icon>VOLVER
      </a>
    </div>
    <div class="pageTitle"></div>
  </div>
  <br>
  <br>
  <!-- * App Header -->

  <!-- App Capsule -->
  <div id="appCapsule" class="pt-0">
    <ul class="listview image-listview text animate__animated animate__fadeInRight">
      <li>
        <div class="in item">
          <div>Notificaciones</div>
        </div>
      </li>
    </ul>
    <br>
    <ul class="listview image-listview animate__animated animate__fadeInRight"><?php
      //var_dump($_SESSION);
    
      $pdo = Database::connect();
      $sql = " SELECT l.id, l.id_notificacion, date_format(l.fecha_hora,'%d/%m/%Y %H:%i') AS fecha_hora, l.leida,n.asunto,n.mensaje FROM notificaciones_lecturas l inner join notificaciones n on n.id = l.id_notificacion WHERE enviada = 1 AND l.id_usuario = ".$_SESSION['user']['id']." order by l.id desc";
      foreach ($pdo->query($sql) as $row) {
        $color="success";
        $link="#";
        $id=$row["id"];
        $leida=$row["leida"];
        if ($row["leida"] == 0){
          $color="danger";
          $link="marcarNotificacionLeida.php?id=".$row["id"];
        }?>
        <!-- <li>
          <a href="<?=$link?>" class="item">
            <ion-icon color="<?=$color?>" class="iconedbox" name="checkmark-circle-outline"></ion-icon>
            <div class="in">
              <div class="separador">
                <header><?php echo $row["fecha_hora"]; ?>hs</header>
                <?php echo $row["mensaje"]; ?>
                <footer><?php echo $row["asunto"]; ?></footer>
              </div>
            </div>
          </a>
        </li> -->
        <li>
          <div class="item" data-id="<?=$id?>" data-leida="<?=$leida?>">
            <ion-icon color="<?=$color?>" class="iconedbox" name="checkmark-circle-outline"></ion-icon>
            <div class="in">
              <div class="separador">
                <header><?php echo $row["fecha_hora"]; ?>hs</header>
                <?php echo $row["mensaje"]; ?>
                <footer><?php echo $row["asunto"]; ?></footer>
              </div>
            </div>
          </div>
        </li>
        <?php
      }
      Database::disconnect();?>
    </ul>
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
  <script src="assets/js/base.js"></script>

  <script>
    $(document).ready(function () {
      $(".item").on("click",function(){
        if(this.dataset.leida==0){
          window.location.href="marcarNotificacionLeida.php?id="+this.dataset.id;
        }
      })
    });
  </script>

</body>

</html>