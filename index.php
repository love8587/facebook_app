<?php 

require_once('autoload.php');




session_start();




use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\Helpers\FacebookCanvasLoginHelper;

FacebookSession::setDefaultApplication('680605312014481','8f7df2bbfa7259bafe6ec9443f054776');

// Use one of the helper classes to get a FacebookSession object.
//   FacebookRedirectLoginHelper
//   FacebookCanvasLoginHelper
//   FacebookJavaScriptLoginHelper
// or create a FacebookSession with a valid access token:



$helper = new FacebookCanvasLoginHelper();
try {
  $session = $helper->getSession();

var_dump($session);

} catch(FacebookRequestException $ex) {
  // When Facebook returns an error
} catch(\Exception $ex) {
  // When validation fails or other local issues
}
if ($session) {
  // Logged in

  echo 1111;
}









?>
