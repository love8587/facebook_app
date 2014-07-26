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

 
 
$helper = new FacebookRedirectLoginHelper('http://boiling-caverns-1628.herokuapp.com/index.php');
 
$session = $helper->getSessionFromRedirect();
 
if($session != NULL){
    echo "Logged In !<br>";
    $request = new FacebookRequest($session, 'GET', '/me');
    $response = $request->execute();
    $graph = $response->getGraphObject(GraphUser::className());
    echo $graph->getName();
}
else{
    echo '<a href="' . $helper->getLoginUrl() . '">Login</a>';
}

?>
