<?php
include_once("admin/config.php");
include_once("admin/database.php");
include_once("admin/funciones.php");

$id_persona=$_POST["id_persona"];
$es_titular=$_POST["es_titular"];

/*$id_persona=101146;
$es_titular=false;*/

//$id_persona=2;
$url=$url_ws."?Modo=7&Usuario=$usuario_ws&Persona=$id_persona";
//var_dump($url);
$jsonData = json_decode(file_get_contents($url),true);
/*$resp=file_get_contents($url);
$jsonData = json_decode($resp,true);*/
//var_dump($jsonData);

if($jsonData){

  function draw_roundrectangle($img, $x1, $y1, $x2, $y2, $radius, $color,$filled=1) {
    // With this function you will draw rounded corners rectangles with transparent colors.
    // Empty (not filled) figures are allowed too!!
    if ($filled==1){
        imagefilledrectangle($img, $x1+$radius, $y1, $x2-$radius, $y2, $color);
        imagefilledrectangle($img, $x1, $y1+$radius, $x1+$radius-1, $y2-$radius, $color);
        imagefilledrectangle($img, $x2-$radius+1, $y1+$radius, $x2, $y2-$radius, $color);

        imagefilledarc($img,$x1+$radius, $y1+$radius, $radius*2, $radius*2, 180 , 270, $color, IMG_ARC_PIE);
        imagefilledarc($img,$x2-$radius, $y1+$radius, $radius*2, $radius*2, 270 , 360, $color, IMG_ARC_PIE);
        imagefilledarc($img,$x1+$radius, $y2-$radius, $radius*2, $radius*2, 90 , 180, $color, IMG_ARC_PIE);
        imagefilledarc($img,$x2-$radius, $y2-$radius, $radius*2, $radius*2, 360 , 90, $color, IMG_ARC_PIE);
    }else{
        imageline($img, $x1+$radius, $y1, $x2-$radius, $y1, $color);
        imageline($img, $x1+$radius, $y2, $x2-$radius, $y2, $color);
        imageline($img, $x1, $y1+$radius, $x1, $y2-$radius, $color);
        imageline($img, $x2, $y1+$radius, $x2, $y2-$radius, $color);

        imagearc($img,$x1+$radius, $y1+$radius, $radius*2, $radius*2, 180 , 270, $color);
        imagearc($img,$x2-$radius, $y1+$radius, $radius*2, $radius*2, 270 , 360, $color);
        imagearc($img,$x1+$radius, $y2-$radius, $radius*2, $radius*2, 90 , 180, $color);
        imagearc($img,$x2-$radius, $y2-$radius, $radius*2, $radius*2, 360 , 90, $color);
    }
  }

  //var_dump($jsonData);
  //echo $jsonData;

  $apellido=$jsonData["Apellido"];
  $nombre=$jsonData["Nombre"];
  $nombre_apellido=$apellido.", ".$nombre;
  $caracter=$jsonData["Caracter"];
  $plan=$jsonData["Plan"];
  $beneficiario=$jsonData["Documento"];
  $coseguro=$jsonData["Coseguro"];
  $token=$jsonData["Token"];
  //$token="a28e8f33";

  /*$apellido="BELETZKI";
  $nombre="JORGE RICARDO ROBERTO";
  $nombre_apellido=$apellido.", ".$nombre;
  $caracter="Titular";
  $plan="A";
  $beneficiario="28833213";*/
  //$coseguro="Coseguro";

  // Crear la imagen usando la imagen base
  //$imagen_fondo = imagecreatefrompng('assets/img/credencial_modelo.png');
  //$image = imagecreatefrompng('assets/img/credencial_modelo.png');
  $image = imagecreatefrompng('assets/img/credencial_modelo_chica.png');
  
  //$image = imagecreatefrompng('assets/img/credencial_modelo_completa_chica.png');

  imagealphablending($image, false);
  $transparency = imagecolorallocatealpha($image, 0, 0, 0, 127);
  imagefill($image, 0, 0, $transparency);
  imagesavealpha($image, true);

  // Asignar el color para el texto
  $black_color = imagecolorallocate($image, 0, 0, 0);
  $white_color = imagecolorallocate($image, 255, 255, 255);

  // Asignar la ruta de la fuente
  //$font_path = __DIR__.'/assets/arial.ttf';
  $font_path = __DIR__.'/assets/arial-bold.ttf';

  //imagecopy($image, $imagen_fondo, 0, 0, 0, 0, 100, 100);
  $scale_img_x=250;
  $scale_img_y=249;
  //$es_titular llega como un string
  if($es_titular=="true" and $_SESSION["user"]["imagen"]!=""){
    $imagen='admin/usuarios/'.$_SESSION["user"]["imagen"];
    $foto_perfil = imagecreatefromstring(file_get_contents($imagen));
    list($width, $height) = getimagesize($imagen);
    if ($width > $height) {
        //Landscape
        $foto_perfil = imagerotate($foto_perfil, 270, 0);
    } else {
        //Portrait or Square
    }
    /*$foto_perfil = imagecreatefromjpeg($imagen);
    var_dump($foto_perfil);
    if($foto_perfil===false){
      $foto_perfil = imagecreatefrompng($imagen);
      var_dump($foto_perfil);
    }*/
    //$foto_perfil = imagecreatefromjpeg('admin/usuarios/1_flor-cs.jpg');
    $foto = imagescale($foto_perfil,$scale_img_x,$scale_img_y,IMG_BICUBIC_FIXED);
    //$foto = $foto_perfil;
    //imagecopy($image, $foto, 32, 12, 0, 0, $scale_img_x, $scale_img_y);
    imagecopy($image, $foto, 165, 140, 0, 0, $scale_img_x, $scale_img_y);
  }

  $font_color=$black_color;
  $font_color=$white_color;

  //imagecopy($image, $foto, 32, 128, 148, 12, 10, 100);
  imagettftext($image, 22, 0, 14, 433, $font_color, $font_path, $apellido); // Colocar el Slogan
  imagettftext($image, 22, 0, 14, 472, $font_color, $font_path, $nombre); // Colocar el Slogan
  //imagettftext($image, 14, 0, 40, 152, $font_color, $font_path, $nombre_apellido); // Colocar el Slogan
  imagettftext($image, 22, 0, 14, 513, $font_color, $font_path, "D.N.I. ".$beneficiario); // Colocar el domicilio linea 1 en la imagen
  imagettftext($image, 22, 0, 14, 553, $font_color, $font_path, $caracter); // Colocar el nombre en la imagen
  imagettftext($image, 22, 0, 14, 595, $font_color, $font_path, "Plan ".$plan); // Colocar el puesto en la imagen
  imagettftext($image, 22, 0, 50, 655, $font_color, $font_path, "Token"); // Colocar el puesto en la imagen
  imagettftext($image, 22, 0, 250, 655, $font_color, $font_path, $token); // Colocar el puesto en la imagen

  //draw_roundrectangle($image, $x1=30, $y1=625, $x2=400, $y2=665, $radius=10, $color=$font_color,$filled=0);
  
  //imagettftext($image, 14, 0, 165, 252, $font_color, $font_path, $coseguro); // Colocar el domicilio linea 2 en la imagen

  // Guardar la imagen en el servidor
  $filename = "credencial/credencial-".date("Ymdhis").".png";
  //$filename = "credential.png";
  $result=imagepng($image, $filename,9);
  
  $resp=0;
  if($result){
    $resp=$filename;
  }

  imagedestroy($image); // Limpiar la memoria
  //echo "<a href='".$filename."'>$filename</a>"; // Mostrar el enlace para ver la imagen
  //echo "<img src='".$filename."' alt='".$filename."'></img>"; // Mostrar el enlace para ver la imagen
  echo json_encode([
    "json_ok"=>1,
    "resp"=>$resp
  ]);
}else{
  echo json_encode([
    "json_ok"=>0,
    "resp"=>$resp
  ]);
}
?>