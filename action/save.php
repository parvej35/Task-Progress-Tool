<?php 

	require('configuration.php');

	$title = $_POST['title'];
	$title = str_replace("'","",$title);
	$title = str_replace('"','',$title);

	$topic_id = $_POST['topic_id'];
	$app_user_id = $_POST['app_user_id'];

    //$title = mysql_real_escape_string($title);


	$sql = "INSERT INTO tasks (app_user_id, topic_id, title, created_on, position_id, status_id, is_active, updated_on) VALUES (".$app_user_id.", ".$topic_id.", '".$title."', '".date("Y-m-d H:i:s")."', 1, 1, 1, NULL);";

	// echo $sql;

    // $mysqli->query($sql);
    mysqli_query($connection, $sql);

    mysqli_close($connection);