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
<script>

  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      console.log(response.authResponse.accessToken);
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }


  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }


 window.fbAsyncInit = function() {
      FB.init({
        appId      : '518851781580229',
        xfbml      : true,
        version    : 'v2.0'
      });
    };





(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=518851781580229&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Here we run a very simple test of the Graph API after login is
// successful.  See statusChangeCallback() for when this call is made.
function testAPI() {
  console.log('Welcome!  Fetching your information.... ');

FB.login(
  function(response) {
    console.log(response);
  },
  {
    scope: 'public_profile,email,user_likes,user_interests,user_videos,user_actions.books,publish_actions',
    auth_type: 'rerequest'
  }
);

  FB.api('/me', function(response) {
    console.log('Successful login for: ' + response.name);
    document.getElementById('status').innerHTML =
      'Thanks for logging in, ' + response.name + '!';
  });
}


</script>


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
  '/me'
);

$response = $request->execute();
$graphObject = $response->getGraphObject();
/* handle the result */

echo "<pre>";
print_r($graphObject);
echo "</pre>";

} ?>


<fb:login-button scope="public_profile,email,user_likes,user_interests,user_videos,user_actions.books,publish_actions" onlogin="checkLoginState();">
</fb:login-button>

<div id="status">
</div>


</body>
</html>
