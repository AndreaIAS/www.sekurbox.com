<html>
    
<?php

include 'include/connessione.php';
include "include/lingua.php";

//Leggo l'ID della transazione che mi ritorna gestpay nella variabile (b) che contiene il mio NUM_ORD

require_once "GestPayCrypt.inc.php";   

if (empty($_GET["a"])) {
    die("Parametro mancante: 'a'\n");
}

if (empty($_GET["b"])) {
    die("Parametro mancante: 'b'\n");
}

$crypt = new GestPayCrypt();

$crypt->SetShopLogin($_GET["a"]);
$crypt->SetEncryptedString($_GET["b"]);

if (!$crypt->Decrypt()) {
    die("Error: ".$crypt->GetErrorCode().": ".$crypt->GetErrorDescription()."\n");
}
      
switch ($crypt->GetTransactionResult()) {
    
        case "XX":

            break;

        case "KO":

            break;

        case "OK":
        

        $query = " UPDATE ordini SET pagato = 1
	           WHERE id_ordine = '" . trim($crypt->GetShopTransactionID()) . "' ";
        $Risultato = mysql_query($query, $db);
        
        
        $query_tr = " SELECT * FROM ordini WHERE id_ordine = '".trim($crypt->GetShopTransactionID())."' ";
        $result_tr = mysql_query($query_tr);
        $list_tr = mysql_fetch_array($result_tr);
        
        $subtotale_ordine=$list_tr['subtotale'];
        
        $queryc="SELECT *
                 FROM clienti
                 WHERE id_cliente='".$list_tr['id_cliente']."' ";
        $resultc=mysql_query($queryc) or die(mysql_error());
        $listc=  mysql_fetch_assoc($resultc);


        $id_cliente=$listc['id_cliente'];

        //PARTE DI GESTIONE DEI PUNTI
        $puntitotali=0;
        $punti_a_rivenditore=0;
        $puntiarivinst=0;


        if($listc['id_tipologia_cliente']==3){

            $variabile_punti_rivenditore=0.5;   
            $puntitotali=$subtotale_ordine/$variabile_punti_rivenditore;

        }else if($listc['id_tipologia_cliente']==2){

            $variabile_punti_installatore=0.5;   
            $puntitotali=$subtotale_ordine/$variabile_punti_installatore;

            if($list_tr['sconto_listino']>0){

            $variabile_punti_codice_da_rivenditore=0.5;
            $punti_a_rivenditore=$subtotale_ordine/$variabile_punti_codice_da_rivenditore;

            $queryriv = "SELECT id_cliente 
                         FROM clienti WHERE attivo='si' 
                         AND codice_per_installatore='".$listc['codice_sconto']."' ";
            $resultriv=mysql_query($queryriv) or die(mysql_error());
            $listriv=mysql_fetch_assoc($resultriv);

            $query = "UPDATE punti
                      SET
                      punti = punti + ".$punti_a_rivenditore."
                      WHERE
                      id_cliente = '". $listriv['id_cliente']."' ";
            mysql_query($query, $db) or (mysql_error($db));

            }


        }else if($listc['id_tipologia_cliente']==1){

            $variabile_punti_privato=0.5;   
            $puntitotali=$subtotale_ordine/$variabile_punti_privato;

            if($list_tr['sconto_listino']>0){

            $variabile_punti_codice_da_rivenditore=0.5;
            $variabile_punti_codice_da_installatore=0.3;

            $queryriv = "SELECT id_cliente,id_tipologia_cliente 
                         FROM clienti WHERE attivo='si' 
                         AND codice_per_privato='".$listc['codice_sconto']."' ";
            $resultriv=mysql_query($queryriv) or die(mysql_error());
            $listriv=mysql_fetch_assoc($resultriv);

            if($listriv['id_tipologia_cliente']==2){ $puntiarivinst=$subtotale_ordine/$variabile_punti_codice_da_installatore;   }
            else if($listriv['id_tipologia_cliente']==3){ $puntiarivinst=$subtotale_ordine/$variabile_punti_codice_da_rivenditore;   }

            $query = "UPDATE punti
                      SET
                      punti = punti + ".$puntiarivinst."
                      WHERE
                      id_cliente = '". $listriv['id_cliente']."' ";
            mysql_query($query, $db) or (mysql_error($db));

            }

        }

        // AGGIORNAMENTO DELLA TABELLA PUNTI
        $query = "UPDATE punti
                  SET
                  punti = punti + ".$puntitotali."
                  WHERE
                  id_cliente = '". $id_cliente."' ";

        mysql_query($query, $db) or (mysql_error($db));
             
        
        break;
        
    default:       
        
}


?>
</html>