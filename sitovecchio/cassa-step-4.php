<?php
include 'include/connessione.php';
include "include/lingua.php";
session_start();

if(!isset($_SESSION['user'])){ header("Location: http://www.sekurbox.com/".$lingua."/cassa-step-1.html");}


$session = session_id();
//SPEDIZIONE
$id_spesa_di_spedizione = $_POST['id_spesa_di_spedizione'];
$query_spese_spedizione="select * from spese_di_spedizione WHERE id_spesa_di_spedizione = '" . mysql_real_escape_string($id_spesa_di_spedizione)  . "'";
$Risultato_spese_spedizione = mysql_query($query_spese_spedizione, $db) or die (mysql_error($db));
$riga_spese_spedizione=mysql_fetch_assoc($Risultato_spese_spedizione);

$nome_spesa_di_spedizione_ita = $riga_spese_spedizione['nome_spesa_di_spedizione_ita'];
$desc_spesa_di_spedizione_ita = $riga_spese_spedizione['desc_spesa_di_spedizione_ita'];
$costo_spesa_spedizione = $riga_spese_spedizione['costo_spesa_spedizione'];

//PAGAMENTO
$id_metodo_pagamento = $_POST['id_metodo_pagamento'];
$query_metodi_pagamento="select * from metodi_di_pagamento WHERE id_metodo_pagamento = '" . mysql_real_escape_string($id_metodo_pagamento)  . "'";
$Risultato_metodi_pagamento = mysql_query($query_metodi_pagamento, $db) or die (mysql_error($db));
$riga_metodi_pagamento=mysql_fetch_assoc($Risultato_metodi_pagamento);

$nome_pagamento_ita = $riga_metodi_pagamento['nome_pagamento_ita'];
$testo_pagamento_ita = $riga_metodi_pagamento['testo_pagamento_ita'];
$costo_metodo_di_pagamento = $riga_metodi_pagamento['costo_metodo_di_pagamento'];

//NOTE PER IL CORRIERE
$note_per_il_corriere = $_POST['note_per_il_corriere'];

// DATI ALTRA SPEDIZIONE
$nome_spedizione = $_POST['nome_spedizione'];
$cognome_spedizione = $_POST['cognome_spedizione'];
$id_nazione_spedizione = $_POST['id_nazione_spedizione'];
$indirizzo_spedizione = $_POST['indirizzo_spedizione']; 
$citta_spedizione = $_POST['citta_spedizione']; 
$cap_spedizione = $_POST['cap_spedizione']; 
$id_provincia_spedizione = $_POST['id_provincia_spedizione']; 
$telefono_fisso_spedizione = $_POST['telefono_fisso_spedizione'];
$telefono_cellulare_spedizione = $_POST['telefono_cellulare_spedizione'];

// DATI CLIENTE
$id_cliente =$_SESSION['user'];

$queryli="SELECT *
          FROM listini
               ";
$resultli=mysql_query($queryli) or die(mysql_error());
 while($listli=  mysql_fetch_assoc($resultli)){
        if($listli['id_listino']=='6'){ $listinorivenditore=$listli['sconto_listino'];}
        if($listli['id_listino']=='5'){ $listinoinstallatore=$listli['sconto_listino'];}
        if($listli['id_listino']=='1'){ $listinoprivato=$listli['sconto_listino'];}
    }
    

$queryc="SELECT *
         FROM clienti
         WHERE id_cliente='".$id_cliente."' ";
$resultc=mysql_query($queryc) or die(mysql_error());
$listc=  mysql_fetch_assoc($resultc);
            
$sconto_cliente=$listc['sconto'];

$puntiinstallatore='no';
$puntiprivato='no';

if($listc['attivo']=='no'){ $sconto_listino=0;}
else {
    
     //CASO CLIENTE RIVENDITORE ATTIVO
                if($listc['id_tipologia_cliente']==3){

                    $sconto_listino=$listinorivenditore;
               
                                                          
                } else if( $listc['id_tipologia_cliente']==2){ //CASO INSTALLATORE ATTIVO
                    
                    if($listc['codice_sconto']!=''){ //SE HA CODICE SCONTO VERIFICO E APPLICO
                      
                            $querycodice = "SELECT codice_per_installatore 
                                            FROM clienti WHERE attivo='si' 
                                            AND codice_per_installatore='".$listc['codice_sconto']."' ";
                            $resultcodice=mysql_query($querycodice) or die(mysql_error());
                            if(mysql_num_rows($resultcodice)>0){
                           
                                $sconto_listino=$listinoinstallatore;
                                $puntiinstallatore='si';
                              
                            }
                    }
                    
                }else if( $listc['id_tipologia_cliente']==1){//CASO PRIVATO ATTIVO
                    
                    if($listc['codice_sconto']!=''){//SE HA CODICE SCONTO VERIFICO E APPLICO
                    
                    
                            $querycodice = "SELECT codice_per_privato 
                                            FROM clienti WHERE attivo='si' 
                                            AND codice_per_privato='".$listc['codice_sconto']."' ";
                            $resultcodice=mysql_query($querycodice) or die(mysql_error());
                            if(mysql_num_rows($resultcodice)>0){
        
                                $sconto_listino=$listinoprivato;
                                $puntiprivato='si';
                     
                            } 
                    }
    
                }
    
}


// CREA NUOVO ORDINE
$query = 'INSERT INTO ordini
         (sconto_cliente,sconto_listino,data_ordine, id_cliente, id_metodo_pagamento, id_spesa_di_spedizione, nome_spedizione, cognome_spedizione, id_nazione_spedizione, indirizzo_spedizione, citta_spedizione, cap_spedizione, id_provincia_spedizione, telefono_fisso_spedizione, telefono_cellulare_spedizione, note_per_il_corriere)
         VALUES
        (           "'.$sconto_cliente.'",
                    "'.$sconto_listino.'",NOW(),
                    "' . mysql_real_escape_string($id_cliente) . '",
                    "' . mysql_real_escape_string($id_metodo_pagamento) . '",
                    "' . mysql_real_escape_string($id_spesa_di_spedizione) . '",
                    "' . mysql_real_escape_string($nome_spedizione) . '",
                    "' . mysql_real_escape_string($cognome_spedizione) . '",
                    "' . mysql_real_escape_string($id_nazione_spedizione) . '",
                    "' . mysql_real_escape_string($indirizzo_spedizione) . '",
                    "' . mysql_real_escape_string($citta_spedizione) . '",
                    "' . mysql_real_escape_string($cap_spedizione) . '",
                    "' . mysql_real_escape_string($id_provincia_spedizione) . '",			
                    "' . mysql_real_escape_string($telefono_fisso_spedizione) . '",
                    "' . mysql_real_escape_string($telefono_cellulare_spedizione) . '",
                    "' . mysql_real_escape_string($note_per_il_corriere) . '")';

$Risultato = mysql_query($query, $db) or die (mysql_error($db));
$id_ordine = mysql_insert_id();


// SPOSTA I DATI DA CARRELLI TEMPORANEI A DETTAGLIO_PREVENTIVO A DETTAGLIO_ORDINE
$totaleprev=0;

$queryp=" SELECT  ct.quantita, ct.id_prodotto, p.prezzo, p.sconto
          FROM
          carrelli_temporanei ct,prodotti p
          WHERE ct.id_prodotto = p.id_prodotto
	  AND ct.session = '". mysql_real_escape_string($session)."' ";
$resultp=  mysql_query($queryp) or die (mysql_error());
while($listp=  mysql_fetch_array($resultp)){
 
  $queryins= "INSERT INTO dettaglio_ordine( id_ordine,quantita,id_prodotto,prezzo_def,sconto)
              VALUES('". $id_ordine."','".$listp['quantita']."','".$listp['id_prodotto']."','".$listp['prezzo']."','".$listp['sconto']."')";
  $resultins=  mysql_query($queryins) or die(mysql_error());
  
  
  if($listp['sconto']!=0){
      
       $prezzoscontato=($listp['prezzo']*$listp['sconto'])/100;
       $prezzoscontato=$listp['prezzo']-$prezzoscontato;
      $totaleprev=$totaleprev+($listp['quantita']*$prezzoscontato);             
  }
  
  else{
      
    $prezzoscontato_listino=($listp['prezzo']*$sconto_listino)/100;  
    $prezzoscontato=$listp['prezzo']-$prezzoscontato_listino;
    
    if($sconto_listino!=0){$prezzoscontato_cliente=($prezzoscontato*$sconto_cliente)/100; } else {$prezzoscontato_cliente=($listp['prezzo']*$sconto_cliente)/100;} 
      
    $prezzoscontato=$prezzoscontato-$prezzoscontato_cliente;
    $totaleprev=$totaleprev+($listp['quantita']*$prezzoscontato); 
         
    }
  
  
    
}


$subtotale_ordine = $totaleprev;
//CALCOLO DEL TOTALE
$totale_ordine = $subtotale_ordine + $costo_spesa_spedizione + $costo_metodo_di_pagamento;


$query = 'DELETE FROM carrelli_temporanei WHERE session = "' . $session . '"';
$Risultato = mysql_query($query, $db) or die (mysql_error($db));



// AGGIORNAMENTO DELLA TABELLA ORDINI
$query = 'UPDATE ordini
          SET
          subtotale = ' . $subtotale_ordine . ',
          totale = ' . $totale_ordine . '
          WHERE
          id_ordine = ' . $id_ordine;
mysql_query($query, $db) or (mysql_error($db));

if(isset($_SESSION['user'])){header("Location: http://www.sekurbox.com/" . $lingua . "/conferma_ordine_" . $id_ordine . ".html");}
?>	 