<?php
session_start();

function renderform($firstName,$lastName,$userName,$email,$emailConfirm,$error)
{
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link href="style.css" type="text/css" rel="stylesheet"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="CPCS, auction, cedar, park, christian, school" />
<meta http-equiv="author" content="Sean Muir">
<title>Auction - Register</title>
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
        
        <div class="main" id="center">
        	<h1>Register for a new account</h1>
            
        	<?php
			if($error != '')
			{
				echo "<div id='red'>" . $error . "</div>";
			}
			?>
            
            <form action="" method="post" enctype="multipart/form-data">
                <p>First Name: 			<input type="text" name="firstName" value="<?php echo $firstName ?>"/></p>
                <p>Last Name: 			<input type="text" name="lastName" value="<?php echo $lastName ?>"/></p>
                <p>Username: 			<input type="text" name="userName" value="<?php echo $userName ?>"/></p>
                <p>Email: 				<input type="text" name="email" value="<?php echo $email ?>"/></p>
                <p>Confirm Email:		<input type="text" name="emailConfirm" value="<?php echo $emailConfirm ?>"/></p>
                <p>Password: 			<input type="password" name="password"  value=""/></p>
                <p>Confirm Password: 	<input type="password" name="passwordConfirm" value=""/></p>
            <input name="submit" type="submit" />
            </form>
        </div>
        
        <?php include 'includes/footer.php'; ?>
        
    </div>
</div>
</body>
</html>

<?php
}

include('connect.db.php');

if(isset($_POST['submit']))
{
	$firstName 			= $connection->real_escape_string($_POST['firstName']);
	$lastName 			= $connection->real_escape_string($_POST['lastName']);
	$userName			= $connection->real_escape_string($_POST['userName']);
	$email				= $connection->real_escape_string($_POST['email']);
	$emailConfirm 		= $connection->real_escape_string($_POST['emailConfirm']);
	$password			= crypt($connection->real_escape_string($_POST['password']),'$6$rounds=5000$thisisarandomstringforasalt$');
	$passwordConfirm	= crypt($connection->real_escape_string($_POST['passwordConfirm']),'$6$rounds=5000$thisisarandomstringforasalt$');
	$passLength			= strlen($_POST['password']);
	
	$emailExists = $connection->query("SELECT * FROM credentials WHERE email='$email'") or die($connection->error);
	$userExists = $connection->query("SELECT * FROM credentials WHERE user='$userName'") or die($connection->error);
	
	if($firstName == '' || $lastName == '' || $userName == '' || $email == '' || $emailConfirm == '' || $password == '' || $passwordConfirm == '')
	{
		$error = 'ERROR: Please fill in all required fields!';
		
		renderForm($firstName,$lastName,$userName,$email,$emailConfirm,$error); 
	}
	elseif($email != $emailConfirm)
	{
		$error = 'ERROR: Email does not match!';
		
		renderForm($firstName,$lastName,$userName,$email,$emailConfirm,$error); 
	}
	elseif($password != $passwordConfirm)
	{
		$error = 'ERROR: Password does not match!';
		
		renderForm($firstName,$lastName,$userName,$email,$emailConfirm,$error); 
	}
	elseif($emailExists->num_rows != 0)
	{
		$error = 'ERROR: An account already exists for this email!';
		
		renderForm($firstName,$lastName,$userName,$email,$emailConfirm,$error); 
	}
	elseif($userExists->num_rows != 0)
	{
		$error = 'ERROR: This username is already taken!';
		
		renderForm($firstName,$lastName,$userName,$email,$emailConfirm,$error); 
	}
	else
	{
		$error = 'Got this far :/';
		$connection->query("INSERT INTO credentials(firstName,lastName,user,pass,passLength,email)
					VALUES('$firstName','$lastName','$userName','$password','$passLength','$email')")
		or die($connection->error);
		
		{
			//define the receiver of the email
			$to = $email;
			//define the subject of the email
			$subject = 'Bidding Account Registration'; 
			//define the headers we want passed. Note that they are separated with \r\n
			$headers = "From: AuctionSupport@laseritnow.com\r\nReply-To: AuctionSupport@laseritnow.com";
 
			//define the body of the message.
			ob_start(); //Turn on output buffering
			?>
			
			Dear <?php echo $firstName . ' ' . $lastName?>,
			Thank you for requesting a bidding account! 
			
			Your username: <?php echo $userName;?>
			
			Please allow time to authorize your account.
			
			If you have any questions or concerns, or you did not register for an account, email AuctionSupport@laseritnow.com.

			<?
			//copy current buffer contents into $message variable and delete current output buffer
			$message = ob_get_clean();
			//send the email
			$mail_sent = @mail( $to, $subject, $message, $headers );
		}

		ob_start();
		
		header( "refresh:5;url=login.php" );
		echo '<head><link href="style.css" type="text/css" rel="stylesheet"/></head>';
		echo '<div id="center"> <h1>Thank you for registering!</h1> <p>You will receive an email confirmation shortly.</p><p>Returning you to the login page.</p> </div>';
		ob_end_flush();
		
	}
}
else
{
	renderForm('','','','','','');
}


ob_end_clean();
$connection->close();
?>