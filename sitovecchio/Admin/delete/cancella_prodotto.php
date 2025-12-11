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
<title>CANCELLA PRODOTTO</title>
</head>
<body>
<?php
	if (isset($_GET["id"]))
	{
		$IdProdotto = $_GET["id"];	

		$query = "DELETE FROM prodotti
					WHERE id_prodotto = '" . $IdProdotto . "'";
		$Risultato = mysql_query($query, $db);
		
		if (mysql_query($query, $db))
    {
			$query3 = "DELETE FROM  listini_dettaglio
					WHERE id_prodotto = '" . $IdProdotto . "'";	
			$Risultato3 = mysql_query($query3, $db);	
			
			$query2 = "DELETE FROM  prodotti_correlati
					WHERE id_prodotto = '" . $IdProdotto . "'";	
			$Risultato2 = mysql_query($query2, $db);		
			//Cancellazione andata a buon fine
			header("Location: ../prodotti.php");
			exit;
		
		}
		else
		{
			//Cancellazione non riuscita
			echo "<p>Cancellazione record fallita</p>";
			echo "<p>" . mysql_error() ."</p>";
			echo "<a href='../prodotti.php'>Ritorna alla pagina iniziale</a>";
		}
	}
mysql_close($db); 
?>
</body>