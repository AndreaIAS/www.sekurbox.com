<?php
	include 'include/connessione.php';
	$session = $_GET['session'];
	$redirect= $_GET['redirect'];
	$id_prodotto = $_GET['id_prodotto'];
    $query = 'DELETE FROM carrelli_temporanei
        WHERE
            session = "' . $session . '" AND id_prodotto = "' . $id_prodotto . '"';
    mysql_query($query, $db) or die(mysql_error($db));
    header('Location: '.$redirect);
?>