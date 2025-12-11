<?php
require 'include/db.inc.php';
$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$id_sottocategoria = $_POST['variabile'];
$id_prodotto=$_POST['prodotto'];
$stato=$_POST['stato'];
?>
<?php
if ($stato=="true")
{ 
$query = 'INSERT INTO  sezioni_sottocategorie_prodotti (id_sottocategoria, id_prodotto) VALUES
("' . $id_sottocategoria . '",
"' . $id_prodotto .'")';
$Risultato = mysql_query($query, $db);
}
else
{
$query = "DELETE FROM sezioni_sottocategorie_prodotti
					WHERE id_sottocategoria = '" . mysql_real_escape_string($id_sottocategoria) . "' AND id_prodotto = '" . mysql_real_escape_string($id_prodotto) . "'";
$Risultato = mysql_query($query, $db);
}
echo json_encode($stato); 
?>

<?php mysql_close($db); ?>