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
<title>CANCELLA CATEGORIA PRODOTTO</title>
</head>
<body>
<?php
	if (isset($_GET["id"]))
	{
		$IdSottocategoria = $_GET["id"];	

		$query = "DELETE FROM sottocategorie_prodotti
					WHERE id_sottocategoria = {$IdSottocategoria}";
		$Risultato = mysql_query($query, $db);
		
		if (mysql_affected_rows() == 1)
		{
			//Cancellazione andata a buon fine
			header("Location: ../sottocategorie-prodotti.php");
			exit;
		}
		else
		{
			//Cancellazione non riuscita
			echo "<p>Cancellazione record fallita</p>";
			echo "<p>" . mysql_error() ."</p>";
			echo "<a href='../sottocategorie-prodotti.php'>Ritorna alla pagina iniziale</a>";
		}
	}
mysql_close($db); 
?>
</body>