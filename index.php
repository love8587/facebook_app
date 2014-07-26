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
// init login helper
$helper = new FacebookRedirectLoginHelper( 'http://boiling-caverns-1628.herokuapp.com/index.php' );
 
// init page tab helper
$pageHelper = new FacebookPageTabHelper();
 
// get session from the page
$session = $pageHelper->getSession();
 
// get page_id
echo '<p>You are currently viewing page: '. $pageHelper->getPageId() . '</p>';
 
// get like status - use for likegates
echo '<p>You have '. ( $pageHelper->isLiked() ? 'LIKED' : 'NOT liked' ) . ' this page</p>';
 
// get admin status
echo '<p>You are '. ( $pageHelper->isAdmin() ? 'an ADMIN' : 'NOT an ADMIN' ) . '</p>';
 
// see if we have a session
if ( isset( $session ) ) {
  
  // show logged-in user id
  echo 'User Id: ' . $pageHelper->getUserId();
  
  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me' );
  $response = $request->execute();
  // get response
  $graphObject = $response->getGraphObject()->asArray();
  
  // print profile data
  echo '<pre>' . print_r( $graphObject, 1 ) . '</pre>';
  
  // print logout url, target = _top to break out of page frame
  echo '<a href="' . $helper->getLogoutUrl( $session, 'http://boiling-caverns-1628.herokuapp.com' ) . '" target="_top">Logout</a>';
  
} else {
  // show login url, target = _top to break out of page frame
  echo '<a href="' . $helper->getLoginUrl( array( 'email', 'user_friends' ) ) . '" target="_top">Login</a>';
}


?>
