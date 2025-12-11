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
<title>MODIFICA PRODOTTO</title>
</head>
<body>
<?php

$IdProdotto = $_GET["id_prodotto"];			
$codice=$_POST['codice'];
$posizione=$_POST['posizione'];
$giacenza=$_POST['giacenza'];								
$title_ita=$_POST['title_ita'];
$title_eng=$_POST['title_eng'];
$description_ita=$_POST['description_ita'];
$description_eng=$_POST['description_eng'];
$url=$_POST['url'];
$url_eng=$_POST['url_eng'];
$nome_ita=$_POST['nome_ita'];
$nome_eng=$_POST['nome_eng'];
$descrizione_ita=$_POST['descrizione_ita'];
$descrizione_eng=$_POST['descrizione_eng'];
$descrizione_capitolato_ita=$_POST['descrizione_capitolato_ita'];
$descrizione_capitolato_eng=$_POST['descrizione_capitolato_eng'];
$visible=$_POST['visible'];
$primo_piano=$_POST['primo_piano'];
$puglia=$_POST['puglia'];
$prezzo=$_POST['prezzo'];
$sconto=$_POST['sconto'];
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : '../prodotti.php';
$query = "UPDATE prodotti SET
            codice = '$codice',
            posizione = '" . mysql_real_escape_string($posizione) ."',
            giacenza = '" . mysql_real_escape_string($giacenza) ."',
            title_ita = '" . mysql_real_escape_string($title_ita) ."',
            title_eng = '" . mysql_real_escape_string($title_eng) ."',
            description_ita = '" . mysql_real_escape_string($description_ita) ."',
            description_eng = '" . mysql_real_escape_string($description_eng) ."',
            url = '" . mysql_real_escape_string($url) ."',
            url_eng = '" . mysql_real_escape_string($url_eng) ."',
            nome_ita = '" . mysql_real_escape_string($nome_ita) ."',
            nome_eng = '" . mysql_real_escape_string($nome_eng) ."',
            descrizione_ita = '" . mysql_real_escape_string($descrizione_ita) ."',
            descrizione_eng = '" . mysql_real_escape_string($descrizione_eng) ."',
            descrizione_capitolato_ita = '" . mysql_real_escape_string($descrizione_capitolato_ita) ."',
            descrizione_capitolato_eng = '" . mysql_real_escape_string($descrizione_capitolato_eng) ."',
            visible = '" . mysql_real_escape_string($visible) ."',
            primo_piano = '" . mysql_real_escape_string($primo_piano) ."',
            puglia = '" . mysql_real_escape_string($puglia) ."',
            prezzo = '" . mysql_real_escape_string($prezzo) ."',
            sconto = '" . mysql_real_escape_string($sconto) ."'    
            WHERE id_prodotto  = '" . mysql_real_escape_string($IdProdotto) ."'";
mysql_query($query, $db);

header("Location: http://www.sekurbox.com/Admin/update/modifica_prodotto.php?id_prodotto=" . $IdProdotto);

?>
</body>