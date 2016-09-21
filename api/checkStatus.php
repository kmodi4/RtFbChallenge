<?php
header('Access-Control-Allow-Origin: *'); 
   session_start();
  $res['success'] = false; 
  if(isset($_SESSION['facebook_access_token'])){
       $res['success'] = true;
  }
  echo json_encode($res);
?>