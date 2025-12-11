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
<title>CANCELLA ORDINE</title>
</head>
<body>
<?php
	if (isset($_GET["id"]))
	{
		$id_ordine = $_GET["id"];	

		$query = "DELETE ordini.*, dettaglio_ordine.*
					   FROM ordini
					   INNER JOIN dettaglio_ordine
					   ON ordini.id_ordine = dettaglio_ordine.id_ordine
						WHERE dettaglio_ordine.id_ordine = '" . mysql_real_escape_string($id_ordine) . "'";
		if (mysql_query($query, $db))
		{
			//Cancellazione andata a buon fine
			header("Location: ../ordini.php");
			exit;
		}
		else
		{
			//Cancellazione non riuscita
			echo "<p>Cancellazione record fallita</p>";
			echo "<p>" . mysql_error() ."</p>";
			echo "<a href='../ordini.php'>Ritorna alla pagina iniziale</a>";
		}
	}
mysql_close($db); 
?>
</body>