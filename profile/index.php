<?php
ob_start();
session_start();
include_once('../includes/functions.php');
include_once('../includes/db_connect.php');
include_once('../includes/error.php');
$usrnm = $_SESSION['usr_id'];
if(is_staff($dbh, $usrnm)) {die(header('location: ../staff/')); }
if (checkLogin($dbh) == true) {
	createUser($dbh, $usrnm);
	$_SESSION['usr'] = $user;
	$user->fullName = $user->fname. "&nbsp;" . $user->lname;
	if(strlen($user->fullName) > 20) {
		$user->fullName = $user->fname;
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
	<link href="../css/main.css" rel="stylesheet">
	<link href="../css/jquery.mobile.css" rel="stylesheet">
	<link href="../genericons/genericons.css" rel="stylesheet">
	<script src="../js/jquery.min.js" type="text/javascript"></script>
	<script src="../js/jquery.mobile.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	var router = new $.mobile.Router({
          "/members/index.php[?]id=(\\+d)": {handler: "members", events: "bc,c,i,bs,s,bh,h" },
        },{
          members: function(type,match,ui){
            console.log("localpage2: "+type+" "+match[0]);
            var params=router.getParams(match[1]);
            console.log(params);
          }
        }, { 
          defaultHandler: function(type, ui, page) {
            console.log("Default handler called due to unknown route (" 
              + type + ", " + ui + ", " + page + ")"
            );
          },
          defaultHandlerEvents: "s",
	  defaultArgsRe: true
        });
    </script>
	
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

</head>
<body>
	<div data-role="page" id="home" data-url="/usp/profile/" data-title="Unimaid | <?php echo $user->fullName; ?>" style="overflow:hidden;">
	
		<!-- header -->
		
		<header data-role="header" id="header">
			<div id="logo">
			 <a href="#" target="_self"><img src="../assets/images/logo_log.png" alt="UNIMAID logo" title="University of Maiduguri"></a>
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
					<li><a href="#" id="un-link"><div id="dsp-nm"><?php echo $user->fullName; ?><br><label><?php echo $user->username; ?></label></div> <img src="uploads/<?php echo $user->idn; ?>.jpg" alt="<?php echo $user->fname . "'s picture"; ?>" title="profile picture"></a>
						<ul>
							<li><a href="#profile"><div class="genericon genericon-user"></div> Profile</a></li>
							<li><a href="exit/" data-ajax="false"><div class="genericon genericon-key"></div> Log out</a></li>
							<li><a href="#settings"><div class="genericon genericon-cog"></div> Settings</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</section>

		<section class="navigation">
			<nav id="main-nv">
				<ul data-role="listview" data-inset="true">
					<li><a href="#" target="_self" id="active">Home</a></li>
					<li><a href="courses/" data-ajax="false">Courses</a></li>
					<li><a href="pin/" data-ajax="false">Results</a></li>
					<li><a href="#gallery">Gallery</a></li>
					<li><a href="#blog">Blog</a></li>
				</ul>
			</nav>
		</section><!-- /navigation -->
		
		<!-- main content -->
		<section data-role="content" class="main">
		
			<?php if("" != $err_msg): ?>
				<div class="ui-widget">
					<div class="ui-state-error ui-corner-all" style="font-size:14px; text-shadow:none;" id="fake_error">
						<p><div style="color:#FC0; font-size: 16px;" class="genericon genericon-warning"></div>
						<strong>Error:&nbsp;</strong><?php echo $err_msg; ?></p>
					</div>
				</div>
			<?php endif; ?>

			<!-- user -->
			<div id="student">
				<div id="student-pic">
					<img src="uploads/<?php echo $user->idn; ?>.jpg">
				</div>
				<div id="details">
					<span id="fullname"><?php echo $user->fullName; ?> <br></span>
					<span id="dept"><?php echo $user->department. ", " . $user->level . " level"; ?></span>
				</div>
			</div>

			<!-- map -->
			<div id="location">
				user location and related details
			</div>

			<!-- weather -->
			<div id="weather">
				weather info and related details
			</div>
		</section>
		
		<!-- sidebar -->
		<section class="sidebar">
			<div data-role="tabs" id="tabs">
			  <div data-role="navbar" id="tab-nvbar">
			    <ul>
			      <li><a href="#events" id="tab-btn" data-ajax="false">Events</a></li>
			      <li><a href="#two" id="tab-btn" data-ajax="false">News</a></li>
			    </ul>
			  </div>
			  <div id="events" class="ui-body-d ui-content">
			    <?php get_posts($dbh, $_SESSION['usr_id'], '2013/2014'); ?>
			  </div>
			  <div id="two">
			    <ul data-role="listview" data-inset="true">
			        <li data-icon="false"><a href="#">Acura</a></li>
			        <li data-icon="false"><a href="#">Audi</a></li>
			        <li data-icon="false"><a href="#">BMW</a></li>
			        <li data-icon="false"><a href="#">Cadillac</a></li>
			        <li data-icon="false"><a href="#">Ferrari</a></li>
			    </ul>
			  </div>
			</div>
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
				<div>&copy;<?php echo date('Y', time()); ?>. <a href="#">University of Maiduguri</a></div>
		</footer>
	</div>
	<script type="text/javascript">
	$('#main-nv li').attr('data-icon', 'false');
	$('#active').attr('style', 'color:#0ad; font-weight:bold');
	
	$('#mob-nv-btn').on('click', function() {
		$('#main-nv').show();
		$(this).attr('style', 'z-index:10');
	});
	
	$('#cls-btn').on('click', function() {
		$('#main-nv').hide();
		$('#mob-nv-btn').attr('style', 'z-index:14');
	});
	</script>
</body>
</html>
<?php }
else { 
	die(header('Location: ../info/?i=u'));
}
?>