<?php
echo '	<div id="right">
			<form action="" method="post" enctype="multipart/form-data">

			<input name="search" type="text" placeholder=" Search..." value="">

			<input name="submit" type="submit" style="display: none;">

			</form>
		</div>';

if(isset($_POST['submit']))
{
	$searchValue	=	mysql_real_escape_string(htmlspecialchars($_POST['search']));
	
	header("searchResults.php?search=$searchValue");
}
?>