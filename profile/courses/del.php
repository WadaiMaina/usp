<?php 
session_start();

$dbh = new PDO('mysql:host=localhost;dbname=usp', 'root', '');

$params[] = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
$params[] = filter_input(INPUT_GET, 'del', FILTER_SANITIZE_STRING);
$params[] = filter_input(INPUT_GET, 'pgId', FILTER_SANITIZE_STRING);

if(!empty($params)) {
	try {
		$stmt = $dbh->prepare("DELETE FROM results WHERE courseId = ? AND userId = ? AND sesion = ?");
		$stmt->execute(array($params[0], $_SESSION['usr_id'], '2013/2014'));
		header("Location: /usp/profile/courses/reg-courses.php#reg-$params[2]");
	} catch(PDOException $e) {
		print "Error: " . $e->getMessage()."<br />";
		die();
	}	
}
?>