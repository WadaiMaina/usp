<?php
session_start();
include_once('../../includes/functions.php');
include_once('../../includes/db_connect.php');
if(!isset($_SESSION['usr_id']) || (checkPin($_SESSION['usr_id'], $_SESSION['pin'], $dbh) !== true)) {
	header("Location: ../../info/?i=u");
}
$user = $_SESSION['usr'];
$sesion =  $_SESSION['ses'];
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
<div data-role="page" id="second-semester" data-url="/usp/profile/results/second-semester" data-title="<?php echo $user->fullName; ?> | Results | Unimaid">
	
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
				<a href="#" onClick="showNav()" id="mob-nv-btn"><div class="mob-nv-btn"></div></a>
				<a href="#" onClick="showNav()" id="cls-btn"></a>
				
			</div>
			<div class="options">
				<ul>
					<li><a href="#" id="un-link"><div id="dsp-nm"><?php echo $user->fullName; ?><br><label><?php echo $user->username; ?></label></div> <img src="../uploads/<?php echo $user->idn; ?>.jpg" alt="<?php echo $user->username."'s picture"; ?>" title="profile picture"></a>
						<ul>
							<li><a href="../../profile/#profile" data-ajax="false"><div class="genericon genericon-user"></div> Profile</a></li>
							<li><a href="../exit" data-ajax="false"><div class="genericon genericon-key"></div> Log out</a></li>
							<li><a href="../../profile/#settings" data-ajax="false"><div class="genericon genericon-cog"></div> Settings</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</section>

		<section class="navigation">
			<nav id="main-nv">
				<ul data-role="listview" data-inset="true">
					<li><a href="../../profile/" data-ajax="false">Home</a></li>
					<li><a href="../courses/" data-ajax="false">Courses</a></li>
					<li><a href="#" target="_self" data-ajax="false" id="active">Results</a>
						<ul id="rslt">
							<li><a href="../results/" data-ajax="false">First Semester</a></li>
							<li><a href="second-semester.php" data-ajax="false" style="color:#0ad;">Second Semester</a></li>
							<li><a href="summery.php" data-ajax="false">Summery</a></li>
							<li><a href="javascript:rsltPDF()">PDF</a></li>
						</ul>
					</li>
					<li><a href="../../profile/#gallery" data-ajax="false">Gallery</a></li>
					<li><a href="../../profile/#blog" data-ajax="false">Blog</a></li>
				</ul>
			</nav>
		</section><!-- /navigation -->
		
		<!-- main content -->
		<section data-role="content" class="main">
			<header data-role="header" id="session">
				<h1>Second Semster, <?php echo $sesion; ?> Session</h1>
			</header>
			
			<?php 
			$result = array();
			getResult($dbh, $_SESSION['usr_id'], 2, $sesion); ?>
			<?php if(empty($result)) { echo "<h3>Result is not available</h3>"; } else { ?>
			<table data-role="table" id="temp-table" data-mode="reflow" class="ui-responsive table-stroke">
			<thead>
				<tr>
					<th colspan="3" data-priority="persist">Course</th>
					<th colspan="3">Marks</th>
					<th colspan="3">Grade</th>
				</tr>
				<tr>
					<th data-priority="persist">Course Id</th>
					<th data-priority="1">Course Title</th>
					<th data-priority="2">Units</th>
					<th data-priority="1">Test</th>
					<th data-priority="2">Exam</th>
					<th data-priority="2">Total(%)</th>
					<th data-priority="2">GP</th>
					<th data-pririty="2">CGP</th>
					<th data-priority="2">Grade</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($result as $rslt) { ?>
				<tr>
					<th><?php echo $rslt['course_code']; ?></th>
					<td><?php echo $rslt['course_title']; ?></td>
					<td><?php echo $rslt['unit']; ?></td>
					<td><?php echo $rslt['ca']; ?></td>
					<td><?php echo $rslt['exam']; ?></td>
					<?php $total = $rslt['ca'] + $rslt['exam']; ?>
					<td><?php echo $total; ?></td>
					<td><?php echo gp($total); ?></td>
					<td><?php echo $rslt['unit'] * gp($total); ?></td>
					<td><?php echo grade($total); ?></td>
				</tr>
				<?php } ?>
				</form>
			</tbody>
		</table>
		<?php } ?>
		</section>
		
		<footer class="footer" id="footer" data-role="footer" data-position="fixed">
			<ul>
				<li><a href="../../terms/" data-ajax="false">Terms of Use</a></li>
				<li><a href="../../pp/" data-ajax="false">Privacy Policy</a></li>
				<li><a href="../../about/" data-ajax="false">About UNIMAID</a></li>
				<li><a href="../../contact/" data-ajax="false">Contact Us</a></li>
				<li><a href="../../consult/" data-ajax="false">UNIMAID Consult</a></li>
				<li><a href="../../faq/" data-ajax="false">FAQ</a></li>
			</ul>
			<div>&copy;<?php print(date("Y")); ?> <a href="http://www.unimaid.edu.ng" data-ajax="false">University of Maiduguri</a></div>
		</footer>
	</div><!-- /second semester -->
	
	<script type="text/javascript">
	$('#main-nv li').attr('data-icon', 'false');
	$('#active').attr('style', 'color:#0ad; font-weight:bold');
	
	function showNav() {
		$('#mob-nv-btn').on('click', function() {
			$('#main-nv').show();
			$(this).attr('style', 'z-index:10');
		});
		
		$('#cls-btn').on('click', function() {
			$('#main-nv').hide();
			$('#mob-nv-btn').attr('style', 'z-index:14');
		});
	}
	
	</script>
</body>
</html>