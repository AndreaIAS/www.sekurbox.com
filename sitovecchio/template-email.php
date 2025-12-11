<?php 
include 'include/connessione.php';
include 'include/leggi_immagine.inc.php';
include "include/lingua.php"; 

function calcolaprezzo_ordine($id_prodotto,$id_ordine){
    
    

       
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
            $sconto = $prezzo;
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
               
             $sconto= ($sconto * $sconto_cliente) / 100;
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Ordine</title>
<style>
body 
{
margin:0px;
background:#FFF;
font-family:Arial, Helvetica, sans-serif;
}
img
{
border:none;
text-decoration:none;
}
div#container 
{  
margin:0 auto 0 auto;
width:100%;
}
#content
{
margin:0 auto;
width:100%;
height:auto;
float:left;
padding-bottom:30px;
background:#f3f1f1;
}
#content_fix
{
margin:0 auto;
width:1100px;
height:auto;
}
#content h2
{
width:1100px;
height:20px;
float:left;	
font-size:20px;
color:#322a7c;
margin:20px 0 10px 0;
}
#ricevuta
{
width:1060px;
height:auto;
float:left;
padding:20px;
background:#FFF;
color:#322a7c;
font-size:18px;
}
#ricevuta_alert
{
width:1040px;
height:auto;
float:left;
border:#d72c38 2px dotted;
padding:10px;
}
#carrello
{
width:1100px;
height:auto;
float:left;
}
.intestazione_tab_carrello
{
width:1100px;
height:30px;
float:left;
background:#322a7c;
color:#FFF;
margin:5px 0 0 0;
font-size:16px;
padding-top:5px;
text-align:center;
}
.intestazione_tab_carrello_prodotto
{
width:685px;
height:30px;
float:left;
}
.intestazione_tab_carrello_prezzo
{
width:200px;
height:30px;
float:left;
}
.intestazione_tab_carrello_sconto
{
width:85px;
height:30px;
float:left;
}
.intestazione_tab_carrello_totale
{
width:100px;
height:30px;
float:left;
}
.carrello_box_prodotto
{
width:1100px;
height:100px;
float:left;
margin:5px 0 0 0;
text-align:center;
font-size:18px;
color:#322a7c;
background:#FFF;	
}
.carrello_prodotto
{
width:685px;
height:100px;
float:left;
}
.carrello_prodotto_img
{
width:80px;
height:100px;
float:left;
}
.carrello_prodotto_titolo
{
width:595px;
height:100px;
float:left;
margin-left:10px;
}
.carrello_prodotto_titolo a
{
font-size:18px;
color:#322a7c;
text-decoration:none;	
}
.carrello_prodotto_prezzo
{
width:200px;
height:100px;
float:left;
}
.carrello_prodotto_sconto
{
width:85px;
height:100px;
float:left;
}
.carrello_prodotto_totale
{
width:100px;
height:100px;
float:left;
}
#carrello_totale
{
width:1100px;
height:auto;
float:left;
background:#f2f2f2;
color:#322a7c;
margin:10px 0 20px 0;
font-size:18px;
padding-top:5px;
background:#FFF;
}
.carrello_totale_sn
{
width:900px;
height:30px;
float:left;
text-align:right;
}
.carrello_totale_ds
{
width:150px;
height:30px;
float:left;
text-align:right;
margin-right:50px;
}
</style>
</head>   
<body> 	
	<div id="container">
		<div id="content">
			<div id="content_fix">
				<h2>Conferma dell'ordine</h2>
				<?php
                $query = "SELECT 
                          ordini.*,
                          spese_di_spedizione.*,
                          metodi_di_pagamento.*
                          FROM ordini 
                          INNER JOIN spese_di_spedizione ON spese_di_spedizione.id_spesa_di_spedizione = ordini.id_spesa_di_spedizione
                          INNER JOIN metodi_di_pagamento ON metodi_di_pagamento.id_metodo_pagamento = ordini.id_metodo_pagamento
                          WHERE ordini.id_ordine = '" . mysql_real_escape_string($_GET['id_ordine']) . "'";	    
                $Risultato = mysql_query($query, $db) or die (mysql_error($db));
                while ($riga=mysql_fetch_array($Risultato))
                {
                $costo_spesa_spedizione = 	$riga['costo_spesa_spedizione'];
                $costo_metodo_di_pagamento = $riga['costo_metodo_di_pagamento'];
                $totale_carrello_sopra=$riga['subtotale'];
                ?>
				<div id="ricevuta">
                    <p>
                    Grazie per aver ordinato i nostri prodotti.<br />
                    Di seguito un dettaglio dell'ordine:<br />
                    <strong>ID ORDINE:</strong> #<?php echo $id_ordine;?><br />
                    <?php $data_ordine = date("d-m-Y", strtotime($riga['data_ordine']));?>
                    <strong>DATA ORDINE:</strong> <?php echo $data_ordine;?><br /><br />
                    <strong>Il prodotto verrà spedito con:</strong><br />
                    <?php echo $riga['nome_spesa_di_spedizione_ita'] . '&nbsp;(&euro; ' . $riga['costo_spesa_spedizione'] . ")";?><br /><br />                            
                    <strong>Hai scelto di pagare con:</strong><br />
                    <?php echo $riga['nome_pagamento_ita'] . '&nbsp;(&euro; ' . $riga['costo_metodo_di_pagamento'] . ')';?>
                    <?php
                    if($riga['id_metodo_pagamento']==3){  // CARTA DI CREDITO ?>
                    <br />   
                    Se ancora non hai effettuato il pagamento, puoi sempre farlo cliccando 
                    <a href="http://www.sekurbox.com/conferma_ordine.php?id_ordine=<?php echo $_GET['id_ordine'];?>" > qui</a>    
                    <?php } ?>
                    <br />
                    
                    </p>
                                   <?php if($riga['id_metodo_pagamento']!=3 AND $riga['id_metodo_pagamento']!=2  ){ ?>
					<div id="ricevuta_alert">
						<?php echo $riga['testo_pagamento_ita'];?>
					</div>
                                   <?php  }?>
				</div>
		<?php } ?>   
				<?php
                $query_conferma_ordine = 'SELECT prodotti.id_prodotto, prodotti.url, prodotti.nome_ita, prodotti.nome_eng,
                                                dettaglio_ordine.id_ordine, dettaglio_ordine.quantita, dettaglio_ordine.id_prodotto, dettaglio_ordine.prezzo_def, dettaglio_ordine.sconto
                                                FROM prodotti 
                                                INNER JOIN dettaglio_ordine ON dettaglio_ordine.id_prodotto = prodotti.id_prodotto
                                                WHERE 
                                                dettaglio_ordine.id_ordine = "' . mysql_real_escape_string($_GET['id_ordine']) . '"
                                                ORDER BY
                                                dettaglio_ordine.id_prodotto ASC';	 
                
                $Risultato_ordine = mysql_query($query_conferma_ordine, $db) or die (mysql_error($db));

               // $totale_carrello_sopra = 0;
        
                            $queryli="SELECT *
                                      FROM listini
                                     ";
                            $resultli=mysql_query($queryli) or die(mysql_error());
                            while($listli=  mysql_fetch_assoc($resultli)){
                                if($listli['id_listino']=='6'){ $listinorivenditore=$listli['sconto_listino'];}
                                if($listli['id_listino']=='5'){ $listinoinstallatore=$listli['sconto_listino'];}
                                if($listli['id_listino']=='1'){ $listinoprivato=$listli['sconto_listino'];}
                            }
                
                
                ?>
                <div id="carrello">
                   	<div class="intestazione_tab_carrello">
                        <div class="intestazione_tab_carrello_prodotto"><?php echo $prodotto; ?></div>
                        <div class="intestazione_tab_carrello_prezzo"><?php echo $prezzo_unitario; ?></div>
                        <div class="intestazione_tab_carrello_sconto"><?php echo $sconto; ?></div>
                        <div class="intestazione_tab_carrello_totale"><?php echo $totale; ?></div>
                	</div>
				<?php
                while ($riga_ordine=mysql_fetch_array($Risultato_ordine))
                {	
                    
                 
                    $id_prodotto=$riga_ordine['id_prodotto'];
                    
                    //CONTROLLO SE C'E' UNO SCONTO PRODOTTO CHE ESCLUDE GLI ALTRI
                        $query="SELECT *
                                FROM prodotti 
                                WHERE id_prodotto='".$id_prodotto."' ";
                        $result=mysql_query($query) or die(mysql_error());
                        $list=  mysql_fetch_assoc($result);

                        $prezzo=$list['prezzo'];
                        $sconto_prodotto=$list['sconto'];


                          //SE E' LOGGATO E C'E' LO SCONTO PRODOTTO
                        if ( $sconto_prodotto > 0){
                            $sconto= ($prezzo * $sconto_prodotto) / 100;
                            $prezzo_scontato = $prezzo - $sconto;  

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

                              }

                        }else{  //CLIENTE ATTIVO

                            $prezzo_scontato=$prezzo;
                            $sconto = $prezzo;

                            //CASO CLIENTE RIVENDITORE ATTIVO
                            if($listc['id_tipologia_cliente']==3){

                                $sconto= ($prezzo * $listinorivenditore) / 100;
                                $prezzo_scontato = $prezzo - $sconto;

                            } else if( $listc['id_tipologia_cliente']==2){ //CASO INSTALLATORE ATTIVO

                                if($listc['codice_sconto']!=''){ //SE HA CODICE SCONTO VERIFICO E APPLICO


                                        $querycodice = "SELECT codice_per_installatore 
                                                        FROM clienti WHERE attivo='si' 
                                                        AND codice_per_installatore='".$listc['codice_sconto']."' ";
                                        $resultcodice=mysql_query($querycodice) or die(mysql_error());
                                        if(mysql_num_rows($resultcodice)>0){

                                            $sconto= ($prezzo * $listinoinstallatore) / 100;
                                            $prezzo_scontato = $prezzo - $sconto;

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

                                        } 
                                }

                            }

                         if ( $sconto_cliente > 0){

                                $sconto= ($sconto * $sconto_cliente) / 100;
                                $prezzo_scontato = $prezzo_scontato - $sconto;

                              }          
                        }

                    }  
                    
                   // $totale_carrello_sopra=$totale_carrello_sopra+($prezzo_scontato * $riga_ordine['quantita']);
                    
                    
                ?>
				<div class="carrello_box_prodotto">
					<div class="carrello_prodotto">
						<div class="carrello_prodotto_img"><?php leggi_immagine("images/miniature/prodotti/" . $riga_ordine['id_prodotto'], 60);?></div>
						<div class="carrello_prodotto_titolo">
								<?php if ($lingua=="it") { echo $riga_ordine['nome_ita'];} else { echo $riga_ordine['nome_eng'];}?>
						</div>
					</div>
                                    
<!--                    <div class="carrello_prodotto_prezzo"><?php echo $riga_ordine['quantita'] . " x &euro; " . $riga_ordine['prezzo'];?></div>
						<?php
                        $prezzo_prodotto = $riga_ordine['prezzo'];
                        $percentuale_di_sconto = $riga_ordine['sconto'];
                        $sconto = ($prezzo_prodotto * $percentuale_di_sconto) / 100;
                        $prezzo_scontato = $prezzo_prodotto - $sconto;
                        $totale_prodotto = $riga_ordine['quantita'] * $prezzo_scontato;
                        $totale_ordine_ricevuta = $totale_ordine_ricevuta + $totale_prodotto;
                        ?>
                        <div class="carrello_prodotto_sconto"><?php if ($percentuale_di_sconto > 0) { echo $percentuale_di_sconto . " %";}?></div>
                        <div class="carrello_prodotto_totale"><?php echo "&euro; " . $totale_prodotto;?></div>-->
                        
                       <?php  echo calcolaprezzo_ordine($riga_ordine['id_prodotto'],$_GET['id_ordine']);  ?>
                        
					</div>
	<?php } ?>
                
                <div id="carrello_totale">
                    <div class="carrello_totale_sn">Subtotale</div>
                    <div class="carrello_totale_ds">&euro; <?php echo  number_format($totale_carrello_sopra, 2, ',', '.'); ?></div>
                    <div class="carrello_totale_sn">Spese di spedizione</div>
                    <div class="carrello_totale_ds">&euro; <?php echo  number_format($costo_spesa_spedizione, 2, ',', '.'); ?></div>    
                        <?php if ($costo_metodo_di_pagamento > 0) { ?>
                    <div class="carrello_totale_sn">Spese di contrassegno</div>
                    <div class="carrello_totale_ds">&euro; <?php echo  number_format($costo_metodo_di_pagamento, 2, ',', '.'); ?></div> 								
                    <?php } ?> 
                    <div class="carrello_totale_sn">TOTALE</div>
                    <div class="carrello_totale_ds">
                        &euro; <?php $nuovo_totale =  number_format($totale_carrello_sopra + $costo_spesa_spedizione + $costo_metodo_di_pagamento, 2, ',', '.'); 
                        echo $nuovo_totale; ?>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
</body>
</html>