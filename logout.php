<?php
require("admin/config.php");
$nueva_app=$_SESSION['nueva_app'];
//var_dump($_SESSION);
//die();
unset($_SESSION['user']);
header("Location: check_token_app.php?token=".$token."&nueva_app=".$nueva_app);
die("Redirecting to: check_token_app.php");
?> 