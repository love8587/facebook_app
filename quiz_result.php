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
 
// init app with app id and secret
//FacebookSession::setDefaultApplication( 'xxx','yyy' );
FacebookSession::setDefaultApplication('518851781580229','4284499c6fb57d117268cd20931f0ff5');


$signedRequest = new SignedRequest($rawSignedRequest, $this->state, $this->appSecret);


var_dump($test1);

$session = new FacebookSession($_GET['access_token']);

var_dump($session);



if ($session != null) {
	/* make the API call */
	$request = new FacebookRequest(
	  $session,
	  'POST',
	  '/me/feed',
	  array (
	    'message' => 'This is a test message',
	  )
	);
	$response = $request->execute();
	$graphObject = $response->getGraphObject();
	/* handle the result */

	var_dump($graphObject);
	
} 






?>
