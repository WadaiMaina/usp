<?php ob_start();
session_start();
if($_SESSION['page_id'] !== '\!&$%;#.o*?/v^k') {
	die(header("Location: ../info/?inf=1"));
	}
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
	<link href="../css/jquery.mobile.min.css" rel="stylesheet">
	<link href="../css/jquery-ui.min.css" rel="stylesheet">
	<link href="../genericons/genericons.css" rel="stylesheet">
	<link href="../assets/css/login.css" rel="stylesheet">
	<link href="../assets/css/reg.css" rel="stylesheet">
</head>
<body>
<div data-role="page" id="page" data-title="Unimaid | StudentsPortal | Registration">
		<div class="navbar-container">
			<div id="unimaid-logo">
				<a href="#"><div class="unimaid-home-link"></div></a>
			</div>
			<div data-role="navbar" id="navbar">
				<ul>
					<li><a href="#"><div class="genericon  genericon-chat"></div></a></li>
					<li><a href="#"><div class="genericon genericon-info"></div></a></li>
					<li><a href="#"><div class="genericon genericon-mail"></div></a></li>
				</ul>
			</div><!-- /navbar -->
		</div><!-- /container -->
		<div data-role="header" id="header">
			<div id="menu-block">
				<div id="logo">
					<a href="#"><img src="../assets/images/logo_home.png" id="sitelogo"></a>
				</div>
				<ul data-role="listview">
				    <li><a href="#">Acura</a></li>
				    <li><a href="#">Audi</a></li>
				    <li><a href="#">BMW</a></li>
				    <li><a href="#">Cadillac</a></li>
				    <li><a href="#">Ferrari</a></li>
				</ul>
			</div>
		</div><!-- /header -->
		<div data-role="content" class="main">
		<div id="info_box">
		<h1>Congratulations</h1>
		<h3>Your account has been successfully created</h3>
		<span>An email containing details of your registration has been sent to you.</span>
		<a href="../index.php" data-ajax="false">Sign in</a>
		</div>
		</div><!-- /content -->
		<div data-role="footer" data-position="fixed"></div><!-- /footer -->
		</div><!-- /page -->
		<script src="../js/jquery.js" type="text/javascript"></script>
		<script src="../js/jquery.mobile.min.js" type="text/javascript"></script>
		<script src="../js/jquery-ui.min.js" type="text/javascript"></script>
		
		<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<?php $_SESSION['page_id'] = '$^%B#*&&?~'; ?>
		</body>
		</html>