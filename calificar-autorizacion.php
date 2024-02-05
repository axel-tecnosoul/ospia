<?php 
require_once("admin/config.php"); 
require_once 'admin/database.php';
?>
<!doctype html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="theme-color" content="#000000">
  <title>CALIFICAR AUTORIZACION</title>
  <meta name="description" content="Mobilekit HTML Mobile UI Kit">
  <meta name="keywords" content="bootstrap 5, mobile template, cordova, phonegap, mobile, html" />
  <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="manifest" href="__manifest.json">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <style>
	p.clasificacion {
	  position: relative;
	  overflow: hidden;
	  display: inline-block;
	}

	p.clasificacion input {
	  position: absolute;
	  top: -100px;
	}

	p.clasificacion label {
	  float: right;
	  color: #333;
	}

	p.clasificacion label:hover,
	p.clasificacion label:hover ~ label,
	p.clasificacion input:checked ~ label {
	  color: #dd4;
	}
  </style>
</head>

<body class="bg1">
  
  <!-- App Capsule -->
  <div id="appCapsule" class="pt-0">
    <div class="login-form mt-1">
      <div class="section animate__animated animate__zoomIn">
        <img src="assets/img/logo.png" alt="image" width="95%" id="logo">
      </div>
      <div class="section mt-1 animate__animated animate__fadeInRight">
        <h1>Calificar Atención Recibida</h1>
      </div>
      
        <form action="enviar-calificacion-autorizacion.php" method="post">
		<div style="background-color:#FFFFFF;margin-left:50px;margin-right:50px;border-radius:15px;">
			<br><br>
			¿Cómo considera que fue atendido?
			<div class="form-group boxed">
			<p class="clasificacion" style="font-size:24px;">
			  <input id="radio1" type="radio" name="atencion" value="5">
			  <label for="radio1">★</label>
			  <input id="radio2" type="radio" name="atencion" value="4">
			  <label for="radio2">★</label>
			  <input id="radio3" type="radio" name="atencion" value="3">
			  <label for="radio3">★</label>
			  <input id="radio4" type="radio" name="atencion" value="2">
			  <label for="radio4">★</label>
			  <input id="radio5" type="radio" name="atencion" value="1">
			  <label for="radio5">★</label>
			</p>
			</div>
		  ¿Le cobraron copago?
		  <div class="form-group boxed">
			<p class="">
			  <input id="radio11" type="radio" name="copago" value="1">
			  <label for="radio11">SI</label>
			  <input id="radio12" type="radio" name="copago" value="0">
			  <label for="radio12">NO</label>
			</p>
			</div>
		  ¿Cómo califica al prestador?
		  <div class="form-group boxed">
			<p class="clasificacion" style="font-size:24px;">
			  <input id="radio6" type="radio" name="prestador" value="5">
			  <label for="radio6">★</label>
			  <input id="radio7" type="radio" name="prestador" value="4">
			  <label for="radio7">★</label>
			  <input id="radio8" type="radio" name="prestador" value="3">
			  <label for="radio8">★</label>
			  <input id="radio9" type="radio" name="prestador" value="2">
			  <label for="radio9">★</label>
			  <input id="radio10" type="radio" name="prestador" value="1">
			  <label for="radio10">★</label>
			</p>
			</div>
		  </div>
          <div class="button">
            <button type="submit" class="btn btn-primary btn-block btn-lg bt4">Enviar Encuesta</button>
			<input type="hidden" name="codAut" value="<?php echo $_GET['codAut']; ?>" />
          </div>
        </form>
      
    </div>
	</div>

  </div>
  <!-- * App Capsule -->

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

</body>

</html>