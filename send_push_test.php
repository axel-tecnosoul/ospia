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
//$server_key = 'AAAAWv3X-68:APA91bHYHwsOQrKKs4fIIAx2K5e1hVCQJCa-IaQDnUa0TUz_MIkC_uesPqdoY0Yxt6CNPvpwf-dkLJ7NZhRin_H4qImiJI_Zs-ddD7ALdeWDaYhNSIo0LZR2LWvoOfroqpwBMBMJtKfR';
$server_key = 'AAAAwX7IHbg:APA91bGGqGNPBel8rfonJYgx7Cu6wvFu_Y-0aaVzOjL_0mUAhI8Jxomfm0yuVmhdBHS03O7R9WMhAq0QTE2J_OdJYOyUGxq3KcDf8mVpMJQZgsgS4ow47917vebcvLjgm50lZQzktLhf'; //cuenta firebase ospia

//axel
//$token="epq-f-UoSxC1k-5LIakzt1:APA91bHyYJ69jlKG_R44_WzZS4Z4EuPienUHT0ds3R530lvAmzcscUKE2x241SQ3EZajtaWvTfCIPUtxYTB_UHjlR-f6X-f4k0fquosLJX1bhf5CoVzGNmI2kI_SnjYGJD8huln7xYUw";
$token="eWhRhIz-RkcjsO5e-hnbsk:APA91bHF3bMgQI7toyQq2YPSjJEF66wdDAJFLfT93jKVgbjj8Ippj9fyU26EXjagroAwMHzTw3NBEmo2We-UFTguCHy44fFDMdKs89TYvBFh3vOZJkm5UaGSWNQTMmYyPQa_XGoPyOdg";

//mat
//$token="fFYv3CpWSaObW_js5B66d3:APA91bFHaDTd9ftn_oBiFPaq8DDaeDTWVPc4UIrUQp1begfqVF68wLz5OhL1JgDj7vgDOdpKyY8TbKK9SA5EQlGLub12fwG_vk7h0ngH9LF--VmFUuFq__umfMHCZ6GSHvAo4jAazaV5";

//Mara
//$token="dJHZZQ83ThecTQCFsufLGt:APA91bFCtl2ZO39I3J5k5LsZag1FgjLQik32EKh1u2gqiQOB2zStgymS17L33NcAurkq9Qo_n2x57N0WfXj1bVbq0HuFYDajK2ml25f5XjkJqIGL_3MtFw-WE4M-JimyOG4qJfk6Vhpj";
//$token="d3v5DgkcTXaHBmebu0Tg5t:APA91bHKjAEKGQY-biOoTU9Zsldul-VNtXR_Vetj-52Gmo0aa3LF-cWqx3DLORAAY0Q7LkC-hIYTfZ11lQ4Llja2VV-pHadw0-1UVBFaoibekiwQy6xJVG_lQYhhiLp0DtClAFTdhZi-";

//nelson
//$token="fShLx2yCQtK-E9efeHeHrO:APA91bGSsmbhIIhdv5rgi128CLeZq_HIQ1SKFRri72p0NEk2rfuzV_YvoCYQd9eBx63yVsyt-ssxgm1WIC3hsyvwjgmbWyC2MEUN3xbTBBh4XNQG3Lj1HIzpdjuYmPYlJp25VLOYcXAz";
//$email = "nelson.murstein@gmail.com";

$client = new Client();
$client->setApiKey($server_key);
$client->injectGuzzleHttpClient(new \GuzzleHttp\Client());

$titulo='Notificacion Particular';
$cuerpo='Hola, viendo las push! ;)';

$message = new Message();
$message->setPriority('high');
$message->addRecipient(new Device($token));
$message
    ->setNotification(new Notification($titulo, $cuerpo))
    //->setData(['key' => 'value']);
    ->setData(['title' => $titulo,'body' => $cuerpo, 'notification_foreground' => 'true']);

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