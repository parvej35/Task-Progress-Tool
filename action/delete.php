<?php 

	require('configuration.php');

	$id = $_GET['id'];
	$sql = "UPDATE tasks SET is_active = 0, updated_on = '".date("Y-m-d H:i:s")."' WHERE id = " .$id;

	// $mysqli->query($sql);
	mysqli_query($connection, $sql);

	mysqli_close($connection);