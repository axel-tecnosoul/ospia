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
  echo $token;

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
}?>
<script>
  window.onload=function(){
    //Push.Permission.request();
  }
</script>