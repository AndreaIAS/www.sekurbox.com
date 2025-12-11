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


<?php 
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : '../listini.php';
$listino=$_POST['listino'];
$sconto_listino=$_POST['sconto_listino'];

$query = 'INSERT INTO listini (listino, sconto_listino) VALUES
("' . mysql_real_escape_string($listino) . '",
 "' . mysql_real_escape_string($sconto_listino) . '")';

$Risultato = mysql_query($query, $db) or die (mysql_error($db));
$id_listino = mysql_insert_id();

//INSERT INTO tabella2(field2) SELECT field1 FROM (SELECT field1, COUNT(field1) AS AggrName FROM table1 GROUP BY field1 HAVING AggrName> 10 ORDER BY field1) AS temp_tabella

$query = 'INSERT INTO listini_dettaglio (id_listino, id_prodotto, prezzo_prodotto) VALUES
("' . mysql_real_escape_string($id_listino) . '",
"SELECT id_prodotto FROM prodotti", 
"00.00")';

if (mysql_query($query, $db))
    {
	header ('Refresh: 1; URL=' . $redirect);
        echo '<img src="../img/loaders/1d_2.gif"><p>Listino creato con successo.</p>';
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