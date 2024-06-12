<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: *");
}

require_once 'vendor/autoload.php';

# composer require google/auth
use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;

function getAccessToken() {
    $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];
    #usar json del proyecto firebase correspondiente
    #ospia testing
    $jsonKey = 'ospiapbatesting-firebase-adminsdk-lbt4s-8db4ebc483.json';

    $credentials = new ServiceAccountCredentials($scopes, $jsonKey);
    $accessToken = $credentials->fetchAuthToken();
    
    if (!isset($accessToken['access_token'])) {
        throw new Exception('Failed to fetch access token');
    }
    
    return $accessToken['access_token'];
}


//$server_key = 'dato a configurar';
//$server_key = 'AAAAWv3X-68:APA91bHYHwsOQrKKs4fIIAx2K5e1hVCQJCa-IaQDnUa0TUz_MIkC_uesPqdoY0Yxt6CNPvpwf-dkLJ7NZhRin_H4qImiJI_Zs-ddD7ALdeWDaYhNSIo0LZR2LWvoOfroqpwBMBMJtKfR';
$server_key = 'AAAAwX7IHbg:APA91bGGqGNPBel8rfonJYgx7Cu6wvFu_Y-0aaVzOjL_0mUAhI8Jxomfm0yuVmhdBHS03O7R9WMhAq0QTE2J_OdJYOyUGxq3KcDf8mVpMJQZgsgS4ow47917vebcvLjgm50lZQzktLhf'; //cuenta firebase ospia

//axel
//$token="epq-f-UoSxC1k-5LIakzt1:APA91bHyYJ69jlKG_R44_WzZS4Z4EuPienUHT0ds3R530lvAmzcscUKE2x241SQ3EZajtaWvTfCIPUtxYTB_UHjlR-f6X-f4k0fquosLJX1bhf5CoVzGNmI2kI_SnjYGJD8huln7xYUw";
$token="eWhRhIz-RkcjsO5e-hnbsk:APA91bHF3bMgQI7toyQq2YPSjJEF66wdDAJFLfT93jKVgbjj8Ippj9fyU26EXjagroAwMHzTw3NBEmo2We-UFTguCHy44fFDMdKs89TYvBFh3vOZJkm5UaGSWNQTMmYyPQa_XGoPyOdg";

//mat
//$token="fFYv3CpWSaObW_js5B66d3:APA91bFHaDTd9ftn_oBiFPaq8DDaeDTWVPc4UIrUQp1begfqVF68wLz5OhL1JgDj7vgDOdpKyY8TbKK9SA5EQlGLub12fwG_vk7h0ngH9LF--VmFUuFq__umfMHCZ6GSHvAo4jAazaV5";

function sendMessage($token, $payload) {
  $accessToken = getAccessToken();
  #ajustar url
  $url = 'https://fcm.googleapis.com/v1/projects/ospiapbatesting/messages:send';

  $client = new Client();
  $response = $client->post($url, [
      'headers' => [
          'Authorization' => 'Bearer ' . $accessToken,
          'Content-Type' => 'application/json',
      ],
      'json' => [
          'message' => [
              'token' => $token,
              'notification' => $payload['notification'],
              'data' => array_merge($payload['data'], [
                  'notification_foreground' => 'true'
              ])
          ]
      ]
  ]);

  return $response->getBody()->getContents();
}

//$token = 'DEVICE_REGISTRATION_TOKEN';
//$regIdfijo ="dAjpcZYFQ2OLjVlKiG8QA1:APA91bEhPcjmBIoIzAPmUbQZ1qfURpjRrpyb1oyUKN7p-hcTcluz4BlhR0XxJHpESar0g_XZm_0JK6xWeoaEnZ7KGpYVI8N-x0jvub8OA9LHayyXgQeqrt7x4ReZHl9AhB7J8FFlPlBN";
//$token="dZUJa92BTpeqEn2N5K6Q6f:APA91bFoyajam2ETs4cEhFLVLHV2-V5ONRXElIlX-AT0jikiyasmCLffU1bdcQagPmGlMVzV_Ut_FAjCN2nxdJza9A1CsAtT-70h2mJKngULCpb-tWGJhN6hXqipdA719kh_eqevuvJ1";

$token=$_GET['fcmToken'];

//print_r ($_GET);
echo "<p>mobile token: ".$token."</p>";
$payload = [
    'notification' => [
        'title' => 'Firebase HTTPv1 API',
        'body' => 'Mensaje con Nueva api !'
    ],
    'data' => [
        'key1' => 'value1',
        'key2' => 'value2'
    ]
];

$result = sendMessage($token, $payload);
echo "<p>result: ".$result."</p>";










?>