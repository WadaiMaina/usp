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
	<div data-role="page" id="update" data-url="/usp/staff/student-records" data-title="Students' Records">
		<div class="links">
		</div>
		<div data-role="header" id="main-header">
		<span id="site-logo"><a href="#">UNIMAID</a></span>
		<a href="#footer" id="menu-btn"><div class="genericon genericon-menu"></div> Menu</a>
		</div>
		
		<div data-role="header" id="header" style="border-bottom:1px solid #ccc;">
			<div data-role="navbar" id="ui-navbar">
				<ul>
					<li><a href="../staff/"><div class="genericon genericon-home"></div> Home</a></li>
					<li><a href="#courses" id="nav"><div class="genericon genericon-book"></div> Courses</a></li>
				</ul>
			</div><!-- /navbar -->
		</div><!-- /header -->
		
		<div data-role="content" id="content">
		<?php
		$id = filter_input(INPUT_GET, 'linkId', FILTER_DEFAULT);
		$rows_per_page = 25;
		$stmt = $dbh->prepare("SELECT userId FROM results WHERE courseId = ? AND sesion = '2013/2014'");
		$stmt->execute(array($id));
		$total_records = $stmt->rowCount();
		$pages = ceil($total_records / $rows_per_page);
		
		$screen = filter_input(INPUT_GET, 'pg');
		if(!isset($screen))
			$screen = 0;
		$start = $screen * $rows_per_page;
		
		$stmt = $dbh->prepare("SELECT id, idn, ca, exam FROM user_data LEFT JOIN results ON userId = id WHERE courseId = ? AND sesion = '2013/2014' LIMIT $start, $rows_per_page");
		$stmt->execute(array($id));
		$students = $stmt->fetchAll(); ?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="scores" method="post">
		<input type="hidden" name="cId" value="<?php echo $id; ?>">
		<table cellpadding="0" cellspacing="0" border="0">
			<thead>
				<tr>
					<th><b>ID Number</b></th>
					<th><b>Test</b></th>
					<th><b>Exam</b></th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(!empty($students)) {
					foreach($students as $student) { ?>
					<tr>
						<th><input type="hidden" name="id[]" value="<?php print($student[0]); ?>"> <?php print $student[1]; ?></th>
						<td><input type="text" name="ca[]" size="5" value="<?php print($student[2]); ?>"></td>
						<td><input type="text" name="exam[]" size="5" value="<?php print($student[3]); ?>"></td>
					</tr>
					<?php
					}
				} ?>
			</tbody>
		</table>
		<button type="reset" id="reset-btn">Reset</button>
		<button type="submit" name="update" id="submit-btn">Update records</button>
		<?php 
		echo "<p><hr></p>\n"; 
		$prev = $screen - 1;
		if($screen > 0) {
			$url = $_SERVER['PHP_SELF'] . "?linkId=$id&pg=$prev";
			echo "<a href=$url data-ajax=false>Previous</a>";
		}
		
		for($i = 0; $i < $pages; $i++) {
			$url = $_SERVER['PHP_SELF'] . "?linkId=$id&pg=$i";
			echo "<a href=$url>" . ($i + 1) . "</a> |";
		}
		
		$nxt = $screen + 1;
		$pages -= 1;
		if($screen < $pages) {
			$url = $_SERVER['PHP_SELF'] . "?linkId=$id&pg=$nxt";
			echo "<a href=$url>Next</a>\n";
		}
		?>
		</form>
		
		<?php if(isset($_POST['update'], $_POST['id'])) {
					$id = $_POST['id'];
					$cid = $_POST['cId'];
					$ca = $_POST['ca'];
					$exam = $_POST['exam'];
					$now = date("Y-m-d h:i:s", time());
					$ses = '2013/2014';
					
					foreach ($id as $key => $_id) {
						$records[$key] = array($now, $ca[$key], $exam[$key], $cid, $_id, $ses);
					}
					try {
						$stmt = $dbh->prepare("UPDATE results SET rTime = ?, ca = ?, exam = ? WHERE courseId = ? AND userId = ? AND  sesion = ?");
						foreach($records as $record) {
							$stmt->execute($record);
						} 
					}catch (PDOException $e) {
						echo 'Unable to establish a secure connection to DB: ' . $e->getMessage();
					}
					header("Location: $_SERVER[PHP_SELF]?linkId=$cid");
					echo '<p class=success>Update was successful!</p>';
				}
			?>
		</div>
	</div><!-- /page -->
</body>
</html>