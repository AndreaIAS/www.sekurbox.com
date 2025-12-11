<?php
require '../include/db.inc.php';
$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

session_start();
include '../include/auth.inc.php';
	if (isset($_SESSION['logged']) && $_SESSION['logged'] ==1) {
	}
	else {
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
$id_prodotto = $_GET['id_prodotto'];
$giacenza = $_POST['giacenza'];
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : '../prodotti.php';
$query = "UPDATE prodotti SET
				giacenza = '$giacenza'										
		 WHERE id_prodotto  = {$id_prodotto}";
			mysql_query($query, $db);
			header('Location: http://www.rosaorlando.com/Admin/prodotti.php');
			exit;	
?>
</body>