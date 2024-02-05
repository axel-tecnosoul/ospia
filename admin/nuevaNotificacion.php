<?php
    require("config.php");
    if(empty($_SESSION['user']))
    {
        header("Location: index.php");
        die("Redirecting to index.php"); 
    }
	
	require 'database.php';
	
	if ( !empty($_POST)) {
		
		// insert data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$sql = "INSERT INTO notificaciones (asunto, mensaje, fecha_hora, ejecutada) VALUES (?,?,?,0)";
		$q = $pdo->prepare($sql);
		$q->execute(array($_POST['asunto'],$_POST['mensaje'],$_POST['fecha_hora']));
		$id_notificacion = $pdo->lastInsertId();

		if (empty($_POST['usuarios'])) {
			$sql = " SELECT id FROM usuarios WHERE notif_push=1 AND token_app!=''";
			foreach ($pdo->query($sql) as $row) {
			  $sql = "INSERT INTO notificaciones_lecturas (id_notificacion, id_usuario, fecha_hora, enviada, leida) VALUES (?,?,?,0,0)";
			  $q = $pdo->prepare($sql);
			  $q->execute(array($id_notificacion,$row['id'],$_POST['fecha_hora']));
			}
		} else {
			foreach ($_POST['usuarios'] as $item) {
			  $sql = "INSERT INTO notificaciones_lecturas (id_notificacion, id_usuario, fecha_hora, enviada, leida) VALUES (?,?,?,0,0)";
			  $q = $pdo->prepare($sql);
			  $q->execute(array($id_notificacion,$item,$_POST['fecha_hora']));
			}
		}

		Database::disconnect();
		
		header("Location: listarNotificaciones.php");
	}
	
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include('head_forms.php');?>
	<link rel="stylesheet" type="text/css" href="assets/css/select2.css">
  </head>
  <body>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper">
	  <?php include('header.php');?>
	  
      <!-- Page Header Start-->
      <div class="page-body-wrapper">
		<?php include('menu.php');?>
        <!-- Page Sidebar Start-->
        <!-- Right sidebar Ends-->
        <div class="page-body">
          <div class="container-fluid">
            <div class="page-header">
              <div class="row">
                <div class="col">
                  <div class="page-header-left">
                    <h3>Ospia APP - Administración</h3>
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="#"><i data-feather="home"></i></a></li>
                      <li class="breadcrumb-item">Nueva Notificación</li>
                    </ol>
                  </div>
                </div>
                <!-- Bookmark Start-->
                <div class="col">
                  <div class="bookmark pull-right">
                    <ul>
                      <li><a  target="_blank" data-container="body" data-toggle="popover" data-placement="top" title="" data-original-title="<?php echo date('d-m-Y');?>"><i data-feather="calendar"></i></a></li>
                    </ul>
                  </div>
                </div>
                <!-- Bookmark Ends-->
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h5>Nueva Notificación</h5>
                  </div>
				  <form class="form theme-form" role="form" method="post" action="nuevaNotificacion.php">
                    <div class="card-body">
                      <div class="row">
                        <div class="col">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Usuarios</label>
								<div class="col-sm-9">
								<select class="js-example-basic-multiple col-sm-12" name="usuarios[]" id="usuarios[]" multiple="multiple">
								  <?php
									$pdo = Database::connect();
									$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									$sqlZon = "SELECT id, nombre_apellido FROM usuarios WHERE notif_push=1 AND token_app != ''";
									$q = $pdo->prepare($sqlZon);
									$q->execute();
									while ($fila = $q->fetch(PDO::FETCH_ASSOC)) {
										echo "<option value='".$fila['id']."'";
										echo ">".$fila['nombre_apellido']."</option>";
									}
									Database::disconnect();
									?>
								</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Fecha Hora</label>
								<div class="col-sm-9"><input name="fecha_hora" type="datetime-local" class="form-control" value="" required="required"></div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Asunto</label>
								<div class="col-sm-9"><input name="asunto" type="text" maxlength="99" class="form-control" value="" required="required"></div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Mensaje</label>
								<div class="col-sm-9"><textarea name="mensaje" class="form-control" required="required"></textarea></div>
							</div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <div class="col-sm-9 offset-sm-3">
                        <button class="btn btn-success" type="submit">Crear</button>
						<a href="listarNotificaciones.php" class="btn btn-light">Volver</a>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
		<?php include("footer.php"); ?>
      </div>
    </div>
    <!-- latest jquery-->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap js-->
    <script src="assets/js/bootstrap/popper.min.js"></script>
    <script src="assets/js/bootstrap/bootstrap.js"></script>
    <!-- feather icon js-->
    <script src="assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="assets/js/icons/feather-icon/feather-icon.js"></script>
    <!-- Sidebar jquery-->
    <script src="assets/js/sidebar-menu.js"></script>
    <script src="assets/js/config.js"></script>
    <!-- Plugins JS start-->
    <script src="assets/js/typeahead/handlebars.js"></script>
    <script src="assets/js/typeahead/typeahead.bundle.js"></script>
    <script src="assets/js/typeahead/typeahead.custom.js"></script>
    <script src="assets/js/chat-menu.js"></script>
    <script src="assets/js/tooltip-init.js"></script>
    <script src="assets/js/typeahead-search/handlebars.js"></script>
    <script src="assets/js/typeahead-search/typeahead-custom.js"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="assets/js/script.js"></script>
    <!-- Plugin used-->
	<script src="assets/js/select2/select2.full.min.js"></script>
    <script src="assets/js/select2/select2-custom.js"></script>
  </body>
</html>