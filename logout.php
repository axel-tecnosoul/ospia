<?php 

require("admin/config.php"); 
unset($_SESSION['user']);
header("Location: check_token_app.php?token=".$token."&nueva_app=1");
die("Redirecting to: check_token_app.php");
?> 