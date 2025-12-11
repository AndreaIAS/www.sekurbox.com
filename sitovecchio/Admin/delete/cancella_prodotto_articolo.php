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
	if (isset($_GET["id"]))
	{
		$id= $_GET["id"];
		$Risultato1=mysql_query("SELECT * FROM prodotti_articoli_correlati WHERE id = {$id}", $db);
		if (!$Risultato1)
		{
		die ("La tabella selezionata non esiste" . mysql_error());
		}
		while ($riga1=mysql_fetch_array($Risultato1))
			{
				$id_articolo = $riga1['id_articolo'];
			}
		$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : 'Location: ../prodotti-correlati-articoli.php?id_articolo=' . $id_articolo;
		$query = "DELETE FROM prodotti_articoli_correlati
					  WHERE id = {$id}";
		$Risultato = mysql_query($query, $db);			
		if (mysql_affected_rows() == 1)
		{
			header($redirect);
			exit;
		}
		else
		{
			echo "<p>Cancellazione record fallita</p>";
			echo "<p>" . mysql_error() ."</p>";
			echo "<a href='" . $redirect . "'>Ritorna alla pagina iniziale</a>";
		}
	}
mysql_close($db); 
?>
</body>