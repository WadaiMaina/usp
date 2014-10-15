<?php

function checkbrute($usr, $db) {
	//Get time stamp of the current time
	$now = time();
	
	//All login attemps are counted from the past two hours
	$valid_attempts = $now - 7200;
	$stmt = $db->prepare("SELECT time FROM login_attempts WHERE id = ? AND time > $valid_attempts");
	$stmt->execute(array($usr));
		
	//if there have been more than five attemps
	if($stmt->rowCount() > 5) {
		return true;
	}
	else {
		return false;
	}

}

function checkLogin($dbh) {
	if (isset($_SESSION['usr_id'], $_SESSION['loginStr'])) { //check if all session variables are set.
		$usr_id = $_SESSION['usr_id'];
		$login_string = $_SESSION['loginStr'];

		if ($stmt = $dbh->prepare("SELECT salt FROM users WHERE id = :id")) {
			$stmt->bindValue(':id', $usr_id, PDO::PARAM_INT);
			$stmt->execute();

			if ($stmt->rowCount() == 1) {
				// if the user exists, get variable from result
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$salt = $row['salt'];
				
				//the user-agent string of the user
				$user_browser = $_SERVER['HTTP_USER_AGENT'];
				
				$loginStr = hash('sha512', $user_browser.$salt);
				if ($loginStr == $login_string) {
					// user is logged in!!!
					return true;
				} else {
					// not logged in..
					return false;
				}
			} 
		} else {
			//Not logged in..
			return false;
			}
	} 
} 

function esc_url($url) {
	if ('' == $url) {
		return $url;
	}
	$url = preg_replace('|[^a-z0-9-~+_.?#=!;&,/:%@$,\|*\'()\\x80-\\xff]|i', '', $url);
	$strip = array('%0d', '%0a', '%0D', '%0A');
	$url = (string) $url;
	
	$count = 1;
	while ($count) {
		$url = str_replace($strip, '', $url, $count);
	}
	$url = str_replace(';\\', ':\\', $url);
	$url = htmlentities($url);
	
	$url = str_replace('&amp;', '&#038;', $url);
	$url = str_replace("'", '&#039', $url);
	
	if ($url[0] !== '/') {
		//We are only interested in relative link from $_SERVER['PHP_SELF'].
		return '';
	}
	else {
		return $url;
	}
}
function createUser($dbh, $id) {
$prep_stmt ="SELECT idn, fname, lname, s.email, mobile, department, level, username 
		FROM user_data s 
		LEFT JOIN users u ON s.id = u.id
		WHERE s.id = ?";
		
		$stmt = $dbh->prepare($prep_stmt);
		$stmt->execute(array($id));
		$GLOBALS['user'] = $stmt->fetch(PDO::FETCH_OBJ);
		
}

function getPageElement($name) {
	$path = "main/headers; main/footers"; //directories where files specified for inclusion are saved.
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);

	$name = htmlspecialchars($name);
	$name = (string) $name.".php";
	include $name;
}

function checkResult($dbh, $id, $sesion) { 
		$stmt = $dbh->prepare("SELECT * FROM results WHERE userId = :id AND sesion = :sesion");
		$stmt->execute(array(':id' => $id, ':sesion' => $sesion));
		if($stmt->rowCount() > 0) {
			return true;
		} else {
			return false;
		}	
	}
function getResult($db, $id, $semester, $sesion) {
	$prep_stmt = "SELECT course_code, course_title, unit, ca, exam\n"
    . "FROM courses c, results r\n"
    . "WHERE id = courseId AND userId = :id AND semester = :semester AND sesion = :sesion";
	
	$stmt = $db->prepare($prep_stmt);
	$stmt->execute(array(':id' => $id, ':semester' => $semester, ':sesion' => $sesion));
	$result = $stmt->fetchAll();
	
	return $GLOBALS['result'] = $result;
}
function um_num_reg_courses($dbh, $id, $sesion) {
	$prep_stmt_one = "SELECT COUNT(courseId) AS num_courses FROM results WHERE userId = :id AND sesion = :sesion";
	$prep_stmt_two = "SELECT COUNT(courseId) AS num_courses FROM results WHERE userId = :id AND ca IS NOT NULL AND exam IS NOT NULL AND sesion = :sesion";
	
	$stmt_one = $dbh->prepare($prep_stmt_one);
	$stmt_one->execute(array(':id' => $id, ':sesion' => $sesion));
	$row_one = $stmt_one->fetchAll();
	
	$stmt_two = $dbh->prepare($prep_stmt_two);
	$stmt_two->execute(array(':id' => $id, ':sesion' => $sesion));
	$row_two = $stmt_two->fetchAll();
	
	if($row_one[0]['num_courses'] == $row_two[0]['num_courses']) {
		return true;
	} else {
		return false;
	}
}
class um_grade {
	public $user;
	public $sesion;
	public $semster;
	public $dbh;
	
	public function um_grade_a() {
		$prep_stmt = "SELECT course_code
					  FROM courses c
					  JOIN results r ON c.id = r.courseId
					  WHERE (ca + exam) >= 70 AND semester = ? AND userId = ? AND sesion = ?";
					
		$stmt = $this->dbh->prepare($prep_stmt);
		$stmt->bindParam(1, $this->semster);
		$stmt->bindParam(2, $this->user);
		$stmt->bindParam(3, $this->sesion);
		$stmt->execute();
		if($stmt->rowCount() == 0) {
			print 'none';
		} else {
			$row = $stmt->fetchAll();
			for($i = 0; $i < sizeof($row); $i++) {
				$result[$i] = $row[$i]['course_code'];
			}
			$courses = implode(', ', $result);
			print $courses;
		}
	}
	public function um_grade_b_plus() {
		$prep_stmt = "SELECT course_code
					  FROM courses c
					  JOIN results r ON c.id = r.courseId
					  WHERE (ca + exam) >= 65 AND (ca + exam) <= 69 AND semester = ? AND userId = ? AND sesion = ?";
					
		$stmt = $this->dbh->prepare($prep_stmt);
		$stmt->bindParam(1, $this->semster);
		$stmt->bindParam(2, $this->user);
		$stmt->bindParam(3, $this->sesion);
		$stmt->execute();
		if($stmt->rowCount() == 0) {
			print 'none';
		} else {
			$row = $stmt->fetchAll();
			for($i = 0; $i < sizeof($row); $i++) {
				$result[$i] = $row[$i]['course_code'];
			}
			$courses = implode(', ', $result);
			print $courses;
		}
	}
	public function um_grade_b() {
		$prep_stmt = "SELECT course_code
					  FROM courses c
					  JOIN results r ON c.id = r.courseId
					  WHERE (ca + exam) >= 60 AND (ca + exam) <= 64 AND semester = ? AND userId = ? AND sesion = ?";
					
		$stmt = $this->dbh->prepare($prep_stmt);
		$stmt->bindParam(1, $this->semster);
		$stmt->bindParam(2, $this->user);
		$stmt->bindParam(3, $this->sesion);
		$stmt->execute();
		if($stmt->rowCount() == 0) {
			print 'none';
		} else {
			$row = $stmt->fetchAll();
			for($i = 0; $i < sizeof($row); $i++) {
				$result[$i] = $row[$i]['course_code'];
			}
			$courses = implode(', ', $result);
			print $courses;
		}
	}
	public function um_grade_c_plus() {
		$prep_stmt = "SELECT course_code
					  FROM courses c
					  JOIN results r ON c.id = r.courseId
					  WHERE (ca + exam) >= 55 AND (ca + exam) <= 59 AND semester = ? AND userId = ? AND sesion = ?";
					
		$stmt = $this->dbh->prepare($prep_stmt);
		$stmt->bindParam(1, $this->semster);
		$stmt->bindParam(2, $this->user);
		$stmt->bindParam(3, $this->sesion);
		$stmt->execute();
		if($stmt->rowCount() == 0) {
			print 'none';
		} else {
			$row = $stmt->fetchAll();
			for($i = 0; $i < sizeof($row); $i++) {
				$result[$i] = $row[$i]['course_code'];
			}
			$courses = implode(', ', $result);
			print $courses;
		}
	}
	public function um_grade_c() {
		$prep_stmt = "SELECT course_code
					  FROM courses c
					  JOIN results r ON c.id = r.courseId
					  WHERE (ca + exam) >= 50 AND (ca + exam) <= 54 AND semester = ? AND userId = ? AND sesion = ?";
					
		$stmt = $this->dbh->prepare($prep_stmt);
		$stmt->bindParam(1, $this->semster);
		$stmt->bindParam(2, $this->user);
		$stmt->bindParam(3, $this->sesion);
		$stmt->execute();
		if($stmt->rowCount() == 0) {
			print 'none';
		} else {
			$row = $stmt->fetchAll();
			for($i = 0; $i < sizeof($row); $i++) {
				$result[$i] = $row[$i]['course_code'];
			}
			$courses = implode(', ', $result);
			print $courses;
		}
	}
	public function um_grade_d() {
		$prep_stmt = "SELECT course_code
					  FROM courses c
					  JOIN results r ON c.id = r.courseId
					  WHERE (ca + exam) >= 45 AND (ca + exam) <= 49 AND semester = ? AND userId = ? AND sesion = ?";
					
		$stmt = $this->dbh->prepare($prep_stmt);
		$stmt->bindParam(1, $this->semster);
		$stmt->bindParam(2, $this->user);
		$stmt->bindParam(3, $this->sesion);
		$stmt->execute();
		if($stmt->rowCount() == 0) {
			print 'none';
		} else {
			$row = $stmt->fetchAll();
			for($i = 0; $i < sizeof($row); $i++) {
				$result[$i] = $row[$i]['course_code'];
			}
			$courses = implode(', ', $result);
			print $courses;
		}
	}
	public function um_grade_e() {
		$prep_stmt = "SELECT course_code
					  FROM courses c
					  JOIN results r ON c.id = r.courseId
					  WHERE (ca + exam) >= 40 AND (ca + exam) <= 44 AND semester = ? AND userId = ? AND sesion = ?";
					
		$stmt = $this->dbh->prepare($prep_stmt);
		$stmt->bindParam(1, $this->semster);
		$stmt->bindParam(2, $this->user);
		$stmt->bindParam(3, $this->sesion);
		$stmt->execute();
		if($stmt->rowCount() == 0) {
			print 'none';
		} else {
			$row = $stmt->fetchAll();
			for($i = 0; $i < sizeof($row); $i++) {
				$result[$i] = $row[$i]['course_code'];
			}
			$courses = implode(', ', $result);
			print $courses;
		}
	}
	public function um_grade_f() {
		$prep_stmt = "SELECT course_code
					  FROM courses c
					  JOIN results r ON c.id = r.courseId
					  WHERE (ca + exam) <= 39 AND semester = ? AND userId = ? AND sesion = ?";
					
		$stmt = $this->dbh->prepare($prep_stmt);
		$stmt->bindParam(1, $this->semster);
		$stmt->bindParam(2, $this->user);
		$stmt->bindParam(3, $this->sesion);
		$stmt->execute();
		if($stmt->rowCount() == 0) {
			print 'none';
		} else {
			$row = $stmt->fetchAll();
			for($i = 0; $i < sizeof($row); $i++) {
				$result[$i] = $row[$i]['course_code'];
			}
			$courses = implode(', ', $result);
			print $courses;
		}
	}
}
function checkPin($usr, $pin, $dbh) {
	$stmt = $dbh->prepare("SELECT pin FROM users WHERE id = :id");
	$stmt->execute(array(':id' => $usr));
	$usr = $stmt->fetchAll();
	
	if(empty($usr) || ($usr[0]['pin'] !== $pin)) {
		return false;
	} else {
		return true;
	}
}
function courseCheck($dbh, $field) {
	$stmt = $dbh->query("SELECT DISTINCT $field FROM courses");
	$row = $stmt->fetchAll();
	
	foreach($row as $fac) {
		print '<option value='.filter_var($fac[$field], FILTER_SANITIZE_STRING).'>' . $fac[$field] . '</option>';
	}
}
function status($dbh, $id, $sesion) {
	$stmt = $dbh->prepare("SELECT course_code
							FROM courses
							LEFT JOIN failed_courses ON id = courseId
							WHERE studentId = ? AND sesion = ?"
							);
							

	$stmt->bindParam(1, $id);
	$stmt->bindParam(2, $sesion);
	
	$stmt->execute();
	$count = $stmt->rowCount();
	print $count;
}
function is_staff($dbh, $id) {
	$stmt = $dbh->prepare("SELECT email FROM staff WHERE id = ?");
	$stmt->execute(array($id));
	if($stmt->rowCount() == 1) {
		return true;
	} else {
		return false;
	}
}
function get_posts($dbh, $id, $sesion) {
	$sql = "SELECT s.id, fname, lname, department, content, time, title\n"
    . "FROM staff s\n"
    . "LEFT JOIN posts p ON s.id = staffId\n"
    . "WHERE courseId IN (SELECT courseId FROM results WHERE userId = ? AND sesion = ?)"
	. "ORDER BY p.id DESC\n";
	
	$stmt = $dbh->prepare($sql);
	$stmt->execute(array($id, $sesion));
	if($stmt->rowCount() >= 1) {
		$row = $stmt->fetchAll();
		print('<ul data-role=listview data-inset=true>');
		foreach($row as $post) {
			array_multisort($post, SORT_DESC, SORT_NUMERIC);
			print "<li data-icon=false>" .
			"<h2>".$post['title']."</h2>" .
			"<span id=sender><a href=../members/?id=$post[id]>".$post['fname']." ".$post['lname']."</a> | " .
			date("F d, Y | h.i A", $post['time'])."</span>" .
			"<p id=msg>".$post['content']."</p>
			</li>";	
		}
		print('</ul>');
	} else {
		print "<span class=no-new>No new update</span>";
	}
}
function grade($total) {
	$grade = array('F', 'E', 'D', 'C', 'C+', 'B', 'B+', 'A');
	$_grade = '';
	
	if (($total) <= 39) {
	   $_grade = $grade[0];
	}
	elseif (($total >= 40) && ($total <= 44)) {
	   $_grade = $grade[1];
	}
	elseif (($total >= 45) && ($total <= 49)) {
	   $_grade = $grade[2];
	}
	elseif (($total >= 50) && ($total <= 54)) {
	   $_grade = $grade[3];
	}
	elseif (($total >= 55) && ($total <= 59)) {
	   $_grade = $grade[4];
	}
	elseif (($total >= 60) && ($total <= 64)) {
	   $_grade = $grade[5];
	}
	elseif (($total >= 65) && ($total <= 69)) {
	   $_grade = $grade[6];
	}
	elseif (($total >= 70) && ($total <= 100)) {
	   $_grade = $grade[7];
	}
	else {
	   $_grade = "N/A";
	}
	return $_grade;
}
function gp($total) {
	$gp = array(0, 1, 2, 3, 3.5, 4, 4.5, 5);
	$_gp = '';
	
	if (($total) <= 39) {
	   $_gp = $gp[0];
	}
	elseif (($total >= 40) && ($total <= 44)) {
	   $_gp = $gp[1];
	}
	elseif (($total >= 45) && ($total <= 49)) {
	   $_gp = $gp[2];
	}
	elseif (($total >= 50) && ($total <= 54)) {
	   $_gp = $gp[3];
	}
	elseif (($total >= 55) && ($total <= 59)) {
	   $_gp = $gp[4];
	}
	elseif (($total >= 60) && ($total <= 64)) {
	   $_gp = $gp[5];
	}
	elseif (($total >= 65) && ($total <= 69)) {
	   $_gp = $gp[6];
	}
	elseif (($total >= 70) && ($total <= 100)) {
	   $_gp = $gp[7];
	}
	else {
	   $_gp = "N/A";
	}
	return $_gp;
}