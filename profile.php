<?php
session_start();

	include('protected.php');
	
	session_start();
	
	function renderProfile($id, $name, $user, $email, $password, $validated, $bidderNum, $adminPrivelege, $managerPrivelege)
	{
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link href="style.css" type="text/css" rel="stylesheet"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="CPCS, auction, cedar, park, christian, school" />
<meta http-equiv="author" content="Sean Muir">
<title>Auction - <?php echo $_SESSION['user'] ?></title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
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
                <h1><?php echo $user; if($adminPrivelege){ echo ' (Administrator Access)';}elseif($managerPrivelege){echo ' (Manager Access)';} ?></h1> 
                
                <?php
				
				include('connect.db.php');
				
                if($adminPrivelege)
                {
				 $result = $connection->query("SELECT * FROM credentials WHERE validated = '0' ORDER BY id DESC") or die('No Records Found' . $connection->error); 
				 if($result->num_rows)
				 {
					 $newUsers = '(' . $result->num_rows . ' New)';
				 }
				 else
				 {
				 	 $newUsers = '';
				 }
				 
				 			 
                 echo '<p id="center"> <a href="manage_users.php">Manage Users '.$newUsers.'</a> - <a href="manage_products.php">Manage Products</a> </p>';
                }elseif($managerPrivelege){
					echo '<p id="center"><a href="manage_products.php">Manage Products</a> </p>';
				}
				?>
                
                <div id="boxBorder">
                
                <p><span id="bold">Name:</span> <?php echo $name; ?></p>
                <p><span id="bold">Email:</span> <?php echo $email; ?> <a href="edit_user.php?id=<? echo $id;?>">Change</a></p>
                <p><span id="bold">Password:</span> <?php echo str_repeat('*',$password); ?> <a href="edit_user.php?id=<? echo $id;?>">Change</a></p>
                <p><span id="bold">Validated:</span> <?php echo $validated; ?></p>
                <p><span id="bold">Bidder #:</span> <?php echo $bidderNum; ?></p>
                
                </div>
                
                <div id="center">        
                <h2>My Winning Bids</h2>
                <p id="subtext">See the items for which you are currently the top bidder</p>
                </div>
                
                <?php
				
				$bidderNum = $_SESSION['bidder'];
				
				$data_p = $connection->query("SELECT * FROM products WHERE lastBidder='$bidderNum' ORDER BY lastBidTime")
				
				or die('No Records Found' . $connection->error);
						
				while($info = $data_p->fetch_array(MYSQLI_ASSOC))
                {
                
                    $pName = $info['productName'];
                    
                    $upcNumber 	= $info['upcNumber'];
                    
                    $picture1 	= $info['picture_t'];
                    
                    $currentBid = $info['currentBid'];
                    
                    echo	'<a id="noUnderline" href="catalog.php?item=' . $upcNumber . '">';
					echo 	'<div id="quarterbox">';		
                    echo	'<div id="imgbox">';
                    echo	'<img id="imgboximg" src="uploads/' . $picture1 . '"/>';
                    echo	'</div>';
                    echo	'<h3>' . $pName . '</h3>';
					echo	'<p id="black">Current Bid: $' . $currentBid . '</p>';
					echo	'</div>';
                    echo	'</a>';
                }
				?>
                <div id="line"></div>
                
                <div id="center">        
                <h2>My Watch List</h2>
                <p id="subtext">See your saved items so you can bid later. You can save up to 15 items.</p>
				<?php
				
				$watchlist = $connection->query("SELECT * FROM watchlist WHERE user='$bidderNum' ORDER BY id") or die('No Records Found' . $connection->error);
				
				while($watched = $watchlist->fetch_array(MYSQLI_ASSOC))
				{
					$watchedItem = $watched['item'];
					$watchedID = $watched['id'];
					
					$data_p = $connection->query("SELECT * FROM products WHERE id='$watchedItem' ORDER BY lastBidTime")
					
					or die('No Records Found' . $connection->error);
					
					$info = $data_p->fetch_array(MYSQLI_ASSOC);
                
                    $pName = $info['productName'];
                    
                    $upcNumber	= $info['upcNumber'];
                    
                    $picture1 	= $info['picture_t'];                    
                    
                    $currentBid = $info['currentBid'];
                    
                    
					echo 	'<div id="quarterbox">';
					echo	'<div id="remove"><div id="removeTriangle"></div><a href="delete_watched_item.php?id='. $watchedID .'"><div id="removeX">X</div></a></div>';
					echo	'<a id="noUnderline" href="catalog.php?item=' . $upcNumber . '">';
                    echo	'<div id="imgbox">';
                    echo	'<img id="imgboximg" src="uploads/' . $picture1 . '"/>';
                    echo	'</div>';
                    echo	'<h3>' . $pName . '</h3>';
					echo	'<p id="black">Current Bid: $' . $currentBid . '</p>';
					echo	'</a>';
					echo	'</div>';
                    
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
	
	include('connect.db.php');
	
	$sessionUser = $_SESSION['user'];
	
	$query = $connection->query("SELECT * FROM credentials WHERE user='$sessionUser'") or die($connection->error);
	
	$info = $query->fetch_array(MYSQLI_ASSOC);
	
	$id		= $info['id'];
	$name 	= $info['firstName'] . ' ' . $info['lastName'];
	$user 	= $info['user'];
	$email 	= $info['email'];
	$password 	= $info['passLength'];
	$bidderNum 	= $info['bidderNum'];
		if($bidderNum <= 0)
			$bidderNum = 'Not assigned';
	$adminPrivelege = $info['adminPrivelege'];
	$managerPrivelege = $info['managePrivelege'];
	
	if($info['validated'])
		$validated = 'Yes';
	else
		$validated = 'No';

	renderProfile($id, $name, $user, $email, $password, $validated, $bidderNum, $adminPrivelege, $managerPrivelege);
	
	$connection->close();
?>


