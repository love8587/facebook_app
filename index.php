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

?>

<!DOCTYPE html>
<html>
<head>
  <title>Quiz App Test</title>
  <script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
</head>
<body>
<div id="fb-root"></div>
<script>

// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {
  //console.log('statusChangeCallback');
  //console.log(response);
  // The response object is returned with a status field that lets the
  // app know the current login status of the person.
  // Full docs on the response object can be found in the documentation
  // for FB.getLoginStatus().
  if (response.status === 'connected') {
    // Logged into your app and Facebook.
    //console.log(response.authResponse.accessToken);
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


    // In your onload handler
    FB.Event.subscribe('edge.create', page_like_or_unlike_callback);
    FB.Event.subscribe('edge.remove', page_like_or_unlike_callback);

};

    var page_like_or_unlike_callback = function(url, html_element) {
      console.log("page_like_or_unlike_callback");
      console.log(url);
      console.log(html_element);
    } 

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
  
  // console.log('Welcome!  Fetching your information.... ');


    FB.login(
      function(response) {
        // console.log(response);
        // console.log('Successful login for: ' + response.name);
  
        FB.api('/me', function(response) {
          document.getElementById('status').innerHTML =
            'Thanks for logging in, ' + response.name + '!';

          document.getElementById('login_button_area').innerHTML = '';
        });

      },
      {
        scope: 'public_profile,email,user_likes,user_interests,user_videos,user_actions.books,publish_actions',
        auth_type: 'rerequest'
      }
    );


    

}


</script>


<h2> Welcome! my Quiz Quiz page! </h2>


<?php if ($helper->isLiked() === false) { ?>
   <!--
    <iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Feat.drink.dress&amp;width&amp;layout=button&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=35&amp;appId=518851781580229" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:35px;" allowTransparency="true"></iframe>
    -->
<br />
<?php 

echo 'Click on above “Like” button to join this contest!';

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
?>

<div id="login_button_area">
    <fb:login-button scope="public_profile,email,user_likes,user_interests,user_videos,user_actions.books,publish_actions" onlogin="checkLoginState();">
    Request Permission
    </fb:login-button>
</div>

<?php

} ?>



<div id="status">
</div>

<script type="text/javascript">

$(document).ready(function() {


// empty

});  

</script>
</body>
</html>
