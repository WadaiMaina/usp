<?php 
session_start(); 
include_once('../../includes/functions.php');
include_once('../../includes/db_connect.php');
if(!isset($_SESSION['usr_id'])) {
	header("Location: ../../info/?i=u");
}
$user = $_SESSION['usr'];
$update = filter_input(INPUT_GET, 'update', FILTER_DEFAULT);
$error = filter_input(INPUT_GET, 'err', FILTER_DEFAULT);
$mobile = filter_input(INPUT_GET, 'm');
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
	<link href="../../css/main.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="../../css/jquery.mobile.css" rel="stylesheet">
	<link href="../../genericons/genericons.css" rel="stylesheet">
	<script src="../../js/jquery.min.js" type="text/javascript"></script>
	<script src="../../js/jquery.mobile.min.js" type="text/javascript"></script>
	
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

</head>
<body>
<div data-role="page" id="options" data-url="/usp/profile/options/" data-title="<?php echo $user->fullName; ?> | Settings">
	
		<!-- header -->
		
		<header data-role="header" id="header">
			<div id="logo">
			 <a href="#" target="_self"><img src="../../assets/images/logo_log.png" alt="UNIMAID logo" title="University of Maiduguri"></a>
			</div>
			<nav class="um-nv">
				<div data-role="navbar" data-grid="b">
					<ul>
						<li id="nvbar-list"><a href="#" id="um-link">About Us</a></li>
						<li id="nvbar-list"><a href="#" id="um-link">Contact</a></li>
					</ul>
				</div><!-- /navbar -->
				<div data-role="navbar" id="cnct-nvbar">
					<ul>
						<li><a href="#" id="contact"><div class="mob-contact"></div></a></li>
					</ul>
				</div><!-- /navbar -->
			</nav>
		</header><!--/header -->
		
		<section class="blue-band">
			<div id="usp-title">
				<a href="#">Students' Portal</a>
			</div>
			<div id="nv-btn">
				<a href="#" id="mob-nv-btn"><div class="mob-nv-btn"></div></a>
				<a href="#" id="cls-btn"></a>
			</div>
			<div class="options">
				<ul>
					<li><a href="#" id="un-link"><div id="dsp-nm"><?php echo $user->fullName; ?><br><label><?php echo $user->username; ?></label></div> <img src="../uploads/<?php echo $user->idn; ?>.jpg" alt="<?php echo $user->username."'s picture"; ?>" title="profile picture"></a>
						<ul>
							<li><a href="../../profile/#profile"><div class="genericon genericon-user"></div> Profile</a></li>
							<li><a href="../exit/" data-ajax="false"><div class="genericon genericon-key"></div> Log out</a></li>
							<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>"><div class="genericon genericon-cog"></div> Settings</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</section>

		<section class="navigation">
			<nav id="main-nv">
				<ul data-role="listview" data-inset="true">
					<li data-icon="false"><a href="../../profile/" data-ajax="false" id="active">Home</a></li>
					<li data-icon="false"><a href="../courses/" data-ajax="false">Courses</a></li>
					<li data-icon="false"><a href="../result/" data-ajax="false">Results</a></li>
					<li data-icon="false"><a href="../../profile/#gallery" data-ajax="false">Gallery</a></li>
					<li data-icon="false"><a href="../../profile/#blog" data-ajax="false">Blog</a></li>
				</ul>
			</nav>
		</section><!-- /navigation -->
		
		<!-- main content -->
		<section data-role="content" class="main">
			<p id="settings-heading">SETTINGS</p>
			<?php $msg = !$update ? '' : 'Profile updated'; if($msg !== '') echo "<p class=msg>$msg</p>"; ?>
			<form action="settings.php" method="post" id="settings-form" enctype="multipart/form-data">
				<ul>
					<p>PERSONAL DETAILS</p>
					<li>Change profile picture <span>(Max. Size: 100kb)</span>
					<input data-clear-btn="false" name="profile-pic" type="file">
					</li>
					<li>First name <input type="text" name="fname" size="8" value="<?php echo $user->fname; ?>"></li>
					<li>Last name <input type="text" name="lname" size="8" value="<?php echo $user->lname; ?>"></li>
					<li>ID Number <span>(You don't need to change the ID Number.)</span> <input type="text" name="id-number" size="8" value="<?php echo $user->idn; ?>" disabled></li>
					<li>Level <span>(Make sure that the value in this field corresponds to your current level)</span>
					<input type="text" name="curr-level" size="4" value="<?php echo $user->level; ?>">
					</li>
					
					<?php $mobile = isset($mobile) ? $mobile : $user->mobile; ?>
					<p>CONTACT</p>
					<li>Email <span>(required)</span> <input type="email" name="email" value="<?php echo $user->email; ?>"></li>
					<li>Mobile <input type="tel" name="mob" value="<?php echo $mobile; ?>"></li>
					
					<p>ACCOUNT</p>
					<li>Change password <span>(Leave blank if you do not want to change your password)</span>
					<br>
					<br>
					New password <input type="password" name="password_1"></li>
					<li>Confirm new password <input type="password" name="password_2"></li>
				</ul>
				<button type="submit" name="done">Done</button>
			</form>
		</section>
		<footer class="footer" id="footer" data-role="footer" data-position="fixed">
			<ul>
				<li><a href="#">Terms of Use</a></li>
				<li><a href="#">Privacy Policy</a></li>
				<li><a href="#">About UNIMAID</a></li>
				<li><a href="#">Contact Us</a></li>
				<li><a href="#">UNIMAID Consult</a></li>
				<li><a href="#">FAQ</a></li>
			</ul>
			<div>&copy;<?php echo date('Y', time()); ?>. <a href="http://www.unimaid.edu.ng" data-ajax="false" target="new">University of Maiduguri</a></div>
		</footer>
		</div>