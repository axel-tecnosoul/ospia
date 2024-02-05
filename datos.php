<?php
require("admin/config.php"); 
require 'admin/database.php';
if(!isset($_SESSION["user"]["ficha"])){
  header("Location: page-login.php");
}
require 'admin/funciones.php';
if (!empty($_POST)) {

  function compressImage($source, $destination, $quality) { 
    // Obtenemos la información de la imagen
    $imgInfo = getimagesize($source); 
    $mime = $imgInfo['mime']; 
     
    // Creamos una imagen
    switch($mime){ 
        case 'image/jpeg': 
            $image = imagecreatefromjpeg($source); 
            break; 
        case 'image/png': 
            $image = imagecreatefrompng($source); 
            break; 
        case 'image/gif': 
            $image = imagecreatefromgif($source); 
            break; 
        default: 
            $image = imagecreatefromjpeg($source); 
    } 
     
    // Guardamos la imagen
    imagejpeg($image, $destination, $quality); 
     
    // Devolvemos la imagen comprimida
    return $destination; 
  } 

  $id = null;
  if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
  }

  if (null==$id) {
    header("Location: main-login.php");
  }
  // insert data
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $notif_push=(isset($_POST["notif_push"]) and $_POST["notif_push"]=="on") ? 1 : 0;
  $notif_whatsapp=(isset($_POST["notif_whatsapp"]) and $_POST["notif_whatsapp"]=="on") ? 1 : 0;
  $notif_email=(isset($_POST["notif_email"]) and $_POST["notif_email"]=="on") ? 1 : 0;

  //var_dump($_POST);
  
  $sql = "UPDATE usuarios set nombre_apellido = ?, dni = ?, domicilio = ?, id_provincia = ?, email = ?, celular = ?, cuit = ?, alias = ?, cbu = ?, notif_push = ?, notif_whatsapp = ?, notif_email = ?  where id = ?";
  $q = $pdo->prepare($sql);
  $q->execute([$_POST['nombre_apellido'],$_POST['dni'],$_POST['domicilio'],$_POST['id_provincia'],$_POST['email'],$_POST['celular'],$_POST['cuit'],$_POST['alias'],$_POST['cbu'],$notif_push,$notif_whatsapp,$notif_email,$_GET['id']]);
	
  $filename="";
  if (!empty($_FILES['imagen']['name'])) {
    $filename = $id.'_'.$_FILES['imagen']['name'];
    $imageTemp=$_FILES['imagen']['tmp_name'];
    $imageUploadPath='admin/usuarios/'.$filename;
    move_uploaded_file($imageTemp,$imageUploadPath);
    //$compressedImage = compressImage($imageTemp, $imageUploadPath, 50);

    $sql = "UPDATE usuarios set imagen = ? where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($filename,$id));
  }

  if(isset($_POST["clear_foto"]) and $_POST["clear_foto"]==1){
    $sql = "UPDATE usuarios set imagen = '' where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
  }

  $cbte_cbu_name="";
  if (!empty($_FILES['cbte_cbu']['name'])) {
    $cbte_cbu_name = $id.'_'.$_FILES['cbte_cbu']['name'];
    $imageTemp=$_FILES['cbte_cbu']['tmp_name'];
    $imageUploadPath='admin/usuarios/'.$cbte_cbu_name;
    //$compressedImage = compressImage($imageTemp, $imageUploadPath, 50);

    $sql = "SELECT cbte_cbu FROM usuarios where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);

    if($data["cbte_cbu"]!=$cbte_cbu_name){
      move_uploaded_file($imageTemp,$imageUploadPath);
    
      $aAdjuntosMail[]=[
        "ruta"      =>$imageUploadPath,
        "fileName"  =>$cbte_cbu_name,
      ];

      $destinatarios=[
        "cbu.app@ospiaprovincia.org"=> "CBU APP",
      ];
      $asunto="Han ingresado nuevos datos bancarios.";
      $cuerpo="Hola!
      
      El afiliado ".$_POST["nombre_apellido"]." con email ".$_POST['email']." (DNI ".$_SESSION["user"]["dni"].") ha enviado el comprobante de CBU por medio de la app.
    
      Se adjunta comprobante del CBU.
      
      GRACIAS!";
    
      $envio=enviarMail($cuenta_envio="bbdd", $destinatarios, $asunto, $cuerpo, $aAdjuntosMail);
      //var_dump($envio);

      if($envio){
        $sql = "UPDATE usuarios set cbte_cbu = ? where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($cbte_cbu_name,$id));
      }
      
      //die();
    }
  }

  if(isset($_POST["clear_cbte_cbu"]) and $_POST["clear_cbte_cbu"]==1){
    $sql = "UPDATE usuarios set cbte_cbu = '' where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
  }



  Database::disconnect();
  //var_dump($_SESSION);
  
  //die();
  header("Location: index.php");
}?>
<!doctype html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="theme-color" content="#000000">
  <title>OSPIA APP Modificar Datos</title>
  <meta name="description" content="Mobilekit HTML Mobile UI Kit">
  <meta name="keywords" content="bootstrap 5, mobile template, cordova, phonegap, mobile, html" />
  <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="manifest" href="__manifest.json">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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
          <div><strong>Cambiar datos del beneficiario</strong></div>
        </div>
      </li>
    </ul>
    <br><?php
    $query = "SELECT id, nombre_apellido, fecha_nacimiento, dni, imagen, domicilio, id_provincia, email, celular, ficha, cuit, alias, cbu, cbte_cbu, token_app, notif_push, notif_whatsapp, notif_email, persona_id, requiere_cambio_clave FROM usuarios WHERE id = :id";
    $query_params = array(':id' => $_SESSION["user"]['id']); 
    try{
      $stmt = $db->prepare($query); 
      $result = $stmt->execute($query_params); 
    } catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
    $row = $stmt->fetch();
    if($row){
      $_SESSION['user'] = $row;
    }?>
    <div class="section full mt-2 mb-2 animate__animated animate__fadeInRight">
      <div class="sectiontitle2">
        <ion-icon class="iconedbox iconedbox-lg" name="people-circle"></ion-icon>Editar mis datos personales</div>
      </div>
      <div class="section full mt-3 animate__animated animate__fadeInRight">
        <div class="wide-block pt-2 pb-2" style="text-align: center;">
          <p style="text-align: left;"><?php echo $row['nombre_apellido'];?></p>
          <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#ModalForm_<?php echo $row['id'];?>">Abrir</button>
        </div>
      </div>
    </div>
    
    <!-- Modal Form -->
    <div class="modal fade modalbox animate__animated animate__fadeInRight" id="ModalForm_<?php echo $row['id'];?>" data-bs-backdrop="static" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title"><?php echo $row['nombre_apellido'];?></h3>
          </div>
          <div class="modal-body">
            <div class="login-form">
              <div class="section mt-2">
                  
              </div>
              <div class="section mt-4 mb-5">
                <form name="form_<?php echo $row['id'];?>" method="post" action="datos.php?id=<?php echo $row['id'];?>" enctype="multipart/form-data">
                  <div class="form-group boxed custom__form">
                    <h3 class="titulo1">Agregar foto 4x4</h3>
                    <div class="custom__image-container1">
                      <label id="add-foto-label" for="add-single-foto"><?php
                        if($row['imagen']!=""){
                          $style="";
                          $img="admin/usuarios/".$row['imagen'];?>
                          <img src="<?=$img?>" alt='<?=$img?>'><?php
                        }else{
                          $style="display:none;";
                          echo "+";
                        }?>
                      </label>
                      <input type="file" name="imagen" id="add-single-foto" capture/>
                    </div>
                    <div align="center"><!--  style="margin:10px" -->
                      <input type="hidden" name="clear_foto" id="clear_foto_yes_no">
                      <div id="clear_foto" class="bg-danger" style="border-radius: 5px;margin-top: 15px;<?=$style?>"><ion-icon name="trash"></ion-icon> Borrar foto</div>
                    </div>
                    <!-- <br /> -->
                  </div>
                  <div class="form-group basic">
                    <div class="input-wrapper">
                      <label class="form-label" for="nombre_apellido">Nombre y Apellido</label>
                      <input type="text" class="form-control" name="nombre_apellido" id="nombre_apellido" value="<?php echo $row['nombre_apellido']; ?>" placeholder="Nombre y Apellido">
                      <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                      </i>
                    </div>
                  </div>
                  <div class="form-group basic">
                    <div class="input-wrapper">
                      <label class="form-label" for="dni">DNI</label>
                      <input type="text" class="form-control" id="dni" name="dni" value="<?php echo $row['dni']; ?>" placeholder="Número de DNI">
                      <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                      </i>
                    </div>
                  </div>
                  <div class="form-group basic">
                    <div class="input-wrapper">
                      <label class="form-label" for="email">E-mail</label>
                      <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" placeholder="Tu e-mail">
                      <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                      </i>
                    </div>
                  </div>
                  <div class="form-group basic">
                    <div class="input-wrapper">
                      <label class="form-label" for="celular">Celular</label>
                      <input type="text" class="form-control" id="celular" name="celular" required value="<?php echo $row['celular']; ?>" placeholder="Número de Celular">
                      <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                      </i>
                    </div>
                  </div>
                  <div class="form-group basic">
                    <div class="input-wrapper">
                      <label class="form-label" for="domicilio">Domicilio</label>
                      <input type="text" class="form-control" id="domicilio" name="domicilio" required value="<?php echo $row['domicilio']; ?>" placeholder="Domicilio Completo">
                      <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                      </i>
                    </div>
                  </div>
                  <div class="form-group basic">
                    <label class="form-label" for="id_provincia">Provincia</label>
                    <select name="id_provincia" id="id_provincia" class="form-control col-sm-12" required="required">
                      <option value="">Seleccione...</option><?php
                      $pdo = Database::connect();
                      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                      $sqlZon = "SELECT `id`, `provincia` FROM `provincias` ";
                      $q = $pdo->prepare($sqlZon);
                      $q->execute();
                      while ($fila = $q->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='".$fila['id']."'";
                        if ($fila['id'] == $row['id_provincia']) {
                          echo " selected ";
                        }
                        echo ">".$fila['provincia']."</option>";
                      }
                      Database::disconnect();?>
                    </select>
                  </div>
				  <?php 
				  if ($_SESSION['titular']==1) {
				  ?>
                  <div class="form-group mt-2">
                    <h3 style="color:black">Datos Bancarios</h3>
                  </div>
                  <div class="form-group basic">
                    <div class="input-wrapper">
                      <label class="form-label" for="cuit">CUIT</label>
                      <input type="number" class="form-control" id="cuit" name="cuit" value="<?php echo $row['cuit']; ?>" placeholder="Tu CUIT sin guiones">
                      <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                      </i>
                    </div>
                  </div>
                  <div class="form-group basic">
                    <div class="input-wrapper">
                      <label class="form-label" for="alias">Alias</label>
                      <input type="text" class="form-control" id="alias" name="alias" value="<?php echo $row['alias']; ?>" placeholder="El alias de tu cuenta bancaria">
                      <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                      </i>
                    </div>
                  </div>
                  <div class="form-group basic">
                    <div class="input-wrapper">
                      <label class="form-label" for="cbu">CBU</label>
                      <input type="number" class="form-control" id="cbu" name="cbu" value="<?php echo $row['cbu']; ?>" placeholder="El CBU de tu cuenta bancaria" size="25">
                      <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                      </i>
                    </div>
                  </div>
                  <div class="form-group boxed custom__form">
                    <h3 class="titulo1">Comprobante de CBU</h3>
                    <div class="custom__image-container1">
                      <label id="add-cbte-cbu-label" for="add-single-cbte-cbu"><?php
                        if($row['cbte_cbu']!=""){
                          $style="";
                          $img="admin/usuarios/".$row['cbte_cbu'];?>
                          <img src="<?=$img?>" alt='<?=$img?>'><?php
                        }else{
                          $style="display:none;";
                          echo "+";
                        }?>
                      </label>
                      <input type="file" name="cbte_cbu" id="add-single-cbte-cbu" />
                    </div>
                    <div align="center"><!--  style="margin:10px" -->
                      <input type="hidden" name="clear_cbte_cbu" id="clear_cbte_cbu_yes_no">
                      <div id="clear_cbte_cbu" class="bg-danger" style="border-radius: 5px;margin-top: 15px;<?=$style?>"><ion-icon name="trash"></ion-icon> Borrar comprobante</div>
                    </div>
                    <!-- <br /> -->
                  </div>
				  <?php } ?>
                  <div class="form-group mt-2">
                    <h3 style="color:black">Notificaciones</h3>
                  </div>
                  <ul class="listview image-listview" style="border-top: inherit;border-bottom: inherit;">
                    <li>
                      <div class="item">
                        <div class="icon-box">
                          <ion-icon name="phone-portrait"></ion-icon>
                        </div>
                        <div class="in">
                          <div>Notificaciones</div>
                          <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="notif_push" role="switch" id="flexSwitchCheckDefault" <?=($row['notif_push'])?"checked":""?>>
                            <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="item">
                        <div class="icon-box">
                          <ion-icon name="logo-whatsapp"></ion-icon>
                        </div>
                        <div class="in">
                          <div>Whatsapp</div>
                          <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="notif_whatsapp" role="switch" id="flexSwitchCheckDefault" <?=($row['notif_whatsapp'])?"checked":""?>>
                            <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                          </div>
                        </div>
                      </div>
                    </li>
                    <!-- <li>
                      <div class="item">
                        <div class="icon-box">
                          <ion-icon name="mail"></ion-icon>
                        </div>
                        <div class="in">
                          <div>Email</div>
                          <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="notif_email" role="switch" id="flexSwitchCheckDefault" <?=($row['notif_email'])?"checked":""?>>
                            <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                          </div>
                        </div>
                      </div>
                    </li> -->
                  </ul>
                  <div class="mt-2">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Modificar</button>
                    <button type="button" class="btn btn-primary btn-block btn-lg" data-bs-dismiss="modal">Cerrar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- * Modal Form -->

    <!-- * App Bottom Menu --><?php
    include_once("footer.php")?>
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
    <script>
      
      /*function modificarImagen(){
        $("#add-single-foto").click();
      }*/
      
      var fileUpload = document.getElementById('add-single-foto');
      fileUpload.onchange = function (e) {
        console.log(this);
        console.log(e);
        readFile(e.srcElement);
        var q=$('#q');
        //console.log(q.val());
        if(q.val()=="update"){
          bootbox.confirm({
            //title: "Destroy planet?",
            //size: "large",
            message: "Está por subir la imagen seleccionada. Si ya habia una imagen, esta será reemplazada.\n\n ¿Está seguro que desea continuar?",
            buttons: {
              cancel: {
                label: '<i class="fas fa-times"></i> No'
              },
              confirm: {
                label: '<i class="fas fa-check"></i> Si'
              }
            },
            callback: function (result) {
              if(result==true){
                //form.submit();
              }else{
                fileUpload.value="";
                document.getElementById('foto-preview').innerHTML="";
              }
            }
          });
        }
      }

      function readFile(input) {
        //$("#clear_foto").css("d-none");
        $("#clear_foto").css("display","block");
        $("#clear_foto_yes_no").val(0)
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            var fotoPreview = document.createElement('img');
            fotoPreview.id = 'foto-preview';
            fotoPreview.width = 350;
            //e.target.result contents the base64 data from the image uploaded
            fotoPreview.src = e.target.result;
            //console.log(e.target.result);
      
            //var previewZone = document.getElementById('foto-preview');
            var previewZone = document.getElementById('add-foto-label');
            previewZone.innerHTML="";
            previewZone.appendChild(fotoPreview);
          }
      
          reader.readAsDataURL(input.files[0]);
        }
      }

      $("#clear_foto").on("click",function(){
        //$(this).addClass("d-none");
        $(this).css("display","none");
        document.getElementById('add-foto-label').innerHTML="+";
        document.getElementById('add-single-foto').value=null;
        $("#clear_foto_yes_no").val(1)
      });

      var fileUpload = document.getElementById('add-single-cbte-cbu');
      fileUpload.onchange = function (e) {
        console.log(this);
        console.log(e);
        readCbteCBU(e.srcElement);
        var q=$('#q');
        //console.log(q.val());
        if(q.val()=="update"){
          bootbox.confirm({
            //title: "Destroy planet?",
            //size: "large",
            message: "Está por subir el comprobante seleccionado. Si ya habia un comprobante, este será reemplazada.\n\n ¿Está seguro que desea continuar?",
            buttons: {
              cancel: {
                label: '<i class="fas fa-times"></i> No'
              },
              confirm: {
                label: '<i class="fas fa-check"></i> Si'
              }
            },
            callback: function (result) {
              if(result==true){
                //form.submit();
              }else{
                fileUpload.value="";
                document.getElementById('cbte_cbu_preview').innerHTML="";
              }
            }
          });
        }
      }

      function readCbteCBU(input) {
        //$("#clear_cbte_cbu").css("d-none");
        $("#clear_cbte_cbu").css("display","block");
        $("#clear_cbte_cbu_yes_no").val(0)
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            var cbte_cbu_preview = document.createElement('img');
            cbte_cbu_preview.id = 'cbte_cbu_preview';
            cbte_cbu_preview.width = 350;
            //e.target.result contents the base64 data from the image uploaded
            cbte_cbu_preview.src = e.target.result;
            //console.log(e.target.result);
      
            //var previewZone = document.getElementById('cbte_cbu_-preview-zone');
            var previewZone = document.getElementById('add-cbte-cbu-label');
            previewZone.innerHTML="";
            previewZone.appendChild(cbte_cbu_preview);
          }
      
          reader.readAsDataURL(input.files[0]);
        }
      }

      $("#clear_cbte_cbu").on("click",function(){
        //$(this).addClass("d-none");
        $(this).css("display","none");
        document.getElementById('add-cbte-cbu-label').innerHTML="+";
        document.getElementById('add-single-cbte-cbu').value=null;
        $("#clear_cbte_cbu_yes_no").val(0)
      });
    </script>

</body>

</html>