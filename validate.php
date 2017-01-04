<?php
session_start();
ob_start();
?>

<?php
include('protected.php');
?>

<?php

function renderForm($error, $id, $user, $name, $bidderNum)
{
	
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link href="style.css" type="text/css" rel="stylesheet"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="CPCS, auction, cedar, park, christian, school" />
<meta http-equiv="author" content="Sean Muir">
<title>Auction - Validate</title>
<script type="text/javascript" src="[JS library]"></script>
<!--[if lt IE 9]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->
</head>

<body>

<div id="page-wrap">
<div class="container">
<?php include 'includes/banner.php'; ?>
<?php include 'includes/navigation.php'; ?>
	<div class="main">
 <?php 
 // if there are any errors, display them
 if ($error != '')
 {
 echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
 }
 ?> 
 
 <h1><?php echo $user;?></h1>
 <div id="center">
<form action="" method="post" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?php echo $id; ?>"/>

<p><span id="bold">Name:</span> <?php echo $name; ?></p>
 
<p>Assign Bidder #: <input name="bidderNum" type="text" value="<?php echo $bidderNum; ?>"></p>

<p>
<input name="submit" type="submit" value="Validate User">
</p>

</form>
</div>
</div>

	<?php include 'includes/footer.php'; ?>
</div>
</div>
 </body>
 </html>
 
 
<?php 
}

include('connect.db.php');


if (isset($_POST['submit']))
{ 

	if (is_numeric($_POST['id']))
	{

		$id 		= $_POST['id']; 
		$bidderNum 	= $connection->real_escape_string(htmlspecialchars($_POST['bidderNum']));
		
		$result = $connection->query("SELECT * FROM credentials WHERE id=$id")or die($connection->error); 
		$row = $result->fetch_array(MYSQLI_ASSOC);
		
		$user = $row['user'];
		$name = $row['firstName'] . ' ' . $row['lastName'];
		
		$bidderExists = $connection->query("SELECT * FROM credentials WHERE bidderNum='$bidderNum'") or die($connection->error);

		if ($bidderNum == '')
		{
			$error = 'ERROR: Please fill in all required fields!';
			
			renderForm($error, $id, $user, $name, $bidderNum);
		}
		elseif($bidderExists->num_rows != 0)
		{
			$error = 'ERROR: This bidder number already exists!';
		
			renderForm($error, $id, $user, $name, $bidderNum);
		}
		else
		{
			$connection->query("UPDATE credentials SET bidderNum='$bidderNum', validated='1' WHERE id='$id'")
			or die($connection->error);

			header("Location: manage_users.php");
				ob_end_clean();
		}
	}
	else
	{
		echo 'Error! Invalid ID!';
	}
}
else
{
	if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
	{
		$id = $_GET['id'];
		
		$result = $connection->query("SELECT * FROM credentials WHERE id=$id")
		or die($connection->error); 
		
		$row = $result->fetch_array(MYSQLI_ASSOC);
		
		if($row)
		{
			// get data from db
			$user = $row['user'];
			$name = $row['firstName'] . ' ' . $row['lastName'];
			
			// show form
			renderForm($error, $id, $user, $name, $bidderNum);
		}
		else
		{
			echo "No results!";
		}
	}
	else
	{
		echo 'Error!';
	}
}

$connection->close();
?>