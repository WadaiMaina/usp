<?php
ob_start();
session_start();
include_once('functions.php');
include_once('../includes/db_connect.php');
include_once('../includes/error.php');
$GLOBALS['meta'] = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
$GLOBALS['dbh'] = $dbh; 

$stmt = $dbh->prepare("SELECT * FROM staff WHERE id = ?");
$stmt->execute(array($meta));
$GLOBALS['member'] = $stmt->fetchAll(PDO::FETCH_CLASS, 'member');
$member = $member[0];
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--[endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Unimaid | Students Portal</title>
	<link href="../css/main.css" rel="stylesheet">
	<link href="../css/jquery.mobile.css" rel="stylesheet">
	<link href="../genericons/genericons.css" rel="stylesheet">
	<script src="../js/jquery.min.js" type="text/javascript"></script>
	<script src="../js/jquery.mobile.min.js" type="text/javascript"></script>
	<script src="../js/jquery.mobile.router.min.js" type="text/javascript"></script>

	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

</head>
<body>
<div data-role="page" id="members-page" data-url="/usp/members/<?php print(strtolower($member->fname)); ?>/" data-title="Unimaid | <?php echo $member->fullName(); ?>">
<div data-role="header" id="m-header">
<a href="#" id="sitelink" title="University of Maiduguri">Uiversity of Maiduguri</a>
</div>

<div data-role="content">

<div id="block-a">

<div id="block-b">
<a href="../../profile/"><img src="../../assets/images/029.jpg" alt="<?php echo $member->fullName()."'s picture"; ?>"></a>
</div>

<div id="block-c">
	<p id="p-block-c"><?php print(strtoupper($member->fullName())); ?></p>
	
	<ul id="ul-block-c">
		<li><?php print($member->department); ?></li>
		<li><?php print($member->email); ?></li>
	</ul>
</div>

</div><!-- End of member block -->

</div>

<div data-role="footer">
And this, the footer.
</div>

</div><!-- End of members page -->
</body>
</html>