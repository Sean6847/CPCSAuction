<?php 
session_start();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link href="style.css" type="text/css" rel="stylesheet"/>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<meta name="keywords" content="CPCS, auction, cedar, park, christian, school" />
<meta http-equiv="author" content="Sean Muir">
<title>Auction - Home</title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
<script src="//code.jquery.com/jquery-latest.min.js"></script>
<script src="unslider.js"></script>
<script src="//stephband.info/jquery.event.move/js/jquery.event.move.js"></script>
<script src="//stephband.info/jquery.event.swipe/js/jquery.event.swipe.js"></script>

<style>
.slider { position: relative; overflow: auto; align: center; padding:0;}
    .slider li { list-style: none; padding: 0; margin:0; }
	.slider ul {padding: 0;}
        .slider ul li { float: left; min-height: 350px; padding: 0; margin:0; }
</style>

<script>


$('.slider').unslider({
	speed: 500,               //  The speed to animate each slide (in milliseconds)
	delay: 3000,              //  The delay between slide animations (in milliseconds)
	keys: true                //  Enable keyboard (left, right) arrow shortcuts
});
	
$(function() {
    $('.slider').unslider();
});
</script>
</head>

<body>
<div id="page-wrap">
	<div class="container">
	<?php include 'includes/banner.php'; ?>
	<?php include 'includes/navigation.php'; ?>
	<div class="main">	
		
		<div class="slider">
			<ul>
				<!--<li style="background-image: url('images/Castellar Logo-COLOR-banner.gif')"> </li>-->
				<li style="background-image: url('images/Catalog Ad - banner.gif')"><a style="display: block; width: 900px; height: 350px;"href="catalog.php"></a></li>
				<li style="background-image: url('images/Forms ad - banner.gif')"><a style="display: block; width: 900px; height: 350px;"href="forms.php"></a></li>
			</ul>
		</div>
		
		<p>Welcome to “Starry Starry Night”, Cedar Park’s 2016 Auction for the Lynnwood and Mountlake Terrace Campuses! Your support helps promote academic excellence and educating children in a Christian environment. Now, let me tell you a little more about the event.</p>
		<ul>
			<li><b>We have FUN!</b>  We have a festive atmosphere, fantastic food, and splendid entertainment!</li>
			<li><b>Great Food:</b>  We start off with incredible appetizers, served to our guests with elegance and style as they peruse and bid on silent auction items. As the silent auction closes, guests will sit down to a delicious dinner catered by Java Haus Café & Catering Company.  Java Haus wowed our auction committee at the test tasting, and we think you’ll love it!</li>
			<li><b>The DESSERT DASH!</b> To top off our delicious dinner, we have a dessert dash auction of tantalizing delicacies that will tickle your taste buds! You can enjoy selections from some of Puget Sound’s best restaurants, as well as some of the most talented bakers in the area!</li>
			<li><b>Get Amazing Bargains:</b> For all you bargain hunters who can sniff out a deal like a dog with a bone...get a whiff of these delicious deals our past attendees have uncovered, including home décor at deep discounts, and vacation packages and lodging for a fraction of the retail price! We have plenty of great deals in every price range!</li>
			<li><b>Get Great Merchandise, Services, and Certificates:</b> Our huge variety of items, includes one-of-a-kind projects created by each class, trips, jewelry, all kinds of gift certificates, great guy stuff, and much more! You can preview many of our items soon on the auction website. Items will be added as procurements are recorded. Just click on “Catalog” on our auction website to view what is posted so far. New items are added regularly, so remember to check back often once we start adding items.</li>
			<li><b>An Incredible Event!</b> Our dedicated, creative auction committee knows how to make this Auction a 5 star event...our food is always catered by the best, our ambiance is over the top (thanks to the caliber and excellence of our decorating committee), and our deals are unmatched. Come see for yourself why people rave about this event!</li>
			<li><b>If you've never been to an Auction before</b> and you didn't quite know what to expect ....make this your first... you can anticipate a fun, relaxed evening of low pressure deals and high quality entertainment. Get your ticket today and expect an entertaining and thoroughly enjoyable evening out!!!</li>
			<li><b>Support Our School:</b> Proceeds from the auction support scholarships, as well as all of the programs that keep our school running. We also have special Fund-A-Need bidding to help the Lynnwood and Mountlake Terrace campuses with a specific program that needs funding. This is our major fund raiser of the year. Your help and support are greatly appreciated!</li>
		</ul>
		<p>On behalf of Cedar Park Christian Schools and our 2016 auction committee, I invite you to support our auction with your sponsorship, donations, and/or attendance.  We look forward to seeing YOU at the auction!</p>
		<p>Blessings,</p>
		</br>
		<p style="line-height:.2em">~Sue Muir & Jessica Taylor</p>
		<p>2016 Auction Co-Chairs | "Starry Starry Night"</p>
		
	</div>
<?php include 'includes/footer.php'; ?>

	
</div>
</div>
</body>
<script>

</script>

</html>