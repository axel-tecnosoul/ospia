<?php
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
  #ajustar url
  #testing
  #$url = 'https://fcm.googleapis.com/v1/projects/ospiapbatesting/messages:send';
  #prod
  $url = 'https://fcm.googleapis.com/v1/projects/app-ospiapba/messages:send';
  
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
//$token="eTh6c5s8TmyVl6VYj0FHhR:APA91bGLJ0GGdQIW3WnRBalbMdguTCLOrit8JwwzF46n1S1RKI9hWdPxGWLg5KHAgOHCcEOrK3qbZa9A4TnWWXL5-75piMaLe8upngdq-bnHp5gYR9JwCY2gW_xCufNpQm5iTpnFBhK0";

//$token=$_GET['fcmToken'];

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