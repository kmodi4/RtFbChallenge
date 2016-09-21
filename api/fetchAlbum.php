<?php

header('Access-Control-Allow-Origin: *'); 
require_once __DIR__ . '/src/Facebook/autoload.php';
include_once 'fbconfig.php';

if (session_status() == PHP_SESSION_NONE){ session_start(); }

$fb = new Facebook\Facebook([
  'app_id' => app_id, // Replace {app-id} with your app id
  'app_secret' => app_secret,
  'default_graph_version' => default_graph_version,
  'default_access_token' => $_SESSION['facebook_access_token'],
  'persistent_data_handler' => 'session'
  ]);

 try {
    /*$albums = $fb->get('/me?fields=albums.limit(10)')->getGraphNode()->asArray();
     $pictures = $albums['albums'];
   //echo "<script> console.log(". json_encode( $albums,true).") </script>";
   
     $cover_photoes = [];
     $i=0;
    foreach ($pictures as $cover) {
      if(isset($cover['id'])){
       $pid = $cover['id'];
       $pics = $fb->get('/'.$pid.'?fields=picture,name')->getGraphNode()->asArray();
       $cover_photoes[$i] = $pics;
       $i = $i + 1;
     }
    }*/

   $albums = $fb->get('me?fields=albums.limit(10){picture,name}')->getGraphNode()->asArray();
   $pictures = $albums['albums'];
    
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }

   echo json_encode($pictures);


?>