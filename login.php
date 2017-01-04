<?php
session_start();
ob_start();
?>

<?php 

$error = false;
 
if ($_GET['login']) {
     // Only load the code below if the GET
     // variable 'login' is set. You will
     // set this when you submit the form
	 
	 $user = $_POST['username'];
	 $pass = crypt($_POST['password'],'$6$rounds=5000$thisisarandomstringforasalt$');
	 
	 include('connect.db.php');
	 
	 $query = $connection->query("SELECT * FROM credentials WHERE user='$user'");
	
	 $row = $query->fetch_array(MYSQLI_ASSOC);
	 
	 $dbuser = $row['user'];
	 $dbpass = $row['pass'];
	 $admin  = $row['adminPrivelege'];
	 $manager	= $row['managePrivelege'];
	 $bidderNum = $row['bidderNum'];
	 $valid		= $row['validated'];
	 
	 echo $dbpass;
 
     if ((strcasecmp($user, $dbuser) == 0) && $pass == $dbpass) {
         // Load code below if both username
         // and password submitted are correct
 
 		 $_SESSION['user'] = $dbuser;
		 $_SESSION['bidder'] = $bidderNum;
		 $_SESSION['admin'] = $admin;
		 $_SESSION['manager'] = $manager;
         $_SESSION['loggedin'] = 1;
		 $_SESSION['validated'] = $valid;
          // Set session variable

			session_start();
			header("Location: profile.php");
			exit;
 		
     } 
	 else $error = true;
	 
	 $connection->close();
}

ob_end_clean();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link href="style.css" type="text/css" rel="stylesheet"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="CPCS, auction, cedar, park, christian, school" />
<meta http-equiv="author" content="Sean Muir">
<title>Auction - Login</title>
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
        	<?php
			if($error)
			{
				echo "<div id='red'>Wrong credentials</div>";
				// Otherwise, echo the error message
			}
			?>
            <h3>Log in:</h3>
            <form action="?login=1" method="post" enctype="multipart/form-data">
            Username: <input type="text" name="username" value=""/> </br>
            Password: <input type="password" name="password"  value=""/> </br>
            <input type="submit" />
            </form>
            
            </br>
            
            <h3> Don't have an account? Apply for one <a href="register.php">here</a>.
        </div>
        
        <?php include 'includes/footer.php'; ?>
        
    </div>
</div>
</body>
</html>
