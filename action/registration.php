<?php
    require('configuration.php');

    include '../Email.php';

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $current_time = date('Y-m-d h:i:s', time());

    $sql = "SELECT id FROM app_user WHERE email = '".$email."' AND oauth_provider = 'Manual'";
    $result = $connection->query($sql);

    if ($result->num_rows == 0) {

        $access_token = generateAccessToken();

        $sql = "INSERT INTO app_user (oauth_uid, first_name, last_name, email, password, gender, mobile, locale, picture, oauth_provider, modified, created, is_account_verified, access_token) VALUES ('', '".$first_name."', '".$last_name."', '".$email."', '".$password."', '', '', 'en', '', 'Manual', null, '".$current_time."', 0, '".$access_token."')";

        // if ($mysqli->query($sql) === TRUE) {
        if (mysqli_query($connection, $sql)) {

            $app_user_id = mysqli_insert_id($connection);    

            $data = array();

            $page_url = APP_BASE_URL.ACCOUNT_VERIFICATION_PAGE."?token=".$access_token;
            $emailObj = new Email();
            $isSent = $emailObj->buildMailAndSend($first_name." ".$last_name, $email, $page_url, "ACCOUNT_ACTIVATION", $data);

            echo json_encode(array("isError" => "false", "message" => "Registration completed successfully."));

        } else {

            echo json_encode(array("isError" => "true", "message" => "Registration failed."));

        }

    } else {

        echo json_encode(array("isError" => "true", "message" => "Email is already registered."));

    }