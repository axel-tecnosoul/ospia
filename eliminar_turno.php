<?php
include_once("admin/config.php");
include_once("admin/database.php");
include_once("admin/funciones.php");

$turno=$_POST["turno"];

$url=$url_ws."?Modo=21&Turno=".$turno;

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = " SELECT l.id, l.id_notificacion, date_format(l.fecha_hora,'%d/%m/%Y %H:%i') AS fecha_hora, l.leida,n.asunto,n.mensaje FROM notificaciones_lecturas l inner join notificaciones n on n.id = l.id_notificacion WHERE enviada = 0 AND l.id_usuario = ".$_SESSION['user']['id']." and n.asunto like '%Turnos%'  and n.mensaje like '%".$turno."%'";
$q = $pdo->prepare($sql);
$q->execute();
$data = $q->fetch(PDO::FETCH_ASSOC);
$sql = "delete from `notificaciones_lecturas` where id_notificacion = ?";
$q = $pdo->prepare($sql);
$q->execute(array($data['id_notificacion']));
$sql = "delete from `notificaciones` where id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($data['id_notificacion']));

$jsonData = file_get_contents($url);
echo $jsonData;



		
	
		
		
		