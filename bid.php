<?php
session_start();
ob_start();
?>

<?php
include('protectedValidated.php');
include('connect.db.php');
function renderForm($id, $bid, $error)
 {
?>
 
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link href="style.css" type="text/css" rel="stylesheet"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="CPCS, auction, cedar, park, christian, school" />
<meta http-equiv="author" content="Sean Muir">
<title>Auction - Catalog</title>

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
        
       <!---------------------------------------------------------------------------------------------------------->
        <?php
		include('connect.db.php');
        	if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
			 {
			 $id = $_GET['id'];
			 $result = $connection->query("SELECT * FROM products WHERE id=$id") or die($connection->error); 
			 $row = $result->fetch_array(MYSQLI_ASSOC);

			 if($row)
				 {

				 $name 			= $row['productName'];
				 $value 		= $row['value'];
				 $startBid 		= $row['startBid'];
				 $prevBid		= $row['prevBid'];
				 $currentBid	= $row['currentBid'];
				 $minIncrease	= $row['minIncrease'];
				 $upcNumber 	= $row['upcNumber'];
				 
				 if($row['picture'] != '')
				 {
					$picture1 	= $row['picture_t'];
				 }
				 else
				 {
					$picture1 	= 'not_available.png';	
				 }
			 	 }
			 }
			 else
				 {
				 echo 'Error!';
				 }
			?>
            
         <!---------------------------------------------------------------------------------------------------------->   
            
         <?php
			
			echo	'<a href="catalog.php?item=' . $upcNumber . '">';
            echo	'<div id="bidPage">';
            echo	'<img id="itemBoxImageSmall" src="uploads/' . $picture1 . '"/>';

            echo	'<h3 id="priceTag"> Value: ' . $value . '</h3>';
            echo	'<h2 id="name">' . $name . '</h2>';
            
            echo	'</div>';
			echo	'</a>';
        
          ?>
        
        <!---------------------------------------------------------------------------------------------------------->
        
        <div id="bidBox">
		
		<?php
			$endDate = new DateTime('2015-04-07');
			$now = new DateTime("now");
			
			if(!($endDate < $now))
			{
		?>
        <form action="" method="post" enctype="multipart/form-data" >
        
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        
        <p id="subtext">Starting Bid: $<?php echo $startBid; ?> --- Previous Bid: $<?php echo $prevBid; ?> --- <span id="green">Current Bid: $<?php echo $currentBid; ?></span></p>
               
        <p>Bid Amount: $<input name="bid" type="text" value="<?php echo $bid; ?>"></p>
		<p id="subtext">You must raise the bid by at least $<?php echo $minIncrease; ?></p>
        
        <p>
        <input name="submit" type="submit" value="Submit Bid">
        </p>
        
        </form>
		
		<? }
			else
			{
				echo "Bidding for this item has ended!";
			}
			?>
        </div>
		
		
    </div>
    
        <?php include 'includes/footer.php'; ?>
        
    </div>
</div>
 </body>
 </html>
 <?php 
 }

 // connect to the database
 
 
 // check if the form has been submitted. If it has, start to process the form and save it to the database
  if (isset($_POST['submit']))
 { 
 // confirm that the 'id' value is a valid integer before getting the form data
 if (is_numeric($_POST['id']))
 {
 // get form data, making sure it is valid
 $id 			= $_POST['id']; 
 $newBid 		= $connection->real_escape_string(htmlspecialchars($_POST['bid']));
 
 $result		= $connection->query("SELECT * FROM products WHERE id=$id") or die($connection->error); 
 $row 			= $result->fetch_array(MYSQLI_ASSOC);
 
 $upcNumber		= $row['upcNumber'];
 $startBid 		= $row['startBid'];
 $currentBid 	= $row['currentBid'];
 $minIncrease 	= $row['minIncrease'];
 
 $bidderNum		= $_SESSION['bidder'];
 
	 // check that fields are both filled in
	 if ($newBid == '')
	 {
	 // generate error message
	 $error = 'ERROR: Please fill in all required fields!';
	 
	 //error, display form
	 renderForm($id, $newBid, $error);
	 }
	 elseif(!is_numeric($newBid))
	 {
		// generate error message
	 $error = 'ERROR: Bid must only contain numbers!';
	 
	 // if either field is blank, display the form again
	 renderForm($id, $newBid, $error); 
	 }
	 elseif( $newBid < $startBid)
	 {
		$error = 'ERROR: Bid must exceed the starting bid!';
	 
		 // if either field is blank, display the form again
		 renderForm($id, $newBid, $error); 
	 }
	 elseif(($newBid - $currentBid) < $minIncrease)
	 {
		// generate error message
	 $error = 'ERROR: Bid must exceed the minimum bid increase!';
	 
	 // if either field is blank, display the form again
	 renderForm($id, $newBid, $error); 
	 }
	 else
	 {
	 // save the data to the database
	 $connection->query("UPDATE products SET prevBid='$currentBid', currentBid='$newBid', lastBidder='$bidderNum', lastBidTime=NOW() WHERE id='$id'") or die($connection->error);
	 
	 $connection->query("INSERT INTO bids(bidderNum, bidAmount, itemNum) VALUES ('$bidderNum', '$newBid', '$upcNumber')") or die($connection->error);
	 
	 // once saved, redirect back to the view page
	 header("Location: profile.php"); 
	 ob_end_clean();
	 }
 }
 else
 {
 // if the 'id' isn't valid, display an error
 echo 'Error!';
 }
 }
 /*----------------------------------------------------------------------------------------------------------*/
 /*----------------------------------------------------------------------------------------------------------*/
 /*----------------------------------------------------------------------------------------------------------*/
 else
 // if the form hasn't been submitted, get the data from the db and display the form
 {
	 
	 // get the 'id' value from the URL (if it exists), making sure that it is valid (checing that it is numeric/larger than 0)
	 if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
	 {
		 // query db
		 $id = $_GET['id'];
		 		
		 renderForm($id, '', '');
	 }
	 else
	 // if the 'id' in the URL isn't valid, or if there is no 'id' value, display an error
	 {
	 	echo 'Error!';
	 }
 }
 
 $connection->close();
 
 ?>