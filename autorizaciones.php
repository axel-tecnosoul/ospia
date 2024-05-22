<?php
include_once("admin/config.php");
require 'admin/database.php';
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
    <title>OSPIA APP</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 5, mobile template, cordova, phonegap, mobile, html" />
    <!-- <link rel="stylesheet" type="text/css" href="admin/assets/css/mapsjs-ui.css"> -->
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="admin/assets/css/responsive.css">
    <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="manifest" href="__manifest.json">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<style>
  html, body, #map {
    height: 100%;
    margin: 0;
    padding: 0;
  }

  #circular-menu{
    -webkit-transform: inherit;
    transform: inherit;
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
  <!-- * App Header -->

  <!-- App Capsule -->

  <span class="float btn-primary" data-bs-toggle="modal" data-bs-target="#ModalNuevaAutorizacion">
    <!-- <i class="fa fa-whatsapp my-float"></i> -->
    <ion-icon name="add-outline" style="vertical-align: -webkit-baseline-middle;"></ion-icon>
  </span>

  <div class="section full" style="height: calc( 100% - 56px - 16px - 13px);">
    <h2 class="text-center">Autorizaciones</h2>
    <div class="row" style="height: calc( 100% - 16px - 9px);overflow: scroll;">
      <div class="col-12">
        <ul id="cartilla" class="listview link-listview search-result animate__animated animate__fadeInRight" style="border-radius: 10px;">
		<?php
          $id=$_SESSION["user"]["id"];
          $ficha=$_SESSION["user"]["ficha"];
          $persona=$_SESSION["user"]["persona_id"];

          //$url=$url_ws."?Modo=20&Usuario=$usuario_ws&Ficha=$ficha";
          $url=$url_ws."?Modo=22&Persona=$persona";
          //echo $url;
          $jsonData = json_decode(file_get_contents($url),true);
          //var_dump($jsonData);
          if($jsonData["Ok"]!="false"){
            $autorizaciones=$jsonData["Autorizaciones"];
            //var_dump($autorizaciones[0]);
            foreach ($autorizaciones as $autorizacion) {
              //var_dump($autorizacion);
              $ejecutada="";
              if(isset($autorizacion["Ejecutada"])){
                $ejecutada=$autorizacion["Ejecutada"];
              }
              ?>
              <div class="row border border-2 <?=$autorizacion["cClassEstado"]?> rounded m-2 p-1">
                <div class="col-12"><?php
                  if ($autorizacion["SolicitaAutorizacion"]!=0 && $ejecutada=="") {?>
                    <h3 class="mb-05 titulo1 text-center"><?=$autorizacion["Fecha"]?></h3>
                    <h3 class="mt-05 titulo1"><strong>Estado: <?=$autorizacion["Estado"]?></strong><?php
                    if ($autorizacion["Respuesta"]==12 && $ejecutada=="") {?>
                      <strong class="text-success"> - Cod.Aut. <?=$autorizacion["Autorizacion"]?></strong></h3><?php
                    }
                  }else{?>
                    <h3 class="mb-05 titulo1 text-center"><?=$autorizacion["Fecha"]?></h3>
                    <h3 class="mt-05 titulo1"><strong>Estado: <?=$autorizacion["Estado"]?></strong></h3><?php
                  }?>
                  <div class="text-muted">
                    <span onclick="">
                      <?=$autorizacion["Prestador"]."<br>".$autorizacion["CodPractica"]." - ".$autorizacion["Practica"]?>
                    </span><?php
                    if ($autorizacion["SolicitaAutorizacion"]!=0 && $autorizacion["Respuesta"]==12 && $ejecutada=="") {?>
                       <h3 class="mb-05 mt-1 text-center text-danger">Concurrir al prestador <br />con el c&oacute;digo enviado.</h3><?php
                    }
                    if ($autorizacion["SolicitaAutorizacion"]==0 && $ejecutada=="" && $ejecutada=="" && $autorizacion["Respuesta"]=="") {?>
                      <div class="mt-05" style="text-align: center;">
                        <span class='btn btn-sm btn-primary border mb-05 btnSolicitarAutorizacion' data-autorizacion='<?=$autorizacion["Autorizacion"]?>'>Solicitar Autorizacion</span>
                      </div><?php
                    }
                    /*
                    $pdo = Database::connect();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);			
                    $sql = "SELECT `id` FROM `calificaciones_autorizaciones` WHERE `codigo_autorizacion` = ?";
                    $q = $pdo->prepare($sql);
                    $q->execute([$autorizacion["Autorizacion"]]);
                    $count = $q->rowCount();
                    if($count==0){
                    */
                    if ($autorizacion["Respuesta"]==12 && $ejecutada!="" && isset($autorizacion["Encuesta"]) and $autorizacion["Encuesta"]=="Falso") {?>
						          <!--<div class="mt-05"><a href="calificar-autorizacion.php?codAut=<?php echo $autorizacion["Autorizacion"]; ?>">Calificar Atenci&oacute;n Recibida</a></div>--><?php
                    }?>
                    <!--<div class="mt-05"><a target="_blank" href="https://www.ospiapba.org.ar/AU_SugerenciasReclamos.asp?codAut=<?php echo $autorizacion["Autorizacion"]; ?>">Reclamos o Sugerencias</a></div>-->
                  </div>
                </div>
                <!-- <div class="col-2" style="text-align: center;align-self: center;">
                  <div class="delete_autorizacion bg-danger" data-autorizacion="<?=$autorizacion["Autorizacion"]?>" style="margin-top:0;max-width: 40px;padding-top: 5px;padding-bottom: 5px;"><ion-icon name="trash"></ion-icon></div>
                </div> -->
              </div><?php
            }
          }else{?>
            <div class="row border border-2 border-secondary rounded m-2 p-1">
              <div class="col-12">
                <h3 class="mb-05 mt-05 titulo1">Sin autorizaciones</h3>
              </div>
            </div><?php
          }?>
        </ul>
      </div>
    </div>
  </div>
  <!-- * App Capsule -->
    
  <!-- Modal Form -->
  <div class="modal fade modalbox animate__animated animate__fadeInRight" id="ModalNuevaAutorizacion" data-bs-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Nueva autorización</h3>
        </div>
        <div class="modal-body">
          <div class="login-form border rounded">
            <div class="section mt-2">
                  
            </div>
            <div class="section mt-4 mb-3">
              <form name="form" id="fileupload" method="post" enctype="multipart/form-data">
                <div class="form-group basic">
                  <label class="form-label" for="id_afiliado">Afiliado</label>
                  <select name="id_afiliado" id="id_afiliado" class="form-control col-sm-12" required="required">
                    <option value="">Seleccione...</option><?php
                    $url=$url_ws."?Modo=6&Usuario=$usuario_ws&Ficha=$ficha";
                    //echo $url;
                    $jsonData = json_decode(file_get_contents($url),true);
                    $grupo_fliar=$jsonData[0]["Data"];
                    foreach ($grupo_fliar as $persona) {?>
                      <option value='<?=$persona['Id']?>'><?=$persona['Apellido']." ".$persona['Nombre']?></option><?php
                    }?>
                  </select>
                </div>
                <div class="form-group basic">
                  <label class="form-label" for="id_delegacion">Delegacion</label>
                  <select name="id_delegacion" id="id_delegacion" class="form-control col-sm-12" required="required">
                    <option value="">Seleccione...</option><?php
                    $url=$url_ws."?Modo=23&Usuario=$usuario_ws";
                    //echo $url;
                    $jsonData = json_decode(file_get_contents($url),true);
                    $delegaciones=$jsonData["Data"];
                    foreach ($delegaciones as $delegacion) {?>
                      <option value='<?=$delegacion['Id']?>' data-mail='<?=$delegacion['Mail']?>'><?=$delegacion['Policlinico']?></option><?php
                    }?>
                  </select>
                </div>
                <div class="form-group basic">
                  <label class="form-label" for="">Fotos de la orden</label>
                  <br>
                  <!-- <input type="file" name="imagen" multiple/> -->
                  <div style="text-align: center;">
                    <span class="btn bg-primary" id="fileinput-button">
                      <ion-icon name="add-outline"></ion-icon>
                      <span>Agregar</span>
                    </span>
                  </div>
                  <div id="container" class="container"></div>
                  <!-- <table role="presentation" class="table table-striped" id="fileTable">
                    <tbody class="files"></tbody>
                  </table> -->
                </div>
                <div class="mt-2">
                  <button type="submit" class="btn btn-primary btn-block btn">Enviar</button>
                  <button type="button" class="btn btn-danger btn-block btn" data-bs-dismiss="modal">Cerrar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- * Modal Form -->

  <!-- Modal para avisar que falta cargar los archivos -->
  <div class="modal fade modalbox " id="DialogFaltaFoto" data-bs-backdrop="static" tabindex="-1" role="dialog" style="background-color: rgb(0 0 0 / 50%);">
    <div class="modal-dialog" role="document" style="top: 25%;left: 10%;width: 80%;min-width: 0;max-height: 30%;">
      <div class="modal-content" style="padding-top: 0;height: min-content;">
        <div class="modal-body" style="height: min-content;">
          <h3 class="modal-title" style="color:black">Debe subir la foto de la orden.</h3>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-primary btn-block btn-lg">OK</button> -->
          <a href="#" class="btn btn-primary" data-bs-dismiss="modal">OK</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal para avisar que falta cargar los archivos -->

  <!-- Modal Confirmar nueva autorizacion -->
  <div class="modal fade modalbox " id="ModalConfirmNuevaAutorizacion" data-bs-backdrop="static" tabindex="-1" role="dialog" style="background-color: rgb(0 0 0 / 50%);">
    <div class="modal-dialog" role="document" style="top: 25%;left: 10%;width: 80%;min-width: 0;max-height: 30%;">
      <div class="modal-content" style="padding-top: 0;height: min-content;">
        <!-- <div class="modal-header">
          
        </div> -->
        <div class="modal-body" style="height: min-content;">
          <h3 class="modal-title" style="color:black">La autorización ha sido enviada correctamente. Usted recibirá un email cuando se haya ingresado en el sistema</h3>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-primary btn-block btn-lg">OK</button> -->
          <a href="autorizaciones.php" type="button" class="btn btn-primary btn-block btn-lg">OK</a>
        </div>
      </div>
    </div>
  </div>
  <!-- * Modal Confirmar nueva autorizacion -->

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
  <!-- <script src="assets/js/base.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    $(document).ready(function() {

      //$("form").on("submit",function(e){
      $("form#fileupload").submit(function(e) {
        e.preventDefault();
        console.log("Se cargará la autorizacion")
        /*console.log(this);
        var formData = new FormData(this);

        var formElement = document.getElementById("fileupload");
        var formData = new FormData(formElement);
        console.log(formElement);
        console.log(formData);
        $.post("enviar_autorizacion.php", formData, function(data) {
            console.log(data);
        });*/
        let select_afiliado=$("#id_afiliado");
        let id_afiliado=select_afiliado.val();
        let selected_afiliado=select_afiliado.find("option[value='"+id_afiliado+"']");
        let nombre_afiliado=selected_afiliado[0].innerText;

        let select_delegacion=$("#id_delegacion");
        let id_delegacion=select_delegacion.val();
        let selected_delegacion=select_delegacion.find("option[value='"+id_delegacion+"']");
        let nombre_delegacion=selected_delegacion[0].innerText;
        let mail_delegacion=selected_delegacion[0].dataset.mail;

        let datosEnviar = new FormData();
        datosEnviar.append("id_afiliado", id_afiliado);
        datosEnviar.append("nombre_afiliado", nombre_afiliado);
        datosEnviar.append("id_delegacion", id_delegacion);
        datosEnviar.append("nombre_delegacion", nombre_delegacion);
        datosEnviar.append("mail_delegacion", mail_delegacion);

        let i=0;
        $("input[name='files[]']").each(function(){
          let file=$(this).prop('files')[0];
          datosEnviar.append('file'+i, file);
          i++;
        });

        if(i==0){
          //console.log("agregar archivo");
          $("#DialogFaltaFoto").modal("show")
          return false;
        }
        
        $.ajax({
          data: datosEnviar,
          url: "enviar_autorizacion.php",
          method: "post",
          cache: false,
          contentType: false,
          processData: false,
          success: function(data) {
            console.log(data);
            /*$("#btnGuardar").removeClass("disabled")
            $("#spinner_guardar").toggleClass("d-none");*/
            if(data=="1"){
              //document.location.href=document.location.href;
              $("#ModalConfirmNuevaAutorizacion").modal("show")
            }
            /*else{
              swal("Ha ocurrido un error!");
            }*/
          }
        });

      });

      $("#fileinput-button").on("click",function(){

        if(this.nextElementSibling!=null){
          this.nextElementSibling.remove();
        }

        const inputFile = document.createElement("input")
        inputFile.type="file"
        inputFile.name="files[]"
        inputFile.style="display:none";
        inputFile.capture="";
        inputFile.accept="image/*, application/pdf";
        inputFile.required=true;
        inputFile.addEventListener("change",function(e){
          readFile(e.srcElement)
        },false)

        //pongo el input file temporalmente al lado del boton Agregar
        this.parentElement.appendChild(inputFile);

        $(inputFile).click()

      })

      $(document).on("click",".clear_file",function(){
        this.parentElement.parentElement.remove()
      });

      $(".btnSolicitarAutorizacion").on("click",function(){
        let autorizacion=this.dataset.autorizacion;

        $.ajax({
          url: "solicitar_autorizacion.php?autorizacion="+autorizacion,
          method: "post",
          cache: false,
          contentType: false,
          processData: false,
          success: function(data) {
            //console.log(data);
            //alert("done")
            //if(data=="1"){
              document.location.href=document.location.href;
              //$("#ModalConfirmNuevaAutorizacion").modal("show")
            //}
            
          }
        });
      })

    });

    function readFile(input) {
      //$("#clear_file").css("d-none");
      //$("#clear_file").css("display","block");
      if (input.files && input.files[0]) {

        const inputFile=document.getElementById("fileinput-button").nextElementSibling

        const fila = document.createElement("div")
        fila.classList="row border mt-1"
        fila.style="align-items: center";
        
        const celda1=document.createElement("div")
        celda1.classList="col-9"
        const celda2=document.createElement("div")
        celda2.classList="col-3"
        celda2.style="align-self: center;"
        //celda2.style="vertical-align:middle"

        const div=document.createElement("div")
        div.classList="bg-danger clear_file"
        //div.style="margin-top:0"
        div.style="border-radius: 5px; margin-top: 15px;"
        const icon=document.createElement("ion-icon")
        icon.name="trash"
        div.appendChild(icon)

        const tabla=document.getElementById("container");
        celda2.appendChild(inputFile)
        celda2.appendChild(div)
        fila.appendChild(celda1)
        fila.appendChild(celda2)
        tabla.appendChild(fila)

        //var fileInput = document.getElementById('file-input');
        var file = input.files[0];
        console.log(file);
        var fileName = file.name;
        var fileNameLabel = document.createElement('label');
        fileNameLabel.innerHTML=fileName
        console.log(fileName);

        if(file.type!="application/pdf"){
          var reader = new FileReader();
          reader.onload = function (e) {

            var filePreview = document.createElement('img');
            filePreview.id = 'file-preview';
            filePreview.width = 150;
            //e.target.result contiene los datos base64 de la imagen cargada
            filePreview.src = e.target.result;
            filePreview.alt = file;
            celda1.appendChild(filePreview)
            celda1.appendChild(fileNameLabel)

            //e.target.result contents the base64 data from the image uploaded
            /*filePreview.src = e.target.result;
            celda1.appendChild(filePreview)*/
          }

          reader.readAsDataURL(input.files[0]);
          
        }else{
          div.style.marginBottom="15px"
          celda1.appendChild(fileNameLabel)
        }

      }
    }

  </script>
</body>
</html>