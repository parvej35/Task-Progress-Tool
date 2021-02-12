<?php

//    include('action/configuration.php');

	//Include Google Client Library for PHP autoload file
	require_once 'vendor/autoload.php';

	//Make object of Google API Client for call Google API
	$google_client = new Google_Client();

	$google_client->setClientId("452146522917-knb831l7feqsarhsk2tki4llpi0qpfsv.apps.googleusercontent.com");
	$google_client->setClientSecret("Dw4xsX3HAvJXQkAohqDlWcWc");

    $google_client->setRedirectUri("http://localhost:8081/TASK_PROGRESS_TOOL/google_auth.php");
//    $google_client->setRedirectUri("http://tpt.horekkhobor.com/google_auth.php");

	//Set scope
	$google_client->addScope('email');
	$google_client->addScope('profile');