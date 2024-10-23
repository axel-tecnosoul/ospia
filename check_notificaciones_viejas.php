<?php
require "admin/config.php";
require "admin/database.php";

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "DELETE FROM notificaciones_lecturas WHERE enviada=0 AND DATEDIFF(NOW(),fecha_hora)>=7";
$q = $pdo->prepare($sql);
$q->execute();
$afe=$q->rowCount();
echo "<br>Afe: ".$afe;

$sql = "UPDATE usuarios SET token_app=NULL WHERE token_app='1234' AND id!=20";
$q = $pdo->prepare($sql);
$q->execute();
$afe=$q->rowCount();
echo "<br>Afe: ".$afe;

Database::disconnect();
$pdo = null; // Libera la referencia en la variable local
?>