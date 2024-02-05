<?php
include_once("config.php");
class Database
{

  //LOCALHOST
  private static $dbHost = 'localhost' ;
  private static $dbName = 'ospia_app' ;
  private static $dbUsername = 'root';
  private static $dbUserPassword = '';

  //PRODUCCION
  /*private static $dbHost = "localhost";
  private static $dbName = "c2191641_db";
  private static $dbUsername = "c2191641_db";
  private static $dbUserPassword = "ne51KAwoza";*/
  //ba58goLOde

  private static $cont  = null;
  
  public function __construct()
  {
      exit('Init function is not allowed');
  }
  
  public static function connect()
  {
      // One connection through whole application
      if (null == self::$cont) {
          try {
              self::$cont =  new PDO("mysql:host=".self::$dbHost.";"."dbname=".self::$dbName.";charset=utf8", self::$dbUsername, self::$dbUserPassword);
          } catch (PDOException $e) {
              die($e->getMessage());
          }
      }
      return self::$cont;
  }
  
  public static function disconnect()
  {
      self::$cont = null;
  }
}
