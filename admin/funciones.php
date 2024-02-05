<?php
require("PHPMailer/PHPMailerAutoload.php");
require("PHPMailer/class.smtp.php");

function generarPasswordRandom(){
  $comb = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
  $pass = array(); 
  $combLen = strlen($comb) - 1; 
  for ($i = 0; $i < 12; $i++) {
      $n = rand(0, $combLen);
      $pass[] = $comb[$n];
  }
  return (implode($pass));
}

function enviarMail($cuenta_envio="bbdd", $destinatarios, $asunto, $cuerpo, $adjuntos=[]){
  /*
  $destinatarios=[
    'recipient1@domain.com'=> 'First Name',
    'recipient2@domain.com'=> 'Second Name'
  ];

  $adjuntos[]=[
      "ruta"      =>$directorio."/".$nombreArchivo,
      "fileName"  =>$nombreArchivo,
  ];
  */
  $debug=0;
  /*require("../vendor/PHPMailer-5.2.26/PHPMailerAutoload.php");
  require("../vendor/PHPMailer-5.2.26/class.smtp.php");*/
  
  require_once 'database.php';
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "SELECT id,valor FROM parametros WHERE id IN (?,?,?,?,?) ";
  $q = $pdo->prepare($sql);
  $q->execute([3,4,5,6,7]);// del 3 al 7 son los parametros estblecidos para el envío de mails
  $datosMail=[];
  while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
      $datosMail[$data["id"]]=$data["valor"];
  }
  Database::disconnect();

  $smtpHost = $datosMail[3];  //agregar servidor
  $smtpUsuario = $datosMail[4];  //agregar usuario
  $smtpClave = $datosMail[5];  //agregar contraseña
  $remitente = $datosMail[6];
  $nombre_remitente = $datosMail[7];

  if($cuenta_envio=="autorizaciones"){
    //$smtpHost = "mail.ospiapba.org.ar";  //agregar servidor
    $smtpHost = "mail.ospiaprovincia.org";  //agregar servidor
    $smtpUsuario = "autorizaciones.app@ospiaprovincia.org";  //agregar usuario
    $smtpClave = "DpYhp4Zjx(RB";  //agregar contraseña
    $remitente = $smtpUsuario;
    $nombre_remitente = "Autorizaciones OSPIA";
  }

  //var_dump($smtpUsuario);
  //var_dump($smtpClave);
  
  $mail = new PHPMailer();
  $mail->SMTPDebug = 3;//Habilitamos solo para debugguear
  $mail->IsSMTP();
  $mail->SMTPAuth = true;
  $mail->Port = 465;
  //$mail->Port = 587;
  //$mail->Port = 25;
  $mail->SMTPSecure = 'ssl';
  $mail->IsHTML(true);
  $mail->CharSet = "utf-8";
  $mail->Host = $smtpHost;
  $mail->Username = $smtpUsuario;
  $mail->Password = $smtpClave;
  $mail->From = $remitente;//"mailorigen@gmail.com"; //mail remitente
  $mail->FromName = $nombre_remitente;//"de donde sale el mail"; //remitente
  foreach ($destinatarios as $key => $value) {
      /*var_dump($key);
      var_dump($value);*/
      $email=$key;
      $name=$value;
      if(is_numeric($key)){
        $email=$value;
        $name="";
      }
      $mail->AddAddress($email, $name); //destinatario
  }
  foreach ($adjuntos as $key => $value) {
      $mail->addAttachment($value["ruta"], $value["fileName"]);
  }
  $mail->Subject = $asunto; //titulo
  $mensajeHtml = nl2br($cuerpo); //mensaje
  $mail->Body = "{$mensajeHtml} <br /><br />";
  $mail->AltBody = "{$cuerpo} \n\n";
  //var_dump($mail);
  $envio = $mail->Send();

  return $envio;
}