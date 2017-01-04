<?php
	session_start();
	
	$category = $_GET['cat'];
	$auction = $_GET['auction'];
	$item = $_GET['item'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link href="style.css" type="text/css" rel="stylesheet"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="CPCS, auction, cedar, park, christian, school" />
<meta http-equiv="author" content="Sean Muir">
<title>Auction - Catalog</title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
<link rel="stylesheet" href="css/fontello.css">
<link rel="stylesheet" href="css/animation.css"><!--[if IE 7]><link rel="stylesheet" href="css/fontello-ie7.css"><![endif]-->
<script type="text/javascript" src="[JS library]"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery.lightbox-0.5.min.js"></script>

<script type="text/javascript">
// Image lightbox
$(function() {
	$('.gallery').lightBox(); // Select all links in object with gallery ID
});

</script>
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
		<!--<h1>Catalog</h1>-->
		
		<div class="categoryChooser">
			<span class="floatleft" id="blue"><a href="catalog.php"> store home </a> 
				<?php if($category || $auction) {echo '>';} else { echo '> Recent Items';} ?> 
				
				<a href="catalog.php?cat=<?php echo $category; ?>"> 
					<?php include 'includes/category.translate.php'; ?>
				</a>
			</span>	
			
			<?php if(!$item){ ?>
			
			<span class="floatright" id="relative">
				| Display:
					<button title="Grid" class="grid"><div  class="the-icons span3"><i class="icon-th" style="font-size: 13.5px;"></i><!--Grid View--></div></button>
					<button title="List" class="list"><div  class="the-icons span3"><i class="icon-th-list" style="font-size: 13.5px;"></i><!--List View--></div></button>
				|
			</span>
			
			<form class="floatright" id="relative">
				|
				<select name="auction" value="options" onchange="document.location = this.value">
				<option value="store.php">Sort By Auction</option>
                <option value="">-----------------------</option>
				<option value="catalog.php?auction=silver">Silver</option>
				<option value="catalog.php?auction=gold">Gold</option>
				<option value="catalog.php?auction=fuchsia">Fuchsia</option>
				<option value="catalog.php?auction=live">Live</option>
				<option value="catalog.php?auction=penny">Penny Auction</option>
				<option value="catalog.php?auction=store">Auction Store</option>
				</SELECT>
            </form>
			
            <form class="floatright" id="relative">
				|
				<select name="category" value="options" onchange="document.location = this.value">
				<option value="store.php">Sort By Category</option>
                <option value="">-----------------------</option>
					<?php include 'includes/categories.php'; //Having it included allows to easily change categories?> 
				</SELECT>
            </form>
			
			<form class="floatright" id="relative">
				|
				<select name="auction" value="options" onchange="document.location = this.value">
				<option value="store.php">Items Per Page</option>
                <option value="">-----------------------</option>
				<option value="numDisplay.php?count=5">5 Items</option>
				<option value="numDisplay.php?count=15">15 Items</option>
				<option value="numDisplay.php?count=50">50 Items</option>
				</SELECT>
            </form>
			<?php } ?>
        </div>
                    
		<?php
        
        include('connect.db.php');
		
		
		
		$category 	= $connection->real_escape_string(htmlspecialchars($_GET['cat']));
		$pagenum 	= $connection->real_escape_string(htmlspecialchars($_GET['pagenum']));
		$auction 	= $connection->real_escape_string(htmlspecialchars($_GET['auction']));
		$item	 	= $connection->real_escape_string(htmlspecialchars($_GET['item']));
		
		if(!isset($pagenum))
			$pagenum = 1;
		
		if(!isset($_SESSION['numDisplay']))
			$_SESSION['numDisplay'] = 15;
		
		$itemCountQuery = $connection->query("SELECT * FROM products") or die('No Records Found' . $connection->error);
		$itemCount		= $itemCountQuery->num_rows;
		
		$limit = $_SESSION['numDisplay'];
		$pages = ceil($itemCount/$limit);
		
		if($pagenum < 1)
			$pagenum = 1;
		else if ($pagenum > $limit)
			$pagenum = limit;
		
		$max = 'LIMIT ' . ($pagenum - 1) * $limit . ',' . $limit;
		
		
		
		if($item)
		{
			$data_p = $connection->query("SELECT * FROM products WHERE upcNumber='$item'") or die('No Records Found' . $connection->error);
			
			$numResults = $data_p->num_rows;
		}
		else if($category){
			
			if(!isset($pagenum))
				$pagenum = 1;

			$itemCountQuery = $connection->query("SELECT * FROM products WHERE category='$category'") or die('No Records Found' . $connection->error);
			$itemCount		= $itemCountQuery->num_rows;
			
			$limit = $_SESSION['numDisplay'];
			$pages = ceil($itemCount/$limit);
			
			if($pagenum < 1)
				$pagenum = 1;
			else if ($pagenum > $limit)
				$pagenum = limit;
			
			$max = 'LIMIT ' . ($pagenum - 1) * $limit . ',' . $limit;
			
			$data_p = $connection->query("SELECT * FROM products WHERE category='$category' ORDER BY id DESC $max") or die('No Records Found' . $connection->error);
			
			$numResults = $data_p->num_rows;
		}
		else if($auction){
			
			if(!isset($pagenum))
				$pagenum = 1;

			$itemCountQuery = $connection->query("SELECT * FROM products WHERE auctionSection='$auction'") or die('No Records Found' . $connection->error);
			$itemCount		= $itemCountQuery->num_rows;
			
			$limit = $_SESSION['numDisplay'];
			$pages = ceil($itemCount/$limit);
			
			if($pagenum < 1)
				$pagenum = 1;
			else if ($pagenum > $limit)
				$pagenum = limit;
			
			$max = 'LIMIT ' . ($pagenum - 1) * $limit . ',' . $limit;
			
			$data_p = $connection->query("SELECT * FROM products WHERE auctionSection='$auction' ORDER BY id DESC $max")
			
			or die('No Records Found' . $connection->error);
			
			$numResults = $data_p->num_rows;
		}
		else
		{
			if(!isset($pagenum))
			$pagenum = 1;

			$itemCountQuery = $connection->query("SELECT * FROM products") or die('No Records Found' . $connection->error);
			$itemCount		= $itemCountQuery->num_rows;
			
			$limit = $_SESSION['numDisplay'];
			$pages = ceil($itemCount/$limit);
			
			if($pagenum < 1)
				$pagenum = 1;
			else if ($pagenum > $limit)
				$pagenum = limit;
			
			$max = 'LIMIT ' . ($pagenum - 1) * $limit . ',' . $limit;
			
			$data_p = $connection->query("SELECT * FROM products ORDER BY id DESC $max") or die('No Records Found' . $connection->error);
			
			$numResults = $data_p->num_rows;
		
		}
		
		if(!$item)
		{
			//$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$key = '#pagenum=#';
			
			if($category)
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
			 
			 if ($pagenum == 1) 
			 {
				echo "<<-First <-Previous";
			 } 
			 else 
			 {
				 echo " <a href='" . $url;
				 if($category || $auction)
					echo "&";
				 else
					echo "?";
				 echo "pagenum=1'> <<-First</a> ";
				 echo " ";
				 $previous = $pagenum-1;
				 echo " <a href='" . $url;
				 if($category || $auction)
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
					if($category || $auction)
						echo "&";
					 else
						echo "?";
					echo "pagenum=$i'>$i</a> ";
				}
				else
				{
					echo " <a href='".$url;
					if($category || $auction)
						echo "&";
					 else
						echo "?";
					echo "pagenum=$i'>$i</a> ";
				}
			 }
			 
			 echo "-- ";

			 //This does the same as above, only checking if we are on the last page, and then generating the Next and Last links
			 if ($pagenum == $last || $last == 0) 
			 {
				echo "Next-> Last->>";
			 } 
			 else {
				 $next = $pagenum+1;
				 echo " <a href='".$url;
				 if($category || $auction)
					echo "&";
				 else
					echo "?";
				 echo "pagenum=$next'>Next-></a> ";
				 echo " ";
				 echo " <a href='".$url; 
				 if($category || $auction)
					echo "&";
				 else
					echo "?";
				 echo "pagenum=$pages'>Last->></a> ";
			 } 
			 echo '</div></div>';
			
			//echo '<div class="categoryChooser"><div id="center">' . $numResults .' of ' . $itemCount . ' items</div></div>';
        }
		        		
		if($item)
			{
				$info 			= $data_p->fetch_array(MYSQLI_ASSOC);
				
				$name 			= $info['productName'];
				$description 	= $info['description'];
				$upcNumber 		= $info['upcNumber'];
				$catalogNumber	= $info['catalogNumber'];
				$id				= $info['id'];
				$donor			= $info['donor'];
				$picture1 		= $info['picture'];
				$picture_t		= $info['picture_t'];
				$webBid			= $info['webBid'];
				
				$value = $info['value'];
				
				$currentBid = $info['currentBid'];
        		
				echo	'<div class="productPage">';
			
				echo	'<div id="productBox">';
				
				echo 	'<div id="quarterbox">';
							
				echo	'<div id="imgbox">';
				echo	'<a class="gallery"  href="uploads/' . $picture1 . '"><img id="imgboximg" src="uploads/' . $picture_t . '"/></a>';
				echo	'</div>';
				if($picture2){echo	'<a class="gallery"  href="' . $picture2 . '"><img id="microImage" src="' . $picture2 . '"/></a>';}
				if($picture3){echo	'<a class="gallery"  href="' . $picture3 . '"><img id="microImage" src="' . $picture3 . '"/></a>';}
				if($picture4){echo	'<a class="gallery"  href="' . $picture4 . '"><img id="microImage" src="' . $picture4 . '"/></a>';}
				if($picture5){echo	'<a class="gallery"  href="' . $picture5 . '"><img id="microImage" src="' . $picture5 . '"/></a>';}
				echo    '<p id="subtext">Click to expand image</p>';
				
				echo	'</div>';
				
			echo '<div id="productInfoBox">';
				
				print '
				<div id="productHeader">
					<h2 id="name">' . $name . '</h2>
					<p id="subtext">Donor: <span id="green">' . $donor .'</span> | Item #: <span id="green">'. $upcNumber .'</span> | Catalog #: <span id="green">'. $catalogNumber . '</span></p>
				</div>';
				
				echo 	'<div id="priceBox">';
				echo		'Item Value: <span id="red">' . $value . '</span>';
				if($webBid)
				{
					echo	'</br>Current Bid: <span id = "red">$' . $currentBid . '</span>';
				}
				echo	'</div>';
				if($webBid)
				{
					echo	'<a href="bid.php?id='. $id .'"><div class="bidButton"></div></a>';					
				}
				echo	'<a href="watch.php?id='. $id .'"><div class="watchButton"></div></a>';
				echo 	'</div>';
				
			echo '</div>';	
				
				echo	'<div id="productBox">';
				echo	'<p id="subtext">PRODUCT DESCRIPTION</p>';
				echo	'<p>' . $description . '</p>';
				echo	'</div>';

				echo	'</div>';
			}
			else
			{
			while($info = $data_p->fetch_array(MYSQLI_ASSOC))
        	{
			
				$name 			= $info['productName'];
				$description 	= $info['description'];
				$upcNumber 		= $info['upcNumber'];
				$picture1 		= $info['picture_t'];
				$value 			= $info['value'];
				
				echo	'<a id="noUnderline" href="catalog.php?item=' . $upcNumber . '">';
				echo	'<div class="grid">';
				echo 	'<div id="quarterbox">';	
				echo	'<div id="imgbox">';
				echo	'<img id="imgboximg" src="uploads/' . $picture1 . '"/>';
				echo	'</div>';
				echo	'<h3>' . $name . '</h3>';
				echo	'<p>' . $value . '</p>';
				echo    '</div>';
				echo    '</div>';
				echo	'</a>';
			}
		
        }
		
		if(!$item)
		{
			//$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$key = '#pagenum=#';
			
			if($category)
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
			 
			 if ($pagenum == 1) 
			 {
				echo "<<-First <-Previous";
			 } 
			 else 
			 {
				 echo " <a href='" . $url;
				 if($category || $auction)
					echo "&";
				 else
					echo "?";
				 echo "pagenum=1'> <<-First</a> ";
				 echo " ";
				 $previous = $pagenum-1;
				 echo " <a href='" . $url;
				 if($category || $auction)
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
					if($category || $auction)
						echo "&";
					 else
						echo "?";
					echo "pagenum=$i'>$i</a> ";
				}
				else
				{
					echo " <a href='".$url;
					if($category || $auction)
						echo "&";
					 else
						echo "?";
					echo "pagenum=$i'>$i</a> ";
				}
			 }
			 
			 echo "-- ";

			 //This does the same as above, only checking if we are on the last page, and then generating the Next and Last links
			 if ($pagenum == $last || $last == 0) 
			 {
				echo "Next-> Last->>";
			 } 
			 else {
				 $next = $pagenum+1;
				 echo " <a href='".$url;
				 if($category || $auction)
					echo "&";
				 else
					echo "?";
				 echo "pagenum=$next'>Next-></a> ";
				 echo " ";
				 echo " <a href='".$url; 
				 if($category || $auction)
					echo "&";
				 else
					echo "?";
				 echo "pagenum=$pages'>Last->></a> ";
			 } 
			 echo '</div></div>';
			
			//echo '<div class="categoryChooser"><div id="center">' . $numResults .' of ' . $itemCount . ' items</div></div>';
        }
		
		?>
        
	</div>
    
<?php include 'includes/footer.php'; ?>
	</div>
    </div>
</body>

<script>
	
	// Grid-List View
	$('button').click(function(e) {
		if ($(this).hasClass('grid')) {
			$('#noUnderline .list').removeClass('list').addClass('grid');
		}
		else if($(this).hasClass('list')) {
			$('#noUnderline .grid').removeClass('grid').addClass('list');
		}
	});
</script>

</html>

<?php
$connection->close();
?>
