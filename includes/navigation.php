<div id="navbar">
<div class="nav">
    <ul id="coolMenu">
        <li><a href="index.php">home</a></li>
        <li><a href="catalog.php">catalog</a>
			<ul>
            	<li><div class="arrow-down"></div></li>
				<li><a href="catalog.php?cat=school_items">school items</a></li>
				<li><a href="catalog.php?cat=class_projects">class projects</a></li>
				<li><a href="catalog.php?cat=clothing_handmade">clothing/handmade</a></li>
				<li><a href="catalog.php?cat=desserts">desserts</a></li>
				<li><a href="catalog.php?cat=entertainment">entertainment</a></li>
				<li><a href="catalog.php?cat=food">food</a></li>
				<li><a href="catalog.php?cat=health_beauty">health/beauty</a></li>
				<li><a href="catalog.php?cat=home_garden">home and garden</a></li>
				<li><a href="catalog.php?cat=jewelry">jewelry</a></li>
				<li><a href="catalog.php?cat=lessons">lessons and classes</a></li>
				<li><a href="catalog.php?cat=miscellaneous">miscellaneous</a></li>
				<li><a href="catalog.php?cat=pets">pets</a></li>
				<li><a href="catalog.php?cat=services">services</a></li>
				<li><a href="catalog.php?cat=recreation">sports and recreation</a></li>
				<li><a href="catalog.php?cat=technology">technology</a></li>
				<li><a href="catalog.php?cat=toys">toys</a></li>
				<li><a href="catalog.php?cat=tools">tools</a></li>
				<li><a href="catalog.php?cat=travel">travel</a></li>
			</ul>
        </li>
        <li><a href="dinner.php">dinner</a></li>
        <li><a href="forms.php">forms</a></li>
        <li><a href="sponsor.php">sponsor</a></li>
        <li><a href="about.php">about</a></li>
    </ul>
	<div id="leftTriangle"></div><div id="rightTriangle"></div>
</div>
<?php
if($_SESSION['user'])
{
	echo '<div id="loginLink">
			Logged in as <a href="profile.php">' . $_SESSION['user'] . '</a>. 
			<a href="logout.php">Log Out</a>.
		  </div>';
}
else echo '<div id="loginLink"> <a href="login.php">Log in</a> </div>'
?>
</div>

<!--
<a href="docs/2015/2015 Auction-Terrace to Paris.pdf" target="_blank"><div class="catalogButton">
	DOWNLOAD CATALOG (4.3 MB PDF)
</div></a>-->