<?php
ob_start();
session_start();
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'includes/error.php';
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
	<link href="genericons/genericons.css" rel="stylesheet">
	<link href="assets/css/login.css" rel="stylesheet">
	<link href="css/jquery-ui.min.css" rel="stylesheet">
	<script src="js/jquery.min.js" type="text/javascript"></script>
	<script src="js/jquery.mobile.min.js" type="text/javascript"></script>
	<script src="js/jquery-ui.min.js" type="text/javascript"></script>
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

</head>
<body>
	<div data-role="page" id="page" data-url="index.php" data-title="Unimaid | StudentsPortal | Login" data-ajax="false">
		<header data-role="header" id="home-header">
		<h1>UNIMAID STUDENTS' PORTAL</h1>
		</header>
		<div data-role="content" class="">
		<?php if(!isset($_POST['submit'])) { ?>
		<div class="form-container">
			<?php if('' != $err_msg): ?>
				<div class="ui-widget">
					<div class="ui-state-error ui-corner-all" style="font-size:14px; text-shadow:none;">
						<p><div style="color:#FC0; font-size: 16px;" class="genericon genericon-warning"></div>
						<strong>Alert:&nbsp;</strong><?php echo $err_msg; ?></p>
					</div>
				</div>
			<?php endif; ?>
			<h1>Login</h1>
			<span>Enter your userneame and password to login to your account.</span>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<input type="text" name="user[name]" id="username" placeholder="username">
				<input type="password" name="user[password]" id="password" placeholder="password">
				<fieldset data-role="controlgroup" data-mini="true">
					<input name="checkbox-6" id="checkbox-6" type="checkbox">
					<label id="rem" for="checkbox-6">Remember me</label>
				</fieldset>
				<button type="submit" name="submit" id="login-submit-btn">Log in</button>
				<div id="sep"></div>
				<span id="reg-link"><a href="#">Lost your password?</a> | <a href="reg.php" data-ajax="false">Register here</a> in few easy steps</span>
			</form>
			</div>
			</div><!-- /content -->
		<div style="display:none;" data-role="footer" id="footer" data-position="">
		&copy;<?php echo date("Y", time()); ?>, <a href="#">University of Maiduguri</a>
		</div>
	</div><!-- /page -->
	<?php } 
	else {
		if(isset($_POST['user']['name']) && isset($_POST['user']['password'])) {
			$user = $_POST['user'];
			
			//check if the user exists and fetch the login credentials
			//that corresponds to the username provided.
			$stmt = $dbh->prepare("SELECT * FROM users WHERE username = ?");
			$stmt->execute(array($user['name']));
			$usr = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if(!empty($usr)) { // if DBase did not return an empty result set
				$pwd = hash('sha512', $user['password'] . $usr['salt']);
				if($pwd == $usr['password']) { //password is correct
					if(checkbrute($usr['id'], $dbh) == true) {
					//make sure the user did not exceed the
					//maximum number of login attempts 
						die(header('Location: info/?i=l'));
					} else {
						// maximum number of login attempts is not exceeded
						// get the user-agent string
						$user['browser'] = $_SERVER['HTTP_USER_AGENT'];
						
						//XSS protection as we might print this value in another session
						$user['id'] = preg_replace('/[^0-9]+/', '', $usr['id']);
						
						$_SESSION['usr_id'] = $user['id'];
						$_SESSION['loginStr'] = hash('sha512', $user['browser'].$usr['salt']);
						
						// Login successful
						if(is_staff($dbh, $usr['id'])) {
							header("Location: staff/");
						} else {
							header("Location: profile/?id=$user[name]");
						}
					}
				} else { // password is not correct
				// We record the attempt and send the user an error message
					$now = time();
					$stmt = $dbh->query("INSERT INTO login_attempts (id, time, location) VALUES ($usr[id], $now, 'not set')");
					header('Location: index.php?err=10');
				}
			} else {
				header('Location: index.php?err=11');
			}
		} else {
			header('Location: index.php');
		}
	}
	?>
</body>
</html>	