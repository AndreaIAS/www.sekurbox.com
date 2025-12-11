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
<title>INSERIMENTO PRODOTTO IMPIEGATO</title>
</head>


<?php 
$id_articolo=$_GET['id_articolo'];
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : '../prodotti-correlati-articoli.php?id_articolo=' . $id_articolo;
$id_prodotto_correlato=$_POST['id_prodotto_correlato'];

$query = 'INSERT INTO prodotti_articoli_correlati (id_articolo, id_prodotto_correlato) VALUES
("' . $id_articolo . '",
"' . $id_prodotto_correlato .'")';

if (mysql_query($query, $db))
    {
		//Cancellazione andata a buon fine
		header("Location: ../prodotti-correlati-articoli.php?id_articolo=" . $id_articolo);
		exit;
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