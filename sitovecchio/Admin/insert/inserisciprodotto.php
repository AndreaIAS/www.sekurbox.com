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
<title>INSERIMENTO PRODOTTO</title>
 <link href="css/transizione.css" rel="stylesheet" type="text/css" /> 
</head>


<?php 
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : '../prodotti.php';
$codice=$_POST['codice'];
$result = mysql_query("SELECT codice FROM prodotti WHERE codice='$codice'");
if(mysql_num_rows($result)>=1)
        {
        header ('Refresh: 3; URL=' . $redirect);
        echo '<img src="../images/rot_small.gif"><p>Codice prodotto già esistente.</p>';
        echo '<p>Se la pagina non viene visualizzata, <a href="' . $redirect . '">click here</a>.</p>';
        }
else
	{
$posizione=$_POST['posizione'];
$giacenza=$_POST['giacenza'];				
$title_ita=$_POST['title_ita'];
$title_eng=$_POST['title_eng'];
$description_ita=$_POST['description_ita'];
$description_eng=$_POST['description_eng'];
$url=$_POST['url'];
$url_eng=$_POST['url_eng'];
$nome_ita=$_POST['nome_ita'];
$nome_eng=$_POST['nome_eng'];
$prezzo=$_POST['prezzo'];
$sconto=$_POST['sconto'];
$descrizione_ita=$_POST['descrizione_ita'];
$descrizione_eng=$_POST['descrizione_eng'];
$descrizione_capitolato_ita=$_POST['descrizione_capitolato_ita'];
$descrizione_capitolato_eng=$_POST['descrizione_capitolato_eng'];
$visible=$_POST['visible'];
$primo_piano=$_POST['primo_piano'];
$puglia=$_POST['puglia'];

$query = 'INSERT INTO prodotti (codice, posizione, giacenza, title_ita, title_eng, description_ita, description_eng, url, url_eng, nome_ita, nome_eng, descrizione_ita, descrizione_eng, descrizione_capitolato_ita, descrizione_capitolato_eng, visible, primo_piano, puglia,prezzo,sconto) VALUES
("' . mysql_real_escape_string($codice) . '",
"' . mysql_real_escape_string($posizione) . '",
"' . mysql_real_escape_string($giacenza) . '",
"' . mysql_real_escape_string($title_ita) . '",
"' . mysql_real_escape_string($title_eng) . '",
"' . mysql_real_escape_string($description_ita) . '",
"' . mysql_real_escape_string($description_eng) . '",
"' . mysql_real_escape_string($url) . '",
"' . mysql_real_escape_string($url_eng) . '",
"' . mysql_real_escape_string($nome_ita) . '",
"' . mysql_real_escape_string($nome_eng) . '",
"' . mysql_real_escape_string($descrizione_ita) . '",
"' . mysql_real_escape_string($descrizione_eng) . '",
"' . mysql_real_escape_string($descrizione_capitolato_ita) . '",
"' . mysql_real_escape_string($descrizione_capitolato_eng) . '",
"' . mysql_real_escape_string($visible) . '",
"' . mysql_real_escape_string($primo_piano) . '",
"' . mysql_real_escape_string($puglia) .'",
"' . mysql_real_escape_string($prezzo) . '",
"' . mysql_real_escape_string($sconto) .'")';


mysql_query($query, $db);
$last_id = mysql_insert_id();
//se la cartella non esiste, la creo.. se esiste no... 
mkdir("../../" . "images/galleria/prodotti" . "/" . "$last_id");  
mkdir("../../" . "images/miniature/prodotti" . "/" . "$last_id");
mkdir("../../" . "images/galleria/prodotti/applicazioni" . "/" . "$last_id");

header('Location: http://www.sekurbox.com/Admin/update/modifica_prodotto.php?id_prodotto=' . $last_id . '#salva_info');
}
?>
<?php mysql_close($db); ?>
<body>
</body>
</html>