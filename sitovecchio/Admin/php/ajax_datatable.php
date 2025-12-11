<?php
require '../include/db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
$Risultato=mysql_query("SELECT  clienti.*, 
                                                                 tipologia_cliente.id_tipologia_cliente, tipologia_cliente.tipologia_cliente_it,
                                                                 nazioni.ID, nazioni.Nazione,
                                                                 regioni.id, regioni.cod_regione, regioni.regione,
                                                                 province.id, province.provincia
								 FROM  clienti
								 INNER JOIN tipologia_cliente ON clienti.id_tipologia_cliente = tipologia_cliente.id_tipologia_cliente
								 INNER JOIN nazioni ON clienti.id_nazione = nazioni.ID	
								 LEFT JOIN regioni ON clienti.id_regione = regioni.id
								 LEFT JOIN province ON clienti.id_provincia = province.id
								 ORDER BY clienti.nome", $db);		   


while ($riga=mysql_fetch_array($Risultato))
{
if ($riga['attivo']=='si') { $registrato="SI";} else {$registrato="NO";}	
$array[] = array(
	    $riga['tipologia_cliente_it'],
            $riga['cognome'] . " " . $riga['nome'],
            $riga['ragione_sociale'],
	    $riga['email'],
	    $riga['codice_sconto'],
	    $riga['codice_per_installatore'],
	    $riga['codice_per_privato'],
	    $registrato,
            $riga['sconto'],
            "<a href='dettaglio_cliente.php?id_cliente=" . $riga['id_cliente']. "'><span class='icon-zoom-in'></span></a>",
            "<a href=\"#bModal\" role=\"button\" class=\"btn deletemodal\" id=" . $riga['id_cliente'] . " data-toggle=\"modal\"><span class=\"icon-trash\"></span></a>"
        );
}
$response = array("aaData" => $array);

        echo json_encode($response);
?>