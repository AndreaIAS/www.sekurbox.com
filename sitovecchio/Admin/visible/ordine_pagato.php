<?php 
session_start();
include '../include/auth.inc.php';
require '../include/db.inc.php';
$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

?>
<?php
	if (isset($_GET["id_ordine"]))
	{
		$id_ordine = $_GET["id_ordine"];		

		$query = "UPDATE ordini SET pagato = 1
					WHERE id_ordine = '" . $id_ordine . "'";
		$Risultato = mysql_query($query, $db);
                
                
        $query_tr = " SELECT * FROM ordini WHERE id_ordine = '".$id_ordine."' ";
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
            $variabile_punti_codice_da_installatore=0.5;

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
                
                
                
	         	
		if (mysql_affected_rows() == 1)
		{                
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit(0);
		}
		else
		{
			echo "<p>Pubblicazione del record fallita</p>";
			echo "<p>" . mysql_error() ."</p>";
			echo "<a href='../ordini.php'>Ritorna alla pagina iniziale</a>";
		}
	}
?>

<?php mysql_close($db); ?>