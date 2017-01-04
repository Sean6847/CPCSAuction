<?php 
 
session_start();
 
if ($_GET['login']) {
     // Only load the code below if the GET
     // variable 'login' is set. You will
     // set this when you submit the form
	 
	 $user = $_POST['username'];
	 $pass = $_POST['password'];
	 
	 //include('connect.db.php');
	 
	 //$query = mysql_query("SELECT * FROM credentials WHERE user='$user'");
	 //$numrows = mysql_num_rows($query);
	 
	 //$dbuser= $row['user'];
	 //$dbpass= $row['pass'];
 
     if ($user == 'admin' && $pass == 'Auct!on123') {
         // Load code below if both username
         // and password submitted are correct
 
         $_SESSION['loggedin'] = 1;
          // Set session variable
 
         header("Location: add_item.php");
         exit;
         // Redirect to a protected page
 
     } else echo "<span id='red'>Wrong credentials</span>";
     // Otherwise, echo the error message
 
}
 
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link href="style.css" type="text/css" rel="stylesheet"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="CPCS, auction, cedar, park, christian, school" />
<meta http-equiv="author" content="Sean Muir">
<title>Auction - Catalog</title>
<script type="text/javascript" src="[JS library]"></script>
<!--[if lt IE 9]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->
</head>

<body>

<div class="container">
<?php include 'includes/banner.php'; ?>
<?php include 'includes/navigation.php'; ?>
	<div class="main">

Log in:
<form action="?login=1" method="post">
Username: <input type="text" name="username" />
Password: <input type="password" name="password" />
<input type="submit" />
</form>

</div>

	<?php include 'includes/footer.php'; ?>
</div>

</body>
</html>