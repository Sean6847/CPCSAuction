<?php
ob_start();
include('protectedAdmin.php');
?>

<?php
/* 
 DELETE.PHP
 Deletes a specific entry from the 'players' table
*/

 // connect to the database
 include('connect.db.php');
 
 // check if the 'id' variable is set in URL, and check that it is valid
 if (isset($_GET['id']) && is_numeric($_GET['id']))
 {
 // get id value
 $id = $_GET['id'];
 
 $connection->query("UPDATE credentials SET validated='0', bidderNum='0' WHERE id='$id'")
 or die($connection->error);
 
 // redirect back to the view page
 header("Location: manage_users.php");
 }
 else
 // if id isn't set, or isn't valid, redirect back to view page
 {
 header("Location: manage_users.php");
 }
 ob_end_clean();
 $connection->close();
?>