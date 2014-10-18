<?php 
include('../includes/db_connect.php');
$name = $_POST['name'];
$level = $_POST['level'];

if(isset($name)) {
	$details[] = $name;
	$details[] = $level;
}

?>