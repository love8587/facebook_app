<?php 

require_once('autoload.php');
require_once('lib/libDB.php');
require_once('lib/libQuestion.php');

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\Helpers\FacebookPageTabHelper;
use Facebook\Helpers\FacebookCanvasLoginHelper;

$oDB = libDB::getInstance();


if ($_SERVER['HTTP_HOST'] == 'localhost') {

$_POST['signed_request'] = 'CAAHX5Jgh1cUBAIC5ZBU61QY7qHNiuJ5skc770fNqGuofPTeaqZAT1HnJm2ZBkr5OsJUVwnJKWLRCqD8HibL1GkWhFhM6KJ8LRMfZAe7LVVadzULotulIFIVf4YRBLJsfXhC3PqR8XuLfa2vtvfRyVqQjeSTMyFILWpxNNg5ZBGQtBx5zrPy7oSUmLupncaXU2jxZAZCsoZCSxLBAOQXPrRPQCnmXJQGJfEMZD';
$_POST['signed_request'] = 'TjTnstpnjdiNIflHfY_W7E_x1BZQrXcDmDpY967uRtA.eyJhbGdvcml0aG0iOiJITUFDLVNIQTI1NiIsImV4cGlyZXMiOjE0MDcwNzgwMDAsImlzc3VlZF9hdCI6MTQwNzA3MjkzNSwib2F1dGhfdG9rZW4iOiJDQUFIWDVKZ2gxY1VCQU1NeVlqZ1FpYzlycm0yVmJ4MkxaQlpDZENmbk53ZVMwalpBRklVTzBDSUxDbUVpcFpDYmI2M25XS2U5eFpBNmwyZVJteUw3bE9xUkRTRG5ja1pDRHNsR2R1Mjhkaktub3AxQ2hveEhsVUhZYXBiVkxaQ0t4RzFvVjViSjlJT1d5cm5WQjd1QTVwaWpqbzh4TmExR0VGNkZsMTY5NnBwaVpDaVdLYzNWNG5PbGJuMWR4ZXozejljVk55ajhKUkN0c1pBWEEyQU1yTUxlSGtjMHFXUlhOa1pBc1pEIiwicGFnZSI6eyJpZCI6IjU4MzAyMDM5MTc3MzA0NCIsImxpa2VkIjp0cnVlLCJhZG1pbiI6dHJ1ZX0sInVzZXIiOnsiY291bnRyeSI6ImtyIiwibG9jYWxlIjoiZW5fVVMiLCJhZ2UiOnsibWluIjoyMX19LCJ1c2VyX2lkIjoiODE5NjI1OTUxMzg5MTA1In0';

}

// start session
session_start();
date_default_timezone_set('America/Los_Angeles');

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
		foreach($oDB->query("SELECT * from entries, users WHERE entries.user_id = '{$aUserInfo['id']}';") as $row) {
	?>
	    <tr>
	      <td><?php echo $row['idx']; ?></td>
	      <td><?php echo $row['user_id']; ?></td>
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