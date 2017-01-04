<?php
session_start();
ob_start();
?>

<?php
include('protected.php');
?>

<?php
/* 
 Allows user to modify a new entry in the database
*/
 
 $target = "uploads/";
$target = $target . basename( $_FILES['photo']['name']);
 
 // creates the new record form
 // since this form is used multiple times in this file, I have made it a function that is easily reusable
 function renderForm($id, $username, $email, $error)
 {
 ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link href="style.css" type="text/css" rel="stylesheet"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="CPCS, auction, cedar, park, christian, school" />
<meta http-equiv="author" content="Sean Muir">
<title>Auction - Edit User</title>
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
 
<form action="" method="post" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?php echo $id; ?>"/>
 
 <h1>Edit User</h1>
 
<p id="green">Username: <?php echo $username; ?></p>

<p>Email Address</p>
<p><input name="email" type="text" value="<?php echo $email; ?>" width="100"></p>

<input name="submit" type="submit" value="Submit Changes">

<p>New Password</p>
<p><input name="password" type="password" value="" width="100"></p>
<p>Confirm Password</p>
<p><input name="passwordConfirm" type="password" value="" width="100"></p>


<input name="submit" type="submit" value="Submit Changes">
</p>

</form>
</div>

	<?php include 'includes/footer.php'; ?>
</div>
</div>
 </body>
 </html>
 <?php 
 }
 

 

 // connect to the database
 include('connect.db.php');
 
 // check if the form has been submitted. If it has, start to process the form and save it to the database
  if (isset($_POST['submit']))
 { 
 // confirm that the 'id' value is a valid integer before getting the form data
 if (is_numeric($_POST['id']))
 {
 // get form data, making sure it is valid
 $id 				= $_POST['id']; 
 $email		 		= $connection->real_escape_string(htmlspecialchars($_POST['email']));
 $password 			= crypt($connection->real_escape_string(htmlspecialchars($_POST['password'])),'$6$rounds=5000$thisisarandomstringforasalt$');
 $passwordConfirm	= crypt($connection->real_escape_string(htmlspecialchars($_POST['passwordConfirm'])),'$6$rounds=5000$thisisarandomstringforasalt$');
 $passLength		= strlen($_POST['password']);
 
 // check that fields are both filled in
 if($password != $passwordConfirm)
 {
	$error = 'ERROR: Password does not match!';
	
	renderForm($id, $username, $email, $error); 
 }
 else
 {
	 if ($password != '')
	 {
		 // save the data to the database
		 $connection->query("UPDATE credentials SET pass='$password', passLength='$passLength' WHERE id='$id'")
		 or die($connection->error);
	 }
	 if ($email != '')
	 {
		$connection->query("UPDATE credentials SET email='$email' WHERE id='$id'")
		or die($connection->error);
	 }
 }
	 
 
 // once saved, redirect back to the view page
 header("Location: profile.php");
ob_end_clean();
 }

 else
 {
 // if the 'id' isn't valid, display an error
 echo 'Error!';
 }
 }
 else
 // if the form hasn't been submitted, get the data from the db and display the form
 {
 
 // get the 'id' value from the URL (if it exists), making sure that it is valid (checking that it is numeric/larger than 0)
 if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
 {
 // query db
 $id = $_GET['id'];
 $result = $connection->query("SELECT * FROM credentials WHERE id=$id")
 or die($connection->error); 
 $row = $result->fetch_array(MYSQLI_ASSOC);
 
 // check that the 'id' matches up with a row in the databse
 if($row)
 {
 
 // get data from db
 $username	 	= $row['user'];
 $email		 	= $row['email'];
 
 // show form
 renderForm($id, $username, $email, '');
 }
 else
 // if no match, display result
 {
 echo "No results!";
 }
 }
 else
 // if the 'id' in the URL isn't valid, or if there is no 'id' value, display an error
 {
 echo 'Error!';
 }
 }
 
 $connection->close();
 ?>