<?php 

require_once('autoload.php');
require_once('lib/libDB.php');

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\Helpers\FacebookPageTabHelper;


$dbh = libDB::getInstance();

foreach($dbh->query('SELECT * from entries;') as $row) {
    print_r($row);
}

 
// start session
session_start();
date_default_timezone_set('America/Los_Angeles');

// init app with app id and secret
//FacebookSession::setDefaultApplication( 'xxx','yyy' );
FacebookSession::setDefaultApplication('518851781580229','4284499c6fb57d117268cd20931f0ff5');

$helper = new FacebookPageTabHelper('518851781580229', '4284499c6fb57d117268cd20931f0ff5');

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta property="og:url" content="http://samples.ogp.me/136756249803614" /> 
  <meta property="og:title" content="Chocolate Pecan Pie" />
  <meta property="og:description" content="This pie is delicious!" /> 
  <title>Quiz App Test</title>
  <script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<body>
<div id="fb-root"></div>
<script>

var sToken; var sSignReq;
var _scope_require = 'public_profile,email,user_friends';


function statusChangeCallback(response) {

  if (response.status === 'connected') {
    
    if (checkPermission() === true) {
      $('#quiz_body').show();  
    } else {
        FB.login(function(response) {
            top.location.href = 'https://www.facebook.com/eat.drink.dress/app_518851781580229';
          },
          {
            scope: 'public_profile,email,user_friends',
            auth_type: 'rerequest'
          }
        );
    }

  } else if (response.status === 'not_authorized') {
    //checkPermission();

    // The person is logged into Facebook, but not your app.
    document.getElementById('status').innerHTML = 'Please log ' +
      'into this app. you are not_authorized';
  } else {
    //checkPermission();

    // The person is not logged into Facebook, so we're not sure if
    // they are logged into this app or not.
    document.getElementById('status').innerHTML = 'Please log ' +
      'into Facebook.';
  }
}       

 window.fbAsyncInit = function() {
    FB.init({
      appId      : '518851781580229',
      xfbml      : true,
      version    : 'v2.0'
    });

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
    

};

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=518851781580229&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


function checkPermission() {

  var bResult = true;

  FB.api('me/permissions', function(response_perm) {
    
    var scopes=_scope_require.split(',');
    var permissions=[];

    for (var i in response_perm.data) {
      permissions.push(response_perm.data[i]['permission']);
    }

    for (var i in scopes) {
      var scope=scopes[i];
      if (permissions.indexOf(scope) === -1) {
        bResult = false;
        break;
      } else {
        bResult = true;
      }
    }
  });

  return bResult;

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

if ($session) {
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
  $_SESSION['signed_request'] = $session->getSignedRequest()->getRawSignedRequest();  
}

?>


<div id="status"> </div>

<div id="quiz_body" style="display:none">

<form id="quiz_form" role="form" action="quiz_result.php" method="post">
  <div class="form-group">
    <label class="form-control"> This is Quiz 1</label>
    <label class="radio-inline">
      <input type="radio" name="quiz1_answer" id="quiz1_select_1" value="option1" checked> 1
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
      <input type="radio" name="quiz2_answer" id="quiz2_select_1" value="option1" checked> 1
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
      <input type="radio" name="quiz3_answer" id="quiz3_select_1" value="option1" checked> 1
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
      <input type="radio" name="quiz4_answer" id="quiz4_select_1" value="option1" checked> 1
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
      <input type="radio" name="quiz5_answer" id="quiz5_select_1" value="option1" checked> 1
    </label>
    <label class="radio-inline">
      <input type="radio" name="quiz5_answer" id="quiz5_select_2" value="option2"> 2
    </label>
    <label class="radio-inline">
      <input type="radio" name="quiz5_answer" id="quiz5_select_3" value="option3"> 3
    </label>
  </div>
  <input type="hidden" id="access_token" name="access_token" <?php echo 'value="'. $_SESSION['access_token'] .'"' ?>>
  <input type="hidden" id="signed_request" name="signed_request" <?php echo 'value="'. $_SESSION['signed_request'] .'"' ?>>
  <button type="submit" class="btn btn-default">Submit</button>
</form>

</div>

<?php

} ?>




<script type="text/javascript">

$(document).ready(function() {

  $( "#quiz_form" ).submit(function( event ) {
   
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

    $(this).submit();
   
  });

});  

</script>
</body>
</html>
