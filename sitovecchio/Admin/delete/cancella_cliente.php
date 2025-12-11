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
<title>CANCELLA CLIENTE</title>
</head>
<body>
<?php
	if (isset($_GET["id"]))
	{
		$id_cliente= $_GET["id"];
		$page= $_GET["page"];	
		//CARTELLA CLIENTI
		$query_clienti = "DELETE FROM clienti
					WHERE id_cliente = '" . mysql_real_escape_string($id_cliente) . "'";
		$Risultato_clienti = mysql_query($query_clienti, $db);
		//CARTELLA LISTINI CLIENTI
		$query_listini_clienti = "DELETE FROM listini_clienti
					WHERE id_cliente = '" . mysql_real_escape_string($id_cliente) . "'";
		$Risultato_listini_clienti = mysql_query($query_listini_clienti, $db);
		//CARTELLA SCONTO CLIENTI
		$query_sconto_cliente = "DELETE FROM sconto_cliente
					WHERE id_cliente = '" . mysql_real_escape_string($id_cliente) . "'";
		$Risultato_sconto_cliente = mysql_query($query_sconto_cliente, $db);
		//CARTELLA PUNTI CLIENTI
		$query_punti_cliente = "DELETE FROM punti
					WHERE id_cliente = '" . mysql_real_escape_string($id_cliente) . "'";
		$Risultato_punti_cliente = mysql_query($query_punti_cliente, $db);				
		
		header("Location: ../clienti.php");
	}
mysql_close($db); 
?>
</body>