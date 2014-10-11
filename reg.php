<?php
ob_start();
session_start();
include_once('includes/error.php');
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
	<link href="css/jquery.mobile.min.css" rel="stylesheet">
	<link href="css/jquery-ui.min.css" rel="stylesheet">
	<link href="genericons/genericons.css" rel="stylesheet">
	<link href="assets/css/login.css" rel="stylesheet">
	<link href="assets/css/reg.css" rel="stylesheet">
	<link href="css/login.css" rel="stylesheet">
</head>
<body>
	<div data-role="page" id="page" data-url="reg.php" data-title="Unimaid | StudentsPortal | Registration">
		<header data-role="header" class="header" style="background-color:#111; border:none; border-bottom:3px solid #0ad;">
			<div class="logo">
				<a href="#"><img src="assets/images/logo_log.png"></a>
			</div>
			<div id="nav">
				<ul>
					<li><a href="#"><div class="genericon genericon-home" style="vertical-align:middle;"></div> Home</a></li>
					<li><a href="#"><div class="genericon genericon-info" style="vertical-align:middle;"></div> About</a></li>
					<li><a href="#"><div class="genericon genericon-mail" style="vertical-align:middle;"></div> Contact</a></li>
				</ul>
			</div><!-- /navbar -->
		</header>
		<div data-role="content" class="main">
			<div class="form-container">
			<?php if('' != $err_msg): ?>
				<div class="ui-widget">
					<div class="ui-state-error ui-corner-all" style="font-size:14px; text-shadow:none;">
						<p><div style="color:#FC0; font-size: 16px;" class="genericon genericon-warning"></div>
						<strong>Alert:&nbsp;</strong><?php echo $err_msg; ?></p>
					</div>
				</div>
			<?php endif; ?>
			<h1>Create an account</h1>
			<span>Registering for a student account is easy. Just fill this form and we will create a new account for you.</span>
			<form action="reg/" method="post" data-role="none" id="regForm" name="regForm" class="regForm">
				<div id="first-section">
				<label for="fname" class="ui-hidden-accessible">Firstname: </label>
				<input type="text" name="usr[1]" id="fname" placeholder="Firstname">
				<label for="lname" class="ui-hidden-accessible">Lastname: </label>
				<input type="text" name="usr[2]" id="lname" placeholder="Lastname">
				<label for="username" class="ui-hidden-accessible">Username: </label>
				<input type="text" name="usr[3]" id="usrname" placeholder="username">
				<label for="email" class="ui-hidden-accessible">Email: </label>
				<input type="email" name="usr[4]" id="email" placeholder="email">
				<label for="pwd" class="ui-hidden-accessible">Password: </label>
				<input type="password" name="usr[pwd][1]" id="pwd" placeholder="password">
				<label for="pwd" class="ui-hidden-accessible">Confirm password: </label>
				<input type="password" name="usr[pwd][2]" id="pwd" placeholder="confirm password">
				</div><!-- /first-section -->
				<div id="second-section">
				<label for="selectmenu" class="ui-hidden-accessible">Faculty: </label>
					<select name="usr[5]" id="selectmenu">
						<option value="Arts">Arts</option>
						<option value="Sciences">Sciences</option>
						<option value="Management Sciences" selected>Management Sciences</option>
						<option value="Engineering">Engineering</option>
						<option value="Social Sciences">Social Sciences</option>
					</select>
					<div>
						<label for="dept" class="ui-hidden-accessible">Department: </label>
						<input id="dept" name="usr[6]" title="type &quot;a&quot;" placeholder="Department">
					</div>
					<label for="level" class="ui-hidden-accessible">Level: </label>
					<select name="usr[8]" id="level">
						<option selected>level</option>
						<option value="100">100 level</option>
						<option value="200">200 level</option>
						<option value="300">300 level</option>
						<option value="400">400 level</option>
						<option value="500">500 level</option>
					</select>
					<label for="idn" class="ui-hidden-accessible">Id number: </label>
					<input type="text" name="usr[7]" id="idn" placeholder="Id number">
					<span>Example: 100504003 <b>NOT</b> 10/05/04/003</span><br><br>
					<button type="submit" rel="external" name="submit" id="login-submit-btn" data-ajax="false" onClick="return checkForm();">Create Account</button>
					<span>Already have an account? <a href="index.php" data-ajax="false">Login</a></span>
				</div><!-- /second-section -->
			</form>
			</div>
		</div><!-- /content -->
		<div style="display:none" data-role="footer" id="footer" data-position="">
		&copy;2014, <a href="#">University of Maiduguri</a>
		</div>
	</div><!-- /page -->

	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/jquery.mobile.min.js" type="text/javascript"></script>
	<script src="js/jquery-ui.min.js" type="text/javascript"></script>
	
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<script type="text/javascript">
	$( "#accordion" ).accordion();


var availableTags = [
	"ActionScript",
	"AppleScript",
	"Asp",
	"BASIC",
	"C",
	"C++",
	"Clojure",
	"COBOL",
	"ColdFusion",
	"Erlang",
	"Fortran",
	"Groovy",
	"Haskell",
	"Java",
	"JavaScript",
	"Lisp",
	"Perl",
	"PHP",
	"Python",
	"Ruby",
	"Scala",
	"Scheme"
];
$( "#dept" ).autocomplete({
	source: availableTags
});



$( "#button" ).button();
$( "#radioset" ).buttonset();



$( "#tabs" ).tabs();



$( "#dialog" ).dialog({
	autoOpen: false,
	width: 400,
	buttons: [
		{
			text: "Ok",
			click: function() {
				$( this ).dialog( "close" );
			}
		},
		{
			text: "Cancel",
			click: function() {
				$( this ).dialog( "close" );
			}
		}
	]
});

// Link to open the dialog
$( "#dialog-link" ).click(function( event ) {
	$( "#dialog" ).dialog( "open" );
	event.preventDefault();
});



$( "#datepicker" ).datepicker({
	inline: true
});



$( "#slider" ).slider({
	range: true,
	values: [ 17, 67 ]
});



$( "#progressbar" ).progressbar({
	value: 20
});



$( "#spinner" ).spinner();



$( "#menu" ).menu();



$( "#tooltip" ).tooltip();



$( "#selectmenu" ).selectmenu();


// Hover states on the static widgets
$( "#dialog-link, #icons li" ).hover(
	function() {
		$( this ).addClass( "ui-state-hover" );
	},
	function() {
		$( this ).removeClass( "ui-state-hover" );
	}

);
</script>
</body>
</html>