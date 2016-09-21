<?php

require_once __DIR__ . '/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '1598149520487843', // Replace {app-id} with your app id
  'app_secret' => '2725a6372883a264e6e4be957f26f0d8',
  'default_graph_version' => 'v2.7',
  'persistent_data_handler' => 'session'
  ]);

// getting basic info about user
	try {
		$profile_request = $fb->get('/me');
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

?>