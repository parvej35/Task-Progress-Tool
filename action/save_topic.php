<?php 

	require('configuration.php');

	$title = $_POST['title'];
	$title = str_replace("'","",$title);
	$title = str_replace('"','',$title);

	$app_user_id = $_POST['app_user_id'];

	$sql = "INSERT INTO topic (app_user_id, title, created_on, is_active, updated_on) 
            VALUES (".$app_user_id.", '".$title."', '".date("Y-m-d H:i:s")."', 1, NULL);";

    mysqli_query($connection, $sql);

    mysqli_close($connection);