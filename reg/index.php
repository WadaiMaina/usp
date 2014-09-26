<?php 
session_start();
include_once('../includes/db_connect.php');

if (isset($_POST['submit']) &&
!empty($_POST['usr'][3]) &&
!empty($_POST['usr'][4]) &&
!empty($_POST['usr']['pwd'][1]) &&
!empty($_POST['usr'][7])) {
	$user = $_POST['usr'];
	print_r($user);
	if(strpos($user[3], '/') ||
	strpos($user[3], '\\') ||
	strpos($user[3], '*') ||
	strpos($user[3], '^') ||
	strpos($user[3], '%') ||
	strpos($user[3], '-')) {
		//Empty value for username
		die(header("Location: ../reg.php?err=7"));
		}
	if(strpos($user[7], '/') || strpos($user[7], '\\')) {
		die(header("Location: ../reg.php?error=8"));
		} 
	$user[3] = filter_var(htmlspecialchars($user[3]), FILTER_SANITIZE_STRING);
	$email = filter_var($user[4], FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		//Invalid email address
		die(header("Location: ../reg.php?err=4"));
		}
	
	if($user['pwd'][1] !== $user['pwd'][2]) {// Password mismatch
		die(header("Location: ../reg.php?err=6"));
		}
	
	$stmt = $dbh->prepare("SELECT id FROM users WHERE username = :username LIMIT 1");
	$stmt->execute(array(':username' => $user[3])); //Check if a student with this username($user[3]) exists.
	$row = $stmt->fetch();
	
	if(!empty($row)) { //A student with this username already exists.
		
		//Return to the registration page with an error message.
		die(header("Location: ../reg.php?err=1&u=$user[3]"));
	}
	// Check if a student with this email address exists 
	$stmt = $dbh->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
	$stmt->execute(array(':email' => $user[4]));
	$stmt->fetch();
	
	if($stmt->rowCount() > 0) {// A student with this email address already exists
		
		//Return to the registration page with an error message
		die(header("Location: ../reg.php?err=3&e=$user[4]"));
		}
	// Check if a student with this id number is already registered	
	$stmt = $dbh->prepare("SELECT id FROM user_data WHERE idn = :idn LIMIT 1");
	$stmt->execute(array(':idn' => $user[7]));
	$stmt->fetch();
	
	if($stmt->rowCount() > 0) {
		
		//Return to the registration page with an error message.
		die(header("Location: ../reg.php?err=2&i=$user[7]"));
		}
	
	$salt = hash('sha512', uniqid(TRUE));
	$password = hash('sha512', $user['pwd'][1].$salt);
	$data = array(':username' => $user[3], ':email' => $user[4], ':password' => $password, ':salt' => $salt);
	$stmt = $dbh->prepare("INSERT INTO users (username, email, password, salt)
	VALUES (:username, :email, :password, :salt)");
	if($stmt->execute($data)) {
		$stmt = $dbh->prepare("SELECT id FROM users WHERE username = ?");
		$stmt->execute(array($user[3]));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$dbh->query("INSERT INTO student_level (id, idNumver, lvl, sesion) VALUES ($row[id], $user[7], $user[8], '2013/2014')");
		$data = array(
		':id' => $row['id'],
		':fname' => $user[1],
		':lname' => $user[2],
		':faculty' => $user[5],
		':dept' => $user[6],
		':lvl' => $user[8],
		':idn' => $user[7],
		':email' => $user[4]
		);
		$stmt = $dbh->prepare("INSERT INTO user_data (
		id,
		fname,
		lname,
		faculty,
		department,
		level,
		idn,
		email
		) VALUES (:id, :fname, :lname, :faculty, :dept, :lvl, :idn, :email)");
		if($stmt->execute($data)) {
			//Registeration success
			$_SESSION['usr_id'] = $row['id'];
			$im = imagecreatefromjpeg('../assets/images/user.jpg');

			// save the image to a file and clear memory
			imagejpeg($im, '../profile/uploads/' . $user[7] . '.jpg');
			imagedestroy($im);
			
			header("Location: reg_info.php");
			}
	}		
} else {
	header("Location: ../reg.php?err=9");
	}
	