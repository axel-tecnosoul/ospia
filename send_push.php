<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: *");
}
require_once 'vendor/autoload.php';

use sngrl\PhpFirebaseCloudMessaging\Client;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Device;
use sngrl\PhpFirebaseCloudMessaging\Notification;

//$server_key = 'dato a configurar';
$server_key = 'AAAAWv3X-68:APA91bHYHwsOQrKKs4fIIAx2K5e1hVCQJCa-IaQDnUa0TUz_MIkC_uesPqdoY0Yxt6CNPvpwf-dkLJ7NZhRin_H4qImiJI_Zs-ddD7ALdeWDaYhNSIo0LZR2LWvoOfroqpwBMBMJtKfR';
			   
//prueba  
$token="dJHZZQ83ThecTQCFsufLGt:APA91bFCtl2ZO39I3J5k5LsZag1FgjLQik32EKh1u2gqiQOB2zStgymS17L33NcAurkq9Qo_n2x57N0WfXj1bVbq0HuFYDajK2ml25f5XjkJqIGL_3MtFw-WE4M-JimyOG4qJfk6Vhpj";
$email = "marasoledadmira@yahoo.com.ar";

$client = new Client();
$client->setApiKey($server_key);
$client->injectGuzzleHttpClient(new \GuzzleHttp\Client());

$message = new Message();
$message->setPriority('high');
$message->addRecipient(new Device($token));
$message
    ->setNotification(new Notification('Notificacion Particular', 'Hola, soy Nelson y estoy probando las push! ;)'))
    ->setData(['key' => 'value']);

$response = $client->send($message);
//
echo "<h2>Notificacion con token</h2>
<h3>Enviada a:</h3>";
echo "<h4> email: $email </h4>";
echo "<p><b>token:</b> $token </p><br><br>";
echo "<h3>Respuesta Firebase</h3>";
var_dump($response->getStatusCode());
$response_content=$response->getBody()->getContents();
$response_content=json_decode($response_content,true);
var_dump($response_content);
var_dump($response_content["success"]);

?>