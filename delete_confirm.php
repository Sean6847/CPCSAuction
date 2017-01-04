<?php
session_start();
?>

<?php
	$id = $_GET['id'];
?>
<?php
include('protectedManager.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="style.css" type="text/css" rel="stylesheet"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="CPCS, auction, cedar, park, christian, school" />
<meta http-equiv="author" content="Sean Muir">
<title>Manage Products</title>
</head>

<body>

<div id="page-wrap">
<div class="container">
<?php include 'includes/banner.php'; ?>
<?php include 'includes/navigation.php'; ?>
<div class="main">

	<?php
	include('connect.db.php');

	// get results from database
	
	$result = $connection->query("SELECT * FROM products WHERE id='$id'") 
	or die('No Records Found' . $connection->error);
	
	$row = $result->fetch_array(MYSQLI_ASSOC);
	
	$picture 		= $row['picture'];
	$picture_t 		= $row['picture_t'];
	$id				= $row['id'];
	$productName	= $row['productName'];
	$value			= $row['value'];
	
	echo	'<div id="center" style="max-width:400px;">';
	echo	'<p id="center"> Are you sure you wish to delete this item?</p>';
	echo	'<p><a style="margin-right:50px;" href="delete.php?id='. $id .'">Yes</a> <a id="red" style="margin-left:50px;" href="manage_products.php">No</a></p>';
	
	
	echo 	'<div id="quarterbox">';				
	echo	'<div id="imgbox">';
	echo	'<img id="imgboximg" src="uploads/' . $picture_t . '"/>';
	echo	'</div>';
	echo	'<h3>' . $productName . '</h3>';
	echo	'<p id="black">' . $value . '</p>';
	echo    '</div>';
	echo    '</div>';
	
	?>
</div>
<?php include 'includes/footer.php'; ?>
</div>
</div>


</body>
</html>

<?php
$connection->close();
?>