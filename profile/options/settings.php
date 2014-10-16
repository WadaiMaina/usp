<?php
session_start();
include_once('../../includes/functions.php');
include_once('../../includes/db_connect.php');
$user = $_SESSION['usr'];
$currSession = $_SESSION['ses'];

if (isset($_POST['done'])) {
	$fname = $_POST['fname'] != $user->fname ? $_POST['fname'] : $user->fname;
	$lname = $_POST['lname'] != $user->lname ? $_POST['lname'] : $user->lname;
	$level = $_POST['curr-level'] != $user->level ? $_POST['curr-level'] : $user->level;
	$email = $_POST['email'] != $user->email ? $_POST['email'] : $user->email;
	$mobile = $_POST['mob'] != $user->mobile ? $_POST['mob'] : $user->mobile;
	$password = $_POST['password_1'];
	$password_2 = $_POST['password_2'];
	$id = $_SESSION['usr_id'];
	
	$stmt = $dbh->query("SELECT salt FROM users WHERE id = $id");
	$salt = $stmt->fetchAll();
	$salt = $salt[0][0];
	
	if(!empty($password))
	$password = ($password == $password_2) ? $password : false;
	
	if(false == $password) {
		header("Location: ../options/?err=true&f=pass");
	} else {
		$password = hash('sha512', $password.$salt);
		$stmt = $dbh->prepare("UPDATE users SET password = ?, email = ? WHERE id = ?");
		$stmt->execute(array($password, $email, $id));
	}
	
	$stmt = $dbh->prepare("SELECT level FROM student_level WHERE id = ? AND sesion = ?");
	$stmt->execute(array($id, $currSession));
	$row = $stmt->fetchAll();
	print_r($row);
	
	if(empty($row))
	$dbh->query("INSERT INTO student_level (id, idNumber, level, sesion) VALUES ($id, $user->idn, $level, $currSession)");
	
	
	$fname = empty($fname) ? $user->fname : $fname;
	$lname = empty($lname) ? $user->lname : $lname;
	$level = empty($level) ? $user->level : $level;
	$mobile = empty($mobile) ? $user->mobile : $mobile;
	
	$stmt = $dbh->prepare("UPDATE user_data SET fname = ?, lname = ?, level = ?, email = ?, mobile = ? WHERE id = ?");
	$stmt->bindParam(1, $_fname);
	$stmt->bindParam(2, $_lname);
	$stmt->bindParam(3, $_level);
	$stmt->bindParam(4, $_email);
	$stmt->bindParam(5, $_mobile);
	$stmt->bindParam(6, $_id);
	
	$_fname = $fname;
	$_lname = $lname;
	$_level = $level;
	$_email = $email;
	$_mobile = $mobile;
	$_id = $id;
	
	$stmt->execute();
	if(isset($_FILES['profile-pic']['name']) && !empty($_FILES['profile-pic']['tmp_name']))
	$pic = $_FILES['profile-pic'];
	
	$upload_dir = '../uploads/';
	$name = $user->idn;
	$allowedExts = array('gif', 'jpeg', 'jpg', 'png');
	$temp = explode('.', $pic['name']);
	$type = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
	$extension = end($temp);

		if(in_array($pic['type'], $type) && in_array($extension, $allowedExts)) {
		if ($pic['error'] == UPLOAD_ERR_PARTIAL) {
			echo "Only a part of the file was uploaded. Please try again.";
		} elseif ($pic['error'] == UPLOAD_ERR_NO_FILE) {
			echo "No file was uploaded. Please make sure that a file was selected for upload.";
		} elseif ($pic['error'] == UPLOAD_ERR_CANT_WRITE) {
			echo "Write error: unable to write file to disk";
		} elseif ($pic['size'] > 102400) {
			echo "The file is too large.";
		} elseif ($pic['error'] == UPLOAD_ERR_OK) {
			move_uploaded_file($pic['tmp_name'], $upload_dir . $name.".jpg");
		} else {
			echo "Invalid file";
		}
	} else {
		echo "Invalid file";
	}
	header("Location: ../options?update=true&m=$mobile");
}