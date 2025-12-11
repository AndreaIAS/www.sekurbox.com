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
<title>MODIFICA PAGINA</title>
</head>
<body>
<?php

$id_contenuto_statico = $_GET["id_contenuto_statico"];					
$title_ita=$_POST['title_ita'];
$description_ita=$_POST['description_ita'];
$keywords_ita=$_POST['keywords_ita'];
$titolo_ita=$_POST['titolo_ita'];
$contenuto_statico_ita=$_POST['contenuto_statico_ita'];

$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : '../contenuti-statici.php';
$query = "UPDATE contenuti_statici SET
				title_ita = '" . mysql_real_escape_string($title_ita) ."',
				description_ita = '" . mysql_real_escape_string($description_ita) ."',
				keywords_ita = '" . mysql_real_escape_string($keywords_ita) ."',
				titolo_ita = '" . mysql_real_escape_string($titolo_ita) ."',
				contenuto_statico_ita = '" . mysql_real_escape_string($contenuto_statico_ita) ."'
		 WHERE id_contenuto_statico  = {$id_contenuto_statico}";
if (mysql_query($query, $db))
    {
	header ('Refresh: 1; URL=' . $redirect);
        echo '<img src="../img/loaders/1d_2.gif"><p>Pagina modificata con successo.</p>';
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