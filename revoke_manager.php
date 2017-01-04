<?php
	ob_start();
	include('protectedAdmin.php');
	include('connect.db.php');
	// check if the 'id' variable is set in URL, and check that it is valid
	if (isset($_GET['id']) && is_numeric($_GET['id']))
	{
		// get id value
		$id = $_GET['id'];
		$connection->query("UPDATE credentials SET managePrivelege='0' WHERE id='$id'")
		or die($connection->error);
	}
	$connection->close();
	header("Location: manage_users.php");
	ob_end_clean();
?>