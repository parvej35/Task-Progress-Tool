<?php 

	require('configuration.php');

	$id = $_GET['id'];
	$status_id = $_GET['status_id'];

	$sql = "UPDATE tasks SET status_id = ".$status_id.", updated_on = '".date("Y-m-d H:i:s")."' WHERE id = " .$id;
	//echo $sql;
	
	// $mysqli->query($sql);
	mysqli_query($connection, $sql);

	mysqli_close($connection);