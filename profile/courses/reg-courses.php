<?php
session_start();
include_once('../../includes/functions.php');
include_once('../../includes/db_connect.php');
if(!isset($_SESSION['usr_id'])) {
	header("Location: ../../info/?i=u");
}
$user = $_SESSION['usr'];
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
	<link href="../../css/main.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="../../css/jquery.mobile.css" rel="stylesheet">
	<link href="../../genericons/genericons.css" rel="stylesheet">
	<script src="../../js/jquery.min.js" type="text/javascript"></script>
	<script src="../../js/jquery.mobile.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	var router = new $.mobile.Router({
          "#reg-second": {handler: "reg_sec", events: "bc,c,i,bs,s,bh,h" },
        },{
          reg_sec: function(type,match,ui){
            console.log("localpage2: "+type+" "+match[0]);
            var params=router.getParams(match[1]);
            console.log(params);
          }
        }, { 
          defaultHandler: function(type, ui, page) {
            console.log("Default handler called due to unknown route (" 
              + type + ", " + ui + ", " + page + ")"
            );
          },
          defaultHandlerEvents: "s",
	  defaultArgsRe: true
        });
    </script>
	
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

</head>
<body>
<div data-role="page" id="reg-first" data-url="<?php echo $_SERVER['PHP_SELF']; ?>" data-title="<?php echo $user->fullName; ?> | Registered Courses">
	
		<!-- header -->
		
		<header data-role="header" id="header">
			<div id="logo">
			 <a href="#" target="_self"><img src="../../assets/images/logo_log.png" alt="UNIMAID logo" title="University of Maiduguri"></a>
			</div>
			<nav class="um-nv">
				<div data-role="navbar" data-grid="b">
					<ul>
						<li id="nvbar-list"><a href="#" id="um-link">About Us</a></li>
						<li id="nvbar-list"><a href="#" id="um-link">Contact</a></li>
					</ul>
				</div><!-- /navbar -->
				<div data-role="navbar" id="cnct-nvbar">
					<ul>
						<li><a href="#" id="contact"><div class="mob-contact"></div></a></li>
					</ul>
				</div><!-- /navbar -->
			</nav>
		</header><!--/header -->
		
		<section class="blue-band">
			<div id="usp-title">
				<a href="#">Students' Portal</a>
			</div>
			<div id="nv-btn">
				<a href="#" id="mob-nv-btn"><div class="mob-nv-btn"></div></a>
				<a href="#" id="cls-btn"></a>
			</div>
			<div class="options">
				<ul>
					<li><a href="#" id="un-link"><div id="dsp-nm"><?php echo $user->fullName; ?><br><label><?php echo $user->username; ?></label></div> <img src="../uploads/<?php echo $user->idn; ?>.jpg" alt="<?php echo $user->username."'s picture"; ?>" title="profile picture"></a>
						<ul>
							<li><a href="../../profile/#profile"><div class="genericon genericon-user"></div> Profile</a></li>
							<li><a href="../exit/" data-ajax="false"><div class="genericon genericon-key"></div> Log out</a></li>
							<li><a href="../../profile/#settings"><div class="genericon genericon-cog"></div> Settings</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</section>

		<section class="navigation">
			<nav id="main-nv">
				<ul data-role="listview" data-inset="true">
					<li data-icon="false"><a href="../../profile/" data-ajax="false">Home</a></li>
					<li data-icon="false"><a href="../courses/" data-ajax="false" id="active">Courses</a></li>
					<li data-icon="false"><a href="reg-courses.php" data-ajax="false" id="active" >Regisrered Courses</a></li>
					<li data-icon="false"><a href="../result/" data-ajax="false">Results</a></li>
					<li data-icon="false"><a href="../../profile/#gallery" data-ajax="false">Gallery</a></li>
					<li data-icon="false"><a href="../../profile/#blog" data-ajax="false">Blog</a></li>
					<li data-icon="false"><a href="../exit" data-ajax="false">Log out</a></li>
				</ul>
			</nav>
		</section><!-- /navigation -->
		
		<!-- main content -->
		<section data-role="content" class="main">
		<h1>Registered courses for 2013/2014 session</h1>
		<a href="#reg-first" id="active-tab">First semester</a> <a href="#reg-second" id="tab-link">Second semester</a>
			<?php
			class reg_courses {
				public $db;
				public $sesion;
				var $ID;
				var $Code;
				var $Title;
				var $Unit;

				function deleteCourse() {
					$dbh = $this->db;
					$stmt = $dbh->prepare("DELETE FROM results WHERE courseId = ? AND userId = ? AND sesion = ?");
					$stmt->execute(array($this->cID, $_SESSION['usr_id'], $this->sesion));
				}
			}
			$stmt = $dbh->prepare("SELECT id, course_code, course_title, unit FROM courses LEFT JOIN results ON id = courseId WHERE userId = ? AND sesion = ? AND semester = ?");
			$stmt->execute(array($_SESSION['usr_id'], '2013/2014', 1));
			$rows = $stmt->rowCount() !== 0 ? $stmt->fetchAll() : 'empty';
			if ('empty' == $rows) {
				die('<p>You did not register any course this semester</p>');
			}
			else {
				foreach ($rows as $key => $row) {
					$course[$key] = new reg_courses();
					$course[$key]->db = $dbh;
					$course[$key]->sesion = '2013/2014';
					$course[$key]->ID = $row[0];
					$course[$key]->Code = $row[1];
					$course[$key]->Title = $row[2];
					$course[$key]->Unit = $row[3];
				}
			} ?>
				<table id="reg-course-tbl" border="0" cellspacing="0" cellpadding="5">
					<thead>
						<tr>
							<th>Course ID</th>
							<th>Course Title</th>
							<th>Couse Unit</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($course as $_) { ?>
							<tr>
								<th><?php echo $_->Code; ?></th>
								<td><?php echo $_->Title; ?></td>
								<td><?php echo $_->Unit; ?></td>
								<td>
									<div id="confirm-box" style="display:none;">
										<a href="del.php?id=<?php echo $_->ID.'&del=true&pgId=first'; ?>" id="confirm" data-ajax="false">Confirm</a>
										<a href="#" id="cancel">Cancel</a>
									</div>
									<a href="#" id="delete">Delete</a>
								</td>
							</tr>
					<?php	} ?>
	 				</tbody>
				</table>
				<script type="text/javascript">
				var del = $("table tr:gt(0)").children("td:last-child");
				del.each(function() {
					$(this).children("a:last-child").click(function() {
						$(this).parent('td').children('div:first-child').show();
						$(this).hide();
					});
				});
				
				var del = $("table tr:gt(0)").children("td:last-child");
				del.each(function() {
					var cancel = $(this).children("div:first-child");
					cancel.children("a:last-child").click(function() {
						$(this).parent('div').hide();
						del.children("a:last-child").show();
					});
				});
				
				$('#mob-nv-btn').on('click', function() {
					$('#main-nv').show();
					$(this).attr('style', 'z-index:10');
				});
				
				$('#cls-btn').on('click', function() {
					$('#main-nv').hide();
					$('#mob-nv-btn').attr('style', 'z-index:14');
				});
				</script>
				</section>
				</div><!-- /page -->
				
				<div data-role="page" id="reg-second" data-url="<?php echo $_SERVER['PHP_SELF'].'#reg-second'; ?>" data-tile="<?php echo $user->fullName; ?> | Registered Courses">
					<!-- header -->
		
					<header data-role="header" id="header">
						<div id="logo">
						 <a href="#" target="_self"><img src="../../assets/images/logo_log.png" alt="UNIMAID logo" title="University of Maiduguri"></a>
						</div>
						<nav class="um-nv">
							<div data-role="navbar" data-grid="b">
								<ul>
									<li id="nvbar-list"><a href="#" id="um-link">About Us</a></li>
									<li id="nvbar-list"><a href="#" id="um-link">Contact</a></li>
								</ul>
							</div><!-- /navbar -->
							<div data-role="navbar" id="cnct-nvbar">
								<ul>
									<li><a href="#" id="contact"><div class="mob-contact"></div></a></li>
								</ul>
							</div><!-- /navbar -->
						</nav>
					</header><!--/header -->
					
					<section class="blue-band">
						<div id="usp-title">
							<a href="#">Students' Portal</a>
						</div>
						<div id="nv-btn">
							<a href="#" id="mob-nv-btn-one"><div class="mob-nv-btn"></div></a>
							<a href="#" id="cls-btn-one"></a>
						</div>
						<div class="options">
							<ul>
								<li><a href="#" id="un-link"><div id="dsp-nm"><?php echo $user->fullName; ?><br><label><?php echo $user->username; ?></label></div> <img src="../uploads/<?php echo $user->idn; ?>.jpg" alt="<?php echo $user->username."'s picture"; ?>" title="profile picture"></a>
									<ul>
										<li><a href="../../profile/#profile"><div class="genericon genericon-user"></div> Profile</a></li>
										<li><a href="../exit/" data-ajax="false"><div class="genericon genericon-key"></div> Log out</a></li>
										<li><a href="../../profile/#settings"><div class="genericon genericon-cog"></div> Settings</a></li>
									</ul>
								</li>
							</ul>
						</div>
					</section>

					<section class="navigation">
						<nav id="main-nv-one">
							<ul data-role="listview" data-inset="true">
								<li data-icon="false"><a href="../../profile/" data-ajax="false">Home</a></li>
								<li data-icon="false"><a href="../courses/" data-ajax="false" id="active">Courses</a></li>
								<li data-icon="false"><a href="../result/" data-ajax="false">Results</a></li>
								<li data-icon="false"><a href="../../profile/#gallery" data-ajax="false">Gallery</a></li>
								<li data-icon="false"><a href="../../profile/#blog" data-ajax="false">Blog</a></li>
								<li data-icon="false"><a href="../exit" data-ajax="false">Log out</a></li>
							</ul>
						</nav>
					</section><!-- /navigation -->
					
					<!-- main content -->
					<section data-role="content" class="main">
					<h1>Registered courses for 2013/2014 session</h1>
					<a href="#reg-first" id="tab-link">First semester</a> <a href="#reg-second" id="active-tab">Second semester</a>
						<?php
						$stmt->execute(array($_SESSION['usr_id'], '2013/2014', 2));
						$rows = $stmt->rowCount() !== 0 ? $stmt->fetchAll() : 'empty';
					if ('empty' == $rows) {
						die('<p>You did not register any course this semester</p>');
					}
					else {
						foreach ($rows as $key => $row) {
							$course[$key] = new reg_courses();
							$course[$key]->db = $dbh;
							$course[$key]->sesion = '2013/2014';
							$course[$key]->ID = $row[0];
							$course[$key]->Code = $row[1];
							$course[$key]->Title = $row[2];
							$course[$key]->Unit = $row[3];
						}
					} ?>
						<table id="reg-course-tbl" border="0" cellspacing="0" cellpadding="5">
							<thead>
								<tr>
									<th>Course ID</th>
									<th>Course Title</th>
									<th>Couse Unit</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($course as $_) { ?>
									<tr>
										<th><?php echo $_->Code; ?></th>
										<td><?php echo $_->Title; ?></td>
										<td><?php echo $_->Unit; ?></td>
										<td>
											<div id="confirm-box" style="display:none;">
												<a href="del.php?id=<?php echo $_->ID."&del=true&pgId=second"; ?>" id="confirm" data-ajax="false">Confirm</a>
												<a href="#" id="cancel">Cancel</a>
											</div>
											<a href="#" id="delete">Delete</a>
										</td>
									</tr>
							<?php	} ?>
			 				</tbody>
						</table>
						<script type="text/javascript">
						var del = $("table tr:gt(0)").children("td:last-child");
						del.each(function() {
							$(this).children("a:last-child").click(function() {
								$(this).parent('td').children('div:first-child').show();
								$(this).hide();
							});
						});
						
						var del = $("table tr:gt(0)").children("td:last-child");
						del.each(function() {
							var cancel = $(this).children("div:first-child");
							cancel.children("a:last-child").click(function() {
								$(this).parent('div').hide();
								del.children("a:last-child").show();
							});
						});
						</script>
					</section>

			
			</div><!-- /page -->
<script type="text/javascript">
	$('#mob-nv-btn').on('click', function() {
		$('#main-nv').show();
		$(this).attr('style', 'z-index:10');
	});
	
	$('#cls-btn').on('click', function() {
		$('#main-nv').hide();
		$('#mob-nv-btn').attr('style', 'z-index:14');
	});
	
	
	
	$('#mob-nv-btn-one').on('click', function() {
		$('#main-nv-one').show();
		$(this).attr('style', 'z-index:10');
	});
	
	$('#cls-btn-one').on('click', function() {
		$('#main-nv-one').hide();
		$('#mob-nv-btn-one').attr('style', 'z-index:14');
	});
</script>
</body>
</html>