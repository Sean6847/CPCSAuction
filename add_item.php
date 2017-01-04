<?php
	$category = $_GET['cat'];
	$item = $_GET['item'];
?>
<?php
include('protected.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="style.css" type="text/css" rel="stylesheet"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="CPCS, auction, cedar, park, christian, school" />
<meta http-equiv="author" content="Sean Muir">
<title>Add Item</title>
</head>

<body>


<div class="container">
<div id="blank">
<div class="banner">
		<img src="images/2013 Lions Banner - Small.png" alt="Lion Head" id="bannerimg"/>
		<h1>2013-14 AUCTION</h1>
        </div>
</div>
<?php include 'includes/navigation.php'; ?>
<div class="main">
<div class="categoryChooser">
                <span class="floatleft" id="blue"><a href="add_item.php"> Product Manage Main </a> 
                <?php if($category) {echo '>>>';} ?> 
                <a href="add_item.php?cat=<?php echo $category; ?>"> 
                <?php include 'includes/category.translate.php'; ?>
                </a></span>		
            <form class="floatright" id="relative">
				<select name="category" value="options" onchange="document.location = this.value">
				<option value="store.php">Sort By Category</option>
                <option value="">-----------------------</option>
				<option value="add_item.php?cat=school_items">school items</option>
				<option value="add_item.php?cat=class_projects">class projects</option>
				<option value="add_item.php?cat=clothing_handmade">clothing/handmade</option>
				<option value="add_item.php?cat=desserts">desserts</option>
				<option value="add_item.php?cat=entertainment">entertainment</option>
				<option value="add_item.php?cat=food">food</option>
				<option value="add_item.php?cat=health_beauty">health/beauty</option>
				<option value="add_item.php?cat=home_garden">home and garden</option>
				<option value="add_item.php?cat=jewelry">jewelry</option>
				<option value="add_item.php?cat=lessons">lessons</option>
				<option value="add_item.php?cat=miscellaneous">miscellaneous</option>
				<option value="add_item.php?cat=pets">pets</option>
				<option value="add_item.php?cat=services">services</option>
				<option value="add_item.php?cat=recreation">recreation</option>
				<option value="add_item.php?cat=technology">technology</option>
				<option value="add_item.php?cat=toys">toys</option>
				<option value="add_item.php?cat=tools">tools</option>
				<option value="add_item.php?cat=travel">travel</option>
				</SELECT>
                </form>
             </div>

<?php
/* 
        VIEW.PHP
        Displays all data from 'players' table
*/

        // connect to the database
        include('connect.db.php');

        // get results from database
		if($category){
		
			$result = $connection->query("SELECT * FROM products WHERE category='$category' ORDER BY id DESC")
			
			or die('No Records Found' . $connection->error);
		
		}
		else
		{
		
			$result = $connection->query("SELECT * FROM products ORDER BY id DESC")
			
			or die('No Records Found' . $connection->error);
		
		}
                
        // display data in table
        echo "<p id='center'><b>Products</b></p>";
?>
		
		<p id="center"><a href="new.php">Add a new item.</a></p>
        
<?php
        
        // loop through results of database query, displaying them in the table
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                
                // echo out the contents of each row into a table
				?>
                <!--
				echo "<tr>";
                echo '<td>' . $row['upcNumber'] . '</td>';
                echo '<td>' . $row['productName'] . '</td>';
				echo '<td><div id="itemBoxImageSmall"><img id="itemBoxImageSmall" src="uploads/' . $row['picture'] . '"/></div></td>';
                echo '<td>' . $row['description'] . '</td>';
				echo '<td>' . $row['category'] . '</td>';
                echo '<td>' . $row['value'] . '</td>';
				echo '<td>' . $row['catalogNumber'] . '</td>';
                echo '<td>' . $row['picture'] . '</td>';
                echo '<td><a href="edit.php?id=' . $row['id'] . '">Edit</a></td>';
                echo '<td><a href="delete.php?id=' . $row['id'] . '">Delete</a></td>';
                echo "</tr>";
				-->
				<?php
					
				echo 	'<div id="quarterbox">';				
				echo	'<div id="imgbox">';
				echo	'<img id="imgboximg" src="uploads/' . $row['picture'] . '"/>';
				echo	'</div>';
				echo	'<a class="floatleft" id="green" href="edit.php?id=' . $row['id'] . '">Edit</a>';
				echo	'<a class="floatright" id="red" href="delete.php?id=' . $row['id'] . '">Delete</a>';
				echo	'<h3>' . $row['productName'] . '</h3>';
				echo	'<p id="black">' . $row['value'] . '</p>';
				echo    '</div>';
        } 

        // close table>
?>
<div id="quarterbox"><a href="new.php"><div id="imgbox"><p id="center" style="margin: 25px 0; font-size:56px;">Add a new item.</p></div></a></div>
</div>
<?php include 'includes/footer.php'; ?>
</div>


</body>
</html>

<?php
$connection->close();
?>