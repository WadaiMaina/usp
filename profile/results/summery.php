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
<div data-role="page" id="summery" data-title="StudentsPortal | <?php echo $user->fname; ?> | Results">
	
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
				<div data-role="navbar">
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
							<li><a href="second-semester.php" data-ajax="false">Second Semester</a></li>
							<li><a href="summery.php" data-ajax="false" style="color:#0ad;">Summery</a></li>
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
				<h1>Summery</h1>
			</header>
			
			<div id="student-details">
				<img src="../uploads/<?php echo $user->idn; ?>.jpg">
				<ul>
					<li><?php echo "<b>".$user->fname." ".$user->lname."</b>"; ?></li>
					<li><?php echo $user->department; ?></li>
					<?php
					$stmt = $dbh->prepare("SELECT lvl FROM student_level WHERE id = ? AND sesion = ?");
					$stmt->execute(array($_SESSION['usr_id'], $sesion));
					$lvl = $stmt->fetch(); ?>
					<li><?php echo $lvl[0]." level"; ?></li>
				</ul>
			</div>
			<h1>Details of performance</h1>
			<div class="ui-grid-a" style="margin-bottom:25px;">
			<?php if(um_num_reg_courses($dbh, $_SESSION['usr_id'], $sesion) !== false): ?> 
				<div class="ui-block-a"><div class="ui-bar ui-bar-a" id="bar" style="height:35px">First Semester</div>
				<?php
				$_courses = new um_grade();
				$_courses->user = $_SESSION['usr_id'];
				$_courses->dbh = $dbh;
				$_courses->sesion = $sesion;
				$_courses->semster = 1;
				?> 
		<table data-role="table" id="temp-table" data-mode="reflow" class="ui-responsive table-stroke">
		<thead>
			<tr>
				<th colspan="1" data-priority="persist">Grade</th>
				<th colspan="1" data-priority="1">Courses</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>A</th>
				<td><?php $_courses->um_grade_a(); ?></td>
			</tr>
			<tr>
				<th>B+</th>
				<td><?php $_courses->um_grade_b_plus(); ?></td>
			</tr>
			<tr>
				<th>B</th>
				<td><?php $_courses->um_grade_b(); ?></td>
			</tr>
			<tr>
				<th>C+</th>
				<td><?php $_courses->um_grade_c_plus(); ?></td>
			</tr>
			<tr>
				<th>C</th>
				<td><?php $_courses->um_grade_c(); ?></td>
			</tr>
			<tr>
				<th>D</th>
				<td><?php $_courses->um_grade_d(); ?></td>
			</tr>
			<tr>
				<th>E</th>
				<td><?php $_courses->um_grade_e(); ?></td>
			</tr>
			<tr>
				<th>F</th>
				<td><?php $_courses->um_grade_f(); ?></td>
			</tr>
		</tbody>
		</table>
		</div>
		<div class="ui-block-b"><div class="ui-bar ui-bar-a" id="bar" style="height:35px">Second Semester</div>
		<?php $_courses->semster = 2; ?>
		<table data-role="table" id="temp-table" data-mode="reflow" class="ui-responsive table-stroke">
		<thead>
			<tr>
				<th colspan="1" data-priority="persist">Grade</th>
				<th colspan="1" data-priority="1">Courses</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>A</th>
				<td><?php $_courses->um_grade_a(); ?></td>
			</tr>
			<tr>
				<th>B+</th>
				<td><?php $_courses->um_grade_b_plus(); ?></td>
			</tr>
			<tr>
				<th>B</th>
				<td><?php $_courses->um_grade_b(); ?></td>
			</tr>
			<tr>
				<th>C+</th>
				<td><?php $_courses->um_grade_c_plus(); ?></td>
			</tr>
			<tr>
				<th>C</th>
				<td><?php $_courses->um_grade_c(); ?></td>
			</tr>
			<tr>
				<th>D</th>
				<td><?php $_courses->um_grade_d(); ?></td>
			</tr>
			<tr>
				<th>E</th>
				<td><?php $_courses->um_grade_e(); ?></td>
			</tr>
			<tr>
				<th>F</th>
				<td><?php $_courses->um_grade_f(); ?></td>
			</tr>
		</tbody>
		</table>
		</div>
		</div><!-- /grid-a -->
		<ul data-role="listview">
			<li id="cgpa"></li>
			<li id="status"></li>
		</ul> 
		<input type="hidden" value="<?php status($dbh, $_SESSION['usr_id'], $sesion); ?>" id="num_failed_courses">
		<?php
				$level = $lvl[0];
				$level -= 100;
				$user->id = $_SESSION['usr_id'];
				$prep_stmt = "SELECT course_code, unit, (ca + exam) as total\n"
				. "FROM courses\n"
				. "LEFT JOIN results ON id = courseId\n"
				. "WHERE userId = ? AND sesion = ? AND courseId NOT IN (SELECT id\n"
				. " FROM courses\n"
				. " LEFT JOIN failed_courses ON id = courseId\n"
				. " WHERE studentId = ? AND sesion = ? AND level = ?)";
				
				$stmt = $dbh->prepare($prep_stmt);
				$stmt->execute(array($user->id, $sesion, $user->id, $sesion, $level));
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if(!empty($rows)) { ?>
				<table data-role="table" id="rslt-tbl" data-mode="reflow" class="ui-responsive table-stroke" style="display:none;">
					<thead>
						<tr>
							<th colspan="2" data-priority="persist">Course</th>
							<th colspan="1">Marks</th>
							<th colspan="1">Grade</th>
						</tr>
						<tr>
							<th data-priority="persist">Course Id</th>
							<th data-priority="2">Units</th>
							<th data-priority="2">Total(%)</th>
							<th data-pririty="2">CGP</th>
						</tr>
					</thead>
					<tbody>
				<?php foreach($rows as $course) { ?>
					<tr id="crs-row">
						<th><?php echo $course['course_code']; ?></th>
						<td><?php echo $course['unit']; ?></td>
						<td><?php echo $course['total']; ?></td>
						<td><?php echo $course['unit'] * gp($course['total']); ?></td>
					</tr>
				<?php	} ?>
				</tbody>
				</table>
			<?php } 
			if($user->level > 100) { ?>
			
			<script type="text/javascript">
				var sumUnits = 0;
				var sumCgp = 0;
				
				var rows = $('#rslt-tbl tr:gt(0)');
				rows.children('td:nth-child(2)').each(function() {
					sumUnits += parseInt($(this).html());
				});
				rows.children('td:nth-child(4)').each(function() {
					sumCgp += parseFloat($(this).html());
				});
				
				var cgpa = parseFloat(sumCgp / sumUnits).toFixed(2);
				
				if(isNaN(cgpa)) {
					$('#cgpa').html('<strong>CGPA: </strong>N/A');
					$('#status').html('<strong>Status: </strong>N/A');
				} else {
				
					$('#cgpa').html('<strong>CGPA: </strong>' + cgpa);
					
					var failed_courses = $('#num_failed_courses').val();
					
					 if(cgpa < 1 || failed_courses >= 6) {
						 $('#status').html('<strong>Status: </strong>Repeat');
					 } else {
						 $('#status').html('<strong>Status: </strong>Proceed');
					 }
				}
			</script>
		<?php } else { ?>
		<script type="text/javascript">
			var firstSumUnits = 0;
			var firstSumCgp = 0;
			
			var rows = $('#temp-table_one tr:gt(0)');
			rows.children('td:nth-child(3)').each(function() {
				firstSumUnits += parseInt($(this).html());
			});
			rows.children('td:nth-child(8)').each(function() {
				firstSumCgp += parseFloat($(this).html());
			});
			
			var secondSumUnits = 0;
			var secondSumCgp = 0;
			
			var rows = $('#temp-table tr:gt(0)');
			rows.children('td:nth-child(3)').each(function() {
				secondSumUnits += parseInt($(this).html());
			});
			rows.children('td:nth-child(8)').each(function() {
				secondSumCgp += parseFloat($(this).html());
			});
			var sumUnits = parseInt(firstSumUnits + secondSumUnits);
			var sumCgp = parseFloat(firstSumCgp + secondSumCgp);
			
			var cgpa = parseFloat(sumCgp / sumUnits).toFixed(2);
			
			
			if(isNaN(cgpa)) {
				$('#cgpa').html('<strong>CGPA: </strong>N/A');
				$('#status').html('<strong>Status: </strong>N/A');
			} else {
			
				$('#cgpa').html('<strong>CGPA: </strong>' + cgpa);
				var failed_courses = $('#num_failed_courses').val();
				
				 if(cgpa < 1 || failed_courses >= 6) {
					 $('#status').html('<strong>Status: </strong>Repeat');
				 } else {
					 $('#status').html('<strong>Status: </strong>Proceed');
				 }
			}
		 </script>
		<?php	} ?>
		<?php else: ?>
			<h3>A detailed summary of your result is currently not available.</h3>
		<?php endif; ?>
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
	</div><!-- /Summery -->
	<script type="text/javascript">
	<!--
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
	//-->
	</script>
</body>
</html>