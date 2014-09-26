<?php
$info = $_GET['i'];
$msg = "";
switch($info) {
	case(!$info):
	$msg = "Illegimate source.";
	break;
	case('u'):
	$msg = "You are not authorised to access this page.";
	break;
	case('l'):
	$msg = "Your account has been locked for exceeding the maximum number of login attempts";
	break;
	default:
	$msg = null;
	break;
	}
	?>
<!DOCTYPE html>
<html lang="en-us">
<head>
<title>Unauthorised access</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Unimaid | Students Portal</title>
	<link href="../css/jquery.mobile.min.css" rel="stylesheet">
	<link href="../assets/css/info.css" rel="stylesheet">
	<script src="../js/jquery.min.js" type="text/javascript"></script>
	<script src="../js/jquery.mobile.min.js" type="text/javascript"></script>
	
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

</head>
<body>
<div data-role="page">

<div data-role="header" class="ui-header" id="header">
<span class="site-title"><a href="#">UNIMAID</a></span>
</div><!--/header-->

<div data-role="content">
<div class="main">
<span class="main-title">Unauthorised access</span>
<p class="info"><?php echo $msg; ?></p>
<a href="../" style="color:#0ad;" data-ajax="false">&larr; return to unimaid students portal</a>
</div>
</div><!--/content-->
</div>
</body>
</html>