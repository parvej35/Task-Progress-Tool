<?php

    //Include Configuration File
    include('action/configuration.php');
    
    include('google_config.php');

    // Include User library file 
    require_once 'action/User.php'; 

    $login_button = '';

    if(isset($_GET["code"])) {
        
        //It will Attempt to exchange a code for an valid authentication token.
        $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

        if(!isset($token['error'])) {
            
            // Initialize User class 
            $user = new User(); 

            //Set the access token used for requests
            $google_client->setAccessToken($token['access_token']);

            //Store "access_token" value in $_SESSION variable for future use.
            //$_SESSION['token'] = $token['access_token'];

            //Create Object of Google Service OAuth 2 class
            $google_service = new Google_Service_Oauth2($google_client);

            //Get user profile data from google
            $data = $google_service->userinfo->get();

            $gpUserData = array(); 
            $gpUserData['oauth_uid']  = !empty($data['id'])?$data['id']:''; 
            $gpUserData['first_name'] = !empty($data['given_name'])?$data['given_name']:''; 
            $gpUserData['last_name']  = !empty($data['family_name'])?$data['family_name']:''; 
            $gpUserData['email']       = !empty($data['email'])?$data['email']:''; 
            $gpUserData['gender']       = !empty($data['gender'])?$data['gender']:''; 
            $gpUserData['locale']       = !empty($data['locale'])?$data['locale']:''; 
            $gpUserData['picture']       = !empty($data['picture'])?$data['picture']:''; 

            $gpUserData['access_token']   = $token['access_token'];
             
            // Insert or update user data to the database 
            $gpUserData['oauth_provider'] = 'Google'; 
            $userData = $user->checkUser($gpUserData); 

            // Storing user data in the session 
            if(!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['user_id'] = $userData['id'];
            $_SESSION['userData'] = $userData;
            //$_SESSION['access_token'] = $token['access_token'];

            // print_r($_SESSION['userData']);

            // echo "location:index.php";
            header("location:index.php");
            exit();
            
        } else {

            header("location:login.php");   
            exit();

        }

    } else {

        header("location:login.php");  
        exit();  

    }