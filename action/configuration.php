<?php

	define('APP_BASE_URL', 'http://localhost:8081/TASK_PROGRESS_TOOL/');
//	define('APP_BASE_URL', 'http://tpt.horekkhobor.com/');

	define('ACCOUNT_VERIFICATION_PAGE', 'verifyaccount.php');

	//DB configuration value
	define('DB_HOST', 'localhost');
	
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_NAME', 'todo_list_db');

//	define('DB_USERNAME', 'horekkho_task_progress_tool_admi');
//	define('DB_PASSWORD', 'BSzweDlLI=wC');
//	define('DB_NAME', 'horekkho_task_progress_tool');

	define('DB_USER_TBL', 'app_user');

	//$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	$connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

	function generateAccessToken() {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        $access_token = '';
        for ($i = 0; $i < 50; $i++) {
            $index = rand(0, $count - 1);
            $access_token .= mb_substr($chars, $index, 1);
        }

        return $access_token;
    }