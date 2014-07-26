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
$session = new FacebookSession('83536eb622aa5a7038ef61199ccae1df');

var_dump($session);
// Get the GraphUser object for the current user:

try {
  $me = (new FacebookRequest(
    $session, 'GET', '/me'
  ))->execute()->getGraphObject(GraphUser::className());
  
  var_dump($me);

  echo $me->getName();
} catch (FacebookRequestException $e) {
  // The Graph API returned an error

  echo 1;

} catch (\Exception $e) {
  // Some other error occurred
echo $e->getMessage();


}









?>
