<?php 
    require("admin/config.php"); 
    unset($_SESSION['user']);
    header("Location: check_token_app.php"); 
    die("Redirecting to: check_token_app.php");
?> 