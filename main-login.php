<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>OSPIA APP LOGIN</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
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
  <!-- loader -->
  <div id="loader">
      <div class="spinner-border text-primary" role="status"></div>
  </div>
  <!-- * loader -->
  <!-- App Capsule -->
  <div id="appCapsule" class="pt-0 animate__animated animate__zoomIn">
    <div class="login-form mt-1">
      <div class="section">
        <img src="assets/img/logo.png" alt="image" width="95%">
      </div>
      <div class="login-form2 mt-1">
        <div class="button">
          <a href="page-register.php?token=<?=$token?>&nueva_app=<?=$_GET['nueva_app']?>"><button type="submit" class="btn btn-primary btn-block btn-lg">CREAR CUENTA</button></a>
        </div>
        <div class="login-form3">
          <a class="page-login.php" href="page-login.php?token=<?=$token?>&nueva_app=<?=$_GET['nueva_app']?>">YA TENGO CUENTA</a>
        </div>
      </div>
    </div>
  </div>
  <!-- * App Capsule -->

  <!-- ///////////// Js Files ////////////////////  -->
  <!-- Jquery -->
  <script src="assets/js/lib/jquery-3.4.1.min.js"></script>
  <!-- Bootstrap-->
  <script src="assets/js/lib/popper.min.js"></script>
  <script src="assets/js/lib/bootstrap.min.js"></script>
  <!-- Ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.js"></script>
  <!-- Owl Carousel -->
  <script src="assets/js/plugins/owl-carousel/owl.carousel.min.js"></script>
  <!-- jQuery Circle Progress -->
  <script src="assets/js/plugins/jquery-circle-progress/circle-progress.min.js"></script>
  <!-- Base Js File -->
  <script src="assets/js/base.js"></script>
</body>
</html>