<?php 
include 'include/connessione.php';
include "include/lingua.php";
session_start();
$session = session_id();
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
                     
                            } 
                    }
    
                }
    
}


// CREA NUOVO PREVENTIVO
$query = "INSERT INTO preventivi(data_preventivo, id_cliente,sconto_cliente,sconto_listino)
          VALUES (NOW(),'". mysql_real_escape_string($id_cliente) . "','".$sconto_cliente."','".$sconto_listino."')";
$Risultato = mysql_query($query, $db) or die (mysql_error($db));
$id_preventivo = mysql_insert_id();

// SPOSTA I DATI DA CARRELLI TEMPORANEI A DETTAGLIO_PREVENTIVO E CALCOLA IL TOTALE
$totaleprev=0;

$queryp=" SELECT  ct.quantita, ct.id_prodotto, p.prezzo, p.sconto
          FROM
          carrelli_temporanei ct,prodotti p
          WHERE ct.id_prodotto = p.id_prodotto
	  AND ct.session = '". mysql_real_escape_string($session)."' ";
$resultp=  mysql_query($queryp) or die (mysql_error());
while($listp=  mysql_fetch_array($resultp)){
 
  $queryins= "INSERT INTO dettaglio_preventivo( id_preventivo,quantita,id_prodotto,preventivo_prezzo_def,preventivo_sconto_def)
              VALUES('". $id_preventivo."','".$listp['quantita']."','".$listp['id_prodotto']."','".$listp['prezzo']."','".$listp['sconto']."')";
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


//echo $query;

$query = 'DELETE FROM carrelli_temporanei WHERE session = "' . $session . '"';
$Risultato = mysql_query($query, $db) or die (mysql_error($db));


// AGGIORNAMENTO DELLA TABELLA PREVENTIVI
$query = 'UPDATE preventivi
          SET
          totale_preventivo = ' . $totaleprev . '
          WHERE
          id_preventivo = ' . $id_preventivo;
mysql_query($query, $db) or (mysql_error($db));

header("Location: http://www.sekurbox.com/" . $lingua . "/preventivi.html");

?>	 