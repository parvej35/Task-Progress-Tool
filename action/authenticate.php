<?php
    require('configuration.php');

    require_once 'User.php'; 

    $email = $_POST['email'];
    $password = $_POST['password'];

    $current_time = date('Y-m-d h:i:s', time());

    $sql = "SELECT id, oauth_uid, first_name, last_name, is_account_verified FROM app_user WHERE email = '".$email."' AND password = '".$password."' AND oauth_provider = 'Manual'";

    $result = $connection->query($sql);

    if ($result->num_rows > 0) {

        $id = "";
        $oauth_uid = "";
        $first_name = ""; 
        $last_name = "";
        $is_account_verified = "";

        while($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $oauth_uid = $row["oauth_uid"];
            $first_name = $row["first_name"];
            $last_name = $row["last_name"];
            $is_account_verified = $row["is_account_verified"];
        }

        if($is_account_verified == "0") {

            echo json_encode(array("isError" => "true", "message" => "You account is not verified.\n A verification mail sent at your registered email. Please check your email."));

        } else {

            $user = new User(); 
            $userData = $user->getUser($id); 

            // Storing user data in the session 
            if(!isset($_SESSION)) {
                session_start();
            }
            //$_SESSION['userData'] = $userData;
            $_SESSION['user_id'] = $id;
            
            echo json_encode(array("isError" => "false", "message" => "Login successful."));

        }
    } else {

        echo json_encode(array("isError" => "true", "message" => "Invalid credential"));

    }

    mysqli_close($connection);