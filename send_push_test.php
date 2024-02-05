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

//axel
//$token="eRHgCR77QTqmQK717ZxHTP:APA91bFoVtB64MgcQ6FI9jeDL6ZX8XP3t41H5Wqt4NssbNoCFI0k4gn-Wu9_SahrGeNQ_UuetwoW5tLT7Vjy7PJVN3ZRBcf7tG5VDuweGXIqG-CV1IRkzq_Pnf8L2iD-kv_LfcWg6YKm";
//$email = "nelson.murstein@gmail.com";

//Mara
//$token="dJHZZQ83ThecTQCFsufLGt:APA91bFCtl2ZO39I3J5k5LsZag1FgjLQik32EKh1u2gqiQOB2zStgymS17L33NcAurkq9Qo_n2x57N0WfXj1bVbq0HuFYDajK2ml25f5XjkJqIGL_3MtFw-WE4M-JimyOG4qJfk6Vhpj";
$token="d3v5DgkcTXaHBmebu0Tg5t:APA91bHKjAEKGQY-biOoTU9Zsldul-VNtXR_Vetj-52Gmo0aa3LF-cWqx3DLORAAY0Q7LkC-hIYTfZ11lQ4Llja2VV-pHadw0-1UVBFaoibekiwQy6xJVG_lQYhhiLp0DtClAFTdhZi-";

//nelson
//$token="fShLx2yCQtK-E9efeHeHrO:APA91bGSsmbhIIhdv5rgi128CLeZq_HIQ1SKFRri72p0NEk2rfuzV_YvoCYQd9eBx63yVsyt-ssxgm1WIC3hsyvwjgmbWyC2MEUN3xbTBBh4XNQG3Lj1HIzpdjuYmPYlJp25VLOYcXAz";
//$email = "nelson.murstein@gmail.com";

$client = new Client();
$client->setApiKey($server_key);
$client->injectGuzzleHttpClient(new \GuzzleHttp\Client());

$message = new Message();
$message->setPriority('high');
$message->addRecipient(new Device($token));
$message
    ->setNotification(new Notification('Notificacion Particular', 'Hola, viendo las push! ;)'))
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