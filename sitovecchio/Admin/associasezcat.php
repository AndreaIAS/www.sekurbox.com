<?php
require 'include/db.inc.php';
$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$id_categoria = $_POST['variabile'];
$id_prodotto=$_POST['prodotto'];
$stato=$_POST['stato'];
?>
<?php
if ($stato=="true")
{ 
$query = 'INSERT INTO  sezioni_categorie_prodotti (id_categoria, id_prodotto) VALUES
("' . $id_categoria . '",
"' . $id_prodotto .'")';
$Risultato = mysql_query($query, $db);
}
else
{
$query = "DELETE FROM sezioni_categorie_prodotti
					WHERE id_categoria = '" . mysql_real_escape_string($id_categoria) . "' AND id_prodotto = '" . mysql_real_escape_string($id_prodotto) . "'";
$Risultato = mysql_query($query, $db);
}
echo json_encode($stato); 
?>

<?php mysql_close($db); ?>