<?php

header('Access-Control-Allow-Origin: *'); 
require_once __DIR__ . '/src/Facebook/autoload.php';
include_once 'fbconfig.php';

if (session_status() == PHP_SESSION_NONE){ session_start(); }
 

$post = json_decode(file_get_contents("php://input"), true);

$fb = new Facebook\Facebook([
  'app_id' => app_id, // Replace {app-id} with your app id
  'app_secret' => app_secret,
  'default_graph_version' => default_graph_version,
  'default_access_token' => $_SESSION['facebook_access_token'],
  'persistent_data_handler' => 'session'
  ]);

$aid = $post['aid'];

  try {
    /*$albums = $fb->get('/'.$aid.'/photos')->getGraphEdge()->asArray();
     $pictures = $albums['data'];
   //echo "<script> console.log(". json_encode( $albums,true).") </script>";
   
     $album_photoes = [];
     $i=0;
    foreach ($pictures as $cover) {
      if(isset($cover['id'])){
       $pid = $cover['id'];
       $pics = $fb->get('/'.$pid.'?fields=picture,name')->getGraphNode()->asArray();
       $album_photoes[$i] = $pics;
       $i = $i + 1;
     }
    }*/
    $albums = $fb->get('/'.$aid.'/photos?fields=picture,source,name')->getGraphEdge()->asArray();
 
    
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }

   echo json_encode($albums);

?>