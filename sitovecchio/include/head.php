<?php 
session_start();
//echo $_SERVER['DOCUMENT_ROOT'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title;?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="<?php echo $description;?>" />
    <meta name="ROBOTS" content="INDEX,FOLLOW" />
    <script src="http://code.jquery.com/jquery-1.9.1.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="http://www.sekurbox.com/js/script.js"></script>
    <link rel="stylesheet" href="http://www.sekurbox.com/css/stile.css" />

<?php

//FUNZIONE CHE CALCOLA IL PREZZO DEL PRODOTTO CONTROLLANDO TUTTI GLI SCONTI

function calcolaprezzo($id_prodotto,$dove,$id_sessione){
    
    include "include/lingua.php"; 
    
    $queryli="SELECT *
              FROM listini
               ";
    $resultli=mysql_query($queryli) or die(mysql_error());
    while($listli=  mysql_fetch_assoc($resultli)){
        if($listli['id_listino']=='6'){ $listinorivenditore=$listli['sconto_listino'];}
        if($listli['id_listino']=='5'){ $listinoinstallatore=$listli['sconto_listino'];}
        if($listli['id_listino']=='1'){ $listinoprivato=$listli['sconto_listino'];}
    }
    
   // $contolistinoriv= $listli['sconto_listino'];
    
    
    $testo=' <div class="hp_prodotto_prezzo">';
   
    if(isset($_SESSION['user'])){
        
        //CONTROLLO SE C'E' UNO SCONTO PRODOTTO CHE ESCLUDE GLI ALTRI
        $query="SELECT *
                FROM prodotti 
                WHERE id_prodotto='".$id_prodotto."' ";
        $result=mysql_query($query) or die(mysql_error());
        $list=  mysql_fetch_assoc($result);

        $prezzo=$list['prezzo'];
        $sconto_prodotto=$list['sconto'];       
        
        if($dove=='carrello_sopra'){
                
                $querytemp = "SELECT * FROM carrelli_temporanei WHERE carrelli_temporanei.id_prodotto = '".$id_prodotto."' AND session = '".$id_sessione."' ";
		$resulttemp=mysql_query($querytemp) or die(mysql_error());
                $listtemp=  mysql_fetch_assoc($resulttemp);
                $quantita=$listtemp['quantita'];
              
                $testo_carrello_sopra='<div class="cart_open_prodotto_prezzo">'.$quantita. ' x &euro; ' . number_format($prezzo, 2, ',', '.').'</div>';
                $testo_carrello_sopra.='<div class="cart_open_prodotto_sconto">';           
            }
            
        if($dove=='carrello_principale'){
                
                $querytemp = "SELECT * FROM carrelli_temporanei WHERE carrelli_temporanei.id_prodotto = '".$id_prodotto."' AND session = '".$id_sessione."' ";
		$resulttemp=mysql_query($querytemp) or die(mysql_error());
                $listtemp=  mysql_fetch_assoc($resulttemp);
                $quantita=$listtemp['quantita'];
              
                $testo_carrello_sopra='<div class="carrello_prodotto_prezzo">'.$quantita. ' x &euro; ' . number_format($prezzo, 2, ',', '.').'</div>';
                $testo_carrello_sopra.='<div class="carrello_prodotto_sconto">';
              
            }    

        
        //SE E' LOGGATO E C'E' LO SCONTO PRODOTTO
        if ( $sconto_prodotto > 0){
            
            $sconto= ($prezzo * $sconto_prodotto) / 100;
            $prezzo_scontato = $prezzo - $sconto;
            
            $testo.='<div class="hp_sconto">'.$scontoprod_txt.' -'.$sconto_prodotto.'%</div>';
            $testo.='<span class="prezzo_sbarrato">€ '. number_format($prezzo, 2, ',', '.').'</span>&nbsp;';
            if($dove=='') $testo.='<br />';
            $testo.='<span class="prezzo_normale">€ '. number_format($prezzo_scontato, 2, ',', '.').'&nbsp;</span><span class="prezzo_stile">Iva Inc.&nbsp;&nbsp;</span>'; 
            
            if($dove=='carrello_sopra'){
                
                $prezzo_scontato_sop=$prezzo_scontato*$listtemp['quantita'];
                $testo_carrello_sopra.=$sconto_prodotto . ' %</div>';
                $testo_carrello_sopra.='<div class="cart_open_prodotto_totale">&euro; '  .number_format($prezzo_scontato_sop, 2, ',', '.').'</div>';
                
                
            }
             if($dove=='carrello_principale'){
                
                $prezzo_scontato_sop=$prezzo_scontato*$listtemp['quantita'];
                $testo_carrello_sopra.=$sconto_prodotto . ' %</div>';
                $testo_carrello_sopra.='<div class="carrello_prodotto_totale">&euro; '  .number_format($prezzo_scontato_sop, 2, ',', '.').'</div>';
                
            }  
           
            
        } 
        /////////////////////////////////////////////////////////
        //SE E' LOGGATO E NON C'E' LO SCONTO PRODOTTO
        else{
            $oksconto=0;
            
            $queryc="SELECT *
                     FROM clienti
                     WHERE id_cliente='".$_SESSION['user']."' ";
            $resultc=mysql_query($queryc) or die(mysql_error());
            $listc=  mysql_fetch_assoc($resultc);
            
            $sconto_cliente=$listc['sconto'];
            
            
            //CLIENTE  NON ATTIVO VEDE SOLO LO SCONTO CLIENTE 
            if($listc['attivo']=='no'){
                
                if ( $sconto_cliente > 0){
            
                    $sconto= ($prezzo * $sconto_cliente) / 100;
                    $prezzo_scontato = $prezzo - $sconto;

                    $testo.='<div class="hp_sconto">'.$sconto_cliente_txt.' -'.$sconto_cliente.'%</div>';
                    $oksconto=1;
                
                     if($dove=='carrello_sopra'){
                   
                        $prezzo_scontato_sop=$prezzo_scontato*$quantita; 
                        $testo_carrello_sopra.=$sconto_cliente . ' %</div>';
                        $testo_carrello_sopra.='<div class="cart_open_prodotto_totale">&euro; '  .number_format($prezzo_scontato_sop, 2, ',', '.').'</div>';
                    }
                    if($dove=='carrello_principale'){
                   
                        $prezzo_scontato_sop=$prezzo_scontato*$quantita; 
                        $testo_carrello_sopra.=$sconto_cliente . ' %</div>';
                        $testo_carrello_sopra.='<div class="carrello_prodotto_totale">&euro; '  .number_format($prezzo_scontato_sop, 2, ',', '.').'</div>';

                    }

                  }
            
            }else{  //CLIENTE ATTIVO
             
                $prezzo_scontato=$prezzo;
               
                  
                //CASO CLIENTE RIVENDITORE ATTIVO
                if($listc['id_tipologia_cliente']==3){
   
                    $sconto= ($prezzo * $listinorivenditore) / 100;
                    $prezzo_scontato = $prezzo - $sconto;
                    
                    $testo.='<div class="hp_sconto">'.$sconto_listino_txt.' -'.$listinorivenditore.'%</div>';
                    
                    $oksconto=1;
                                    
                    if($dove=='carrello_sopra' OR $dove=='carrello_principale'){ $testo_carrello_sopra.=$listinorivenditore.'%'; }
                   
                                            
                } else if( $listc['id_tipologia_cliente']==2){ //CASO INSTALLATORE ATTIVO
                    
                    if($listc['codice_sconto']!=''){ //SE HA CODICE SCONTO VERIFICO E APPLICO
                    
                    
                            $querycodice = "SELECT codice_per_installatore 
                                            FROM clienti WHERE attivo='si' 
                                            AND codice_per_installatore='".$listc['codice_sconto']."' ";
                            $resultcodice=mysql_query($querycodice) or die(mysql_error());
                            if(mysql_num_rows($resultcodice)>0){
                                
                                $sconto= ($prezzo * $listinoinstallatore) / 100;
                                $prezzo_scontato = $prezzo - $sconto;
                                
                                $testo.='<div class="hp_sconto">'.$sconto_listino_txt.' -'.$listinoinstallatore.'%</div>';
                                
                                $oksconto=1;
                                
                                if($dove=='carrello_sopra' OR $dove=='carrello_principale' ){ $testo_carrello_sopra.=$listinoinstallatore.'%';}

                            }
                    
                    }
                    
                }else if( $listc['id_tipologia_cliente']==1){//CASO PRIVATO ATTIVO
                    
                    if($listc['codice_sconto']!=''){//SE HA CODICE SCONTO VERIFICO E APPLICO
                    
                    
                            $querycodice = "SELECT codice_per_privato 
                                            FROM clienti WHERE attivo='si' 
                                            AND codice_per_privato='".$listc['codice_sconto']."' ";
                            $resultcodice=mysql_query($querycodice) or die(mysql_error());
                            if(mysql_num_rows($resultcodice)>0){
                                
                                $sconto= ($prezzo * $listinoprivato) / 100;
                                $prezzo_scontato = $prezzo - $sconto;
                                
                                $testo.='<div class="hp_sconto">'.$sconto_listino_txt.' -'.$listinoprivato.'%</div>';
                                
                                $oksconto=1;
                                
                                if($dove=='carrello_sopra' OR $dove=='carrello_principale'){ $testo_carrello_sopra.=$listinoprivato.'%'; }
                                
                            } 
                    }
    
                }
        
             if ( $sconto_cliente > 0){
                               
                    $sconto= ($prezzo_scontato * $sconto_cliente) / 100;
                    $prezzo_scontato = $prezzo_scontato - $sconto;

                    $testo.='<div class="hp_sconto">'.$sconto_cliente_txt.' -'.$sconto_cliente.'%</div>';
                    
                    
                    
                    if($dove=='carrello_sopra' OR $dove=='carrello_principale' ){
                        
                        if($oksconto==1) { $testo_carrello_sopra.=' + '.$sconto_cliente.'%</div>'; }
                        else {$testo_carrello_sopra.=$sconto_cliente.'%</div>';}
                     }
                 $oksconto=1; 
                  }  
                  
                  else {
                      
                      if($dove=='carrello_sopra' OR $dove=='carrello_principale' ){
                                    
                                    $testo_carrello_sopra.='</div>';

                                }
                   
                  }
                
            }
            
            ////////////////////////////////////////////////////////////////
            
         if($oksconto==1){  
             
             $testo.='<span class="prezzo_sbarrato">€ '. number_format($prezzo, 2, ',', '.').'</span>&nbsp;';
             if($dove=='') $testo.='<br />';
             $testo.='<span class="prezzo_normale">€ '. number_format($prezzo_scontato, 2, ',', '.').'&nbsp;</span><span class="prezzo_stile">Iva Inc.&nbsp;&nbsp;</span>';
                if($dove=='carrello_sopra'){
                    
                  $testo_carrello_sopra.='<div class="cart_open_prodotto_totale">&euro; '  .number_format($prezzo_scontato*$quantita, 2, ',', '.').'</div>';
             
                }
                
                if($dove=='carrello_principale'){
                    
                  $testo_carrello_sopra.='<div class="carrello_prodotto_totale">&euro; '  .number_format($prezzo_scontato*$quantita, 2, ',', '.').'</div>';
             
                }
             
             }else{
             
               $testo.=' <span class="prezzo_normale">€ '. number_format($prezzo, 2, ',', '.').'&nbsp;</span><span class="prezzo_stile">Iva Inc.&nbsp;&nbsp;</span>'; 
             
                if($dove=='carrello_sopra'){
                    
                  $testo_carrello_sopra.='<div class="cart_open_prodotto_totale">&euro; '  .number_format($prezzo*$quantita, 2, ',', '.').'</div>';
             
                }
                
                if($dove=='carrello_principale'){
                    
                  $testo_carrello_sopra.='<div class="carrello_prodotto_totale">&euro; '  .number_format($prezzo*$quantita, 2, ',', '.').'</div>';
             
                }
              
             }
            
          
        }    
     
        
      //SE NON E' LOGGATO  
    }else{
    
    
    $query="SELECT *
            FROM prodotti 
            WHERE id_prodotto='".$id_prodotto."' ";
    $result=mysql_query($query) or die(mysql_error());
    $list=  mysql_fetch_assoc($result);
    
    $prezzo=$list['prezzo'];
    
    if ( $list['sconto'] > 0){
        $sconto = ($prezzo * $list['sconto']) / 100;
        $prezzo_scontato = $prezzo - $sconto;
    }

   
               if ( $list['sconto'] > 0) { 
    
                       $testo.='<div class="hp_sconto">'.$scontoprod_txt.' -'.$list['sconto'].'%</div>';
                       $testo.='<span class="prezzo_sbarrato">€ '. number_format($prezzo, 2, ',', '.').'</span>&nbsp;';
                       if($dove=='') $testo.='<br />';
                       $testo.='<span class="prezzo_normale">€ '. number_format($prezzo_scontato, 2, ',', '.').'&nbsp;</span><span class="prezzo_stile">Iva Inc.&nbsp;&nbsp;</span>'; 

                       if($dove=='carrello_sopra'){

                        $querytemp = "SELECT * FROM carrelli_temporanei WHERE carrelli_temporanei.id_prodotto = '".$id_prodotto."' AND session = '".$id_sessione."' ";
                        $resulttemp=mysql_query($querytemp) or die(mysql_error());
                        $listtemp=  mysql_fetch_assoc($resulttemp);

                        $testo_carrello_sopra='<div class="cart_open_prodotto_prezzo">'.$listtemp['quantita'] . " x &euro; " . number_format($prezzo, 2, ',', '.').'</div>';
                        $testo_carrello_sopra.='<div class="cart_open_prodotto_sconto">'.$list['sconto'] . ' %</div>';
                        $testo_carrello_sopra.='<div class="cart_open_prodotto_totale">&euro; '  .number_format($prezzo_scontato*$listtemp['quantita'], 2, ',', '.').'</div>';


                        }
                        if($dove=='carrello_principale'){

                        $querytemp = "SELECT * FROM carrelli_temporanei WHERE carrelli_temporanei.id_prodotto = '".$id_prodotto."' AND session = '".$id_sessione."' ";
                        $resulttemp=mysql_query($querytemp) or die(mysql_error());
                        $listtemp=  mysql_fetch_assoc($resulttemp);

                        $testo_carrello_sopra='<div class="carrello_prodotto_prezzo">'.$listtemp['quantita'] . " x &euro; " . number_format($prezzo, 2, ',', '.').'</div>';
                        $testo_carrello_sopra.='<div class="carrello_prodotto_sconto">'.$list['sconto'] . ' %</div>';
                        $testo_carrello_sopra.='<div class="carrello_prodotto_totale">&euro; '  .number_format($prezzo_scontato*$listtemp['quantita'], 2, ',', '.').'</div>';


                    }
               
                
                 } else { 
               $testo.=' <span class="prezzo_normale">€ '. number_format($prezzo, 2, ',', '.').'&nbsp;</span><span class="prezzo_stile">Iva Inc.&nbsp;&nbsp;</span>'; 
               
               if($dove=='carrello_sopra'){

                        $querytemp = "SELECT * FROM carrelli_temporanei WHERE carrelli_temporanei.id_prodotto = '".$id_prodotto."' AND session = '".$id_sessione."' ";
                        $resulttemp=mysql_query($querytemp) or die(mysql_error());
                        $listtemp=  mysql_fetch_assoc($resulttemp);

                        $testo_carrello_sopra='<div class="cart_open_prodotto_prezzo">'.$listtemp['quantita'] . " x &euro; " . number_format($prezzo, 2, ',', '.').'</div>';
                        $testo_carrello_sopra.='<div class="cart_open_prodotto_sconto"></div>';
                        $testo_carrello_sopra.='<div class="cart_open_prodotto_totale">&euro; '  .number_format($listtemp['quantita']*$prezzo, 2, ',', '.').'</div>';


                    }
               if($dove=='carrello_principale'){

                        $querytemp = "SELECT * FROM carrelli_temporanei WHERE carrelli_temporanei.id_prodotto = '".$id_prodotto."' AND session = '".$id_sessione."' ";
                        $resulttemp=mysql_query($querytemp) or die(mysql_error());
                        $listtemp=  mysql_fetch_assoc($resulttemp);

                        $testo_carrello_sopra='<div class="carrello_prodotto_prezzo">'.$listtemp['quantita'] . " x &euro; " . number_format($prezzo, 2, ',', '.').'</div>';
                        $testo_carrello_sopra.='<div class="carrello_prodotto_sconto"></div>';
                        $testo_carrello_sopra.='<div class="carrello_prodotto_totale">&euro; '  .number_format($listtemp['quantita']*$prezzo, 2, ',', '.').'</div>';


                    }
               
               
                 } 

    
   }
   
   $testo.='</div>';
  
   if($dove=='carrello_sopra' OR $dove=='carrello_principale') return $testo_carrello_sopra;  else return $testo;
   
}





function calcolaprezzo_preventivo($id_prodotto,$id_preventivo){
    
    include "include/lingua.php"; 

       
                $querytemp = "SELECT * FROM dettaglio_preventivo WHERE id_prodotto = '".$id_prodotto."' AND id_preventivo='".$id_preventivo."' ";
		$resulttemp=mysql_query($querytemp) or die(mysql_error());
                $listtemp=  mysql_fetch_assoc($resulttemp);
                $quantita=$listtemp['quantita'];
                $prezzo=$listtemp['preventivo_prezzo_def'];
                $sconto_prodotto=$listtemp['preventivo_sconto_def'];
              
                $testo_carrello_sopra='<div class="carrello_prodotto_prezzo">'.$quantita . " x &euro; " . number_format($prezzo, 2, ',', '.').'</div>';
                $testo_carrello_sopra.='<div class="carrello_prodotto_sconto">';
              
              

        
        //SE E' LOGGATO E C'E' LO SCONTO PRODOTTO
        if ( $sconto_prodotto > 0){
            
            $sconto= ($prezzo * $sconto_prodotto) / 100;
            $prezzo_scontato = $prezzo - $sconto;
      
                $prezzo_scontato_sop=$prezzo_scontato*$quantita;
                $testo_carrello_sopra.=$sconto_prodotto . ' %</div>';
                $testo_carrello_sopra.='<div class="carrello_prodotto_totale">&euro; '  .number_format($prezzo_scontato_sop, 2, ',', '.').'</div>';
       
        } 
        /////////////////////////////////////////////////////////
        //SE E' LOGGATO E NON C'E' LO SCONTO PRODOTTO
        else{
            $oksconto=0;
            
            $prezzo_scontato = $prezzo;
            
            
            $queryc="SELECT *
                     FROM preventivi
                     WHERE id_preventivo='".$id_preventivo."' ";
            $resultc=mysql_query($queryc) or die(mysql_error());
            $listc=  mysql_fetch_assoc($resultc);
            
            $sconto_cliente=$listc['sconto_cliente'];
            $sconto_listino=$listc['sconto_listino'];
            
            if($sconto_listino>0){
              
             $sconto= ($prezzo * $sconto_listino) / 100;
             $prezzo_scontato = $prezzo - $sconto;   
             $testo_carrello_sopra.=$sconto_listino.'%';   
             $oksconto=1;
                
            }
            
            if($sconto_cliente>0){
               
             $sconto= ($prezzo_scontato * $sconto_cliente) / 100;
             $prezzo_scontato = $prezzo_scontato - $sconto;      
             if($sconto_listino>0)  { $testo_carrello_sopra.=' + '.$sconto_cliente.'%</div>';  }
             else{ $testo_carrello_sopra.= $sconto_cliente.'%</div>';}
            
             $oksconto=1;
            }
            
            else $testo_carrello_sopra.='</div>';
            
            
          
          
             if($oksconto==1){  
                    
                  $testo_carrello_sopra.='<div class="carrello_prodotto_totale">&euro; '  .number_format($prezzo_scontato*$quantita, 2, ',', '.').'</div>';
             
                }
             
             else{
                    
                  $testo_carrello_sopra.='<div class="carrello_prodotto_totale">&euro; '  .number_format($prezzo*$quantita, 2, ',', '.').'</div>';
         
             }
            
        }    
        

   
    return $testo_carrello_sopra; 
   
}

function calcolaprezzo_ordine($id_prodotto,$id_ordine){
    
    include "include/lingua.php"; 

       
                $querytemp = "SELECT * FROM dettaglio_ordine WHERE id_prodotto = '".$id_prodotto."' AND id_ordine='".$id_ordine."' ";
		$resulttemp=mysql_query($querytemp) or die(mysql_error());
                $listtemp=  mysql_fetch_assoc($resulttemp);
                $quantita=$listtemp['quantita'];
                $prezzo=$listtemp['prezzo_def'];
                $sconto_prodotto=$listtemp['sconto'];
              
                $testo_carrello_sopra='<div class="carrello_prodotto_prezzo">'.$quantita . " x &euro; " . number_format($prezzo, 2, ',', '.').'</div>';
                $testo_carrello_sopra.='<div class="carrello_prodotto_sconto">';
              
              

        
        //SE E' LOGGATO E C'E' LO SCONTO PRODOTTO
        if ( $sconto_prodotto > 0){
            
            $sconto= ($prezzo * $sconto_prodotto) / 100;
            $prezzo_scontato = $prezzo - $sconto;
      
                $prezzo_scontato_sop=$prezzo_scontato*$quantita;
                $testo_carrello_sopra.=$sconto_prodotto . ' %</div>';
                $testo_carrello_sopra.='<div class="carrello_prodotto_totale">&euro; '  .number_format($prezzo_scontato_sop, 2, ',', '.').'</div>';
       
        } 
        /////////////////////////////////////////////////////////
        //SE E' LOGGATO E NON C'E' LO SCONTO PRODOTTO
        else{
            $oksconto=0;
            
            $prezzo_scontato = $prezzo;
            
            
            $queryc="SELECT *
                     FROM ordini
                     WHERE id_ordine='".$id_ordine."' ";
            $resultc=mysql_query($queryc) or die(mysql_error());
            $listc=  mysql_fetch_assoc($resultc);
            
            $sconto_cliente=$listc['sconto_cliente'];
            $sconto_listino=$listc['sconto_listino'];
            
            if($sconto_listino>0){
              
             $sconto= ($prezzo * $sconto_listino) / 100;
             $prezzo_scontato = $prezzo - $sconto;   
             $testo_carrello_sopra.=$sconto_listino.'%';   
             $oksconto=1;
                
            }
            
            if($sconto_cliente>0){
               
             $sconto= ($prezzo_scontato * $sconto_cliente) / 100;
             $prezzo_scontato = $prezzo_scontato - $sconto;      
             if($sconto_listino>0)  { $testo_carrello_sopra.=' + '.$sconto_cliente.'%</div>';  }
             else{ $testo_carrello_sopra.= $sconto_cliente.'%</div>';}
            
             $oksconto=1;
            }
             else $testo_carrello_sopra.='</div>';
            
          
          
             if($oksconto==1){  
                    
                  $testo_carrello_sopra.='<div class="carrello_prodotto_totale">&euro; '  .number_format($prezzo_scontato*$quantita, 2, ',', '.').'</div>';
             
                }
             
             else{
                    
                  $testo_carrello_sopra.='<div class="carrello_prodotto_totale">&euro; '  .number_format($prezzo*$quantita, 2, ',', '.').'</div>';
         
             }
}
    return $testo_carrello_sopra; 
   
}


?>