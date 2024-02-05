<?php
include_once("admin/config.php");
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
  <title>OSPIA APP Búsqueda</title>
  <meta name="description" content="Mobilekit HTML Mobile UI Kit">
  <meta name="keywords" content="bootstrap 5, mobile template, cordova, phonegap, mobile, html" />
  <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="manifest" href="__manifest.json">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
  <!-- * App Header -->

  <!-- App Capsule -->
  <div class="section full mt-2">
    <div class="wide-block3 pt-2 pb-2 animate__animated animate__fadeInRight">
      <form class="search-form">
        <div class="section full mt-1">
          <div class="row wide-block3 pt-2 pb-2">
            <div class="dropdown col-12"><?php

              $url=$url_ws."?Modo=9&Usuario=$usuario_ws";
              $jsonData = json_decode(file_get_contents($url),true);?>

              <select name="especialidad" id="especialidad" class="servicios btn btn-secondary dropdown-toggle">
                <option value="0">ESPECIALIDAD</option><?php
                foreach ($jsonData[0]["Data"] as $value) {?>
                  <option value="<?=$value["Id"]?>"><?=$value["Especialidad"]?></option><?php
                }?>
                <!-- <option value="Pediatría">Pediatría</option>
                <option value="Traumatología">Traumatología</option>
                <option value="Cardiología">Cardiología</option>
                <option value="Neurología">Neurología</option> -->
              </select>
            </div>
            <div class="dropdown col-12"><?php

              $url=$url_ws."?Modo=8&Usuario=$usuario_ws";
              $jsonData = json_decode(file_get_contents($url),true);?>

              <select name="Servicios" id="servicios" class="servicios btn btn-secondary dropdown-toggle">
                <option value="0">TIPO DE PRESTADOR</option><?php
                foreach ($jsonData[0]["Data"] as $value) {?>
                  <option value="<?=$value["Id"]?>"><?=$value["TipoPrestador"]?></option><?php
                }?>
                <!-- <option value="Internación">Internación</option>
                <option value="Guardia">Guardia</option>
                <option value="Vacunatorio">Vacunatorio</option>
                <option value="Salas-Médicas">Salas Médicas</option> -->
              </select> 
            </div>
            <div class="dropdown col-12"><?php

              $url=$url_ws."?Modo=13&Usuario=$usuario_ws";
              $jsonData = json_decode(file_get_contents($url),true);
              
              //var_dump($jsonData);
              ?>

              <select name="Localidades" id="localidades" class="servicios btn btn-secondary dropdown-toggle">
                <option value="0">LOCALIDAD</option><?php
                foreach ($jsonData["Data"] as $value) {?>
                  <option value="<?=$value["Id"]?>"><?=$value["Localidad"]?></option><?php
                }?>
                <!-- <option value="Internación">Internación</option>
                <option value="Guardia">Guardia</option>
                <option value="Vacunatorio">Vacunatorio</option>
                <option value="Salas-Médicas">Salas Médicas</option> -->
              </select>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-12">
              <!-- <button type="button" class="btn btn-primary btn5 btn-sm btn-block">
                <ion-icon name="map"></ion-icon>
                <a href="searchmapa.php">Ver en Mapa</a>
              </button> -->
              <a href="searchmapa.php" class="btn btn-primary btn5 btn-sm btn-block">
                <ion-icon name="map"></ion-icon>
                Ver en Mapa
              </a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <ul id="cartilla" class="listview link-listview search-result mb-2 animate__animated animate__fadeInRight">
      <!-- <li>
          <a href="#">
              <div>
                  <h3 class="mb-05 titulo1">CENTRO DIAGNÓSTICO BIOIMÁGENES</h3>
                  <div class="text-muted">
                      Av. H. Yrigoyen 3502, Lanús Oeste, GBA SUR
                      <div class="mt-05"><strong>TEL: 291-443-3399</strong></div>
                      <div class="mt-05"><strong>Email: juanperez@gmail.com</strong></div>
                  </div>
              </div>
          </a>
      </li>
      <li>
          <a href="#">
              <div>
                  <h3 class="mb-05 titulo1">CENTRO DIAGNÓSTICO BIOIMÁGENES</h3>
                  <div class="text-muted">
                      Av. H. Yrigoyen 3502, Lanús Oeste, GBA SUR
                      <div class="mt-05"><strong>TEL: 291-443-3399</strong></div>
                      <div class="mt-05"><strong>Email: juanperez@gmail.com</strong></div>
                  </div>
              </div>
          </a>
      </li>
      <li>
          <a href="#">
              <div>
                  <h3 class="mb-05 titulo1">CENTRO DIAGNÓSTICO BIOIMÁGENES</h3>
                  <div class="text-muted">
                      Av. H. Yrigoyen 3502, Lanús Oeste, GBA SUR
                      <div class="mt-05"><strong>TEL: 291-443-3399</strong></div>
                      <div class="mt-05"><strong>Email: juanperez@gmail.com</strong></div>
                  </div>
              </div>
          </a>
      </li> -->
  </ul>

  <div class="modal" tabindex="-1" role="dialog" id="DialogEspecialidadesPrestador">
    <div class="modal-dialog" role="document" style="overflow-y: initial !important">
      <div class="modal-content">
        <div class="modal-header"><h3 style="color:black" class="modal-title">Especialidades</h3 ></div>
        <div class="modal-body" style="max-height: 65vh;overflow-y: auto;"></div>
        <div class="modal-footer">
          <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">CERRAR</a>
        </div>
      </div>
    </div>
  </div>

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
  <script src="assets/js/base.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
      
      $(document).ready(function() {
        $('.servicios').select2();

        $("#especialidad").on("change",get_cartilla);
        $("#servicios").on("change",get_cartilla);
        $("#localidades").on("change",get_cartilla);

      });

      function get_cartilla(){
        let especialidad=$("#especialidad").val();
        let servicios=$("#servicios").val();
        let localidades=$("#localidades").val();
        console.log(especialidad)
        console.log(servicios);
        console.log(localidades);
        $.post("get_cartilla.php",{especialidad:especialidad,servicios:servicios,localidades:localidades}, function(data){
          console.log(data);
          data=JSON.parse(data);
          $container="";
          if(data.Ok=="false"){
            $container+=`
            <li>
              <a href="#">
                <div>
                  <h3 class="mb-05 titulo1">No se han encontrado registros</h3>
                </div>
              </a>
            </li>`;
          }else{
            data.Data.forEach(result => {
              console.log(result);
              $container+=`
              <li>
                <a href="#" class="prestadores" data-id="${result.Prestador_Id}">
                  <div>
                    <h3 class="mb-05 titulo1">${result.Prestador}</h3>
                    <div class="text-muted">
                      ${result.Domicilio}, ${result.Localidad} `;
                      result.Contactos.forEach(contacto => {
                        $container+=`<div class="mt-05"><strong>${contacto.TipoContacto}: ${contacto.Detalle}</strong></div>`;
                      })
              $container+=`
                    </div>
                  </div>
                </a>
              </li>`;
            })
          }
          $("#cartilla").html($container);
        });
      }

      $(document).on("click",".prestadores",function(){
        let prestador_id=this.dataset.id;
        console.log(prestador_id)
        $.post("get_especialidades_prestador.php",{prestador_id:prestador_id}, function(data){
          data=JSON.parse(data);
          $container="<ul>";
          data.Data.forEach(result => {
            console.log(result);
            $container+=`
            <li>${result.Especialidad}</li>`;
          })
          $container+="</ul>";
          $("#DialogEspecialidadesPrestador").modal("show").find(".modal-body").html($container);
        });
      })
      </script>
    

</body>

</html>