<?php 

require_once('autoload.php');
require_once('lib/libDB.php');
require_once('lib/libQuestion.php');

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\Helpers\FacebookPageTabHelper;
use Facebook\Helpers\FacebookCanvasLoginHelper;

$oDB = libDB::getInstance();

// start session
session_start();
date_default_timezone_set('Japan');

// init app with app id and secret
FacebookSession::setDefaultApplication('518851781580229','4284499c6fb57d117268cd20931f0ff5');

$session = new FacebookCanvasLoginHelper('518851781580229', '4284499c6fb57d117268cd20931f0ff5');
$session->instantiateSignedRequest($_POST['signed_request']);

// check answer 
$oQuestion = new libQuestion();
$aCheckedResult = $oQuestion->checkAnswer($_POST);

$iResultPoint = $oQuestion->getPointFromCheckedAnswer($aCheckedResult);

if ($session != null) {
	/* make the API call */
	$request = new FacebookRequest($session->getSession(), 'GET', '/me');

	// get user info
	$response = $request->execute();
	$graphObject = $response->getGraphObject();
	$aUserInfo = $graphObject->asArray();

	// check answer 
	$oQuestion = new libQuestion();
	$aCheckedResult = $oQuestion->checkAnswer($_POST);

	$iResultPoint = $oQuestion->getPointFromCheckedAnswer($aCheckedResult);

	if ($aUserInfo['id']) {
		try 
		{
			// insert result to database
			$oDB->beginTransaction();

			$sql = 'INSERT INTO entries
			    (user_id, result_point) VALUES (?, ?)';

			$sth = $oDB->prepare($sql);

			$sth->execute(array(
			        $aUserInfo['id'],
			        $iResultPoint,
			    ));

			$oDB->commit();

		} catch(Exception $e) {
			// empty 
		}
	}
} 
?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta property="og:url" content="http://samples.ogp.me/136756249803614" /> 
  <meta property="og:title" content="Chocolate Pecan Pie" />
  <meta property="og:description" content="This pie is delicious!" /> 
  <title>Quiz App Test</title>
  <script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<body>
<div id="fb-root"></div>
<script>

 window.fbAsyncInit = function() {
    FB.init({
      appId      : '518851781580229',
      xfbml      : true,
      version    : 'v2.0'
    });

	FB.ui({
	  method: 'share',
	  href: 'https://www.facebook.com/eat.drink.dress/app_518851781580229',
	}, function(response){});
};

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=518851781580229&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

</script>

<table class="table table-condensed">
  <thead>
    <tr>
      <th>#</th>
      <th>Username</th>
      <th>Result</th>
      <th>Participate_time</th>
    </tr>
  </thead>
  <tbody>
	<?php		
		// show all list that result of user
		$idx = 0;
		foreach($oDB->query("SELECT e.*, u.name from entries e, users u WHERE e.user_id = '{$aUserInfo['id']}';") as $row) {
	?>
	    <tr>
	      <td><?php echo $idx++; ?></td>
	      <td><?php echo $row['name']; ?></td>
	      <td><?php echo $row['result_point']; ?></td>
	      <td><?php echo $row['ins_timestamp']; ?></td>
	    </tr>
	<?php
		}
	?>
  </tbody>
</table>	

</body>
</html>