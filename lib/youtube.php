<?php
// Call set_include_path() as needed to point to your client library.
require_once '../../src/Google_Client.php';
require_once '../../src/contrib/Google_YouTubeService.php';
session_start();


/* You can acquire an OAuth 2 ID/secret pair from the API Access tab on the Google APIs Console
  <http://code.google.com/apis/console#access>
For more information about using OAuth2 to access Google APIs, please visit:
  <https://developers.google.com/accounts/docs/OAuth2>
Please ensure that you have enabled the YouTube Data API for your project. */
$OAUTH2_CLIENT_ID = '63570848359-7nkia42hecl3k5ujuulolkdgqjn67uip.apps.googleusercontent.com';
$OAUTH2_CLIENT_SECRET = 'QV8bMGtJmsHZEzUQeUqZ_8AK';

$yclient = new Google_Client();
$yclient->setClientId($OAUTH2_CLIENT_ID);
$yclient->setClientSecret($OAUTH2_CLIENT_SECRET);
$redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
  FILTER_SANITIZE_URL);
$yclient->setRedirectUri($redirect);

$youtube = new Google_YoutubeService($yclient);

if (isset($_GET['code'])) {
  if (strval($_SESSION['state']) !== strval($_GET['state'])) {
    die('The session state did not match.');
  }

  $yclient->authenticate();
  $_SESSION['token'] = $yclient->getAccessToken();
  header('Location: ' . $redirect);
}

if (isset($_SESSION['token'])) {
  $yclient->setAccessToken($_SESSION['token']);
}

if ($yclient->getAccessToken()) {
  try {
   // $channelsResponse = $youtube->channels->listChannels('contentDetails', array(
   //   'mine' => 'true',
   // ));
    header('Content-Type: application/json');
    $date = "2013-09-01T12:00:00.000Z";
    $date2 = "2010-01-20T12:00:00.000Z";
    $str = 'https://gdata.youtube.com/feeds/api/users/default/watch_history?v=2&token='.
                  json_decode($yclient->getAccessToken())->access_token.'&access_token='.
                  json_decode($yclient->getAccessToken())->access_token.
                  '&start-index=950&max-results=50&alt=json&fields=entry[(xs:dateTime(published)<xs:dateTime("'.$date.'"))]';
 //   $str2 = 

   // var_dump( json_decode($yclient->getAccessToken())->access_token ) ;
 //   echo $str;
//$str = urlencode($str);
 // create curl resource 
        $ch = curl_init(); 

        // set url 
        curl_setopt($ch, CURLOPT_URL, $str); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);   
        echo $output;
       // echo $output;
    
  } catch (Google_ServiceException $e) {
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  }

  $_SESSION['token'] = $yclient->getAccessToken();
} else {
  $state = mt_rand();
  $yclient->setState($state);
  $_SESSION['state'] = $state;

  $authUrl = $yclient->createAuthUrl();
  $htmlBody = <<<END
  <h3>Authorization Required</h3>
  <p>You need to <a href="$authUrl">authorize access</a> before proceeding.<p>
END;
echo $htmlBody;
}
?>
