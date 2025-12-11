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
<title>MODIFICA LISTINO PREZZI</title>
</head>
<body>
<?php

$id_listino = $_GET["id_listino"];	
$listino=$_POST['listino'];
$sconto_listino=$_POST['sconto_listino'];
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : '../listini.php';
$query = "UPDATE listini SET
				listino = '" . mysql_real_escape_string($listino) ."',
				sconto_listino = '" . mysql_real_escape_string($sconto_listino) ."'		 
				WHERE id_listino  = '" . mysql_real_escape_string($id_listino) ."'";
if (mysql_query($query, $db))
    {
	header ('Refresh: 1; URL=' . $redirect);
        echo '<img src="../img/loaders/1d_2.gif"><p>Categoria modificata con successo.</p>';
        echo '<p>Se la pagina non viene visualizzata, <a href="' . $redirect . '">click here</a>.</p>';
        die();
    }
    else
    {
	echo "<p>La modifica non è riuscita</p>";
	echo "<p>" . mysql_error() . "</p>";
    }
?>
</body>