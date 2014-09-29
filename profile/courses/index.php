<?php
session_start();
include_once('../../includes/functions.php');
include_once('../../includes/db_connect.php');
if(!isset($_SESSION['usr_id'])) {
	header("Location: ../../info/?i=u");
}
$user = $_SESSION['usr'];
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
<div data-role="page" id="course" data-url="courses" data-title="StudentsPortal | <?php echo $user->fname; ?> | Courses">
	
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
				<a href="#" id="mob-nv-btn"><div class="mob-nv-btn"></div></a>
				<a href="#" id="cls-btn"></a>
			</div>
			<div class="options">
				<ul>
					<li><a href="#" id="un-link"><div id="dsp-nm"><?php echo $user->fullName; ?><br><label><?php echo $user->username; ?></label></div> <img src="../uploads/<?php echo $user->idn; ?>.jpg" alt="<?php echo $user->username."'s picture"; ?>" title="profile picture"></a>
						<ul>
							<li><a href="../../profile/#profile"><div class="genericon genericon-user"></div> Profile</a></li>
							<li><a href="../exit/" data-ajax="false"><div class="genericon genericon-key"></div> Log out</a></li>
							<li><a href="../../profile/#settings"><div class="genericon genericon-cog"></div> Settings</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</section>

		<section class="navigation">
			<nav id="main-nv">
				<ul data-role="listview" data-inset="true">
					<li data-icon="false"><a href="../../profile/" data-ajax="false">Home</a></li>
					<li data-icon="false"><a href="../courses/" data-ajax="false" id="active">Courses</a></li>
					<li data-icon="false"><a href="../pin/" data-ajax="false">Results</a></li>
					<li data-icon="false"><a href="../../profile/#gallery" data-ajax="false">Gallery</a></li>
					<li data-icon="false"><a href="../../profile/#blog" data-ajax="false">Blog</a></li>
					<li data-icon="false"><a href="../exit" data-ajax="false">Log out</a></li>
				</ul>
			</nav>
		</section><!-- /navigation -->
		
		<!-- main content -->
		<section data-role="content" class="main">
    	<h1>Course registration</h1>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="course-form">
		<span>Select the faculty, department, level and semester for the course(s) you want to register.</span>
		<ul>
			<li>
				<select name="course[fac]" id="fac" data-icon="false">
					<option selected>-faculty-</option>
					<?php courseCheck($dbh, 'faculty'); ?>
				</select>
			</li>
			<li>
				<select name="course[dept]" id="dept" data-icon="false">
				<option selected="selected">-department-</option>
				<?php $stmt = $dbh->query("SELECT DISTINCT department FROM courses");
				$row = $stmt->fetchAll();
				foreach($row as $dept) { ?>
				<option value="<?php echo $dept['department']; ?>"><?php echo $dept['department']; ?></option>
				<?php } ?>
				</select>
			</li>
			<li>
				<select name="course[level]" data-icon="false">
					<option selected>-level-</option>
					<?php courseCheck($dbh, 'level'); ?>
				</select>
			</li>
			<li>
				<select name="course[semester]" data-icon="false">
					<option selected>-semester-</option>
					<?php courseCheck($dbh, 'semester'); ?>
				</select>
			</li>
		</ul>
		<button type="submit" name="check">Fetch Course(s)</button>
	</form>
<?php 
if(isset($_POST['check'])) {	
	$crs = $_POST['course'];
	$stmt = $dbh->prepare("SELECT id, course_code, course_title, unit FROM courses WHERE faculty = :fac AND department = :dept AND level = :level AND semester = :semester");
	$stmt->execute($crs);
	$row = $stmt->fetchAll();
	if(!empty($row)) { ?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="fetched-courses">
	<table data-role="table" id="table-custom-2" class="ui-body-d ui-shadow table-stripe ui-responsive">
		<thead>
			<tr class="ui-bar-d">
				<th></th>
				<th>Course Code</th>
				<th>Course Title</th>
				<th>Course Unit</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($row as $data) { ?>
			<tr>
				<td><input type="checkbox" value="<?php echo $data['id']; ?>" name="course[]"/></td>
				<td><?php echo $data['course_code']; ?></td>
				<td><?php echo $data['course_title']; ?></td>
				<td><?php echo $data['unit']; ?></td>
			</tr>
			<?php
		} ?>
		</tbody>
	</table>
	<button type="submit" name="submit">Submit</button>
	</form>
	<?php }
	else {
		echo "An empty result set was returned";
	}
}
if(isset($_POST['submit']) && !empty($_POST['course'])) {
	$courses = $_POST['course'];
	$dbh->beginTransaction();
	$sql = "INSERT INTO results (courseId, userId, sesion) VALUES (?, ?, ?)";
	$stmt = $dbh->prepare($sql);
	
	foreach($courses as $course) {
		$stmt->execute(array($course, $_SESSION['usr_id'], '2013/2014'));
	}
	$dbh->commit();
	
 }
?>

</section>
</div><!--/course registration page-->
<script type="text/javascript">
$('li').attr('data-icon', 'false');
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