<?php
	session_start();

	$category = $_GET['cat'];
	$item = $_GET['item'];

	include('protectedAdmin.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="style.css" type="text/css" rel="stylesheet"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="CPCS, auction, cedar, park, christian, school" />
<meta http-equiv="author" content="Sean Muir">
<title>Manage Users</title>
</head>

<body>

<div id="page-wrap">
<div class="container">
<?php include 'includes/banner.php'; ?>
<?php include 'includes/navigation.php'; ?>
<div class="main">


<?php
/* 
        VIEW.PHP
        Displays all data from 'players' table
*/

        // connect to the database
        include('connect.db.php');
                
        // display data in table
        echo "<h3 id='center'><b>Manage Users</b></h3>";
		echo '<div class="categoryChooser" id="center"><img class="userButton" src="images/unvalidated.png"/> >>> <img class="userButton" src="images/validated.png"/> >>> <img class="userButton" src="images/manager.png"/> >>> <img class="userButton" src="images/admin.png"/> </div>';

        // loop through results of database query, displaying them in the table
		print 	'<table border="1" style="width: 100%; margin-top: 25px;" >
				<tr style="background-color: #F7F7F7;">
				<th width="40"> Bid # </th>
				<th width="150"> Username </th>
				<th width="200"> Name </th>
				<th width="300"> Email </th>

				</tr>
				';
				
		//////////////////////////////////////////////////////////////////////////////////////////////////
		//											UNVALIDATED USERS									//
		//////////////////////////////////////////////////////////////////////////////////////////////////
        // get results from database
		$result = $connection->query("SELECT * FROM credentials WHERE validated = '0' ORDER BY bidderNum ASC")
			
		or die('No Records Found' . $connection->error);
		
        while($row = $result->fetch_array(MYSQLI_ASSOC)) 
		{        
                // echo out the contents of each row into a table
				echo "<tr class='redTable'>";
                echo '<td>' . $row['bidderNum'] . '</td>';
                echo '<td>' . $row['user'] . '</td>';
                echo '<td>' . $row['firstName'] . ' ' . $row['lastName'] . '</td>';
				echo '<td>' . $row['email'] . '</td>';
				echo '
				<td><img class="userButton" src="images/unvalidated.png"/></td>
				<td><a href="validate.php?id=' . $row['id'] . '"><img class="userButton" src="images/up.png"/></a></td>
				<td><div class="userButton"/></td>
				<td><a id="red" href="delete_user.php?id=' . $row['id'] . '"><img class="userButton" src="images/delete_red.png"/></a></td>
				';
                echo "</tr>";
				
        } 
		
		//////////////////////////////////////////////////////////////////////////////////////////////////
		//											ADMINISTRATORS										//
		//////////////////////////////////////////////////////////////////////////////////////////////////
		$result = $connection->query("SELECT * FROM credentials WHERE adminPrivelege != '0' ORDER BY bidderNum ASC")
			
		or die('No Records Found' . $connection->error);
		
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                
                // echo out the contents of each row into a table
				echo "<tr class='blueTable'>";
                echo '<td>' . $row['bidderNum'] . '</td>';
                echo '<td>' . $row['user'] . '</td>';
                echo '<td>' . $row['firstName'] . ' ' . $row['lastName'] . '</td>';
				echo '<td>' . $row['email'] . '</td>';
				echo '
				<td><img class="userButton" src="images/admin.png"/></td>
				<td><div class="userButton"/></td>
				<td><a id="blue" href="revoke_admin.php?id=' . $row['id'] . '"><img class="userButton" src="images/down.png"/></a></td>
				<td><a id="red" href="delete_user.php?id=' . $row['id'] . '"><img class="userButton" src="images/delete_red.png"/></a></td>
				';
                echo "</tr>";
				
        } 
		
		//////////////////////////////////////////////////////////////////////////////////////////////////
		//											MANGERS												//
		//////////////////////////////////////////////////////////////////////////////////////////////////
		$result = $connection->query("SELECT * FROM credentials WHERE adminPrivelege = '0' AND managePrivelege != '0' ORDER BY bidderNum ASC")
			
		or die('No Records Found' . $connection->error);
		
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                
                // echo out the contents of each row into a table
				echo "<tr class='purpleTable'>";
                echo '<td>' . $row['bidderNum'] . '</td>';
                echo '<td>' . $row['user'] . '</td>';
                echo '<td>' . $row['firstName'] . ' ' . $row['lastName'] . '</td>';
				echo '<td>' . $row['email'] . '</td>';
				echo '
				<td><img class="userButton" src="images/manager.png"/></td>
				<td><a href="grant_admin.php?id=' . $row['id'] . '"><img class="userButton" src="images/up.png"/></a></td>
				<td><a href="revoke_manager.php?id=' . $row['id'] . '"><img class="userButton" src="images/down.png"/></a></td>
				<td><a id="red" href="delete_user.php?id=' . $row['id'] . '"><img class="userButton" src="images/delete_red.png"/></a></td>
				';
                echo "</tr>";
				
        } 
		
		//////////////////////////////////////////////////////////////////////////////////////////////////
		//											VALIDATED USERS										//
		//////////////////////////////////////////////////////////////////////////////////////////////////
		$result = $connection->query("SELECT * FROM credentials WHERE adminPrivelege = '0' AND managePrivelege = '0' AND validated != '0' ORDER BY bidderNum ASC")
			
		or die('No Records Found' . $connection->error);
		
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                
                // echo out the contents of each row into a table
				echo "<tr class='greenTable'>";
                echo '<td>' . $row['bidderNum'] . '</td>';
                echo '<td>' . $row['user'] . '</td>';
                echo '<td>' . $row['firstName'] . ' ' . $row['lastName'] . '</td>';
				echo '<td>' . $row['email'] . '</td>';
				echo '
				<td><img class="userButton" src="images/validated.png"/></td>
				<td><a href="grant_manager.php?id=' . $row['id'] . '"><img class="userButton" src="images/up.png"/></a></td>
				<td><a href="invalidate.php?id=' . $row['id'] . '"><img class="userButton" src="images/down.png"/></a></td>
				<td><a id="red" href="delete_user.php?id=' . $row['id'] . '"><img class="userButton" src="images/delete_red.png"/></a></td>
				';
                echo "</tr>";
				
        } 
		echo '</table>';
        // close table>
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