<?php
session_start();
include_once('../../includes/db_connect.php');

if(isset($_POST['check']) && ('' !== $_POST['pin'])) {
	$_SESSION['pin'] = $_POST['pin'];
	$stmt = $dbh->prepare("SELECT serialNo FROM pin WHERE pinNo = ?");
	$stmt->execute(array($_POST['pin']));
	if($stmt->rowCount() == 1) {
		$stmt = $dbh->prepare("SELECT id FROM users WHERE pin = ?");
		$stmt->execute(array($_POST['pin']));
		$row = $stmt->fetchAll();
		if(empty($row)) {
			$stmt = $dbh->prepare("UPDATE users SET pin = :pin WHERE id = :id");
			$stmt->execute(array(':pin' => $_POST['pin'], ':id' => $_SESSION['usr_id']));
			$_SESSION['ses'] = $_POST['session'];
			header("Location: ../results/");
		} elseif($row[0]['id'] == $_SESSION['usr_id']) {
			$_SESSION['ses'] = $_POST['session'];
			header("Location: ../results/");
		} else {
			die(header('Location: ../?err=b'));
		}
	} else {
		die(header('Location: ../?err=i'));
	}
} else {
	header('Location: ../');
}