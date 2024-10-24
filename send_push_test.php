<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* If started from the command line, wrap parameters to $_POST and $_GET */
if (!isset($_SERVER["HTTP_HOST"])) {
    parse_str($argv[1], $_GET);
    parse_str($argv[1], $_POST);
  }

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
   # $jsonKey = 'serviceAccountKey-ospiapbatesting-firebase-adminsdk-lbt4s-8db4ebc483.json';
    #ospia produccion
   $jsonKey = 'serviceAccountKey-app-ospiapba-582ebadcf1dc-ospianuevaapi.json';
    $credentials = new ServiceAccountCredentials($scopes, $jsonKey);
    $accessToken = $credentials->fetchAuthToken();
    
    if (!isset($accessToken['access_token'])) {
        throw new Exception('Failed to fetch access token');
    }
    
    return $accessToken['access_token'];
}


function sendMessage($token, $payload) {
  $accessToken = getAccessToken();
  var_dump($accessToken);
  
  #ajustar url
  #testing
  #$url = 'https://fcm.googleapis.com/v1/projects/ospiapbatesting/messages:send';
  #prod
  $url = 'https://fcm.googleapis.com/v1/projects/app-ospiapba/messages:send';
  
  $client = new Client();
  var_dump($client);
  echo "<br/><br/>";
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
  var_dump($response);
  echo "<br/><br/>";

  return $response->getBody()->getContents();
}

//$token = 'DEVICE_REGISTRATION_TOKEN';
//$regIdfijo ="dAjpcZYFQ2OLjVlKiG8QA1:APA91bEhPcjmBIoIzAPmUbQZ1qfURpjRrpyb1oyUKN7p-hcTcluz4BlhR0XxJHpESar0g_XZm_0JK6xWeoaEnZ7KGpYVI8N-x0jvub8OA9LHayyXgQeqrt7x4ReZHl9AhB7J8FFlPlBN";
//$token="dZUJa92BTpeqEn2N5K6Q6f:APA91bFoyajam2ETs4cEhFLVLHV2-V5ONRXElIlX-AT0jikiyasmCLffU1bdcQagPmGlMVzV_Ut_FAjCN2nxdJza9A1CsAtT-70h2mJKngULCpb-tWGJhN6hXqipdA719kh_eqevuvJ1";

$token=$_GET['fcmToken'];
//$token="d9Oy0zBOQuO8JGLu5MPfVl:APA91bFQp6iVuMjKRzhV4kQYtJVR_z1fBaLe4VV_SDm-1a5jDp9bA2aAhaXsT_qklu10Fda_-7sLJoWz1RotIgDfRw7WgiCRRzb9GwTD9CIilVr598NEwK6bdAlx0E40sKfgrP43yx3k";

//print_r ($_GET);
echo "<pre><p>mobile token: ".$token."</p>";
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
echo "<p>result: ".$result."</p></pre>";