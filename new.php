<?php
session_start();
 ob_start();
?>

<?php
include('protected.php');
?> 

<?php
/* 
 NEW.PHP
 Allows user to create a new entry in the database
*/
 
 $target = "uploads/";
$target = $target . basename( $_FILES['photo']['name']);
 
 // creates the new record form
 // since this form is used multiple times in this file, I have made it a function that is easily reusable
 function renderForm($name, $desc, $val, $start, $min, $upc, $catalog, $donor, $error)
 {
 ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link href="style.css" type="text/css" rel="stylesheet"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="CPCS, auction, cedar, park, christian, school" />
<meta http-equiv="author" content="Sean Muir">
<title>Auction - New Item</title>
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
 <?php 
 // if there are any errors, display them
 if ($error != '')
 {
 echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
 }
 ?> 
 
 <h1> Add New Item</h1>
<form action="" method="post" enctype="multipart/form-data">

<table border="1" style="width: 700px; margin:0 auto; margin-top: 25px; text-align: center;">

<tr style="background-color: #eee; font-weight: bold;">
<td>Item Name</td>
<td>Item Donor</td>
<td>WebBid</td>
</tr>

<tr>
<td><input name="productName" type="text" value="<?php echo $name; ?>"></td>
<td><input name="donor" type="text" value="<?php echo $donor; ?>"></td>
<td><input name="webBid" type="checkbox" value="1" checked></td>
</tr>

</table>

<table border="1" style="width: 700px; margin:0 auto; margin-top: -1px; text-align: center;">

<tr style="background-color: #eee; font-weight: bold;">
<td>Item Image</td>
<td>Item Description</td>
</tr>

<tr>
<td><input type="hidden" name="size" value="350000">
    <input type="file" name="photo"></td>
<td><textarea name="description" rows="10" cols="60" value="<?php echo $desc; ?>"></textarea></td>
</tr>

</table>

<table border="1" style="width: 700px; margin:0 auto; margin-top: -1px; text-align: center;">

<tr style="background-color: #eee; font-weight: bold;">
<td>Item Category</td>
<td>Auction Section</td>
<td>Tracking Number</td>
<td>Catalog Number</td>
</tr>

<tr>
<td><select name="category" value="options">
<option value="">Select . . .</option>
<option value="">------------------</option>
<option value="afterAuction">After The Auction Sale</option>
	<?php include 'includes/set_categories.php'; //Having it included allows to easily change categories?> 
</SELECT></td>
<td><select name="auction" value="options">
<option value="">Select . . .</option>
<option value="">------------------</option>
<option value="silver">Silver</option>
<option value="gold">Gold</option>
<option value="fuchsia">Fuchsia</option>
<option value="live">Live</option>
<option value="penny">Penny Auction</option>
<option value="store">Auction Store</option>
</SELECT></td>
<td><input name="upcNumber" type="text" value="<?php echo $upc; ?>"></td>
<td><input name="catalogNumber" type="text" value="<?php echo $catalog; ?>"></td>
</tr>

</table>

<table border="1" style="width: 700px; margin:0 auto; margin-top: -1px; text-align: center;">

<tr style="background-color: #eee; font-weight: bold;">
<td>Item Value</td>
<td>
Starting Bid
<p id="subtext"> Recommended 30% of item value</p>
</td>
<td>Minimum Bid Increase</td>
</tr>

<tr>
<td><input name="value" type="text" value="<?php echo $val; ?>"></td>
<td>$<input name="startBid" type="text" value="<?php echo $start; ?>"></td>
<td>$<input name="minIncrease" type="text" value="<?php echo $min; ?>"></td>
</tr>

</table>

<table border="0" style="width: 700px; margin:0 auto; margin-top: -1px; text-align: center;">
	<tr>
		<td>
			<p>
			<input name="submit" type="submit" value="Add Item">
			</p>
		</td>
	</tr>
</table>

</form>
</div>

	<?php include 'includes/footer.php'; ?>
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
 // get form data, making sure it is valid
 $productName 	= $connection->real_escape_string(htmlspecialchars($_POST['productName']));
 $description 	= $connection->real_escape_string(htmlspecialchars($_POST['description']));
 $category 		= $connection->real_escape_string(htmlspecialchars($_POST['category']));
 $auction 		= $connection->real_escape_string(htmlspecialchars($_POST['auction']));
 $value 		= $connection->real_escape_string(htmlspecialchars($_POST['value']));
 $startBid 		= $connection->real_escape_string(htmlspecialchars($_POST['startBid']));
 $minIncrease	= $connection->real_escape_string(htmlspecialchars($_POST['minIncrease']));
 $upcNumber 	= $connection->real_escape_string(htmlspecialchars($_POST['upcNumber']));
 $catalogNumber	= $connection->real_escape_string(htmlspecialchars($_POST['catalogNumber']));
 $donor			= $connection->real_escape_string(htmlspecialchars($_POST['donor']));
 $webBid		= $connection->real_escape_string(htmlspecialchars($_POST['webBid']));
 $picture 		= $connection->real_escape_string(($_FILES['photo']['name']));
 $picture_t		= 't_'. $connection->real_escape_string(($_FILES['photo']['name']));
 
 // check to make sure both fields are entered
 if ($productName == '' || $description == '' || $value == '' || $startBid == '' || $minIncrease == '' || $upcNumber == '' || $donor == '')
 {
 // generate error message
 $error = 'ERROR: Please fill in all required fields!';
 
 // if either field is blank, display the form again
 renderForm($productName, $description, $value, $startBid, $minIncrease, $upcNumber, $catalogNumber, $donor, $error);
 }
 elseif(!is_numeric($startBid) || !is_numeric($minIncrease))
 {
	// generate error message
 $error = 'ERROR: Fields "Starting Bid" and "Minimum Bid Increase" can only contain numbers!';
 
 // if either field is blank, display the form again
 renderForm($productName, $description, $value, $startBid, $minIncrease, $upcNumber, $catalogNumber, $donor, $error); 
 }
 else
 {
 if($picture == '')
 {
	$picture 		= 'not_available.png';
	$picture_t		= 'not_available.png';
 }
 // save the data to the database
$connection->query("INSERT INTO products(productName,description,category,auctionSection,value,startBid,currentBid,minIncrease,upcNumber,catalogNumber,picture,picture_t,donor,webBid)
       		VALUES('$productName','$description','$category','$auction','$value','$startBid','$startBid','$minIncrease','$upcNumber','$catalogNumber','$picture','$picture_t','$donor','$webBid')")
 or die($connection->error); 
 
 include('SimpleImage.php');
 
 $image_t = new SimpleImage();
 $image_t->load($_FILES['photo']['tmp_name']);
 $image_t->resizeToWidth(280);
 $image_t->save("uploads/" . "t_" . basename( $_FILES['photo']['name']));
 
 $image = new SimpleImage();
 $image->load($_FILES['photo']['tmp_name']);
 if($image->getWidth() > 720)
 {
	$image->resizeToWidth(720);
 }
 $image->save("uploads/" . basename( $_FILES['photo']['name']));
 ?><!--move_uploaded_file($_FILES['photo']['tmp_name'], $target);--><?
 
 // once saved, redirect back to the view page
 header("Location: manage_products.php");
 ob_end_clean();
 }
 }
 else
 // if the form hasn't been submitted, display the form
 {
 renderForm('','','$0.00','','','','','','');
 }
 
 $connection->close();
?> 