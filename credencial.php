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

    #modalCredencial .modal-body{
      /*background-image: url('assets/img/fondo_credencial.svg'); /* Ruta de la imagen de fondo */
      /*background-size: cover; /* Ajustar la imagen para cubrir todo el contenedor */
      /*background-size: 100% auto; /* Ajustar la imagen al 100% del ancho del contenedor y mantener la altura automática */
      /*background-position: top; /* Centrar la imagen de fondo */

      /*background-size: cover; /* Ajustar la imagen para cubrir todo el contenedor */
      /*background-position: top; /* Posicionar la imagen en la parte superior */
      height: auto; /* Ajustar la altura automáticamente */

      position: relative;
      width: 100%; /* Ancho completo del contenedor */
      padding-bottom: 50%; /* Proporción de la altura con respecto al ancho (ejemplo: 1:2) */
    }

    .datos_credencial{
      color: white;
      position: absolute;
      font-size: 24px;
      font-weight: bold;
      /*font-variant: all-petite-caps;*/
      text-transform: uppercase; /* Convierte el texto a mayúsculas */
    }
    .custom__image-container1 img{
      height: 30%;
      width: inherit;
    }
    #foto{
      /*width: 115px;
      height: 115px;*/
      /*width: 50%;*/
      height: 100%;
      /*top: 10px;
      left: 30px;*/
      top: 25%; /* Posiciona el texto en el contenedor */
      /*left: 45%; /* Posiciona el texto en el contenedor */
      right: 5%;
    }
    #apellido{
      /*top: 123px;
      left: 39px;*/
      top: 60%; /* Posiciona el texto en el contenedor */
      left: 5%; /* Posiciona el texto en el contenedor */
    }
    #nombre{
      /*top: 123px;
      left: 39px;*/
      top: 65%; /* Posiciona el texto en el contenedor */
      left: 5%; /* Posiciona el texto en el contenedor */
    }
    #dni{
      /*top: 200px;
      left: 185px;*/
      top: 70%; /* Posiciona el texto en el contenedor */
      left: 5%; /* Posiciona el texto en el contenedor */
    }
    #caracter{
      /*top: 149px;
      left: 152px;*/
      top: 75%; /* Posiciona el texto en el contenedor */
      left: 5%; /* Posiciona el texto en el contenedor */
    }
    #plan{
      /*top: 175px;
      left: 102px;*/
      top: 80%; /* Posiciona el texto en el contenedor */
      left: 5%; /* Posiciona el texto en el contenedor */
    }
    #token{
      /*top: 175px;
      left: 102px;*/
      width: 100%;
      top: 88%; /* Posiciona el texto en el contenedor */
      /*left: 5%; /* Posiciona el texto en el contenedor */
      text-align: center;
      font-size: 26px;
      word-spacing: 3em;
    }
    #coseguro{
      /*top: 229px;
      left: 160px;*/
      display: none;
      top: 60%; /* Posiciona el texto en el contenedor */
      left: 5%; /* Posiciona el texto en el contenedor */
    }

    .loader {
      /*position: absolute;
      top: 50%;
      right: 10px; /* Ajusta la posición lateral de la carga */
      /*transform: translateY(-50%);*/
      display: none;
      width: 20px; /* Ajusta el tamaño de la carga según sea necesario */
      height: 20px; /* Ajusta el tamaño de la carga según sea necesario */
      border: 2px solid #ccc;
      border-radius: 50%;
      border-top-color: #333;
      animation: spin 1s ease-in-out infinite;
      margin-left: 15px;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
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
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule" class="pt-0">
      <ul class="listview image-listview text animate__animated animate__fadeInRight">
        <li>
          <div class="in item">
            <div><strong>Credenciales</strong></div>
          </div>
        </li>
      </ul>
      <br><?php
      //var_dump($_SESSION);
      
      $id=$_SESSION["user"]["id"];
      $imagen=$_SESSION["user"]["imagen"];
      $ficha=$_SESSION["user"]["ficha"];
      //var_dump($_SESSION["user"]);
      $email=$_SESSION["user"]["email"];
      //$email="";
      $autorizado = 0;
      if ($_SESSION['titular']!=1) {
        $autorizado = 1;
      }
      $url=$url_ws."?Modo=6&Usuario=$usuario_ws&Ficha=$ficha&Autorizado=$autorizado";
      //echo $url;
      $jsonData = json_decode(file_get_contents($url),true);
      
      //var_dump($jsonData[0]["Data"]);
      //var_dump($jsonData);
      ?>

      <!-- * Dialog Form -->
      <div class="section full mt-2 mb-2 animate__animated animate__fadeInRight">
        <div class="sectiontitle2">
          <!-- <ion-icon class="iconedbox iconedbox-lg" name="people-circle"></ion-icon>FAMILIA BIEDULA -->
          <ion-icon class="iconedbox iconedbox-lg" name="people-circle"></ion-icon>FAMILIA <?=$jsonData[0]["Data"][0]["Apellido"]?>
        </div>
      </div><?php

      $grupo_fliar=$jsonData[0]["Data"];
      foreach ($grupo_fliar as $persona) {?>
        <div class="listview link-listview search-result animate__animated animate__fadeInRight">
          <div class="wide-block1 pt-2 pb-2" style="text-align: center;">
            <!-- <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#DialogImage"><?=$persona["Nombre"]?></button> -->
            <button type="button" class="btn btn-secondary persona <?=($persona===reset($grupo_fliar))?"titular":""?>" data-id="<?=$persona["Id"]?>"><?=$persona["Nombre"]?><div class="loader"></div></button>
          </div>
        </div><?php
      }?>

      <!-- <div class="modal fade dialogbox col"  id="DialogImage" data-bs-backdrop="static" role="dialog">
        <div class="modal-dialog"  role="document">
          <div class="modal-content">
            <div class="modal-body" style="padding: 0;margin-bottom: 0;">
              <img id="credencial" src="assets/img/credencial_modelo.png" alt="image" class="img-fluid" style="width: 500px;height: 322px;">
              <span class="datos_credencial" id="foto"></span>
              <span class="datos_credencial" id="nombre_apellido"></span>
              <span class="datos_credencial" id="caracter"></span>
              <span class="datos_credencial" id="plan"></span>
              <span class="datos_credencial" id="beneficiario"></span>
              <span class="datos_credencial" id="coseguro"></span>
            </div>
            <div class="modal-footer">
              <div class="btn-inline">
                <a href="#" class="btn btn-text-secondary" id="btnCerrarCredencial" data-bs-dismiss="modal">CERRAR</a>
              </div>
            </div>
          </div>
        </div>
      </div> -->

      <div class="modal fade col" id="modalCredencial" data-bs-backdrop="static" role="dialog">
        <div class="modal-dialog" role="document"><!--  style="height: 95%;" -->
          <div class="modal-content" style="border-radius: 50px"><!-- ;width: 447px; ;height: 100%-->
            <div class="modal-body" style="padding: 0;margin-bottom: 0;"><?php
              $class="";
              if($email!="axelbritzius@gmail.com"){
                //$class="d-none";
              }?>
              <!-- <a href="#" class="d-none btn <?=$class?>" id="downloadButton" title="Descargar" style="position: absolute;top: 20px;left: 45%;background-color: rgba(0,0,0,0.5);color: whitesmoke;border-radius: 50px;">
                <ion-icon name="download" style="margin-right: 0;"></ion-icon>
              </a>
              <a href="#" class="d-none btn <?=$class?>" id="shareButton" title="Compartir" style="position: absolute;top: 20px;left: 65%;background-color: rgba(0,0,0,0.5);color: whitesmoke;border-radius: 50px;">
                <ion-icon name="share" style="margin-right: 0;"></ion-icon>
              </a> -->
              <img src="assets/img/fondo_credencial.svg" alt="Imagen de Fondo" style="width: 100%; display: block;">

              <a href="#" class="btn" id="btnCerrarCredencial" style="position: absolute;top: 20px;left: 85%;background-color: rgba(0,0,0,0.5);color: whitesmoke;border-radius: 50px;" data-bs-dismiss="modal">X</a>

              <!-- <img id="credencial" src="assets/img/credencial_modelo.png" alt="image" class="img-fluid" style="width:100%;"> -->
              <!-- <img id="credencial" src="assets/img/fondo_credencial.svg" alt="image" class="img-fluid" style="width:100%;"> -->
              <!-- style="width: 500px;height: 322px;" -->
              <div class="datos_credencial custom__image-container1" id="foto">
                <img></img>
              </div>
              <span class="datos_credencial" id="apellido"></span>
              <span class="datos_credencial" id="nombre"></span>
              <span class="datos_credencial" id="dni"></span>
              <span class="datos_credencial" id="caracter"></span>
              <span class="datos_credencial" id="plan"></span>
              <span class="datos_credencial" id="coseguro"></span>
              <span class="datos_credencial" id="token"></span>
            </div>
            <!-- <div class="modal-footer">
              <div class="btn-inline">
                <a href="#" class="btn btn-text-secondary" id="btnCerrarCredencial" data-bs-dismiss="modal">CERRAR</a>
              </div>
            </div> -->
          </div>
        </div>
      </div>

      <div class="modal" tabindex="-1" role="dialog" id="DialogError">
        <div class="modal-dialog" role="document" style="top: 25%;left: 10%;width: 80%;min-width: 0;max-height: 30%;">
          <div class="modal-content">
            <div class="modal-body">
              <h3 id="error_text" style="color: initial;margin-top: 10px;">Ha ocurrido un error.</h3>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">CERRAR</a>
            </div>
          </div>
        </div>
      </div>
        
      <!-- <div class="listview link-listview search-result animate__animated animate__fadeInRight">
        <div class="wide-block1 pt-2 pb-2">
          <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#DialogImage">JAVIER</button>
        </div>
      </div> -->

        <!-- Dialog Image -->
        <!-- <div class="modal fade dialogbox col"  id="DialogImage" data-bs-backdrop="static" role="dialog">
          <div class="modal-dialog"  role="document">
            <div class="modal-content">
              <img src="assets/img/credencial.png" alt="image" class="img-fluid">
              <div class="modal-footer">
                <div class="btn-inline">
                  <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">CERRAR</a>
                </div>
              </div>
            </div>
          </div>
        </div> -->
        <!-- * Dialog Image -->

           <!-- * Dialog Form -->
           <!-- <div class="listview link-listview search-result animate__animated animate__fadeInRight">
            <div class="wide-block1 pt-2 pb-2">
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                    data-bs-target="#DialogImage">JORGE</button>
            </div>
        </div> -->

        <!-- Dialog Image -->
        <!-- <div class="modal fade dialogbox" id="DialogImage" data-bs-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <img src="assets/img/credencial.png" alt="image" class="img-fluid">
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">CERRAR</a>
                            <a href="#" class="btn btn-text-primary" data-bs-dismiss="modal">COMPARTIR</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- * Dialog Image -->

         <!-- * Dialog Form -->

         <!-- <div class="listview link-listview search-result animate__animated animate__fadeInRight">
            <div class="wide-block1 pt-2 pb-2">
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                    data-bs-target="#DialogImage">FRANCO</button>
            </div>
        </div> -->

        <!-- Dialog Image -->
        <!-- <div class="modal fade dialogbox" id="DialogImage" data-bs-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <img src="assets/img/credencial.png" alt="image" class="img-fluid">
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">CERRAR</a>
                            <a href="#" class="btn btn-text-primary" data-bs-dismiss="modal">COMPARTIR</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- * Dialog Image -->
            
    <!-- * App Capsule -->

    <!-- App Bottom Menu --><?php
    include_once("footer.php")?>
    <!-- * App Bottom Menu -->

   

    <!-- ============== Js Files ==============  -->
    <!-- jQuery Js File -->
    <script src="assets/js/lib/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap -->
    <script src="assets/js/lib/bootstrap.min.js"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Splide -->
    <script src="assets/js/plugins/splide/splide.min.js"></script>
    <!-- ProgressBar js -->
    <script src="assets/js/plugins/progressbar-js/progressbar.min.js"></script>
    <!-- Base Js File -->
    <!-- <script src="assets/js/base.js"></script> -->
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
        //document.querySelector('#output').appendChild(p);
        p.appendChild(document.createTextNode(message));
      }

      function logError(message) {
        logText(message, true);
      }

      function setShareButtonsEnabled(enabled) {
        document.querySelector('#shareButton').disabled = !enabled;
        //document.querySelector('#share-no-gesture').disabled = !enabled;
      }

      function checkBasicFileShare() {
        // XXX: There is no straightforward API to do this.
        // For now, assume that text/plain is supported everywhere.
        const txt = new Blob(['Hello, world!'], {type: 'text/plain'});
        // XXX: Blob support? https://github.com/w3c/web-share/issues/181
        const file = new File([txt], "test.txt");
        return navigator.canShare({ files: [file] });
      }

      async function testWebShareOriginal() {
        const title_input = document.querySelector('#title');
        const text_input = document.querySelector('#text');
        const url_input = document.querySelector('#url');
        /** @type {HTMLInputElement} */
        const file_input = document.querySelector('#files');

        const title = title_input.disabled ? undefined : title_input.value;
        const text = text_input.disabled ? undefined : text_input.value;
        const url = url_input.disabled ? undefined : url_input.value;
        const files = file_input.disabled ? undefined : file_input.files;

        if (files && files.length > 0) {
          if (!navigator.canShare) {
            logError('Warning: canShare is not supported. File sharing may not be supported at all.');
          } else if (!checkBasicFileShare()) {
            logError('Error: File sharing is not supported in this browser.');
            setShareButtonsEnabled(true);
            return;
          } else if (!navigator.canShare({files})) {
            logError('Error: share() does not support the given files');
            for (const file of files) {
              logError(`File info: name - ${file.name}, size ${file.size}, type ${file.type}`);
            }
            setShareButtonsEnabled(true);
            return;
          }
        }

        setShareButtonsEnabled(false);
        try {
          await navigator.share({files, title, text, url});
          logText('Successfully sent share');
        } catch (error) {
          logError('Error sharing: ' + error);
        }
        setShareButtonsEnabled(true);
      }

      async function testWebShare(imageElement) {
        // ... (código existente)
        const title = "Credencial OSPIA";
        const text = "Credencial OSPIA texto";
        const url = "";

        // Obtener la imagen como Blob desde el elemento img
        console.log(imageElement);
        const imageBlob = await fetch(imageElement.src).then(response => response.blob());

        // Crear un objeto File a partir del Blob
        const imageFile = new File([imageBlob], "image.jpg", { type: imageBlob.type });

        // Agregar la imagen al array de archivos a compartir
        const files = [];
        const filesToShare = files ? [...files, imageFile] : [imageFile];
        //const filesToShare = imageFile;
        console.log(filesToShare);

        try {
          //await navigator.share({ files: filesToShare, title, text, url });
          await navigator.share({ files: filesToShare});
          logText('Successfully sent share');
        } catch (error) {
          logError('Error sharing: ' + error);
        }
        setShareButtonsEnabled(true);
      }

      function onLoad() {
        //debugger
        // Obtener referencia al elemento img
        const imageElement = document.querySelector('#credencial');

        // Obtener referencia al botón de compartir
        const shareButton = document.querySelector('#shareButton');
        shareButton.addEventListener('click', () => testWebShare(imageElement));

        if (navigator.share === undefined) {
          setShareButtonsEnabled(false);
          if (window.location.protocol === 'http:') {
            // navigator.share() is only available in secure contexts.
            //window.location.replace(window.location.href.replace(/^http:/, 'https:'));
          } else {
            logError('Error: You need to use a browser that supports this draft ' + 'proposal.');
          }
        }
      }

      //window.addEventListener('load', onLoad);

      $(document).ready(function () {

        /*document.getElementById("downloadButton").addEventListener("click", function() {
          descargarImagen();
        });*/

        function descargarImagen() {
          // Obtiene la URL de la imagen mostrada
          var imagenMostrada = document.getElementById("credencial");
          var imagenURL = imagenMostrada.src;

          // Crea un elemento <a> temporal
          var link = document.createElement("a");
          link.href = imagenURL;
          link.download = "credencial OSPIA.jpg"; // Cambia el nombre según prefieras

          // Simula un clic en el enlace para iniciar la descarga
          link.click();
        }


        $(document).on("click",".persona",function(){
          let id_persona=this.dataset.id;
          let t=this;
          let loader=$(this).find(".loader")
          loader.css("display","block");
          console.log(id_persona)
          //$.post("create_credential_IMG.php",{id_persona:id_persona,es_titular:t.classList.contains('titular')}, function(data){
          $.post("create_credential.php",{id_persona:id_persona,es_titular:t.classList.contains('titular')}, function(data){
            console.log(data);
            data=JSON.parse(data);
            console.log(data);
            let resp=data.resp
            if(data.json_ok==1){
              $("#modalCredencial").modal("show");
              //$("#credencial").attr("src",resp)
              $("#foto img").attr("src",resp.foto_perfil)
              $("#apellido").html(resp.apellido)
              $("#nombre").html(resp.nombre)
              $("#caracter").html(resp.caracter)
              $("#plan").html("Plan "+resp.plan)
              $("#dni").html(resp.dni)
              $("#coseguro").html(resp.coseguro)
              $("#token").html("Token "+resp.token)
            }else if(data.json_ok==0){
              $("#DialogError").modal("show")
              $("#error_text").html(resp)
            }
            loader.css("display","none");

          })
        })

        /*$(document).on("click","#btnCerrarCredencial",function(){
          let imagen=$("#credencial").attr("src")
          $.post("borrar_credential.php",{imagen:imagen}, function(data){
            console.log(data);
          })
        })*/

        /*document.getElementById('shareButton').addEventListener('click', function() {
          // Lógica para cargar o seleccionar la imagen aquí
          let credencial=$("#credencial").attr("src")
          const blob = await fetch(credencial).then(r=>r.blob())
          // Verifica si la API Web Share es compatible con el navegador
          console.log(navigator);
          if (navigator.share) {
            navigator.share({
              title: 'Título de la imagen',
              text: 'Descripción de la imagen',
              url: 'URL de la imagen'
            })
            .then(() => console.log('Imagen compartida exitosamente'))
            .catch(error => console.error('Error al compartir la imagen', error));
          } else {
            console.log('La API Web Share no es compatible con este navegador');
          }
        });*/

      });
    </script>

</body>

</html>