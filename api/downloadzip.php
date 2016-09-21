<?php

header('Access-Control-Allow-Origin: *'); 
require_once __DIR__ . '/src/Facebook/autoload.php';
include_once 'fbconfig.php';

if (session_status() == PHP_SESSION_NONE){ session_start(); }

header('Access-Control-Allow-Origin: *'); 

$post = json_decode(file_get_contents("php://input"), true);

$fb = new Facebook\Facebook([
  'app_id' => app_id, // Replace {app-id} with your app id
  'app_secret' => app_secret,
  'default_graph_version' => default_graph_version,
  'default_access_token' => $_SESSION['facebook_access_token'],
  'persistent_data_handler' => 'session'
  ]);

$aid = $post['aid'];
$albumname = $post['aname'];
$zip_folder = "";
  $album_download_directory = 'album/'.uniqid().'/';
  mkdir($album_download_directory, 0777);

  try {
  
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

   //echo json_encode($albums);
  # define file array
$files = array();
  foreach ($albums as $obj) {
     array_push($files, $obj['source']);
  }

# create new zip opbject
$zip = new ZipArchive();

# create a temp file & open it
$tmp_file = tempnam('.','');
$zip->open($tmp_file, ZipArchive::CREATE);
$i=1;
# loop through each file
foreach($files as $file){

    $album_directory = $album_download_directory.$albumname;
    if ( !file_exists( $album_directory ) ) {
      mkdir($album_directory, 0777);
    }
    # download file
    //$download_file = file_get_contents($file);

    #add it to the zip
    //$zip->addFromString($albums[$i]['name']."jpg",$download_file);
    //$i = $i + 1;
    file_put_contents($album_directory.'/'.$i.".jpg", fopen( $file, 'r'));
    $i = $i + 1;

}

# close zip
$zip->close();

require_once('zipper.php');
    $zipper = new zipper();
    echo $zipper->get_zip($album_download_directory);

# send the file to the browser as a download
//header('Content-disposition: attachment; filename=DownloadAlbum.zip');
//header('Content-type: application/zip');
//readfile($tmp_file);

?>