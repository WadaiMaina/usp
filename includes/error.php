<?php
$error = filter_input(INPUT_GET, 'err', FILTER_SANITIZE_STRING);
$username = filter_input(INPUT_GET, 'u', FILTER_SANITIZE_STRING);
$id = filter_input(INPUT_GET, 'i', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_GET, 'e', FILTER_SANITIZE_STRING);
$err_msg = null;
if(!$error) { //An unknown error
	$err_msg = "An unknown error occurred.";
}

switch($error) {
	case(1): //The username is already in use.
	$err_msg = "A student with the username <a href=#>".$username."</a> already exists";
	break;
	case(2): //The ID Number belongs to an already registered student
	$err_msg = "A student with the ID Number ".$id." is already registered.";
	break;
	case(3): //Email address is already used by another user
	$err_msg = "A student with email address ".$email." already exists";
	break;
	case(4): //Email address is not valid
	$err_msg = "The email address you entered is invalid.";
	break;
	case(5): //Invalid ID Number
	$err_msg = "The ID Number you entered contains invalid characters.";
	break;
	case(6): //password do not match
	$err_msg = "The passwords you provided do not match";
	break;
	case(7): //Empty username value
	$err_msg = "Please enter a username. A username must not contain any of these characters: '/\:*?<>|^%.";
	break;
	case(8): //Empty username value
	$err_msg = "Please type in your ID Number correctly";
	break;
	case(9): //Empty reuired field
	$err_msg = "Please fill all the fields";
	break;
	case('10'): //Password is not correct
	$err_msg = "Password is not correct";
	break;
	case('11'): //No student with this username exists
	$err_msg = "The username you entered is not correct. Please try again";
	break;
	case('i'): //Invalid pin
	$err_msg = "Invalid PIN.";
	break;
	case('b'): //Used PIN
	$err_msg = "The PIN is already used by another student.";
	break;
	default: $err_msg = "";
	break;
}
?>