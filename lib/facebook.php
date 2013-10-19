
<?php
function Facebook(){
require 'vendor/facebook/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '275332542591675',
  'secret' => '8fb18f042a8494e15eb35aba98a42c41',
));


// Get User ID
$user = $facebook->getUser();

if ($user) {
  try {

    $me = $facebook->api('/me');
    
    date_default_timezone_set('Asia/Calcutta');
$lastyearSameday = strtotime('-1 year');
$lastyearNextday = strtotime('-1 year +1 day');

    $params = array(
        'method' => 'fql.query',
        'query' => 'SELECT created_time,message,description,share_count, like_info, type, attachment  FROM stream WHERE source_id='.$me["id"].' and created_time>'.$lastyearSameday.' AND created_time<'.$lastyearNextday.' LIMIT 1000',
    );

    $user_profile = $facebook->api($params);
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $statusUrl = $facebook->getLoginStatusUrl();
  $loginUrl = $facebook->getLoginUrl( array('scope' => 'email,user_photos,friends_photos,read_stream' ));
}


 if (!$user){ 
      echo "<div><a href='".$loginUrl."'>Login</a></div>";}
    

  if ($user){
      echo json_encode($user_profile); }
}   