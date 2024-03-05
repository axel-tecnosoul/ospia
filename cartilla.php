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
    <title>OSPIA APP Mapa</title>
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
  <div class="section full mt-2" style="max-height: 30vh;">
    <div class="wide-block3 pt-2 pb-2 animate__animated animate__fadeInRight" style="height: 100%;">
      <form class="search-form">
        <div class="container">
          <div class="row">
            <div class="col-12 mt-1"><?php
              $url=$url_ws."?Modo=9&Usuario=$usuario_ws";
              $jsonData = json_decode(file_get_contents($url),true);?>

              <select name="especialidad" id="especialidad" style="width: 100%" class="servicios btn btn-secondary dropdown-toggle">
                <option value="0">ESPECIALIDAD</option><?php
                foreach ($jsonData[0]["Data"] as $value) {?>
                  <option value="<?=$value["Id"]?>"><?=$value["Especialidad"]?></option><?php
                }?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-12 mt-1"><?php
              $url=$url_ws."?Modo=8&Usuario=$usuario_ws";
              $jsonData = json_decode(file_get_contents($url),true);
              //var_dump($jsonData);?>

              <select name="Servicios" id="servicios" style="width: 100%" class="servicios btn btn-secondary dropdown-toggle">
                <option value="0">TIPO DE PRESTADOR</option><?php
                foreach ($jsonData[0]["Data"] as $value) {?>
                  <option value="<?=$value["Id"]?>"><?=$value["TipoPrestador"]?></option><?php
                }?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-12 mt-1"><?php
              $url=$url_ws."?Modo=13&Usuario=$usuario_ws";
              $jsonData = json_decode(file_get_contents($url),true);
              //var_dump($jsonData);?>

              <select name="Localidades" id="localidades" style="width: 100%" class="servicios btn btn-secondary dropdown-toggle">
                <option value="0">LOCALIDAD</option><?php
                foreach ($jsonData["Data"] as $value) {?>
                  <option value="<?=$value["Id"]?>"><?=$value["Localidad"]?></option><?php
                }?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-6 mt-1">
              <button type="button" class="btn btn-primary btn5 btn-sm btn-block" id="ver_listado">
                <ion-icon name="list-circle"></ion-icon>Ver en listado
              </button>
            </div>
            <div class="col-6 mt-1">
              <button type="button" class="btn btn-primary btn5 btn-sm btn-block" id="ver_mapa">
                <ion-icon name="map"></ion-icon>Ver en Mapa
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

  <!-- ATENCION no quitar heigth xq sino deja de funcionar el mapa-->
  <!-- <div class="section full" style="height: 100%;"> -->
  <div class="section full" style="height: 60vh;"><!-- height: calc( 100% - 56px - 16px - 13px); -->
    <div class="row" style="height: calc( 100% - 16px - 9px);overflow: scroll;">
      <ul id="cartilla" class="listview link-listview search-result animate__animated animate__fadeInRight" style="border-radius: 10px;">
        <li>
          <a href="#">
            <div>
              <h3 class="mb-05 titulo1">Seleccione una especialidad o un tipo de prestador</h3>
            </div>
          </a>
        </li>
      </ul>

      <div class="modal" tabindex="-1" role="dialog" id="DialogEspecialidadesPrestador" style="background-color: rgb(0 0 0 / 50%);">
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

      <div id="map" class="mapArea" style="display: none;"></div>

    </div>
  </div>
  <!--<div class="map-responsive wide-block3">
     <div class="map-js-height" id="map12"></div> 
  </div>-->
  <!-- <div class="map-responsive wide-block3">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3560.1264919695723!2d-65.20629018441194!3d-26.835928796470863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94225c0f72a55551%3A0xc334dfd601c77e22!2sOSPIA!5e0!3m2!1ses-419!2shr!4v1664976103467!5m2!1ses-419!2shr" width="800" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div> -->
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
  <!-- <script src="assets/js/base.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- <script src="admin/assets/js/map-js/mapsjs-core.js"></script>
  <script src="admin/assets/js/map-js/mapsjs-service.js"></script>
  <script src="admin/assets/js/map-js/mapsjs-ui.js"></script>
  <script src="admin/assets/js/map-js/mapsjs-mapevents.js"></script> -->

  <script>
    var ver="ver_listado";
    var locations = [];
    var ospia={latitude:-34.6143656, longitude:-58.4253821};
    $(document).ready(function() {
      $('.servicios').select2();

      $("#especialidad").on("change",get_cartilla);
      $("#servicios").on("change",get_cartilla);
      $("#localidades").on("change",get_cartilla);
      $("#ver_listado").on("click",get_cartilla);
      $("#ver_mapa").on("click",get_cartilla);

    });

    function get_cartilla(event){
      let spinner=$("#loader-spinner");
      let growing=$("#loader-growing");
      spinner.css("display","block");
      growing.css("display","block");

      let especialidad=$("#especialidad").val();
      let servicios=$("#servicios").val();
      let localidades=$("#localidades").val();
      /*console.log(especialidad)
      console.log(servicios);
      console.log(localidades);*/

      if(event.currentTarget.type=="button"){
        ver=event.currentTarget.id;
      }
      console.log(ver);
      //let mapa=document.getElementById('map12');
      
      if(especialidad==0 && servicios==0 && localidades==0){
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
        $("#cartilla").html($container);
      }else{
        $.post("get_cartilla.php",{especialidad:especialidad,servicios:servicios,localidades:localidades}, function(data){
          //console.log(data);
          data=JSON.parse(data);
          spinner.css("display","none");
          growing.css("display","none");
          //var aLugares=[];

          if(ver=="ver_listado"){
            $("#map").css("display","none");
            $("#cartilla").css("display","block");

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
                //console.log(result);
                $container+=`
                <li id="prestador${result.Prestador_Id}">
                  <a href="#prestador${result.Prestador_Id}">
                    <div>
                      <h3 class="mb-05 titulo1">${result.Prestador}</h3>
                      <div class="text-muted">
                        <span onclick="window.open('http://www.google.com/maps/place/${result.Latitud.replace(',','.')},${result.Longitud.replace(',','.')}', '_blank')">
                          ${result.Domicilio}, ${result.Localidad} 
                          <span class='btn btn-sm btn-link border'>(ir)</span>
                        </span>`;
                        result.Contactos.forEach(contacto => {
                          $container+=`<div class="mt-05"><strong>${contacto.TipoContacto}: ${contacto.Detalle}</strong></div>`;
                        })
                $container+=`
                        <span class="mt-05 btn btn-sm btn-link border prestadores" data-id="${result.Prestador_Id}">Ver especialidades</span>
                      </div>
                    </div>
                  </a>
                </li>`;
              })
            }
            $("#cartilla").html($container);

            $(document).on("click",".prestadores",function(){
              let prestador_id=this.dataset.id;
              //console.log(prestador_id)
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

          }else if(ver=="ver_mapa"){

            $("#map").css("display","block");
            $("#cartilla").css("display","none");

            let mapa=document.getElementById('map');
            locations = []
            mapa.innerHTML="";
            if(data.Ok=="false"){
              //center=ospia
              locations.push(ospia);
              flag=undefined
            }else{
              flag=1
              data.Data.forEach(result => {
                //console.log(result);
                locations.push({
                  "latitude": result.Latitud.replace(',','.'),
                  "longitude": result.Longitud.replace(',','.'),
                  "marker": null,
                  "infoWindow": null,
                  "title": result.Prestador,
                  "infoContent": "<div class='info-window'><address><b>"+result.Prestador+"</b><br/>"+result.Domicilio+", "+result.Localidad+"<br/>"+result.Localidad+"<br /><a class='btn btn-sm btn-link' target='_blank' href='http://www.google.com/maps/place/"+result.Latitud.replace(',','.')+","+result.Longitud.replace(',','.')+"'>(ir)</a></address></div>"
                });
              })
            }
            gmapController.initialize(flag)

          }

        });
      }
    }

  </script>
  <script>
    'use strict';

    var gmapController = (function () {
      // ************************************
      // Private Variables
      // ************************************
      let map = null;
      //let locations = [];

      // ************************************
      // Private Functions
      // ************************************     
      function initialize(flag) {
        // Create a lat/lng boundary
        let bounds = new google.maps.LatLngBounds();

        if(flag==undefined){
          locations.push(ospia);
        }

        // Draw the map
        addMap(locations[0]);

        // Draw the locations
        for (let index = 0; index < locations.length; index++) {
          if(flag==1){
            // Add marker for location
            addMarker(locations[index]);
          }
          // Add info window for location
          addInfoWindow(locations[index]);
          // Extend boundaries to encompass marker
          bounds.extend(locations[index].marker.position);
        }

        // Fit the map to boundaries
        if (locations.length > 1) {
          map.fitBounds(bounds);
        }
      }

      function addMap(mapObject) {
        console.log(mapObject);
        // Create map options
        let mapOptions = {
          center: new google.maps.LatLng(mapObject.latitude, mapObject.longitude),
          zoom: 8,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        // Create new google map
        map = new google.maps.Map(document.getElementById("map"), mapOptions);
      }

      function addMarker(location) {
        // Create a new marker since you may need more than one
        location.marker = new google.maps.Marker({
          position: new google.maps.LatLng(location.latitude, location.longitude),
          map: map,
          title: location.title
        });

        // Add marker to the map
        location.marker.setMap(map);
      }

      function addInfoWindow(mapObject) {
        mapObject.infoWindow = new google.maps.InfoWindow();
        // Add click event to marker
        google.maps.event.addListener(mapObject.marker, 'click', function () {
          // Add HTML content for window
          mapObject.infoWindow.setContent(mapObject.infoContent);
          // Open the window
          mapObject.infoWindow.open(map, mapObject.marker);
        });
      }

      // ************************************
      // Public Functions
      // ************************************
      return {
        "initialize": initialize,
      }
    })();
  </script>
  <!-- <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbj0zB-KPTqxlLn_jtJ9OA225OAFu1CUg&callback=gmapController.initialize"
    type="text/javascript"></script> -->
  <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOBL3F0N318HbvolmOffxX8hqnxy4YotY&callback=gmapController.initialize"></script> -->
  <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcg5Y2D1fpGI12T8wcbtPIsyGdw-_NV1Y&callback=gmapController.initialize"></script> -->
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSddmB9MMTbkGJCCcfaTf7tC5miSAcQy8&callback=gmapController.initialize"></script>
</body>
</html>