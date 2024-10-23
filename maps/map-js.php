<?php
include_once("../admin/config.php");?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="endless admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, endless admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <title>Endless - Premium Admin Template</title>
    <!-- Google font-->
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/fontawesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/feather-icon.css">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/mapsjs-ui.css">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/style.css">
    <link id="color" rel="stylesheet" href="../admin/assets/css/light-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/responsive.css">
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-6">
          <div class="map-js-height" id="map12"></div>
        </div>
      </div>
    </div>
    <!-- latest jquery-->
    <script src="../admin/assets/js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap js-->
    <script src="../admin/assets/js/bootstrap/popper.min.js"></script>
    <script src="../admin/assets/js/bootstrap/bootstrap.js"></script>
    <!-- feather icon js-->
    <script src="../admin/assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="../admin/assets/js/icons/feather-icon/feather-icon.js"></script>
    <!-- Plugins JS start-->
    <script src="../admin/assets/js/tooltip-init.js"></script>
    <script src="map-js/mapsjs-core.js"></script>
    <script src="map-js/mapsjs-service.js"></script>
    <script src="map-js/mapsjs-ui.js"></script>
    <script src="map-js/mapsjs-mapevents.js"></script>
    <!-- <script src="map-js/custom.js"></script> -->
    <!-- Plugins JS Ends-->
    <!-- Plugin used-->
    <script>
      // Common settings
      var platform = new H.service.Platform({
        app_id: 'devportal-demo-20180625',
        app_code: '9v2BkviRwi9Ot26kp2IysQ',
        useHTTPS: true
      });
      var pixelRatio = window.devicePixelRatio || 1;
      var defaultLayers = platform.createDefaultLayers({
        tileSize: pixelRatio === 1 ? 256 : 512,
        ppi: pixelRatio === 1 ? undefined : 320
      });

      // map12
      function addMarkersToMap2(map) {
        var parisMarker = new H.map.Marker({lat:48.8567, lng:2.3508});
        map.addObject(parisMarker);

        var romeMarker = new H.map.Marker({lat:41.9, lng: 12.5});
        map.addObject(romeMarker);

        var berlinMarker = new H.map.Marker({lat:52.5166, lng:13.3833});
        map.addObject(berlinMarker);

        var madridMarker = new H.map.Marker({lat:40.4, lng: -3.6833});
        map.addObject(madridMarker);

        var londonMarker = new H.map.Marker({lat:51.5008, lng:-0.1224});
        map.addObject(londonMarker);
      }
      function addMarkersToMap(map) {<?php
        $url="http://www.ospiapba.org.ar/app_desarrollo/APP_ReqRes.asp?o=101208?&Especialidad=37&TipoPrestador=7";
        $jsonData = json_decode(file_get_contents($url),true);
        //var_dump($jsonData);
        foreach ($jsonData["Data"] as $row) {?>
          /*var parisMarker = new H.map.Marker({lat:<?php echo str_replace(",",".",$row["Latitud"]); ?>, lng:<?php echo str_replace(",",".",$row["Longitud"]); ?>});
          map.addObject(parisMarker);*/
          map.addObject(new H.map.Marker({lat:<?php echo str_replace(",",".",$row["Latitud"]); ?>, lng:<?php echo str_replace(",",".",$row["Longitud"]); ?>}));<?php
        }?>
      }
      var map = new H.Map(document.getElementById('map12'),
        defaultLayers.normal.map,{
        //center: {lat:50, lng:5},
        center: {lat: 43.5293101, lng: -5.6773233},
        zoom: 4,
        pixelRatio: pixelRatio
      });
      var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
      var ui = H.ui.UI.createDefault(map, defaultLayers);
      addMarkersToMap(map);
    </script>
  </body>
</html>