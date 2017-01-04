<?php
	session_start();

	$category 	= $_GET['cat'];
	$webBid	  	= $_GET['webBid'];
	$item 		= $_GET['item'];
	
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
<div class="categoryChooser">
                <span class="floatleft" id="blue"><a href="manage_products.php"> Product Manage Main </a> 
                <?php if($category) {echo '>>>';} ?> 
                <a href="manage_products.php?cat=<?php echo $category; ?>"> 
                <?php include 'includes/category.translate.php'; ?>
                </a></span>
			
            <form class="floatright" id="relative" >
				<select name="category" value="options" onchange="document.location = this.value">
				<option value="store.php">Sort By Category</option>
                <option value="">-----------------------</option>
					<?php include 'includes/banner.php'; //Having it included allows to easily change categories?> 
				</SELECT>
                </form>
				
				<a style="margin-right: 25px; float: right;" href="manage_products.php?webBid=1">WebBid Items</a>
				<a style="margin-right: 25px; float: right;" href="manage_products.php?webBid=2">Non-WebBid Items</a>
             </div>

<?php
/* 
        VIEW.PHP
        Displays all data from 'players' table
*/
		
		$pagenum = $_GET['pagenum'];
		$limit 	 = 18;
		
        // connect to the database
        include('connect.db.php');

        // get results from database
		if($category)
		{
			if(!isset($pagenum))
				$pagenum = 1;

			$itemCountQuery = $connection->query("SELECT * FROM products WHERE category='$category'") or die('No Records Found' . $connection->error);
			$itemCount		= $itemCountQuery->num_rows;
			
			$pages = ceil($itemCount/$limit);
			
			if($pagenum < 1)
				$pagenum = 1;
			else if ($pagenum > $limit)
				$pagenum = limit;
			
			$max = 'LIMIT ' . ($pagenum - 1) * $limit . ',' . $limit;
			
			$result = $connection->query("SELECT * FROM products WHERE category='$category' ORDER BY id DESC $max")
			
			or die('No Records Found' . $connection->error);
		}
		else if($webBid == 1)
		{
			if(!isset($pagenum))
				$pagenum = 1;

			$itemCountQuery = $connection->query("SELECT * FROM products WHERE webBid != 0") or die('No Records Found' . $connection->error);
			$itemCount		= $itemCountQuery->num_rows;
			
			$pages = ceil($itemCount/$limit);
			
			if($pagenum < 1)
				$pagenum = 1;
			else if ($pagenum > $limit)
				$pagenum = limit;
			
			$max = 'LIMIT ' . ($pagenum - 1) * $limit . ',' . $limit;
			
			$result = $connection->query("SELECT * FROM products WHERE webBid != 0 ORDER BY id DESC $max")
			
			or die('No Records Found' . $connection->error);
		}
		else if($webBid == 2)
		{
			if(!isset($pagenum))
				$pagenum = 1;

			$itemCountQuery = $connection->query("SELECT * FROM products WHERE webBid = 0") or die('No Records Found' . $connection->error);
			$itemCount		= $itemCountQuery->num_rows;
			
			$pages = ceil($itemCount/$limit);
			
			if($pagenum < 1)
				$pagenum = 1;
			else if ($pagenum > $limit)
				$pagenum = limit;
			
			$max = 'LIMIT ' . ($pagenum - 1) * $limit . ',' . $limit;
			
			$result = $connection->query("SELECT * FROM products WHERE webBid = 0 ORDER BY id DESC $max")
			
			or die('No Records Found' . $connection->error);
		}			
		else
		{
		
			if(!isset($pagenum))
			$pagenum = 1;

			$itemCountQuery = $connection->query("SELECT * FROM products") or die('No Records Found' . $connection->error);
			$itemCount		= $itemCountQuery->num_rows;
			
			$pages = ceil($itemCount/$limit);
			
			if($pagenum < 1)
				$pagenum = 1;
			else if ($pagenum > $limit)
				$pagenum = limit;
			
			$max = 'LIMIT ' . ($pagenum - 1) * $limit . ',' . $limit;
			
			$result = $connection->query("SELECT * FROM products ORDER BY id DESC $max")
			
			or die('No Records Found' . $connection->error);
		
		}
        
				if(!$item)
		{
			//$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$key = '#pagenum=#';
			
			if($category || $webBid)
			{
				if(preg_match($key, $url))
				{
					$url = substr($url, 0, strrpos($url, "&pagenum="));
				}
			}
			else
			{
				if(preg_match($key, $url))
				{
					$url = substr($url, 0, strrpos($url, "?pagenum="));
				}
			}
			 // This shows the user what page they are on, and the total number of pages
			 echo '<div class="categoryChooser"><div id="center">';
			 echo " --Page $pagenum of $pages-- <p>";
			 
			 // First we check if we are on page one. If we are then we don't need a link to the previous page or the first page so we do nothing. If we aren't then we generate links to the first page, and to the previous page.
			 $last = $pages;
			 
			 if ($pagenum == 1 || $pages == 0) 
			 {
				echo "<<-First <-Previous";
			 } 
			 else 
			 {
				 echo " <a href='" . $url;
				 if($category || $webBid)
					echo "&";
				 else
					echo "?";
				 echo "pagenum=1'> <<-First</a> ";
				 echo " ";
				 $previous = $pagenum-1;
				 echo " <a href='" . $url;
				 if($category || $webBid)
					echo "&";
				 else
					echo "?";
				 echo "pagenum=$previous'> <-Previous</a> ";
			 } 

			 //just a spacer
			 echo " --";
			 
			 for($i = 1; $i <= $pages; $i++)
			 {
				if($i == $pagenum)
				{
					echo " <a id='greenHighlight' href='".$url;
					if($category || $webBid)
						echo "&";
					 else
						echo "?";
					echo "pagenum=$i'>$i</a> ";
				}
				else
				{
					echo " <a href='".$url;
					if($category || $webBid)
						echo "&";
					 else
						echo "?";
					echo "pagenum=$i'>$i</a> ";
				}
			 }
			 
			 echo "-- ";

			 //This does the same as above, only checking if we are on the last page, and then generating the Next and Last links
			 if ($pagenum == $last || $pages == 0) 
			 {
				echo "Next-> Last->>";
			 } 
			 else {
				 $next = $pagenum+1;
				 echo " <a href='".$url;
				 if($category || $webBid)
					echo "&";
				 else
					echo "?";
				 echo "pagenum=$next'>Next-></a> ";
				 echo " ";
				 echo " <a href='".$url; 
				 if($category || $webBid)
					echo "&";
				 else
					echo "?";
				 echo "pagenum=$pages'>Last->></a> ";
			 } 
			 echo '</div></div>';
			
			//echo '<div class="categoryChooser"><div id="center">' . $numResults .' of ' . $itemCount . ' items</div></div>';
        }
        
        // display data in table
        echo "<p id='center'><b>Products</b></p>";
?>
		
		<p id="center"><a href="new.php">Add a new item.</a></p>
        
<?php
        
        // loop through results of database query, displaying them
        while($row = $result->fetch_array(MYSQLI_ASSOC)) 
		{	
			$picture 	= $row['picture'];
			$picture_t 	= $row['picture_t'];
			$id				= $row['id'];
			$productName	= $row['productName'];
			$value			= $row['value'];
				
			echo 	'<div id="quarterbox">';
			echo	'<div id="remove"><div id="removeTriangle"></div><a href="delete_confirm.php?id='. $id .'"><div id="removeX">X</div></a></div>';
			echo	'<div id="edit"><div id="editTriangle"></div><a href="edit.php?id='. $id .'"><div id="editCheck">&#10001</div></a></div>';				
			echo	'<div id="imgbox">';
			echo	'<img id="imgboximg" src="uploads/' . $picture_t . '"/>';
			echo	'</div>';
			echo	'<h3>' . $productName . '</h3>';
			echo	'<p id="black">' . $value . '</p>';
			echo    '</div>';
        } 

        // close table>
		
		if(!$item)
		{
			//$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$key = '#pagenum=#';
			
			if($category || $webBid)
			{
				if(preg_match($key, $url))
				{
					$url = substr($url, 0, strrpos($url, "&pagenum="));
				}
			}
			else
			{
				if(preg_match($key, $url))
				{
					$url = substr($url, 0, strrpos($url, "?pagenum="));
				}
			}
			 // This shows the user what page they are on, and the total number of pages
			 echo '<div class="categoryChooser"><div id="center">';
			 echo " --Page $pagenum of $pages-- <p>";
			 
			 // First we check if we are on page one. If we are then we don't need a link to the previous page or the first page so we do nothing. If we aren't then we generate links to the first page, and to the previous page.
			 $last = $pages;
			 
			 if ($pagenum == 1 || $pages == 0) 
			 {
				echo "<<-First <-Previous";
			 } 
			 else 
			 {
				 echo " <a href='" . $url;
				 if($category || $webBid)
					echo "&";
				 else
					echo "?";
				 echo "pagenum=1'> <<-First</a> ";
				 echo " ";
				 $previous = $pagenum-1;
				 echo " <a href='" . $url;
				 if($category || $webBid)
					echo "&";
				 else
					echo "?";
				 echo "pagenum=$previous'> <-Previous</a> ";
			 } 

			 //just a spacer
			 echo " --";
			 
			 for($i = 1; $i <= $pages; $i++)
			 {
				if($i == $pagenum)
				{
					echo " <a id='greenHighlight' href='".$url;
					if($category || $webBid)
						echo "&";
					 else
						echo "?";
					echo "pagenum=$i'>$i</a> ";
				}
				else
				{
					echo " <a href='".$url;
					if($category || $webBid)
						echo "&";
					 else
						echo "?";
					echo "pagenum=$i'>$i</a> ";
				}
			 }
			 
			 echo "-- ";

			 //This does the same as above, only checking if we are on the last page, and then generating the Next and Last links
			 if ($pagenum == $last || $pages == 0) 
			 {
				echo "Next-> Last->>";
			 } 
			 else {
				 $next = $pagenum+1;
				 echo " <a href='".$url;
				 if($category || $webBid)
					echo "&";
				 else
					echo "?";
				 echo "pagenum=$next'>Next-></a> ";
				 echo " ";
				 echo " <a href='".$url; 
				 if($category || $webBid)
					echo "&";
				 else
					echo "?";
				 echo "pagenum=$pages'>Last->></a> ";
			 } 
			 echo '</div></div>';
			
			//echo '<div class="categoryChooser"><div id="center">' . $numResults .' of ' . $itemCount . ' items</div></div>';
        }
?>

<p id="center"><a href="new.php">Add a new item.</a></p>

</div>
<?php include 'includes/footer.php'; ?>
</div>
</div>


</body>
</html>

<?php
$connection->close();
?>