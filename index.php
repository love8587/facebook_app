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
  <meta charset="UTF-8">
  <title>Quiz App Test</title>
  <script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<body>
<div id="fb-root"></div>
<script>
var sToken;

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

    sToken = response.authResponse.accessToken;

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
  
  // console.log('Welcome!  Fetching your information.... ');


    FB.login(
      function(response) {
        // console.log(response);
        // console.log('Successful login for: ' + response.name);
  
        FB.api('/me', function(response) {
          document.getElementById('status').innerHTML =
            'Thanks for logging in, ' + response.name + '!';

          document.getElementById('login_button_area').innerHTML = '';
          $('#quiz_body').show();
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
  
<h5> Click on above "Like" button to join this contest! </h5>

<?php 
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

$_SESSION['access_token'] = $session->getToken();

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

<div id="status"> </div>

<div id="quiz_body" style="display:none">

<form id="quiz_form" role="form" action="quiz_complete.php">
  <div class="form-group">
    <label class="form-control"> This is Quiz 1</label>
    <label class="radio-inline">
      <input type="radio" name="quiz1_answer" id="quiz1_select_1" value="option1"> 1
    </label>
    <label class="radio-inline">
      <input type="radio" name="quiz1_answer" id="quiz1_select_2" value="option2"> 2
    </label>
    <label class="radio-inline">
      <input type="radio" name="quiz1_answer" id="quiz1_select_3" value="option3"> 3
    </label>
  </div>
  <div class="form-group">
    <label class="form-control"> This is Quiz 2</label>
    <label class="radio-inline">
      <input type="radio" name="quiz2_answer" id="quiz2_select_1" value="option1"> 1
    </label>
    <label class="radio-inline">
      <input type="radio" name="quiz2_answer" id="quiz2_select_2" value="option2"> 2
    </label>
    <label class="radio-inline">
      <input type="radio" name="quiz2_answer" id="quiz2_select_3" value="option3"> 3
    </label>
  </div>
  <div class="form-group">
    <label class="form-control"> This is Quiz 3</label>
    <label class="radio-inline">
      <input type="radio" name="quiz3_answer" id="quiz3_select_1" value="option1"> 1
    </label>
    <label class="radio-inline">
      <input type="radio" name="quiz3_answer" id="quiz3_select_2" value="option2"> 2
    </label>
    <label class="radio-inline">
      <input type="radio" name="quiz3_answer" id="quiz3_select_3" value="option3"> 3
    </label>
  </div>  
  <div class="form-group">
    <label class="form-control"> This is Quiz 4</label>
    <label class="radio-inline">
      <input type="radio" name="quiz4_answer" id="quiz4_select_1" value="option1"> 1
    </label>
    <label class="radio-inline">
      <input type="radio" name="quiz4_answer" id="quiz4_select_2" value="option2"> 2
    </label>
    <label class="radio-inline">
      <input type="radio" name="quiz4_answer" id="quiz4_select_3" value="option3"> 3
    </label>
  </div>
  <div class="form-group">
    <label class="form-control"> This is Quiz 5</label>
    <label class="radio-inline">
      <input type="radio" name="quiz5_answer" id="quiz5_select_1" value="option1"> 1
    </label>
    <label class="radio-inline">
      <input type="radio" name="quiz5_answer" id="quiz5_select_2" value="option2"> 2
    </label>
    <label class="radio-inline">
      <input type="radio" name="quiz5_answer" id="quiz5_select_3" value="option3"> 3
    </label>
  </div>
  <input type="hidden" id="access_token" name="access_token" <?php echo 'value="'. $_SESSION['access_token'] .'"' ?>>
  <button type="submit" class="btn btn-default">Submit</button>
</form>

</div>





<script type="text/javascript">
$(document).ready(function() {



  $( "#quiz_form" ).submit(function( event ) {
   
    // Stop form from submitting normally
    event.preventDefault();

    // Set Element for Validation
    var aValidateElementName = ['quiz1_answer', 'quiz2_answer', 'quiz3_answer', 'quiz4_answer', 'quiz5_answer'];

    // Validate Element
    for (index in aValidateElementName) {
      var bIsChecked = $('input[name='+ aValidateElementName[index] +']').is(':checked');
      
      if (bIsChecked === false) { 
        alert('You must select at least 1. Check your answer each Quiz'); 
        return false; 
      }
    }

    // Get some values from elements on the page:
    var $form = $( this ),
    url = $form.attr( "action" );
   
    // Send the data using post
    var posting = $.post( url, $( "#quiz_form" ).serialize() );
   
    // Put the results in a div
    posting.done(function( data ) {
      // location.href="/quiz_result.php?access_token=" + $('#access_token').val();
        FB.api('/me', function(response) {
          alert(response.name);
        });


        var url = 'https://graph.facebook.com/v2.0/me/feed?method=POST&message=asdfsd&format=json&suppress_http_code=1&access_token=CAAHX5Jgh1cUBAPVWjyyCybyQ3NbdrUmvyekKbtdesdAYc28lUjxG3KevkfsaZAKuYIXpOAirsYxEvMQXi3YT39DLqUlxLcIV11ZCqVpuiSwgOHNVYd3bIoz1ZBafpCZChZAsQUuLQPO3F6GlsvrVDC9NoLMtCkYZBhEri823AiYhUclAcBHnfAeIjZBmgXECWTxDqcofRyOdGffnxq83DqbBArPNHL44MEZD';

        // Send the data using post
        var posting = $.post( url, $( "#quiz_form" ).serialize() );

        alert( sToken );
       
        // Put the results in a div
        posting.done(function( data ) {
            alert(1);
        });




    });


   
  });


});  

</script>

  <button id="publishBtn">Click me to publish a "Hello, World!" post to Facebook.</button>


</body>
</html>
