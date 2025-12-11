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
<title>MODIFICA ARTICOLO</title>
</head>
<body>
<?php

$id_articolo = $_GET["id_articolo"];					
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : '../articoli.php';
$title_ita=$_POST['title_ita'];
$title_eng=$_POST['title_eng'];
$description_ita=$_POST['description_ita'];
$description_eng=$_POST['description_eng'];
$keywords_ita=$_POST['keywords_ita'];
$keywords_eng=$_POST['keywords_eng'];
$url=$_POST['url'];
$data = $_POST['data'];
$autore=$_POST['autore'];
$titolo_ita=$_POST['titolo_ita'];
$titolo_eng=$_POST['titolo_eng'];
$descrizione_ita=$_POST['descrizione_ita'];
$descrizione_eng=$_POST['descrizione_eng'];
$pubblicato = $_POST['pubblicato'];
$home_page = $_POST['home_page'];

$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : '../articoli.php';
$query = "UPDATE blog SET
				title_ita = '" . mysql_real_escape_string($title_ita) ."',
				title_eng = '" . mysql_real_escape_string($title_eng) ."',
				description_ita = '" . mysql_real_escape_string($description_ita) ."',
				description_eng = '" . mysql_real_escape_string($description_eng) ."',
				keywords_ita = '" . mysql_real_escape_string($keywords_ita) ."',
				keywords_eng = '" . mysql_real_escape_string($keywords_eng) ."',
				url = '" . mysql_real_escape_string($url) ."',
				data = '" . mysql_real_escape_string($data) ."',
				autore = '" . mysql_real_escape_string($autore) ."',
				titolo_ita = '" . mysql_real_escape_string($titolo_ita) ."',
				titolo_eng = '" . mysql_real_escape_string($titolo_eng) ."',
				descrizione_ita = '" . mysql_real_escape_string($descrizione_ita) ."',
				descrizione_eng = '" . mysql_real_escape_string($descrizione_eng) ."',
				pubblicato = '" . mysql_real_escape_string($pubblicato) ."',
				home_page = '" . mysql_real_escape_string($home_page) ."'
		 		WHERE id_articolo  = '" . mysql_real_escape_string($id_articolo) ."'";
if (mysql_query($query, $db))
    {
	header ('Refresh: 1; URL=' . $redirect);
        echo '<img src="../img/loaders/1d_2.gif"><p>News modificata con successo.</p>';
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