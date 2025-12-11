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
<title>INSERIMENTO ARTICOLO</title>
 <link href="css/transizione.css" rel="stylesheet" type="text/css" /> 
</head>


<?php 
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

$query = 'INSERT INTO blog (title_ita, title_eng, description_ita, description_eng, keywords_ita, keywords_eng, url, data, autore, titolo_ita, titolo_eng, descrizione_ita, descrizione_eng, pubblicato, home_page) VALUES
("' . mysql_real_escape_string($title_ita) . '",
"' . mysql_real_escape_string($title_eng) . '",
"' . mysql_real_escape_string($description_ita) . '",
"' . mysql_real_escape_string($description_eng) . '",
"' . mysql_real_escape_string($keywords_ita) . '",
"' . mysql_real_escape_string($keywords_eng) . '",
"' . mysql_real_escape_string($url) . '",
"' . mysql_real_escape_string($data) . '",
"' . mysql_real_escape_string($autore) . '",
"' . mysql_real_escape_string($titolo_ita) . '",
"' . mysql_real_escape_string($titolo_eng) . '",
"' . mysql_real_escape_string($descrizione_ita) . '",
"' . mysql_real_escape_string($descrizione_eng) . '",
"' . mysql_real_escape_string($pubblicato) . '",
"' . mysql_real_escape_string($home_page) .'")';

if (mysql_query($query, $db))
    {
	$last_id = mysql_insert_id();
	//se la cartella non esiste, la creo.. se esiste no... 
    mkdir("../../" . "images/galleria/articoli" . "/" . "$last_id");  
	mkdir("../../" . "images/miniature/articoli" . "/" . "$last_id"); 
	header ('Refresh: 1; URL=' . $redirect);
        echo '<img src="../img/loaders/1d_2.gif"><p>Articolo inserito con successo.</p>';
        echo '<p>Se la pagina non viene visualizzata, <a href="' . $redirect . '">click here</a>.</p>';
        die();
    }
    else
    {
	echo "<p>Inserimento non riuscito</p>";
	echo "<p>" . mysql_error() . "</p>";
    }
?>

<?php mysql_close($db); ?>
<body>
</body>
</html>