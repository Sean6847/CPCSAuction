<?php

	session_start();

	include('protected.php');

	include('connect.db.php');
	
	$item = $_GET['id'];
	$user = $_SESSION['bidder'];
	
	if(is_numeric($item))
	{
		$check = $connection->query("SELECT * FROM watchlist WHERE item = '$item' AND user='$user'") or die($connection->error);
		
		if($check->num_rows == 0)
		{
		$connection->query("INSERT INTO watchlist(user,item) VALUES('$user','$item')") or die($connection->error); 
		}
		
		header("Location: profile.php");
	}
	else
	{
		header("Location: catalog.php"); 
	}

	$connection->close();
?>