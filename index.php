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
FacebookSession::setDefaultApplication('680605312014481','8f7df2bbfa7259bafe6ec9443f054776');


$helper = new FacebookCanvasLoginHelper();
try {
  $session = $helper->getSession();

} catch (FacebookRequestException $ex) {
    // When Facebook returns an error
} catch (\Exception $ex) {
    // When validation fails or other local issues  
}
if ($session) {
  echo 'login';
  // Logged in.
}

?>
