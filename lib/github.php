<?php

 $contributions = json_decode(file_get_contents("https://github.com/users/".$_SESSION['ghid']."/contributions_calendar_data"));
 $LastyearSameday = $contributions[0];
 $LastyearNextday = $contributions[1];
 $LastyearRandomday = $contributions[16];
 
 $arr2 = array();
$value2 = array();
$arr = array($LastyearNextday,$LastyearSameday);
if(isset($LastyearRandomday))array_push($arr, $LastyearRandomday);
 foreach ($arr as $key => $value) {
	 $str = 'https://github.com/'.$_SESSION["ghid"].'?tab=contributions&from='.$value[0].'&_pjax=%23contribution-activity';
	 $html = file_get_html($str);
 	$commit = $html->find('div[id=issues-contributed]', 0);
 	if($commit){
	  $commit = $commit->find('a', 0);
 	  $value2["link"] = "https://github.com".$commit->href;
 	  $value2["text"] = $commit->plaintext;

 	  $username = substr( $commit->href, strpos($commit->href, '/') +1 , strpos(substr( $commit->href, strpos($commit->href, '/') +1 ) , '/') );
 	  $nousername = substr($commit->href,strlen($username)+2);
 	  $repo = substr( $nousername, 0 , strpos($nousername , '/') );
 	  $value2["repo"] = $repo;
 	  $value2["username"] = $username;

	}
 	$value2["date"] = $value[0];
 	$value2["contributions"] = $value[1];
	array_push($arr2, $value2);
}

$contri = json_encode($arr2);
echo $contri;