<?php 

	require('configuration.php');

	$id = $_GET['id'];
	$sql = "DELETE FROM tasks WHERE id = " .$id;

	// $mysqli->query($sql);
	mysqli_query($connection, $sql);

	mysqli_close($connection);