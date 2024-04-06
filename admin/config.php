<?php

//LOCALHOST
$host = "localhost";
$username = "root";
$password = "";
$dbname = "ospia_app";

//PRODUCCION
/*$host = "localhost";
$username = "c2191641_db";
$password = "ne51KAwoza";
//$password = "ba58goLOde";
$dbname = "c2191641_db";*/

//TESTING
/*$host = "localhost";
$username = "ospia";
$password = "jksfjksdhfjkh123df";
$dbname = "ospia";*/

$debug=1;

$url_ws="http://www.ospiapba.org.ar/app_desarrollo/APP_ReqRes.asp";
//$url_ws="http://www.ospiapba.org.ar/app/APP_ReqRes.asp";
$usuario_ws=101208;

$options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];
try {
    $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options);
} catch (PDOException $ex) {
    die("Failed to connect to the database: " . $ex->getMessage());
}
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
header('Content-Type: text/html; charset=utf-8');
session_start();
date_default_timezone_set("America/Argentina/Buenos_Aires");
