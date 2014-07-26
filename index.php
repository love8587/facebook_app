<?php 

require_once('autoload.php');



// Must pass session data for the library to work
session_start();


 
use Facebook\GraphSessionInfo;
use Facebook\FacebookSession;
use Facebook\FacebookCurl;
use Facebook\FacebookHttpable;
use Facebook\FacebookCurlHttpClient;
use Facebook\FacebookResponse;
use Facebook\FacebookAuthorizationException;
use Facebook\FacebookRequestException;
use Facebook\FacebookRequest;
use Facebook\FacebookSDKException;
use Facebook\Helpers\FacebookRedirectLoginHelper;
use Facebook\GraphObject;

 
// Replace the APP_ID and APP_SECRET with your apps credentials
//FacebookSession::setDefaultApplication( 'APP_ID', 'APP_SECRET' );
FacebookSession::setDefaultApplication('680605312014481','8f7df2bbfa7259bafe6ec9443f054776');

// Create the login helper and replace REDIRECT_URI with your URL
// Use the same domain you set for the apps 'App Domains'
// e.g. $helper = new FacebookRedirectLoginHelper( 'http://mydomain.com/redirect' );
$helper = new FacebookRedirectLoginHelper( 'https://boiling-caverns-1628.herokuapp.com/' );
 
// Check if existing session exists
if ( isset( $_SESSION ) && isset( $_SESSION['fb_token'] ) ) {
 
  // Create new session from saved access_token
  $session = new FacebookSession( $_SESSION['fb_token'] );
 
  // Validate the access_token to make sure it's still valid
  try {
    if ( ! $session->validate() ) {
      $session = null;
    }
  } catch ( Exception $e ) {
    // Catch any exceptions
    $session = null;
  }
} else {
 
  // No session exists
  try {
    $session = $helper->getSessionFromRedirect();
  } catch( FacebookRequestException $ex ) {
 
    // When Facebook returns an error
  } catch( Exception $ex ) {
 
    // When validation fails or other local issues
    echo $ex->message;
  }
}
 
// Check if a session exists
if ( isset( $session ) ) {
 
  // Save the session
  $_SESSION['fb_token'] = $session->getToken();
 
  // Create session using saved token or the new one we generated at login
  $session = new FacebookSession( $session->getToken() );
 
  // Create the logout URL (logout page should destroy the session)
  $logoutURL = $helper->getLogoutUrl( $session, 'http://yourdomain.com/logout' );
} else {
  // No session
 
  // Requested permissions - optional
  $permissions = array(
    'email',
    'user_location',
    'user_birthday'
  );
 
  // Get login URL
  $loginUrl = $helper->getLoginUrl($permissions);
}



// Graph API to request user data
$request = (new FacebookRequest( $session, 'GET', '/me' ))->execute();
 
// Get response as an array
$user = $request->getGraphObject()->asArray();

// Graph API to request profile picture
$request = (new FacebookRequest( $session, 'GET', '/me/picture?type=large&redirect=false' ))->execute();
 
// Get response as an array
$picture = $request->getGraphObject()->asArray();







?>
