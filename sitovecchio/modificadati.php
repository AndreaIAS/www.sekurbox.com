<?php
require 'include/auth.inc.php';
include 'include/connessione.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
$lingua=$_GET['lingua'];
$id_cliente = $_GET['id_cliente'];
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : "http://www.sekurbox.com/" . $lingua . "/area-riservata.html";
$password = $_POST['password'];
$email = $_POST['email'];
$nome=$_POST['nome'];
$cognome=$_POST['cognome'];
$data_di_nascita='1981-12-12';
$codice_fiscale=$_POST['codice_fiscale'];
$ragione_sociale=$_POST['ragione_sociale'];
$partita_iva = $_POST['partita_iva'];
$indirizzo=$_POST['indirizzo'];
$citta=$_POST['citta'];
$id_provincia=$_POST['id_provincia'];
$id_nazione = $_POST['id_nazione'];
$cap=$_POST['cap'];
$telefono_fisso = $_POST['telefono_fisso'];
$telefono_cellulare = $_POST['telefono_cellulare'];
$codice_sconto=$_POST['codice_esterno'];
 
$query = "UPDATE clienti SET
         password = '" . mysql_real_escape_string($password) ."',
         codice_sconto = '" . mysql_real_escape_string($codice_sconto) ."',    
         email = '" . mysql_real_escape_string($email) ."',
         nome = '" . mysql_real_escape_string($nome) ."',
         cognome = '" . mysql_real_escape_string($cognome) ."',
         data_di_nascita = '" . mysql_real_escape_string($data_di_nascita) ."',  
         codice_fiscale = '" . mysql_real_escape_string($codice_fiscale) ."',
         ragione_sociale = '" . mysql_real_escape_string($ragione_sociale) ."',
         partita_iva = '" . mysql_real_escape_string($piva) ."',
         indirizzo = '" . mysql_real_escape_string($indirizzo) ."',
         citta = '" . mysql_real_escape_string($citta) ."',
         id_provincia = '" . mysql_real_escape_string($id_provincia) ."',
         id_nazione = '" . mysql_real_escape_string($id_nazione) ."',
         cap = '" . mysql_real_escape_string($cap) ."',
         telefono_fisso = '" . mysql_real_escape_string($telefono_fisso) ."',
         telefono_cellulare = '" . mysql_real_escape_string($telefono_cellulare) ."'
         WHERE id_cliente  = '" . $id_cliente . "' ";
if (mysql_query($query, $db))
    {
	header ('Refresh: 0; URL=' . $redirect);
    }
    else
    {
	echo "<p>La modifica non è riuscita</p>"; echo mysql_error();
	//header ('Refresh: 2; URL=' . $redirect);
    }
?>

</body>