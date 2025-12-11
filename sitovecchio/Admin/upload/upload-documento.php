<?php
if ($_FILES['upload_name']['name'] == "" and $_FILES['upload_name']['size'] == 0) exit;
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : '../documenti.php';


include ("../include/db.inc.php");
$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

//contiene il nome originale del file caricato
$fileName = $_FILES['upload_name']['name'];
// contiene il nome assegnato al file nella cartella temporanea
$tmpName = $_FILES['upload_name']['tmp_name'];
//contiene la dimensione in bytes del file caricato
$fileSize = $_FILES['upload_name']['size'];
//contiene il mime del file (ad esempio image/png)
$fileType = $_FILES['upload_name']['type'];
// contiene informazioni su eventuali errori del processo
$fileError = $_FILES['upload_name']['error'];

$query = "INSERT INTO documenti_generali (documento_generale_bin, documento_generale_nome, documento_generale_size, documento_generale_type, url) ";
$query .= "VALUES ('".$tmpName."', '".$fileName."', '".$fileSize."', '".$fileType."', '" . $fileName . "')";

if (mysql_query($query, $db))
    {
		move_uploaded_file($_FILES['upload_name']['tmp_name'],'../../pdf/documentivari/' . $_FILES['upload_name']['name']);
		header ('Refresh: 1; URL=' . $redirect);
        echo '<img src="../img/loaders/1d_2.gif"><p>Documento inserito con successo.</p>';
        echo '<p>Se la pagina non viene visualizzata, <a href="' . $redirect . '">click here</a>.</p>';
        die();
    }
    else
    {
	echo "<p>Inserimento non riuscito</p>";
	echo "<p>" . mysql_error() . "</p>";
    }
?>