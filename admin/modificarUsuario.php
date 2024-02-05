<?php
    require("config.php");
    if (empty($_SESSION['user'])) {
        header("Location: index.php");
        die("Redirecting to index.php");
    }
    
    require 'database.php';

    $id = null;
    if (!empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
    
    if (null==$id) {
        header("Location: listarUsuarios.php");
    }
    
    if (!empty($_POST)) {
        
        // insert data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = "UPDATE `usuarios` set `nombre_apellido` = ?, `fecha_nacimiento` = ?, `dni` = ?, `domicilio` = ?, `id_provincia` = ?, `email` = ?, `celular` = ? where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute([$_POST['nombre_apellido'],$_POST['fecha_nacimiento'],$_POST['dni'],$_POST['domicilio'],$_POST['id_provincia'],$_POST['email'],$_POST['celular'],$_GET['id']]);
        
        if (!empty($_POST['clave1'])) {
            $sql = "UPDATE `usuarios` set `clave`= ? where id = ?";
            $q = $pdo->prepare($sql);
            $q->execute([$_POST['clave1'],$_GET['id']]);
        }
		
		if (!empty($_FILES['imagen']['name'])) {
			$filename = $_FILES['imagen']['name'];
			move_uploaded_file($_FILES['imagen']['tmp_name'],'usuarios/'.$id.'_'.$filename);
				
			$sql = "update `usuarios` set imagen = ? where id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id.'_'.$filename,$id));
		}
        
        Database::disconnect();
        
        header("Location: listarUsuarios.php");
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT `id`, `nombre_apellido`, `fecha_nacimiento`, `dni`, `imagen`, `domicilio`, `id_provincia`, `email`, `celular`, `clave`, `requiere_cambio_clave` FROM `usuarios` WHERE id = ? ";
        $q = $pdo->prepare($sql);
        $q->execute([$id]);
        $data = $q->fetch(PDO::FETCH_ASSOC);
        
        Database::disconnect();
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
        <div class="page-body"><?php
          $ubicacion="Modificar Usuario";
          include_once("head_page.php")?>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h5><?=$ubicacion?></h5>
                  </div>
				  <form class="form theme-form" role="form" method="post" action="modificarUsuario.php?id=<?php echo $id?>" enctype="multipart/form-data">
                    <div class="card-body">
                      <div class="row">
                        <div class="col">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Nombre y Apellido</label>
								<div class="col-sm-9"><input name="nombre_apellido" type="text" maxlength="99" class="form-control" value="<?php echo $data['nombre_apellido']; ?>" required="required"></div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Fecha de Nacimiento</label>
								<div class="col-sm-9"><input name="fecha_nacimiento" type="date" class="form-control" value="<?php echo $data['fecha_nacimiento']; ?>" required="required"></div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">DNI</label>
								<div class="col-sm-9"><input name="dni" type="text" maxlength="99" class="form-control" value="<?php echo $data['dni']; ?>" required="required"></div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Imagen Actual</label>
								<div class="col-sm-9"><img src="usuarios/<?php echo $data['imagen']; ?>" width="200px" /></div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Nueva Imagen</label>
								<div class="col-sm-9"><input name="imagen" type="file" value="" class="form-control"></div>
							</div>	
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Domicilio</label>
								<div class="col-sm-9"><input name="domicilio" type="text" maxlength="299" class="form-control" value="<?php echo $data['domicilio']; ?>" required="required"></div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Provincia</label>
								<div class="col-sm-9">
								<select name="id_provincia" id="id_provincia" class="js-example-basic-single col-sm-12" required="required">
								<option value="">Seleccione...</option>
								<?php
                                $pdo = Database::connect();
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $sqlZon = "SELECT `id`, `provincia` FROM `provincias` ";
                                $q = $pdo->prepare($sqlZon);
                                $q->execute();
                                while ($fila = $q->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='".$fila['id']."'";
                                    if ($fila['id'] == $data['id_provincia']) {
                                        echo " selected ";
                                    }
                                    echo ">".$fila['provincia']."</option>";
                                }
                                Database::disconnect();
                                ?>
								</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">E-Mail</label>
								<div class="col-sm-9"><input name="email" type="email" maxlength="99" class="form-control" value="<?php echo $data['email']; ?>" required="required"></div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Celular</label>
								<div class="col-sm-9"><input name="celular" type="text" maxlength="99" class="form-control" value="<?php echo $data['celular']; ?>" required="required"></div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Contraseña</label>
								<div class="col-sm-9"><input name="clave1" id="password" type="password" maxlength="99" class="form-control"></div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Repetir Contraseña</label>
								<div class="col-sm-9"><input name="clave2" id="confirm_password" type="password" maxlength="99" class="form-control"></div>
							</div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <div class="col-sm-9 offset-sm-3">
                        <button class="btn btn-success" type="submit">Modificar</button>
						<a onclick="document.location.href='listarUsuarios.php'" class="btn btn-light">Volver</a>
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
	<script>
	var password = document.getElementById("password")
	  , confirm_password = document.getElementById("confirm_password");

	function validatePassword(){
	  if(password.value != confirm_password.value) {
		confirm_password.setCustomValidity("Las claves no coinciden");
	  } else {
		confirm_password.setCustomValidity('');
	  }
	}

	password.onchange = validatePassword;
	confirm_password.onkeyup = validatePassword;
	</script>
  </body>
</html>