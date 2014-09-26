<?php

$path = "../includes/; ../functions/"; //directories where files specified for inclusion are saved.
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
include 'db_details.php';

//Created instance with the error mode set
try {
	$dbh = new PDO(DSN, USER, PWD, [PDO::ATTR_PERSISTENT => TRUE]);
} catch (PDOException $e) {
	die("<p class=error>Unable to connect</p> ". $e->getMessage());
}