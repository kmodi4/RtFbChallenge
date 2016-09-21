<?php

header('Access-Control-Allow-Origin: *'); 
require_once __DIR__ . '/src/Facebook/autoload.php';
include_once 'fbconfig.php';


$fb = new Facebook\Facebook([
  'app_id' => app_id, 
  'app_secret' => app_secret,
  'default_graph_version' => default_graph_version
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email','user_photos']; // Optional permissions //http://kmodi4.com/HerokuTest2/
$loginUrl = $helper->getLoginUrl('https://angfbheroku.herokuapp.com/api/fb-callback.php', $permissions);
$result['loginurl'] = $loginUrl;
echo json_encode($result);
//echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>'

?>