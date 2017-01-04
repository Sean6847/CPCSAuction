<?php
	session_start();
	
	include('connect.db.php');
	
	$count = $connection->real_escape_string(htmlspecialchars($_GET['count']));
	
	$_SESSION['numDisplay'] = $count;
	
	//echo $_SESSION['numDisplay'];
	
	session_start();

	header('Location: ' . $_SERVER['HTTP_REFERER']);
	
	exit;

?>