


require 'src/facebook.php';

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
    
    $params = array(
        'method' => 'fql.query',
        'query' => 'SELECT created_time,message,description,share_count, like_info, type, attachment  FROM stream WHERE source_id='.$me["id"].' and created_time>1380847426 AND created_time<1381847429 LIMIT 1000',
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

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>php-sdk</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>

    <?php if ($user): ?>
    <?php else: ?>
      <div>
        Check the login status using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php echo $statusUrl; ?>">Check the login status</a>
      </div>
      <div>
        Login using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>

    

    <?php if ($user): ?>
      <pre><?php  echo json_encode($user_profile); ?></pre>
    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>
  </body>
</html>