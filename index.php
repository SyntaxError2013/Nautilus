<?php
require 'Toro.php';
require 'google-api-php-client/src/Google_Client.php';
require 'google-api-php-client/src/contrib/Google_PlusService.php';

$client = new Google_Client();
$client->setApplicationName("Rekishi: Year One");
$client->setClientId('930206244765.apps.googleusercontent.com');
$client->setClientSecret('5YHs-QqrqX8kSClcSER12NT0');
$client->setRedirectUri('http://localhost:8080/login/google/cb');
$client->setDeveloperKey('AIzaSyAbLfaJIOSWDGGSGX3W3RG4JbOJpbWTyAA');
$plus = new Google_PlusService($client);

class FacebookHandler {
    function get() {
        render('facebook.php');
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
    "/facebook" => "FacebookHandler",
    "/login/google" => "GoogleHandler",
    "/login/google/cb" => "GoogleCBHandler"
));
