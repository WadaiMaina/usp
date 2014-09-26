<!DOCTYPE="html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ESQA | Home</title>
<link href="../../assets/css/main.css" rel="stylesheet" type="text/css" />
<link href="../../genericons/genericons.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="header" id="header">
<h1>ESQA</h1>
<span id="costs">
<a href="#menu"><div class="genericon genericon-menu" style="vertical-align:middle;"></div> Menu</a>
</span>
</div>

<?php
include_once('../../includes/db_connect.php');
include_once('../../faq/faq.php');

if(checkAuth($dbh, CRUDE, SALT) !== true) {
	die(header('Location: ../../index.php'));
} else {
	$stmt = $dbh->query(QUERY);
	$row = $stmt->fetchAll();
	if(empty($row)) {
		print "<h1>Too bad!</h1>";
		print "<p>The University is currently broke. Please try again later.</p>";
	} else { ?>
	<div class="main" id="main">
	<table border="0" cellpadding="5" cellspacing="0" >
	<thead>
	<tr>
	<th>SerialNo</th>
	<th>PIN</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($row as $pin) { ?>
	<tr>
	<td><?php echo $pin[0]; ?></td>
	<td><?php echo $pin[1]; ?></td>
	</tr>
	<?php 
	} ?>
	</tbody>
	</table>
	</div>
	<div class="market-index" id="market-index">
		<table>
		<tr>
		<td>RETURNS</td>
		<td>&euro;<?php checkBalance($dbh, COST_PRICE, PERCENT_SHARE); ?></td>
		</tr>
		<tr>
		<td>BALANCE</td>
		<td>&euro;<?php remBalance($dbh, COST_PRICE, PERCENT_SHARE); ?></td>
		</tr>
		<tr>
		<td>QUANTITY</td>
		<td><?php num_pin_sold($dbh); ?></td>
		</tr>
		</table>
	</div>
	<?php	
	} ?>
<?php } ?>
<div id="menu"></div>
<div class="footer">
<div id="sections">
<h2>Menu</h2>
<ul class="my-checklist">
	<li>News
		<ul>
			<li><a href="#">BBC</a></li>
			<li><a href="#">Washinton Post</a></li>
			<li><a href="#">Time</a></li>
			<li><a href="#">CNN</a></li>
			<li><a href="#">New York Times</a></li>
			<li><a href="#">Reuters</a></li>
			<li><a href="#">CBS</a></li>
		</ul>
	</li>
	<li>Photo
		<ul>
			<li><a href="#">Shutterstock</a></li>
			<li><a href="#">Photobucket</a></li>
			<li><a href="#">Picasa</a></li>
		</ul>
	</li>
	<li>Social Media
		<ul>
			<li><a href="#">Facebook</a></li>
			<li><a href="#">Twitter</a></li>
			<li><a href="#">Google+</a></li>
			<li><a href="#">Pinterest</a></li>
			<li><a href="#">Instagram</a></li>
			<li><a href="#">tumblr</a></li>
		</ul>
	</li>
	<li>Blog
		<ul>
			<li><a href="#">Wordpress</a></li>
			<li><a href="#">Blogger</a></li>
			<li><a href="#">Zend Developer Zone</a></li>
			<li><a href="#">Stack Exchange</a></li>
			<li><a href="#">Smashing Magazine</a></li>
			<li><a href="#">IBM Developer Works</a></li>
		</ul>
	</li>
	<li>Technology
		<ul>
			<li><a href="#">Web Technology</a>
				<ul>
					<li><a href="#">CodeCademy</a></li>
					<li><a href="#">PHP Everyday</a></li>
					<li><a href="forum.jquery.com">jQuery</a></li>
					<li><a href="#">Tut+</a></li>
					<li><a href="#">TutorialPoint</a></li>
				</ul>
			</li>
			<li><a href="#">Networking</a>
				<ul>
					<li><a href="#">CompTIA</a></li>
					<li><a href="#">Cisco</a></li>
					<li><a href="#">Microsoft</a></li>
				</ul>
			</li>
			<li><a href="#">Mobile Technology</a>
				<ul>
					<li><a href="#">Android</a></li>
					<li><a href="#">iOS</a></li>
					<li><a href="#">Blackberry</a></li>
				</ul>
			</li>
		</ul>
	</li>
	<li>Trending</li>
	<li>Weather</li>
	<li>Sports</li>
	<li>Health</li>
	<li>Education</li>
	<li>Arts & Entertainment
		<ul>
			<li>Movies</li>
			<li>Music</li>
		</ul>
	</li>
</ul>
</div>
</div>
<a href="#" id="top" target="_top">Back to top</a>
</body>
</html>