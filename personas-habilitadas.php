<?php
include_once("admin/config.php");
if(!isset($_SESSION["user"]["ficha"])){
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
  <title>OSPIA APP Beneficiario</title>
  <meta name="description" content="Mobilekit HTML Mobile UI Kit">
  <meta name="keywords" content="bootstrap 5, mobile template, cordova, phonegap, mobile, html" />
  <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="manifest" href="__manifest.json">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <style>
    .datos_credencial{
      position: absolute;
      font-size: 26px;
      font-weight: bold;
      font-variant: all-petite-caps;
    }
    #foto{
      width: 115px;
      height: 115px;
      top: 10px;
      left: 30px;
    }
    #nombre_apellido{
      top: 123px;
      left: 39px;
    }
    #caracter{
      top: 149px;
      left: 152px;
    }
    #plan{
      top: 175px;
      left: 102px;
    }
    #beneficiario{
      top: 200px;
      left: 185px;
    }
    #coseguro{
      top: 229px;
      left: 160px;
    }
	 .float{
		position: fixed;
		width: 60px;
		height: 60px;
		bottom: 70px;
		right: 20px;
		/*background-color: #25d366;*/
		color: #FFF;
		border-radius: 50px;
		text-align: center;
		font-size: 50px;
		/*box-shadow: 2px 2px 3px #999;*/
		z-index: 100;
	  }

	  .float :hover{
		border-radius: 50px;
		border: solid 2px #0bd71c;
	  }
  </style>
</head>

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
  <div id="appCapsule" class="pt-0">
    <ul class="listview image-listview text animate__animated animate__fadeInRight">
      <li>
        <div class="in item">
          <div><strong>Personas Habilitadas</strong></div>
        </div>
      </li>
    </ul>
    <br><?php
    
    $id=$_SESSION["user"]["id"];
    $ficha=$_SESSION["user"]["ficha"];?>

    <span class="float btn-primary" data-bs-toggle="modal" data-bs-target="#ModalNuevaPersona">
      <ion-icon name="add-outline" style="vertical-align: -webkit-baseline-middle;"></ion-icon>
    </span>
    
    <div class="section full mt-2 mb-2 animate__animated animate__fadeInRight">
      <div class="sectiontitle2">
        <ion-icon class="iconedbox iconedbox-lg" name="people-circle"></ion-icon>PERSONAS HABILITADAS de <?=$_SESSION['user']['nombre_apellido']?>
      </div>
    </div><?php

    include 'admin/database.php';
    $pdo = Database::connect();
    $sql = " SELECT `id`, `nombre_completo`, `dni`, `email`, `celular`, `clave` FROM `personas_habilitadas` WHERE `id_usuario` = ".$_SESSION['user']['id'];
                            
    foreach ($pdo->query($sql) as $row) {?>
      <div class="listview link-listview search-result animate__animated animate__fadeInRight">
        <div class="wide-block1 pt-2 pb-2" style="text-align: center;">
          <button type="button" class="btn btn-secondary persona" data-id="<?=$row["id"]?>" data-bs-toggle="modal" data-bs-target="#ModalVerPersona_<?=$row["id"]?>"><?=$row["nombre_completo"]?></button>
        </div>
      </div>
  
      <div class="modal fade modalbox animate__animated animate__fadeInRight" id="ModalVerPersona_<?=$row["id"]?>" data-bs-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title">Datos de Persona Habilitada</h3>
            </div>
            <div class="modal-body">
              <div class="login-form">
                <div class="section mt-2">

                </div>
                <div class="section mt-4 mb-5">
                  <form name="formVer" method="post">
                    <div class="form-group basic">
                      <label class="form-label d-block">Nombre Completo</label>
                      <input type="text" class="form-control" name="nombre_completo_ver" readonly="readonly" value="<?=$row["nombre_completo"]?>" />
                    </div>
                    <div class="form-group basic">
                      <label class="form-label d-block">DNI</label>
                      <input type="text" class="form-control" name="dni_ver" readonly="readonly" value="<?=$row["dni"]?>" />
                    </div>
                    <div class="form-group basic">
                      <label class="form-label d-block">E-Mail</label>
                      <input type="email" class="form-control" name="email_ver" readonly="readonly" value="<?=$row["email"]?>" />
                    </div>
                    <div class="form-group basic">
                      <label class="form-label d-block">Celular</label>
                      <input type="text" class="form-control" name="celular_ver" readonly="readonly" value="<?=$row["celular"]?>" />
                    </div>
                    <div class="form-group basic">
                      <label class="form-label d-block">Clave</label>
                      <input type="text" class="form-control" name="clave_ver" readonly="readonly" value="<?=$row["clave"]?>" />
                    </div>
                    <div class="mt-2">
                      <button type="button" onclick="eliminar_persona_habilitada(<?=$row["id"]?>)" id="eliminar_<?=$row["id"]?>" class="btn btn-danger btn-block btn-lg">Eliminar</button>
                      <button type="button" class="btn btn-primary btn-block btn-lg" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                    <input type="hidden" name="id_ver" value="<?=$row["id"]?>">
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><?php 
    }?>

    <div class="modal fade modalbox animate__animated animate__fadeInRight" id="ModalNuevaPersona" data-bs-backdrop="static" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Nueva Persona Habilitada</h3>
          </div>
          <div class="modal-body">
            <div class="login-form">
              <div class="section mt-2">
              
              </div>
              <div class="section mt-4 mb-5">
                <form name="form" method="post">
                  <div class="form-group basic">
                    <label class="form-label d-block">Nombre Completo</label>
                    <input type="text" class="form-control" name="nombre_completo" id="nombre_completo" required="required" />
                  </div>
                  <div class="form-group basic">
                    <label class="form-label d-block">DNI</label>
                    <input type="text" class="form-control" name="dni" id="dni" required="required" />
                  </div>
                  <div class="form-group basic">
                    <label class="form-label d-block">E-Mail</label>
                    <input type="email" class="form-control" name="email" id="email" required="required" />
                  </div>
                  <div class="form-group basic">
                    <label class="form-label d-block">Celular</label>
                    <input type="text" class="form-control" name="celular" id="celular" required="required" />
                  </div>
                  <div class="mt-2">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Crear</button>
                    <button type="button" class="btn btn-primary btn-block btn-lg" data-bs-dismiss="modal">Cerrar</button>
                  </div>
                  <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION['user']['id']; ?>">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade modalbox " id="ModalConfirmNuevaPersona" data-bs-backdrop="static" tabindex="-1" role="dialog" style="background-color: rgb(0 0 0 / 50%);">
      <div class="modal-dialog" role="document" style="top: 25%;left: 10%;width: 80%;min-width: 0;max-height: 30%;">
        <div class="modal-content" style="padding-top: 0;height: min-content;">
          <!-- <div class="modal-header">
            
          </div> -->
          <div class="modal-body" style="height: min-content;">
            <h3 class="modal-title" style="color:black">La persona fue habilitada correctamente</h3>
          </div>
          <div class="modal-footer">
            <!-- <button type="button" class="btn btn-primary btn-block btn-lg">OK</button> -->
            <a href="personas-habilitadas.php" type="button" class="btn btn-primary btn-block btn-lg">OK</a>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade modalbox " id="ModalConfirmEliminarPersona" data-bs-backdrop="static" tabindex="-1" role="dialog" style="background-color: rgb(0 0 0 / 50%);">
      <div class="modal-dialog" role="document" style="top: 25%;left: 10%;width: 80%;min-width: 0;max-height: 30%;">
        <div class="modal-content" style="padding-top: 0;height: min-content;">
          <!-- <div class="modal-header">
            
          </div> -->
          <div class="modal-body" style="height: min-content;">
            <h3 class="modal-title" style="color:black">La persona habilitada fue eliminada correctamente</h3>
          </div>
          <div class="modal-footer">
            <!-- <button type="button" class="btn btn-primary btn-block btn-lg">OK</button> -->
            <a href="personas-habilitadas.php" type="button" class="btn btn-primary btn-block btn-lg">OK</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include_once("footer.php")?>
      
  <script src="assets/js/lib/jquery-3.4.1.min.js"></script>
  <script src="assets/js/lib/bootstrap.min.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="assets/js/plugins/splide/splide.min.js"></script>
  <script src="assets/js/plugins/progressbar-js/progressbar.min.js"></script>
  <script>
    'use strict';

    function logText(message, isError) {
      if (isError)
        console.error(message);
      else
        console.log(message);

      const p = document.createElement('p');
      if (isError)
        p.setAttribute('class', 'error');
      p.appendChild(document.createTextNode(message));
    }

    function logError(message) {
      logText(message, true);
    }
	  
	  function eliminar_persona_habilitada(id) {
		  $.post("eliminar_persona_habilitada.php",{id:id},function(data){
        console.log(data);
        data=JSON.parse(data);
        console.log(data);
        $("#ModalConfirmEliminarPersona").modal("show")
		  });
	  }
	  
	  $("form").on("submit",function(e){
      e.preventDefault();
	    let id_usuario=$("#id_usuario").val();
      let nombre_completo=$("#nombre_completo").val();
      let dni=$("#dni").val();
      let email=$("#email").val();
      let celular=$("#celular").val();
      $.post("get_persona_habilitada.php",{id_usuario:id_usuario,nombre_completo:nombre_completo,dni:dni,email:email,celular:celular}, function(data){
        console.log(data);
        data=JSON.parse(data);
        console.log(data);
        $("#ModalConfirmNuevaPersona").modal("show")
      });
    });
  </script>
</body>
</html>