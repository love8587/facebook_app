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

$helper = new FacebookPageTabHelper('518851781580229', '4284499c6fb57d117268cd20931f0ff5');

$test = $helper->getPageId();
var_dump($test);

$test2 = $helper->isLiked();
var_dump($test2);

$test3 = $helper->isAdmin();
var_dump($test3);



?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=518851781580229&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<h2> Hello ! Welcome my fan page! </h2>


<?php if ($helper->isLiked() === false) { ?>
  <div class="fb-like" data-href="https://www.facebook.com/eat.drink.dress/" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
<?php echo 'Click on above “Like” button to join this contest!'; 

} else { 

$session = $helper->getSession();


  /* make the API call */
$request = new FacebookRequest(
  $session,
  'GET',
  '/me/feed'
);
$response = $request->execute();
$graphObject = $response->getGraphObject();
/* handle the result */

echo "<pre>";
print_r($graphObject);
echo "</pre>";

} ?>

</body>
</html>
