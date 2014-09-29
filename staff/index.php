<?php
session_start();
include_once('../includes/db_connect.php');
include_once('../includes/functions.php');
if(!isset($_SESSION['usr_id'])) {
	die(header('Location: ../index.php'));
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
	<title>University of Maiduguri</title>
	<link href="../assets/css/staff.css" rel="stylesheet">
	<link href="../css/jquery.mobile.min.css" rel="stylesheet">
	<link href="../genericons/genericons.css" rel="stylesheet">
	<script src="../js/jquery.min.js" type="text/javascript"></script>
	<script src="../js/jquery.mobile.min.js" type="text/javascript"></script>
	
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

</head>
<body>
	<div data-role="page" id="home" data-title="Unimaid | staffName">
		<div class="links">
		</div>
		<div data-role="header" id="main-header">
		<span id="site-logo"><a href="#">UNIMAID</a></span>
		<a href="#footer" id="menu-btn"><div class="genericon genericon-menu"></div> Menu</a>
		</div>
		
		<div data-role="header" id="header" style="border-bottom:1px solid #ccc;">
			<div data-role="navbar" id="ui-navbar">
				<ul>
					<li><a href="./" id="active"><div class="genericon genericon-home"></div> Home</a></li>
					<li><a href="#courses" id="nav"><div class="genericon genericon-book"></div> Courses</a></li>
				</ul>
			</div><!-- /navbar -->
		</div><!-- /header -->
		
		<div data-role="content" id="content">
		
			<div class="main">
			<?php
			$stmt = $dbh->prepare("SELECT fname, lname, department FROM staff WHERE id = ?");
			$stmt->execute(array($_SESSION['usr_id']));
			$staff = $stmt->fetchAll();
			?>
				<div id="staffpic">
					<div>
					<a href="#"><img src="../assets/images/user.jpg"></a>
					</div>
					<div>
						<ul>
							<li><b><?php echo $staff[0]['fname']." ".$staff[0]['lname']; ?></b></li>
							<li><?php echo $staff[0]['department']; ?></li>
						</ul>
					</div>
				</div>
				<div id="post">
				<?php $stmt = $dbh->prepare("SELECT id, course_code FROM courses LEFT JOIN staff_course ON id = courseId WHERE staffId = ?");
				$stmt->execute(array($_SESSION['usr_id'])); 
				if($stmt->rowCount() >= 1) { 
				$courses = $stmt->fetchAll(PDO::FETCH_ASSOC); ?>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<input type="text" name="title" placeholder="Title">
				<textarea name="msg" placeholder="message..">
				</textarea>
				
				To: <select name="category">
				<?php foreach($courses as $course) { ?>
				<option value="<?php echo $course['id']; ?>" selected><?php echo $course['course_code']; ?> Students</option>
				<?php } ?>
				<option value="all">All</option>
				</select>
				
				<button type="submit" name="send">Send</button>
				</form>
				<?php } 
				
				if(isset($_POST['send']) && !empty($_POST['msg'])) {
					$cat = $_POST['category'];
					if($cat === 'all') {
						$stmt = $dbh->prepare("SELECT courseId FROM staff_course WHERE staffId = ?");
						$stmt->execute(array($_SESSION['usr_id']));
						$row = $stmt->fetchAll();
						foreach($row as $course) {
							$now = time();
							 $stmt = $dbh->prepare("INSERT INTO posts (staffId, courseId, time, title, content) VALUES (?, ?, ?, ?, ?)");
							 $stmt->execute(array($_SESSION['usr_id'], $course['courseId'], $now, $_POST['title'], $_POST['msg']));
						}
					} else { 
						$now = time();
						$stmt = $dbh->prepare("INSERT INTO posts (staffId, courseId, time, title, content) VALUES (?, ?, ?, ?, ?)");
						$stmt->execute(array($_SESSION['usr_id'], $cat, $now, $_POST['title'], $_POST['msg']));
					}
				}
				?>
				</div>
				
				<div data-role="footer" id="footer">
					<ul class="ui-listview-inset">
						<li><a href="#">Settings</a></li>
						<li><a href="../profile/exit/" data-ajax="false">Log out</a></li>
					</ul>
				</div><!-- /footer -->
			</div><!--/main content -->
			
			<div class="sidebar">
			</div><!--/sidebar -->
			
		</div><!--/content -->
	</div><!-- /staff home page -->
	
	<div data-role="page" id="courses" data-url="course-update" data-title="Unimaid | staffName">
	
		<div data-role="header" id="main-header">
		<span id="site-logo"><a href="#">UNIMAID</a></span>
		</div>	
	
		<div data-role="header" id="header" style="border-bottom:1px solid #ccc;">
			<div data-role="navbar">
				<ul>
					<li><a href="#home" id="nav"><div class="genericon genericon-home"></div> Home</a></li>
					<li><a href="#courses" id="active"><div class="genericon genericon-book"></div> Courses</a></li>
				</ul>
			</div><!-- /navbar -->
		</div><!-- /header -->
		
		<div data-role="content" id="content">
		<?php
		$sql = "SELECT id, course_code, course_title
				FROM courses
				LEFT JOIN staff_course ON id = courseId
				WHERE staffId = ?";
				
		$stmt = $dbh->prepare($sql);
		$stmt->execute(array($_SESSION['usr_id']));
		if($stmt->rowCount() >= 1) {
			$row = $stmt->fetchAll();
			foreach($row as $course) { 
			$stmt = $dbh->prepare("SELECT COUNT(userId) as students FROM results WHERE courseId = ? AND sesion = '2013/2014'");
			$stmt->execute(array($course['id'])); 
			$numOf = $stmt->fetch();
			?>
		 	<div id="course">
				<span id="course-id"><?php echo $course['course_code']; ?></span>
				<p class="course-title"><?php echo $course['course_title']; ?></p>
				<div data-role="navbar" id="course-navbar">
					<ul>
						<li><a href="#" class="ui-btn-active" title="Students offering this course"><img src="../assets/images/icons/35.png"> <?php echo $numOf['students']; ?></a></li>
						<li><a href="update.php?linkId=<?php echo $course['id']; ?>" title="update students' records"><img src="../assets/images/icons/43.png"></a></li>
						<li><a href="#" title="students' performance"><img src="../assets/images/icons/49.png"></a></li>
					</ul>
				</div><!-- /navbar -->
			</div><!--/course-->
			<?php
			}
		} ?>
			
		</div><!--/content -->
		
		<div class="main">
		</div><!--/main content -->
		
		<div class="sidebar">
		</div><!--/sidebar -->
		</div><!-- /course update -->
	
	</body>
</html>