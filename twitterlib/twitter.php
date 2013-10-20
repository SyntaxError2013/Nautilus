<?php

class Twitter{
	private $consumer_key = 'XVczAbQGfBTOVuc2CXZPQ';
	private $consumer_secret = 'qBp4NE4pySxZja09sshaO3xuwUHeEG8V1WrQkVhPU';
	private $callback = 'http://rekishi.in/login/twitter/cb';
	
	function login_check(){
		require_once(ROOT.'/twitteroauth/twitteroauth.php');

		/* If access tokens are not available redirect to connect page. */
		if (empty($_SESSION['twt_access_token']) || empty($_SESSION['twt_access_token']['oauth_token']) || empty($_SESSION['twt_access_token']['oauth_token_secret'])) {
		    header('Location: /login/twitter');
		}
		else return 1;
	}

	function login_prompt(){
		/**
		 * @file
		 * Check if consumer token is set and if so send user to get a request token.
		 */

		/**
		 * Exit with an error message if the CONSUMER_KEY or CONSUMER_SECRET is not defined.
		 */
		if ($this->consumer_key === '' || $this->consumer_secret === '' || $this->consumer_key === 'CONSUMER_KEY_HERE' || $this->consumer_secret === 'CONSUMER_SECRET_HERE') {
			echo 'You need a consumer key and secret to test the sample code. Get one from <a href="https://dev.twitter.com/apps">dev.twitter.com/apps</a>';
			exit;
		}

		/* Build an image link to start the redirect process. */
		$content = '<a href="./redirect.php"><img src="/images/lighter.png" alt="Sign in with Twitter"/></a>';
		 
		/* Include HTML to display on the page. */
		include(ROOT.'/views/html.inc');
	}

	function login(){
		session_start();
		require_once(ROOT.'/twitteroauth/twitteroauth.php');

		/* Build TwitterOAuth object with client credentials. */
		$connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret);
		 
		/* Get temporary credentials. */
		$request_token = $connection->getRequestToken($this->callback);

		/* Save temporary credentials to session. */
		$_SESSION['twt_oauth_token'] = $token = $request_token['oauth_token'];
		$_SESSION['twt_oauth_token_secret'] = $request_token['oauth_token_secret'];
		 
		/* If last connection failed don't display authorization link. */
		switch ($connection->http_code) {
			case 200:
				/* Build authorize URL and redirect user to Twitter. */
				$url = $connection->getAuthorizeURL($token);
				header('Location: ' . $url); 
				break;
			default:
				/* Show notification if something went wrong. */
				echo 'Could not connect to Twitter. Refresh the page or try again later.';
		}
	}

	function callback(){
		/**
		 * @file
		 * Take the user when they return from Twitter. Get access tokens.
		 * Verify credentials and redirect to based on response from Twitter.
		 */

		/* Start session and load lib */
		// session_start();
		require_once(ROOT.'/twitteroauth/twitteroauth.php');

		/* If the oauth_token is old redirect to the connect page. */
		if (isset($_REQUEST['oauth_token']) && $_SESSION['twt_oauth_token'] !== $_REQUEST['oauth_token']) {
			$_SESSION['twt_oauth_status'] = 'oldtoken';
			header('Location: /login/twitter');
		}

		/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
		$connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $_SESSION['twt_oauth_token'], $_SESSION['twt_oauth_token_secret']);

		/* Request access tokens from twitter */
		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

		/* Save the access tokens. Normally these would be saved in a database for future use. */
		$_SESSION['twt_access_token'] = $access_token;

		/* Remove no longer needed request tokens */
		unset($_SESSION['twt_oauth_token']);
		unset($_SESSION['twt_oauth_token_secret']);

		/* If HTTP response is 200 continue otherwise send to connect page to retry */
		if (200 == $connection->http_code) {
			/* The user has been verified and the access tokens can be saved for future use */
			$_SESSION['twt_status'] = 'verified';
			header('Location: /twitter');
		} else {
			/* Save HTTP status for error dialog on connnect page.*/
			header('Location: ./clearsessions.php');
		}
	}

	function tweets($direct){
		/**
		 * @file
		 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
		 */

		/* Load required lib files. */
		// session_start();
		require_once(ROOT.'/twitteroauth/twitteroauth.php');

		if($this->login_check()){
			/* Get user access tokens out of the session. */
			$access_token = $_SESSION['twt_access_token'];

			/* Create a TwitterOauth object with consumer/user tokens. */
			$connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);

			/* If method is set change API call made. Test is called by default. */

			// print_r($content);
			$content = array();

			$start_date = time();
			$end_date = time() + (7 * 24 * 60 * 60);
			$start_date = str_replace("2013", "2012", date( 'Y-m-d', $start_date));
			$end_date = str_replace("2013", "2012", date( 'Y-m-d', $end_date));

			$found = 0;

			$i = 0;

			while(!$found){
				if($i == 6) break;

				if($i == 0){
					$data = $connection->get('statuses/user_timeline', array('count' => '200'));
				}
				else {
					$data = $connection->get('statuses/user_timeline', array('count' => '200', 'max_id' => $id));
				}
				$i++;

				// $content = $data[count((array)$data)-1];
				
				$last = $data[count((array)$data)-1];
				$last_date = date( 'Y-m-d', strtotime($last->created_at));
				if($end_date < $last_date){
					$id = $last->id + 1;
					continue;
				}
				else {
					foreach($data as $tweet){
						$date = date( 'Y-m-d', strtotime($tweet->created_at));
						if($date >= $start_date && $date < $end_date){
							array_push($content, $tweet);
						}
						else if($date < $start_date){
							$found = 1;
							break;
						}
						// $id = $tweet->id + 1;
					}
				}
			}

			// include(ROOT.'/views/html.inc');

			if($connection->http_code == 200){
				if($direct == "json"){
					return $content;
				}
				else {
					include(ROOT.'/views/html.inc');
				}
			}
			else {
				echo json_encode($content->errors);
				// include(ROOT.'/views/html.inc');
			}
		}
	}

	public function tweets_json(){
		$content = $this->tweets('json');
		$data = array();

		// foreach($content as $tweet){
			$temp['id'] = $content[0]->id;
			$temp['text'] = $content[0]->text;
			$temp['name'] = $content[0]->user->name;
			$temp['screen_name'] = $content[0]->user->screen_name;
			array_push($data, $temp);
		// }

		echo json_encode($data);
	}
}

?>