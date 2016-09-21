<?php

header('Access-Control-Allow-Origin: *'); 
require_once __DIR__ . '/src/Facebook/autoload.php';
include_once 'fbconfig.php';

if (session_status() == PHP_SESSION_NONE){ session_start(); }

$fb = new Facebook\Facebook([
  'app_id' => app_id, // Replace {app-id} with your app id
  'app_secret' => app_secret,
  'default_graph_version' => default_graph_version,
  'default_access_token' => 'APP-ID|APP-SECRET',
  'persistent_data_handler' => 'session'
  ]);

$_SESSION['FBRLH_state']=$_GET['state'];
$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

// Logged in
//echo '<h3>Access Token</h3>';
//var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
//echo '<h3>Metadata</h3>';
//var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId(app_id); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    // setting default access token to be used in script
    
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
    exit;
  }

 // echo '<h3>Long-lived</h3>';
  //var_dump($accessToken->getValue());
}

$_SESSION['facebook_access_token'] = (string) $accessToken;
$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);

/*try {
    $profile_request = $fb->get('/me?fields=id,name,email');
    $user = $profile_request->getGraphUser();
    //echo '<h4>'.$user.'</h4>';
    
    $profile = $profile_request->getGraphNode()->asArray();
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    session_destroy();
    // redirecting user back to app login page
    header("Location: ./");
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }

   
    

  // getting all photos of user
  try {
    $photos_request = $fb->get('/me/photos?limit=5&type=uploaded');
    $photos = $photos_request->getGraphEdge();
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }

///me?fields=albums.limit(5){name, photos.limit(2)}

   try {
    $albums = $fb->get('/me/albums?fields=id')->getGraphEdge()->asArray();
    var_dump($albums);
   echo "<script> console.log(". json_encode( $albums,true).") </script>";
   $data = [];
     $data = json_encode( $albums,true);
echo "<script> console.log(". $data."); </script>";
    //print_r($albums);
    $pictures = [];
    for ($i=0; $i <count($albums) ; $i++) { 
      $pid = $albums[$i]['id'];
      $pics = $fb->get('/'.$pid.'/photos?fields=source,picture')->getGraphEdge()->asArray();
      //var_dump($pics);
      $pictures[$i] = $pics;
     echo '<h5>'.$albums[$i]['id'].'</h5>'; 
    }
    //var_dump($pictures);

   /* foreach ($data as $album) {
      $pics = $fb->get('/'.$album['id'].'/photos?fields=source,picture');
      echo "<script> console.log(". json_encode( $pics ).") </script>";
      $pictures[$album['id']] = $pics['data'];
    }*/
  
  //display the pictures url
 /* foreach ($pictures as $album) {
    //Inside each album
    foreach ($album as $image) {
      //$output .= $image['source'] . '<br />';
      //echo '<h5>'.$image['source'].'</h5><br />';
       echo '<img src="'.$image['source'].'">';
    }
    echo "<br>";

  }
 
    
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }
    */
  /*foreach ($albums['data'] as $al) {
     echo '<h5>'.$al['id'].'  '.$al['name'].'</h5>';
  }*/
  //echo '<h5>'.$albums['data'].'</h5>';

  /*$all_photos = array();
  if ($fb->next($photos)) {
    $photos_array = $photos->asArray();
    $all_photos = array_merge($photos_array, $all_photos);
    while ($photos = $fb->next($photos)) {
      $photos_array = $photos->asArray();
      $all_photos = array_merge($photos_array, $all_photos);
    }
  } else {
    $photos_array = $photos->asArray();
    $all_photos = array_merge($photos_array, $all_photos);
  }
  foreach ($all_photos as $key) {
    $photo_request = $fb->get('/'.$key['id'].'?fields=images');
    $photo = $photo_request->getGraphNode()->asArray();
    echo '<img src="'.$photo['images'][2]['source'].'"><br>';
  }*/



// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
header('Location: https://angfbheroku.herokuapp.com');



?>