<?php 

require_once('autoload.php');




session_start();




use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

FacebookSession::setDefaultApplication('680605312014481','8f7df2bbfa7259bafe6ec9443f054776');

// Use one of the helper classes to get a FacebookSession object.
//   FacebookRedirectLoginHelper
//   FacebookCanvasLoginHelper
//   FacebookJavaScriptLoginHelper
// or create a FacebookSession with a valid access token:


// If you're making app-level requests:
$session = FacebookSession::newAppSession();



// To validate the session:
try {
  $session->validate();
} catch (FacebookRequestException $ex) {
  // Session not valid, Graph API returned an exception with the reason.
  echo $ex->getMessage();
} catch (\Exception $ex) {
  // Graph API returned info, but it may mismatch the current app or have expired.
  echo $ex->getMessage();
}


$request = new FacebookRequest($session, 'GET', '/me');
$response = $request->execute();
$graphObject = $response->getGraphObject();

$user = $response->getGraphObject(GraphUser::className());

var_dump($user);




?>
