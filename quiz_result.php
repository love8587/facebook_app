<?php 

require_once('autoload.php');
require_once('lib/libDB.php');
require_once('lib/libQuestion.php');

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\Helpers\FacebookPageTabHelper;
use Facebook\Helpers\FacebookCanvasLoginHelper;

$dbh = libDB::getInstance();

foreach($dbh->query('SELECT * from entries;') as $row) {
    print_r($row);
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

$oQuestion->getPointFromCheckedAnswer($aCheckedResult);

if ($session != null) {
	/* make the API call */
	$request = new FacebookRequest($session->getSession(), 'GET', '/me');

	$response = $request->execute();
	$graphObject = $response->getGraphObject();
	/* handle the result */

	// check answer 
	$oQuestion = new libQuestion();

	$aCheckedResult = $oQuestion->checkAnswer($_POST);

	$oQuestion->getPointFromCheckedAnswer($aCheckedResult);
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

	// FB.ui({
	//   method: 'share',
	//   href: 'https://www.facebook.com/eat.drink.dress/app_518851781580229',
	// }, function(response){});
};

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=518851781580229&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


</script>