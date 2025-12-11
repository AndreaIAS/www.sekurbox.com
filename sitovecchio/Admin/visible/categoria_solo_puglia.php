<?php 
session_start();
include '../include/auth.inc.php';
require '../include/db.inc.php';
$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

?>
<?php
	if (isset($_GET["id_categoria"]))
	{
		
		$id_categoria = $_GET["id_categoria"];		
		$query = "UPDATE categorie_prodotti SET puglia = 1
					WHERE id_categoria = '" . mysql_real_escape_string($id_categoria) . "'";
		$Risultato = mysql_query($query, $db);
		
		if (mysql_affected_rows() == 1)
		{
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit(0);
		}
		else
		{
			echo "<p>Pubblicazione del record fallita</p>";
			echo "<p>" . mysql_error() ."</p>";
			echo "<a href='../categorie-prodotti.php'>Ritorna alla pagina iniziale</a>";
		}
	}
?>

<?php mysql_close($db); ?>