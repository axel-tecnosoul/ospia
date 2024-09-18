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

  .float2{
    text-align: center;
	  position: fixed;
    width: 160px;
    height: 100px;
    bottom: 100px;
	  margin-left: auto;
    margin-right: auto;
    /*right: 220px;*/
    /*background-color: #25d366;*/
    color: #FFF;
    border-radius: 10px;
    font-size: 60px;
    /*box-shadow: 2px 2px 3px #999;*/
    z-index: 100;
  }

  .detalle{
    font-size: 10px;
    font-style: italic;
  }

  .requisito{
    text-decoration: underline;
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
    <div class="pageTitle">

    </div>
  </div>
  <br>
  <br>
  <!-- * App Header -->

  <!-- App Capsule -->
  <!-- <div id="appCapsule" class="pt-0"> -->
    <!-- <ul class="listview image-listview text animate__animated animate__fadeInRight">
      <li>
        <div class="in item">
          <strong>Reintegros</strong>
        </div>
      </li>
    </ul>
    <br> -->
    <?php

    if (!empty($_SESSION['user']['cuit']) and !empty($_SESSION['user']['cbu'])) {?>
      <span class="float btn-primary" id="btnAddNew" data-bs-toggle="modal" data-bs-target="#ModalNuevaAutorizacion">
        <!-- <i class="fa fa-whatsapp my-float"></i> -->
        <ion-icon name="add-outline" style="vertical-align: -webkit-baseline-middle;"></ion-icon>
      </span><?php
    }else{?>
      <span class="float2 w-auto" data-bs-toggle="modal">
        <h2><span class="badge bg-danger p-1 fs-5 h-auto" style="white-space: normal;">Para ingresar un reintegro debe cargar el cuit y cbu en Datos Personales</span></h2>
      </span><?php
    }?>

    <div class="section full" style="height: calc( 100% - 56px - 16px - 13px);">
      <h2 class="text-center">Reintegros</h2>
      <div class="row" style="height: calc( 100% - 16px - 9px);overflow: scroll;">
        <div class="col-12">
          <ul id="cartilla" class="listview link-listview search-result animate__animated animate__fadeInRight" style="border-radius: 10px;"><?php
            $id=$_SESSION["user"]["id"];
            //$imagen=$_SESSION["user"]["imagen"];
            $ficha=$_SESSION["user"]["ficha"];
            $persona=$_SESSION["user"]["persona_id"];

            //$url=$url_ws."?Modo=20&Usuario=$usuario_ws&Ficha=$ficha";
            $url=$url_ws."?Modo=24&Persona=$persona";
            //echo $url;
            $jsonData = json_decode(file_get_contents($url),true);

            if($jsonData["Ok"]!="false"){
              $reintegros=$jsonData["Reintegros"];
              //var_dump($reintegros[0]);
              foreach ($reintegros as $reintegro) {
                $ImporteReclamado=number_format(str_replace(",",".",$reintegro["ImporteReclamado"]),2);
                //$ImporteReclamado=$reintegro["ImporteReclamado"];
                $ImporteAprobado=number_format(str_replace(",",".",$reintegro["ImporteAprobado"]),2);
                //$ImporteAprobado=$reintegro["ImporteAprobado"];
                ?>
                <div class="row border m-2">
                  <div class="col-12">
                    <h3 class="mb-05 titulo1">Reintegro Nro. <?=$reintegro["Reintegro"]?> - <?=$reintegro["Fecha"]?></h3>
                    <div class="text-muted">
                      <span onclick="">
                        Nombre: <?=$reintegro["Nombre"]?>
                      </span>
                      <!-- <span onclick="">
                        <?php //echo $reintegro["TipoReintegro"]."<br>Reclamado: $".$ImporteReclamado."<br>Aprobado: $".$ImporteAprobado?>
                      </span> -->
                      <!-- <div class="mt-05"><strong>Tipo: <?php //echo $TipoTurno?> </strong></div> -->
                      <div class="mt-05"><strong>Estado: <?=$reintegro["Estado"]?> </strong></div>
                      <!-- <span class="mt-05 btn btn-sm btn-link border prestadores" data-id="Prestador_Id">Ver especialidades</span> -->
                    </div>
                  </div>
                  <!-- <div class="col-2" style="text-align: center;align-self: center;">
                    <div class="delete_reintegro bg-danger" data-reintegro="<?=$reintegro["Autorizacion"]?>" style="margin-top:0;max-width: 40px;padding-top: 5px;padding-bottom: 5px;"><ion-icon name="trash"></ion-icon></div>
                  </div> -->
                </div><?php
              }
            }else{?>
              <div class="row border border-2 border-secondary rounded m-2 p-1">
                <div class="col-12">
                  <h3 class="mb-05 mt-05 titulo1">Sin reintegros</h3>
                </div>
              </div><?php
            }?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- * App Capsule -->
    
  <!-- Modal Form -->
  <div class="modal fade modalbox animate__animated animate__fadeInRight" id="ModalNuevaAutorizacion" data-bs-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Nuevo reintegro</h3>
        </div>
        <div class="modal-body">
          <div class="login-form">
            <div class="section mt-2">
                  
            </div>
              <div class="section mt-4 mb-5">
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
                    <label class="form-label" for="id_tipo_reintegro">Tipo</label>
                    <select name="id_tipo_reintegro" id="id_tipo_reintegro" class="form-control col-sm-12" required="required">
                      <option value="">Seleccione...</option><?php
                      $url=$url_ws."?Modo=25&Usuario=$usuario_ws";
                      //echo $url;
                      $jsonData = json_decode(file_get_contents($url),true);
                      $delegaciones=$jsonData["Data"];
                      foreach ($delegaciones as $delegacion) {?>
                        <option value='<?=$delegacion['Id']?>'><?=$delegacion['TipoReintegro']?></option><?php
                      }?>
                    </select>
                  </div>
                  <div class="form-group basic">
                    <label class="form-label" for="">Requisitos</label>
                    <br>
                    <!-- <input type="file" name="imagen" multiple/> -->
                    <div id="requisitos_container" class="requisitos_container"></div>
                    <!-- <table role="presentation" class="table table-striped" id="fileTable">
                      <tbody class="files"></tbody>
                    </table> -->
                  </div>
                  <div class="mt-2">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Solicitar</button>
                    <button type="button" class="btn btn-primary btn-block btn-lg" data-bs-dismiss="modal">Cerrar</button>
					<br>
					<span style="color:red;">*Sólo se reintegrará el importe a la cuenta cargada del titular del O.S.P.I.A. PBA</span>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- * Modal Form -->
	
	<!-- Modal Confirmar nuevo reintegro -->
	  <div class="modal fade modalbox " id="ModalConfirmNuevoReintegro" data-bs-backdrop="static" tabindex="-1" role="dialog" style="background-color: rgb(0 0 0 / 50%);">
		<div class="modal-dialog" role="document" style="top: 25%;left: 10%;width: 80%;min-width: 0;max-height: 30%;">
		  <div class="modal-content" style="padding-top: 0;height: min-content;">
			<!-- <div class="modal-header">
			  
			</div> -->
			<div class="modal-body" style="height: min-content;">
			  <h3 class="modal-title" style="color:black">El reintegro ha sido enviado correctamente. Usted recibirá un email cuando se haya ingresado en el sistema</h3>
			</div>
			<div class="modal-footer">
			  <!-- <button type="button" class="btn btn-primary btn-block btn-lg">OK</button> -->
			  <a href="reintegros.php" type="button" class="btn btn-primary btn-block btn-lg">OK</a>
			</div>
		  </div>
		</div>
	  </div>
	  <!-- * Modal Confirmar nuevo reintegro -->

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
        if(!$(this).hasClass("disabled")){
          console.log("Se cargará el reintegro")
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

          let select_delegacion=$("#id_tipo_reintegro");
          let id_tipo_reintegro=select_delegacion.val();
          let selected_delegacion=select_delegacion.find("option[value='"+id_tipo_reintegro+"']");

          let datosEnviar = new FormData();
          datosEnviar.append("id_afiliado", id_afiliado);
          datosEnviar.append("nombre_afiliado", nombre_afiliado);
          datosEnviar.append("id_tipo_reintegro", id_tipo_reintegro);

          let i=0;
          $("input[name='files[]']").each(function(){
            let file=$(this).prop('files')[0];
            console.log(file);
            if(file!=undefined){
              datosEnviar.append('file'+i, file);
              i++;
            }
          });
          
          //console.log("enviar datos");
          $(this).addClass("disabled");
          $.ajax({
            data: datosEnviar,
            url: "enviar_reintegro.php",
            method: "post",
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
              console.log(data);
              //$("#btnGuardar").removeClass("disabled")
              //$("#spinner_guardar").toggleClass("d-none");
              if(data=="1"){
                //document.location.href=document.location.href;
                $("#ModalConfirmNuevoReintegro").modal("show")
              }else{
                $(this).removeClass("disabled")
              }
            }
          });
        }
      });

      $(document).on("click", ".fileinput-button", function() {
        let files_container = $(this).next(".files_container");
        let inputFile = $(files_container).find("input[name='files[]']")[0];
        let files_preview = $(files_container).find(".files_preview")[0];

        inputFile.click(); // Abre el diálogo de selección de archivos

        // Verificar si ya existe un listener para el cambio de archivos
        if (!inputFile.getAttribute("listenerAdded")) {
          inputFile.addEventListener("change", function(e) {
            readFile(e.srcElement, files_preview);
          }, false);
          inputFile.setAttribute("listenerAdded", "true"); // Marcamos que se ha agregado el listener
        }
      });

      $(document).on("click",".clear_file",function(){
        this.parentElement.parentElement.remove()
      });

      $(document).on("change","#id_tipo_reintegro",function(){
        get_requisitos_reintegro()
      });

    });

    function get_requisitos_reintegro(){
      let id_tipo_reintegro=$("#id_tipo_reintegro").val();
      //console.log(id_especialidad);
      $.post("get_requisitos_reintegro.php",{id_tipo_reintegro:id_tipo_reintegro}, function(data){
        data=JSON.parse(data);
        //console.log(data);
        var requisitos_container = document.getElementById("requisitos_container");
        requisitos_container.innerHTML=""
        data.Data.forEach((requisito, index)=>{

          if(this.nextElementSibling!=null){
            this.nextElementSibling.remove();
          }
          
          let detalle=""
          if(requisito.MuestraDetalle=="SI"){
            detalle=": <span class='detalle'>"+requisito.Detalle+"</span>"
          }

          let required="required"
          if(id_tipo_reintegro==11 && index>0){//id_tipo_reintegro == 11 -> CONSULTAS MEDICAS
            required=""
          }
          //<ion-icon name="add-outline"></ion-icon>
          var nuevoHTML = `
            <div class='mb-3' style="text-align: left;">
              <p class="mb-1"><span class="requisito">${requisito.Requisito}</span>${detalle}</p>
              <span class="btn bg-primary fileinput-button col-3">
                <span>Agregar</span>
              </span>
              <span class="files_container col-9">
                <input type='file' name='files[]' style='width: 1px;height: 1px;' capture ${required} accept='image/*, application/pdf'>
                <span class="files_preview"></span>
              </span>
            </div>`;// accept='.pdf, image/*'

          requisitos_container.innerHTML += nuevoHTML;
        })
      });
    }

    function readFile(input, files_preview) {
      //$("#clear_file").css("d-none");
      //$("#clear_file").css("display","block");
      //debugger
      //console.log(files_preview);
      files_preview.innerHTML="";
      //console.log(files_preview);
      if (input.files && input.files[0]) {

        const celda1=document.createElement("span")

        //var fileInput = document.getElementById('file-input');
        var file = input.files[0];
        //console.log(file);
        var fileName = file.name;
        var fileNameLabel = document.createElement('label');
        fileNameLabel.innerHTML=fileName
        //console.log(fileName);

        if(file.type!="application/pdf"){

          var reader = new FileReader();
          reader.onload = function (e) {

            /*var file = input.files[0];
            var fileName = file.name;
            var fileNameLabel = document.createElement('label');
            fileNameLabel.innerHTML=fileName*/

            var filePreview = document.createElement('img');
            filePreview.id = 'file-preview';
            filePreview.width = 150;
            //e.target.result contiene los datos base64 de la imagen cargada
            filePreview.src = e.target.result;
            filePreview.alt = fileName;
            celda1.appendChild(filePreview)
            //celda1.appendChild(fileNameLabel)
            files_preview.appendChild(celda1);

          }

          reader.readAsDataURL(input.files[0]);
        }else{
          //div.style.marginBottom="15px"
          /*console.log(celda1);
          console.log(fileNameLabel);*/
          files_preview.appendChild(fileNameLabel)
        }
        console.log(files_preview);
      }
    }

  </script>
</body>
</html>