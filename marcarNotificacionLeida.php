<?php
    require("admin/config.php");
    if (empty($_SESSION['user'])) {
        header("Location: index.php");
        die("Redirecting to index.php");
    }
    
    require 'admin/database.php';

    $id = null;
    if (!empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
    
    if (null==$id) {
        header("Location: index.php");
    }
    
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    $sql = "update `notificaciones_lecturas` set leida = 1 WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute([$id]);
        
    Database::disconnect();
        
    header("Location: notificaciones.php");
