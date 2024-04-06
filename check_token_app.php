<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: *");
}

/*$token = $_POST['fcmToken'];
$email = $_POST['email'];*/
//$_POST['fcmToken']="asdas";

if(!isset($_GET['fcmToken'])){
  $_GET['fcmToken']="1234";
  //$_GET['fcmToken']="d4wH8vKITHWExx2hWzFAYW:APA91bFGhWTe_M3zf5vvdWfF-iKZgT7_7VrWxunH5rXe5SW94GdGYsrCZeBNMIXV8z6MlSlEhZPakTQmJjODfgbT_A1_N4cPmdzFAuhLddjUrG0jaCvAVqR28NhWCm4QVl1A9jd9-_K_0";
  //$_GET['fcmToken']="d4wH8vKITHWExx2hWzFAYW:APA91bGblfY0kBDKy2DsfM5Af9IE19kBardVHaKpxXdsbHqYYXGh6KJ-KpXJjQVyWLUncEK8dsNjbDkCoTLFahvjs1rVlGk8mubCC9Z7bws9AgV_69fNRgNbMQPrYEqSf788foSwSsaT";
}

if(isset($_GET['fcmToken']) and strlen($_GET['fcmToken'])>0){

  $token=$_GET['fcmToken'];
  //echo $token;

  include_once("admin/config.php");
  include_once("admin/database.php");

  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "SELECT id,email,clave FROM usuarios WHERE token_app = ?";
  $q = $pdo->prepare($sql);
  $q->execute([$token]);
  $count = $q->rowCount();
  
  Database::disconnect();
  
  $email = "";
  $clave = "";
  //var_dump($count);
  //var_dump($token);
  if($count==1 and $token!="1234"){
    $user = $q->fetch();
    
    if(in_array($user["id"],[20,1])){
      $email = $user["email"];
      $clave = $user["clave"];
    }
  }

  if($count>0){
    //SI EXISTE EL TOKEN HACEMOS UN LOGIN NORMAL
    //echo 1;
    include_once("page-login.php");
  }else{
    //SI NO EXISTE DEBEMOS VERIFICAR SI POR MEDIO DE LA DIRECCION DE EMAIL SI EL USUARIO ESTÁ CARGADO
    //echo 0;
    include_once("main-login.php");//page-register.php
  }

  
}else{
  echo 0;
}

if(!isset($_GET['nueva_app']) or $_GET['nueva_app']!=1){
  //echo 1;?>
  <!-- Modal Temporal -->
  <div class="modal fade modalbox animate__animated animate__fadeInRight" id="ModalAvisoAppNueva" data-bs-backdrop="static" tabindex="-1" role="dialog" style="background-color: rgb(0 0 0 / 50%);">
    <div class="modal-dialog" role="document" style="top: 15%;left: 10%;width: 80%;min-width: 0;height: 70%;">
      <div class="modal-content" style="padding-top: 0">
        <!-- <div class="modal-header">
          Te tenemos buenas noticias!
        </div> -->
        <div class="modal-body text-center" style="height: auto;">
          <!-- <h3 class="modal-title" style="color:black"></h3> -->
          A partir de ahora, contamos<br>con una <strong>nueva versión</strong><br>de nuesta app <strong>ospiapba</strong>.<br>Innovamos en más tecnología<br>para el cuidado de tu salud y<br>mejor seguridad para tus datos.<br>Para tener la nueva versión:<br><a href="https://play.google.com/store/apps/details?id=org.ospiaprovincia.ospiapba" target="_blank">hacé click acá</a>
          <!-- <br>OSPIA PROVINCIA<br>Siempre pensando en vos -->
          <img src="assets/img/logo.png" alt="image" width="75%" style="margin-top: 10px;">
        </div>
        <div class="modal-footer mt-2">
          <button type="button" class="btn btn-primary btn-block btn-lg" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- * Modal Temporal --><?php
}?>

<script>
  window.onload=function(){
    //Push.Permission.request();
    $("#ModalAvisoAppNueva").modal("show")
  }
</script>