<?php 

require_once('autoload.php');

use Facebook\HttpClients\FacebookCurl;
use Facebook\HttpClients\FacebookCurlHttpClient;
 
use Facebook\Entities\AccessToken;
use Facebook\Entities\SignedRequest;
 
use Facebook\FacebookSession;
use Facebook\Helpers\FacebookRedirectLoginHelper;
use Facebook\FacebookSignedRequestFromInputHelper; // added in v4.0.9
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookOtherException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphSessionInfo;
 
// these two classes required for canvas and tab apps
use Facebook\Helpers\FacebookCanvasLoginHelper;
use Facebook\Helpers\FacebookPageTabHelper;
 
// start session
session_start();
date_default_timezone_set('America/Los_Angeles');

// init app with app id and secret
//FacebookSession::setDefaultApplication( 'xxx','yyy' );
FacebookSession::setDefaultApplication('518851781580229','4284499c6fb57d117268cd20931f0ff5');

//$session = new FacebookSession($_POST['access_token'], $_POST['signed_request']);

$session = new FacebookCanvasLoginHelper('518851781580229', '4284499c6fb57d117268cd20931f0ff5');
$session->instantiateSignedRequest($_POST['signed_request']);

print_r($session);

if ($session != null) {
	/* make the API call */
	$request = new FacebookRequest($session->getSession(), 'GET', '/me');

	$response = $request->execute();
	$graphObject = $response->getGraphObject();
	/* handle the result */

echo "<pre>";
	var_dump($graphObject);
	
	echo "</pre>";
} 


?>