<html>
	<head>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="/js/handlebars.js"></script>
		<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
      		{"parsetags": "explicit"}
    	</script>
    	<script type="text/javascript" src="/vendor/underscore/underscore-min.js"></script>
    	<link href='http://fonts.googleapis.com/css?family=Pompiere' rel='stylesheet' type='text/css'>
    	<link href="/css/style.css" type="text/stylesheet" rel="stylesheet">
		<title>Rekishi - Travel in Time</title>
		<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<h1><a href="/">Rekishi</a> - Travel in Time</h1>
		<h2>Facebook Posts</h2>
		<div class="chart">
			<div class="fbImg"></div>
			<h2>Likes</h2>
			<canvas id="fbLikes" width="300" height="300"></canvas>
			<div class="names">
				<div class="link label"></div>
				<div class="photo label"></div>
				<div class="status label"></div>
				<div class="post label"></div>
			</div>
			<div>
				<div class="label linksval"></div>
				<div class="label photosval">Photos</div>
				<div class="label statusval">Statuses</div>
				<div class="label postsval">Posts</div>
			</div>
		</div>
		<div id="fbloader" class="loader">
			<img src="/images/loader.gif">
		</div>

		<h2>Google+ Posts</h2>
		<!--This div will be filled with g+ posts-->
		<div id="google" class="loader">
			<img src="/images/loader.gif">
		</div>
		<h2>Github Activity</h2>
		<!--This div will be filled with github cards-->
		<div id="github" class="loader">
			<img src="/images/loader.gif" id="loader">
		</div>

		<h2>Twitter Posts</h2>
		<div id="twitter">
		</div>

		<script src="/js/fb.js"></script>
		<script src="/js/chart.js"></script>
		<script src="/js/github.js"></script>
		<script src="/js/google.js"></script>
		<script src="/js/twitter.js"></script>
	</body>
</html>