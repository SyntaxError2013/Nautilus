<?php
require 'Toro.php';
require 'google-api-php-client/src/Google_Client.php';
require 'google-api-php-client/src/contrib/Google_PlusService.php';
require 'vendor/facebook/facebook.php';

$client = new Google_Client();
$client->setApplicationName("Rekishi: Year One");
$client->setClientId('930206244765.apps.googleusercontent.com');
$client->setClientSecret('5YHs-QqrqX8kSClcSER12NT0');
$client->setRedirectUri('http://localhost:8080/login/google/cb');
$client->setDeveloperKey('AIzaSyAbLfaJIOSWDGGSGX3W3RG4JbOJpbWTyAA');
$plus = new Google_PlusService($client);

$facebook = new Facebook(array(
  'appId'  => '275332542591675',
  'secret' => '8fb18f042a8494e15eb35aba98a42c41',
));
$user = $facebook->getUser();


class FacebookHandler {
    function get() {
        global $user;
        global $facebook;
        if(!$user){
            header("Location: /login/facebook");
        }
        else{
        require 'lib/facebook.php';
        }
    }
}

class FbLoginHandler {
    function get() {
        global $facebook;
        $loginUrl = $facebook->getLoginUrl( array('scope' => 'email,user_photos,friends_photos,read_stream','redirect_uri'=>'http://'.$_SERVER["HTTP_HOST"].'/facebook' ));
        header("Location: ".$loginUrl);
    }
}

class HomePageHandler {
    function get(){
        if(isset($_SESSION['token'])){
            echo "We have a session token";
            echo $plus->people->get('me');
        }
        else{
            echo "No session token";
        }
    }
}

class GoogleHandler {
    function get() {
            global $client;
            $authUrl = $client->createAuthUrl();
            header("Location: ".$authUrl);
    }
}

class GoogleCBHandler {
        function get() {
                global $client;
                if (isset($_GET['code'])) {
                        $client->authenticate();
                        $_SESSION['token'] = $client->getAccessToken();
                        print_r($_SESSION);
                }
        }
}

Toro::serve(array(
	"/" => "HomePageHandler",
    "/facebook" => "FacebookHandler",
    "/login/google" => "GoogleHandler",
    "/login/google/cb" => "GoogleCBHandler",
    "/login/facebook" => "FbLoginHandler"
));