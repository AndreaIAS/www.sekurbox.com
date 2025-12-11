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


<?php 
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : '../tessuti.php';
$codice_tessuto=$_POST['codice_tessuto'];
$descrizione_tessuto_ita=$_POST['descrizione_tessuto_ita'];
$descrizione_tessuto_eng=$_POST['descrizione_tessuto_eng'];

$query = 'INSERT INTO  tessuti (codice_tessuto, descrizione_tessuto_ita, descrizione_tessuto_eng) VALUES
("' . mysql_real_escape_string($codice_tessuto) . '",
"' . mysql_real_escape_string($descrizione_tessuto_ita) . '",
"' . mysql_real_escape_string($descrizione_tessuto_eng) . '")';

if (mysql_query($query, $db))
    {
        echo '<img src="../img/loaders/1d_2.gif"><p>Tessuto inserito con successo.</p>';
        echo '<p>Se la pagina non viene visualizzata, <a href="' . $redirect . '">click here</a>.</p>';
		header ('Refresh: 1; URL=' . $redirect);
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