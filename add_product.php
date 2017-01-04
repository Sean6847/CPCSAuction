<?php
session_start();
?>

<!DOCTYPE phpl PUBLIC "-//W3C//DTD XphpL 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link href="style.css" type="text/css" rel="stylesheet"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="CPCS, auction, cedar, park, christian, school" />
<meta http-equiv="author" content="Sean Muir">
<title>Auction - Add Product</title>
<script type="text/javascript" src="[JS library]"></script>
<!--[if lt IE 9]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->
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
	<div class="message" style="text-align:left;">
    <h1>Add New Item</h1>
        <form method="post" action="addMember.php" enctype="multipart/form-data">

        <p>Item Name</p>
        <p><input name="productName" type="text"></p>
        
		<p>Item Description</p>
        <p><textarea name="description" rows="10" cols="60"></textarea></p>
        
        <p>Item Category</p>
        <p><select name="category" value="options">
        <option value="">Select . . .</option>
        <option value="school_items">School Items</option>
        <option value="class_projects">Class Projects</option>
        <option value="clothing_handmade">Clothing/Handmade</option>
        <option value="deserts">Deserts</option>
        <option value="entertainment">Entertainment</option>
        <option value="food">Food</option>
        <option value="health_beauty">Health/Beauty</option>
        <option value="home_garden">Home and Garden</option>
        <option value="jewelry">Jewelry</option>
        <option value="lessons">Lessons</option>
        <option value="miscellaneous">Miscellaneous</option>
        <option value="pets">Pets</option>
        <option value="services">Services</option>
        <option value="recreation">Recreation</option>
        <option value="technology">Technology</option>
        <option value="toys">Toys</option>
        <option value="tools">Tools</option>
        <option value="travel">Travel</option>
        </SELECT></p>

        <p>Item Value</p>
        <p><input name="value" type="text"></p>

        <p>Item Number</p>
        <p><input name="upcNumber" type="text"></p>

        <p>Item Image</p>
        <p><input type="hidden" name="size" value="350000">
            <input type="file" name="photo"> </p>

        <p>
        <input name="upload" type="submit" value="Add Item">
        </p>
        
        </form>
</div>
    
	<?php include 'includes/footer.php'; ?>
</div>
</body>

</html>
