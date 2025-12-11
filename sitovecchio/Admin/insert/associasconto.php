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
<body>
<?php
$id_cliente = $_GET['id_cliente'];

$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : '../dettaglio_cliente.php?id_cliente=' . $id_cliente . '';

if(isset($_POST['sconto_cliente']) AND $_POST['sconto_cliente']!=''){
    
    $sconto_cliente = $_POST['sconto_cliente'];
    $query = 'UPDATE clienti SET
    sconto = ("' . mysql_real_escape_string($sconto_cliente) . '")
    WHERE id_cliente = "' . mysql_real_escape_string($id_cliente) . '"';
    $Risultato = mysql_query($query, $db) or die (mysql_error($db));

} else if(isset($_POST['codice_esterno'])){
    
    $query = 'UPDATE clienti SET
    codice_sconto = ("' . mysql_real_escape_string($_POST['codice_esterno']) . '")
    WHERE id_cliente = "' . mysql_real_escape_string($id_cliente) . '"';
    $Risultato = mysql_query($query, $db) or die (mysql_error($db));

} else if(isset($_POST['attivo']) AND $_POST['attivo']!=''){
    
    $query = 'UPDATE clienti SET
    attivo = ("' . mysql_real_escape_string($_POST['attivo']) . '")
    WHERE id_cliente = "' . mysql_real_escape_string($id_cliente) . '"';
    $Risultato = mysql_query($query, $db) or die (mysql_error($db));

}else if(isset($_POST['punti']) AND $_POST['punti']!='0'){
    
    $query = "UPDATE punti SET
    punti = punti - ".$_POST['punti']."
    WHERE id_cliente = '" . mysql_real_escape_string($id_cliente) . "' ";
    $Risultato = mysql_query($query, $db) or die (mysql_error($db));

}



header('Location:' . $redirect);
exit;	
?>
</body>