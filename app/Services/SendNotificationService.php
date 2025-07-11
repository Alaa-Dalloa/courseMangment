<?php
namespace App\Services;

use Google\Service\ServiceConsumerManagement\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http as FacadesHttp;

class SendNotificationService
{

public function sendByFcm(string $fcm , array $message)
{
    $apiUrl='https://fcm.googleapis.com/v1/projects/restaurantdelivery-c7ac8/messages:send';

    $access_token=Cache::remember('access_token', now()->addHour(), function () use($apiUrl){
    $credentialFilePath=storage_path('app/fcm.json');
   

   $client = new \Google_Client();
   $client->setAuthConfig($credentialFilePath);
   $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
   $client->fetchAccessTokenWithAssertion();
   $token=$client->getAccessToken();

  return $token['access_token'];

   });
   
  $message=[
    "message"=>[
        "token"=>$fcm , 
        "notification" => $message
    ]

  ];


  $responce=FacadesHttp::withHeaders(["Authorization"=>"Bearer$access_token"])->post($apiUrl,$message);

  


}

}