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
<title>INSERIMENTO SOTTOCATEGORIA PRODOTTO</title>
</head>


<?php 
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : '../sottocategorie-prodotti.php';
$id_categoria=$_POST['id_categoria'];
$sottocategoria_ita=$_POST['sottocategoria_ita'];
$sottocategoria_eng=$_POST['sottocategoria_eng'];
$query = 'INSERT INTO sottocategorie_prodotti (id_categoria, sottocategoria_ita, sottocategoria_eng) VALUES
("' . $id_categoria . '",
"' . mysql_real_escape_string($sottocategoria_ita) . '",
"' . mysql_real_escape_string($sottocategoria_eng) .'")';

if (mysql_query($query, $db))
    {
	header ('Refresh: 1; URL=' . $redirect);
        echo '<img src="../img/loaders/1d_2.gif"><p>Sottocategoria inserita con successo.</p>';
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