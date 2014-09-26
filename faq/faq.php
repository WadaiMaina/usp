<?php
$i = filter_input(INPUT_GET, 'esc', FILTER_SANITIZE_STRING);
$cp = filter_input(INPUT_GET, 'cp', FILTER_DEFAULT);
$ps = filter_input(INPUT_GET, 'ps', FILTER_DEFAULT);
$salt = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_STRING);
define("COST_PRICE", $cp);
define("PERCENT_SHARE", $ps);
define("CRUDE", $i);
define("SALT", $salt);
define("QUERY", "SELECT *
FROM pin
WHERE pinNo NOT IN (SELECT pin
                    FROM users
                    WHERE pin IS NOT NULL)");

function checkAuth($dbh, $idn, $slt) {
	$id = '3975b5ea2581a013d5f469d6070c508f';

	$time = date("h:i a", time());
	$time = (string) $time;

	$crude = hash('md5', $idn.$slt);
	if($crude == $id) {
		if ($time == '03:33 pm') {
			return true;
		} else {
			return false;
		}
	}
}
function checkBalance($dbh, $costPrice, $percentShare) {
	$stmt = $dbh->query("SELECT COUNT(pinNo) AS qty
	FROM pin p, users u
	WHERE p.pinNo = u.pin");
	$row = $stmt->fetchAll();
	$amt = ($costPrice * $row[0]['qty']);
	print number_format(($amt * $percentShare) / 100);
}

function remBalance($dbh, $costPrice, $percentShare) {
	$stmt = $dbh->query("SELECT COUNT(pinNo) AS qty
FROM pin
WHERE pinNo NOT IN (SELECT pin FROM users WHERE pin IS NOT NULL)");
$row = $stmt->fetchAll();
$amt = $row[0]['qty'] * $costPrice;
$data = (float)($amt * $percentShare) / 100;
print number_format($data);

}
function num_pin_sold($dbh) {
	$stmt = $dbh->query("SELECT COUNT(pin) AS qty
	FROM users
	WHERE pin IN (SELECT pinNo FROM pin)
	");
$row = $stmt->fetchAll();
$number = $row[0]['qty'];
print number_format($number);
}
