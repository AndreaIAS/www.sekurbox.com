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
<title>MODIFICA SOTTOCATEGORIA PRODOTTO</title>
</head>
<body>
<?php

$IdSottoategoria = $_GET["id_sottocategoria"];	
$id_categoria = $_POST['id_categoria'];		
$sottocategoria_ita = $_POST['sottocategoria_ita'];
$sottocategoria_eng=$_POST['sottocategoria_eng'];
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : '../sottocategorie-prodotti.php';
$query = "UPDATE sottocategorie_prodotti SET
				id_categoria = '$id_categoria',
				sottocategoria_ita = '" . mysql_real_escape_string($sottocategoria_ita) ."',
				sottocategoria_eng = '" . mysql_real_escape_string($sottocategoria_eng) ."'											
		 WHERE id_sottocategoria  = {$IdSottoategoria}";
if (mysql_query($query, $db))
    {
	header ('Refresh: 1; URL=' . $redirect);
        echo '<img src="../img/loaders/1d_2.gif"><p>Sottocategoria prodotto modificata con successo.</p>';
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