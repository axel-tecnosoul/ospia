<?php
//var_dump($_POST);
/*var_dump($_GET);
var_dump($_REQUEST);
var_dump($_SERVER);*/

/*
{
  "asunto": "Asunto del mensaje",
  "mensaje": "Contenido del mensaje",
  "fecha_hora": "2024-02-19 10:30",
  "personas_id": [123, 456, 789]
}
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  //$json = file_get_contents('php://input');
  //var_dump($json);
  //$datos = json_decode($json, true); // Decodificar el JSON en un array asociativo
  //var_dump($datos);
  
  // Verificar si se recibieron todos los datos necesarios
  if(isset($_POST['asunto'], $_POST['mensaje'], $_POST['fecha_hora'], $_POST['personas_id'], $_POST['mostrar_en_app'])) {

    require("admin/config.php");
    require 'admin/database.php';
      
    // Aquí puedes acceder a los datos recibidos
    $asunto = $_POST['asunto'];
    $mensaje = $_POST['mensaje'];
    $fecha_hora = $_POST['fecha_hora'];
    $personas_id = $_POST['personas_id'];
    $mostrar_en_app = $_POST['mostrar_en_app'];
    
    // insert data
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "INSERT INTO notificaciones (asunto, mensaje, fecha_hora, mostrar_en_app, ejecutada) VALUES (?,?,?,?,0)";
    $q = $pdo->prepare($sql);
    $q->execute(array($asunto,$mensaje,$fecha_hora,$mostrar_en_app));
    $id_notificacion = $pdo->lastInsertId();

    $query = " SELECT id FROM usuarios WHERE persona_id IN ($personas_id)";
    //$query_params = array(':personas_id' => trim($personas_id));
    // Imprimir la consulta preparada con los parámetros
    //echo "Consulta preparada: " . $query . "\n";
    //echo "Parámetros: " . json_encode($query_params) . "\n";
    //die();
    try{
      $stmt = $db->prepare($query); 
      $result = $stmt->execute([]);
    } catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }

    $c=$c2=0;
    while($row = $stmt->fetch()){
      $c++;
      $sql = "INSERT INTO notificaciones_lecturas (id_notificacion, id_usuario, fecha_hora, enviada, leida) VALUES (?,?,?,0,0)";
      $q = $pdo->prepare($sql);
      // Los valores a insertar en la consulta
      $valores = [$id_notificacion, $row['id'], $fecha_hora];
      //$q->execute(array($id_notificacion,$row['id'],$fecha_hora));

      // Ejecutar la consulta y verificar si se ejecutó correctamente
      if ($q->execute($valores)) {
        //echo "La consulta se ejecutó correctamente.";
        $c2++;
      } else {
        // En caso de error, puedes imprimir el mensaje de error o manejarlo de alguna otra manera
        $errorInfo = $q->errorInfo();
        //echo "Error al ejecutar la consulta: " . $errorInfo[2];
        $respuesta=[
          "status"=> "error",
          "info"  => $errorInfo[2],
        ];
      }
    }

    Database::disconnect();
    
    // Retornar una respuesta, por ejemplo, un mensaje de éxito
    //return "Datos recibidos y procesados correctamente.";
    if($c==$c2){
      $respuesta=[
        "status"=> "ok",
        "info"  => "Todos los registros se insertaron correctamente.",
      ];
    }
  } else {
    //return "No se recibieron todos los datos necesarios.";
    $respuesta=[
      "status"=> "error",
      "info"  => "No se recibieron todos los datos necesarios.",
    ];
  }

  echo json_encode($respuesta);

}
