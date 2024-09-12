<?php
require("admin/config.php");
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
  <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="manifest" href="__manifest.json">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <style>
    html, body, #map {
      height: 100%;
      margin: 0;
      padding: 0;
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
          <strong>Busqueda de Medicamentos</strong>
        </div>
      </li>
    </ul>
    <br>

    <div class="section full">
      <div class="wide-block3 pt-2 pb-2 animate__animated animate__fadeInRight" style="height: 100%;">
        <form class="search-form">
          <div class="container">
            <div class="row">
              <div class="col-3 mt-1">
                <label class="form-label" for="nombre">Nombre:</label>
              </div>
              <div class="col-9 mt-1">
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
              </div>
            </div>
            <div class="row">
              <div class="col-3 mt-1">
                <label class="form-label" for="droga">Droga:</label>
              </div>
              <div class="col-9 mt-1">
                <input type="text" class="form-control" id="droga" name="droga" placeholder="Droga">
              </div>
            </div>
            <div class="row">
              <div class="col-12 mt-1">
                <button type="button" class="btn btn-primary btn5 btn-sm btn-block" id="btnBuscar">
                  <ion-icon name="search"></ion-icon>Buscar
                </button>
              </div>
            </div>
            <div class="row mt-1" id="loader-spinner" style="display:none">
              <div class="col-12" style="text-align: center;">
                <div class="spinner-border" role="status">
                  <span class="sr-only"></span>
                </div>
              </div>
            </div>
            <!-- <div class="spinner-grow mt-1" id="loader-growing" style="display:none" role="status">
              <span class="sr-only"></span>
            </div> -->
          </div>
        </form>
      </div>
    </div>

  <div class="section full" style="height: calc( 100% - 56px - 16px - 13px);">
    <!-- <div class="row" style="height: calc( 100% - 16px - 9px);overflow: scroll;"> -->
    <div class="row" style="height: 100%; overflow-y: auto;">
      <div class="col-12">
        <ul id="medicamentos" class="listview link-listview search-result animate__animated animate__fadeInRight">
          
          <div class="row border border-2 border-secondary rounded m-2 p-1">
            <div class="col-12">
              <h3 class="mb-05 mt-05 titulo1">Sin medicamentos</h3>
            </div>
          </div>

        </ul>
      </div>
    </div>
  </div>
  <!-- * App Capsule -->
    
  <!-- Modal Form -->
  <div class="modal fade modalbox " id="ModalDetalleMedicamento" data-bs-backdrop="static" tabindex="-1" role="dialog" style="background-color: rgb(0 0 0 / 50%);">
    <div class="modal-dialog" role="document" style="top: 10%;left: 10%;width: 80%;min-width: 0;max-height: 60%;">
      <div class="modal-content" style="padding-top: 0;height: min-content;">
        <div class="modal-body"></div>
        <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-block btn-lg" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- * Modal Form -->

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
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

  <script>
    $(document).ready(function() {

      $("#btnBuscar").on("click",get_medicamentos);

      $(document).on("click",".medicamento",function(){
        let medicamento_id=this.dataset.id;
        //console.log(medicamento_id)
        $.post("get_detalle_medicamento.php",{medicamento_id:medicamento_id}, function(data){
          data=JSON.parse(data);
          let result=data[0].Ok;
          let datos=data[0].Data[0];

          let precio = new Intl.NumberFormat('es-AR', {currency: 'ARS', style: 'currency'}).format((datos.Precio).replace(",", '.'))

          $container=`
            <h3 class="text-center" style="color:#141515">Detalle del medicamento</h3>
            <div>Troquel: <strong>${datos.Troquel}</strong></div>
            <div>Nombre: <strong>${datos.Nombre}</strong></div>
            <div>Presentacion: <strong>${datos.Presenta}</strong></div>
            <div>Droga: <strong>${datos.Monodroga}</strong></div>
            <div>Laboratorio: <strong>${datos.Laboratorio}</strong></div>
            <div>Precio: <strong>${precio}</strong></div>
          `;
          
          $("#ModalDetalleMedicamento").modal("show").find(".modal-body").html($container);
        });
      })

    });

    function get_medicamentos(event){
      let spinner=$("#loader-spinner");
      let growing=$("#loader-growing");
      spinner.css("display","block");
      growing.css("display","block");

      let nombre=$("#nombre").val();
      let droga=$("#droga").val();
      
      if(nombre=="" && droga==""){
        spinner.css("display","none");
        growing.css("display","none");
        $container=`
        <li>
          <a href="#">
            <div>
              <h3 class="mb-05 titulo1">Seleccione algún dato</h3>
            </div>
          </a>
        </li>`;
        $("#medicamentos").html($container);
      }else{
        $.post("get_medicamentos.php",{nombre:nombre,droga:droga}, function(data){
          spinner.css("display","none");
          growing.css("display","none");
          //console.log(data);
          data=JSON.parse(data);
          $container="";
          if(data[0]!=undefined){
            let result=data[0].Ok;
            let datos=data[0].Data;
            datos.forEach(medicamento => {
              //console.log(medicamento);
              $container+=`
              <div class="row border border-2 rounded m-2 p-1 medicamento" data-id="${medicamento.Id}">
                <div class="col-12">
                  <h3 class="mb-05 titulo1 text-center">Troquel: ${medicamento.Troquel}</h3>
                  <h3 class="mt-05 titulo1"><strong>${medicamento.Descripcion}</strong>
                  <div class="text-muted">Droga: ${medicamento.Droga}</div>
                </div>
              </div>`;
            })
          }else{
          //if(result=="false"){
            $container+=`
            <li>
              <a href="#">
                <div>
                  <h3 class="mb-05 titulo1">No se han encontrado medicamentos</h3>
                </div>
              </a>
            </li>`;
          //}else{
            
          }
          $("#medicamentos").html($container);
        });
      }
      
    }

  </script>
</body>
</html>