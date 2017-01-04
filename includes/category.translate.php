<?php

	$category = $_GET['cat'];
	$auction = $_GET['auction'];
	
	if($category == school_items){echo 'school items';}
	if($category == class_projects){echo 'class projects';}
	if($category == clothing_handmade){echo 'clothing/handmade';}
	if($category == desserts){echo 'desserts';}
	if($category == entertainment){echo 'entertainment';}
	if($category == food){echo 'food';}
	if($category == health_beauty){echo 'health/beauty';}
	if($category == home_garden){echo 'home and garden';}
	if($category == jewelry){echo 'jewelry';}
	if($category == lessons){echo 'lessons';}
	if($category == miscellaneous){echo 'miscellaneous';}
	if($category == pets){echo 'pets';}
	if($category == services){echo 'services';}
	if($category == recreation){echo 'recreation';}
	if($category == technology){echo 'technology';}
	if($category == toys){echo 'toys';}
	if($category == tools){echo 'tools';}
	if($category == travel){echo 'travel';}
	if($category == afterAuction){echo 'After The Auction';}
	
	if($auction == yellow) {echo 'yellow auction';}
	if($auction == green) {echo 'green auction';}
	if($auction == blue) {echo 'blue auction';}
	if($auction == silent) {echo 'silent auction';}
	
?>