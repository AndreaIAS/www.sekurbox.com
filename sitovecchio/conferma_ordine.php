<?php
include 'include/connessione.php';
include "include/lingua.php";
include 'include/leggi_immagine.inc.php';
if ($lingua == "it")
{
$title = "";
$description = "";
}
else
{
$title = "";
$description = "";
} 
include 'include/head.php';

//if(!isset($_SESSION['user'])){ header("Location: http://www.sekurbox.com/".$lingua."/cassa-step-1.html");}

$id_ordine = $_GET['id_ordine'];

$query= "SELECT email_inviata FROM ordini WHERE id_ordine = '" . mysql_real_escape_string($id_ordine) . "'";
//echo $id_ordine;
$Risultato = mysql_query($query, $db) or (mysql_error($db));
$riga = mysql_fetch_assoc($Risultato);
extract($riga);
$email_inviata = $riga['email_inviata'];
//if ($email_inviata==0)
//{
	if (isset($_SESSION['email'])){$email = $_SESSION['email'];}
	else{
                $query= "SELECT 
                         clienti.id_cliente, clienti.email,
                         ordini.id_ordine, ordini.id_cliente
                         FROM ordini 
                         JOIN clienti ON clienti.id_cliente = ordini.id_cliente
                         WHERE ordini.id_ordine = '" . mysql_real_escape_string($id_ordine) . "'";
                $Risultato = mysql_query($query, $db) or (mysql_error($db));
                $riga = mysql_fetch_assoc($Risultato);
                extract($riga);
                $email = $riga['email'];							
	}
        
	$template_email = file_get_contents("http://www.sekurbox.com/template-email.php?id_ordine=".$id_ordine."&lingua=".$lingua);
	require "class/class.phpmailer.php";
	//istanziamo la classe
	$messaggio = new PHPmailer();
	$messaggio->IsHTML(true);
	//$messaggio->Host='Host SMTP';
	//definiamo le intestazioni e il corpo del messaggio
	$messaggio->From='info@sekurbox.com';
	$messaggio->FromName = "Sekurbox";
	$messaggio->AddAddress($email);
        //$messaggio->AddAddress('clapton_ci@yahoo.it');

	$messaggio->Subject='Conferma ordine';
	$messaggio->Body=$template_email;
	//$messaggio->AddAttachment('http://www.sekurbox.com/css/stile.css'); // attach style sheet
	
	//definiamo i comportamenti in caso di invio corretto 
	//o di errore
	if(!$messaggio->Send()){ 
	  echo $messaggio->ErrorInfo; 
	}else{ 
              $messaggio_email = 'Una email con il riepilogo dell\'ordine &egrave; stata inviata all\'indirizzo email ' . $email;
              $query = 'UPDATE ordini
                        SET
                        email_inviata = 1
                        WHERE
                        id_ordine = ' . $id_ordine;
             mysql_query($query, $db) or (mysql_error($db));
	}
	//chiudiamo la connessione
	//$messaggio->SmtpClose();
	unset($messaggio);
//}
?>
<head>
<body>
<div id="contenuto">
	<div id="contenuto2">
    	<div id="top">
			<?php include 'include/top.php'; ?>
        </div>
        <div id="testata">
			<?php include 'include/testata.php'; ?>
        </div>
		<div class="row_top">
        	<div id="titolo_pagina_sn">
                <div id="titolo_pagina">
                    <div id="stile_titolo_pagina"><?php echo $carrello;?></div>
                    <div id="briciole_di_pane"><a href="index.php">Home Page</a> / <?php echo $carrello;?></div>
                </div>
            </div>  
            <div id="titolo_pagina_ds">
				<?php include 'include/banner-promozionale.php'; ?>
           </div>           
       </div>      
		<div class="row_content">
                    <div class="box_step_cassa">
                        <div class="box_step_cassa_spento"><?php echo $step_1;?></div>
                        <div class="box_step_cassa_spento"><?php echo $step_2;?></div>
                        <div class="box_step_cassa_acceso"><?php echo $step_3;?></div>
                  </div>  
                    
                         <?php
                         
                        $query = "SELECT 
                                  ordini.*,
                                  spese_di_spedizione.*,
                                  metodi_di_pagamento.*
                                  FROM ordini 
                                  INNER JOIN spese_di_spedizione ON spese_di_spedizione.id_spesa_di_spedizione = ordini.id_spesa_di_spedizione
                                  INNER JOIN metodi_di_pagamento ON metodi_di_pagamento.id_metodo_pagamento = ordini.id_metodo_pagamento
                                  WHERE ordini.id_ordine = '" . mysql_real_escape_string($id_ordine) . "'";
                        
                        $Risultato = mysql_query($query, $db) or die (mysql_error($db));
                        
			while ($riga=mysql_fetch_array($Risultato)){
                            
                            
                                $costo_spesa_spedizione = 	$riga['costo_spesa_spedizione'];
                                $costo_metodo_di_pagamento = $riga['costo_metodo_di_pagamento'];							
                        ?>
                        	<div id="ricevuta">
                    			<h2>Conferma dell'ordine</h2>
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
                                </p>
                                
                                <?php if($riga['id_metodo_pagamento']==3){  // CARTA DI CREDITO
                                    
  
                               require_once "GestPayCrypt.inc.php";
                               $crypt = new GestPayCrypt();
                               // impostare i seguenti parametri
                               $crypt->SetShopLogin('9091587');
                               $crypt->SetShopTransactionID($id_ordine); // Identificativo transazione. Es. "34az85ord19"
                               $crypt->SetAmount(number_format($riga['totale'], 2, '.', '')); // Importo. Es.: 1256.50
                               $crypt->SetCurrency("242"); // Codice valuta. 242 = euro

                               if (!$crypt->Encrypt()) {
                                die("Errore: ".$crypt->GetErrorCode().": ".$crypt->GetErrorDescription()."\n");
                               }

                               ?>
                                

                               <form id="inviadati" action="https://ecomm.sella.it/gestpay/pagam.asp">
                               <input type="hidden" name="a" value="<?=$crypt->GetShopLogin();?>" />
                               <input type="hidden" name="b" value="<?=$crypt->GetEncryptedString();?>" />
                               <input type="image" src="http://www.sekurbox.com/images/pagaadessoconcarta.jpg" />
                               </form>
                                    
                             <?php       
                                    
                                }else if($riga['id_metodo_pagamento']==2){    // PAYPAL ?>
                                    
                                <form name="go_paypal" id="go_paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                                <input type="hidden" name="cmd" value="_ext-enter" />
                                <input type="hidden" name="redirect_cmd" value="_xclick" />
                                <input type="hidden" name="email" value="<?=$email;?>" />
                                <input type="hidden" name="business" value="" />
                                <input type="hidden" name="receiver_email" value="info@sekurbox.com" />
                                <input type="hidden" name="item_name" value="Pagamento ordine n. <?=$id_ordine;?>" />
                                <input type="hidden" name="item_number" value="<?=$id_ordine;?>" />
                                <input type="hidden" name="amount" value="<?=$number_format($riga['totale'], 2, '.', '');?>" />
                                <input type="hidden" name="quantity" value="1" />
                                <input type="hidden" name="currency_code" value="EUR" />
                                <input type="hidden" name="return" value="http://www.sekurbox.com/<?php echo $lingua;?>/ordini.html" />
                                <input type="hidden" name="cancel_return" value="http://www.sekurbox.com/<?php echo $lingua;?>/index.html" />
                                <input type="hidden" name="notify_url" value="http://www.sekurbox.com/paypal.php" />
                                <input type="hidden" name="no_shipping" value="1" />
                                <input type="hidden" name="no_note" value="1" />
                                </form>  
                                <p><a href="#" onClick="document.go_paypal.submit();">
                                        <img src="http://www.sekurbox.com/images/paga_adesso.jpg" align="absmiddle" border="0" />
                                   </a>
                                </p>    
                                    
                                <?php } else{ ?>
                                    
                                  <div id="ricevuta_alert">
                                  <?php echo $riga['testo_pagamento_ita'];?>
                                  </div>
                                
                               <?php } ?>
                                
                                
                                
                                
                                
                                <br /><br />
                                <div >
                                <?php echo $messaggio_email;?>
                                </div>
							</div>
                        <?php } ?>   
                    
		      <?php
                      $query_conferma_ordine = 'SELECT prodotti.id_prodotto, prodotti.url, prodotti.nome_ita, prodotti.nome_eng,
                                                dettaglio_ordine.id_ordine, dettaglio_ordine.quantita, dettaglio_ordine.id_prodotto, dettaglio_ordine.prezzo_def, dettaglio_ordine.sconto
                                                FROM prodotti 
                                                INNER JOIN dettaglio_ordine ON dettaglio_ordine.id_prodotto = prodotti.id_prodotto
                                                WHERE 
                                                dettaglio_ordine.id_ordine = "' . mysql_real_escape_string($id_ordine) . '"
                                                ORDER BY
                                                dettaglio_ordine.id_prodotto ASC';
                        //echo $query_conferma_ordine;
                        $Risultato_ordine = mysql_query($query_conferma_ordine, $db) or die (mysql_error($db));
                        ?>
                        <div id="carrello_ricevuta">
                            <div class="intestazione_tab_carrello">
                                <div class="intestazione_tab_carrello_prodotto"><?php echo $prodotto; ?></div>
                                <div class="intestazione_tab_carrello_prezzo"><?php echo $prezzo_unitario; ?></div>
                                <div class="intestazione_tab_carrello_sconto"><?php echo $sconto; ?></div>
                                <div class="intestazione_tab_carrello_totale"><?php echo $totale; ?></div>
                            </div>
                            <?php
                             $totale_ordine_ricevuta = 0;
                             
                             $totale_carrello_sopra = 0;
        
                            $queryli="SELECT *
                                      FROM listini
                                     ";
                            $resultli=mysql_query($queryli) or die(mysql_error());
                            while($listli=  mysql_fetch_assoc($resultli)){
                                if($listli['id_listino']=='6'){ $listinorivenditore=$listli['sconto_listino'];}
                                if($listli['id_listino']=='5'){ $listinoinstallatore=$listli['sconto_listino'];}
                                if($listli['id_listino']=='1'){ $listinoprivato=$listli['sconto_listino'];}
                            }
                             
                            while ($riga_ordine=mysql_fetch_array($Risultato_ordine))
                            {
                                $myNewString=preg_replace('/[^a-z\x20-]+/i','',$riga_ordine['url']); 
                                $myNewString=str_replace(' ','-',$myNewString);	

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

                                $sconto= ($prezzo_scontato * $sconto_cliente) / 100;
                                $prezzo_scontato = $prezzo_scontato - $sconto;

                              }          
                        }

                    }  
                    
                    $totale_carrello_sopra=$totale_carrello_sopra+($prezzo_scontato * $riga_ordine['quantita']);  
               
                                
                                
                                
                            ?>
                            <div class="carrello_box_prodotto">
                                <div class="carrello_prodotto">
                                    <div class="carrello_prodotto_img"><?php leggi_immagine("images/miniature/prodotti/" . $riga_ordine['id_prodotto'], 60);?></div>
                                    <div class="carrello_prodotto_titolo">
                                        <?php echo "<a href='http://www.sekurbox.com/" . $lingua . "/". $riga_ordine['id_prodotto'] . "/" . $myNewString .".html'>"; ?>
                                        	<?php if ($lingua=="it") { echo $riga_ordine['nome_ita'];} else { echo $riga_ordine['nome_eng'];}?>
                                            </a>
                                    </div>
                                </div>
                                
                                
<!--                                <div class="carrello_prodotto_prezzo"><?php echo $riga_ordine['quantita'] . " x &euro; " . $riga_ordine['prezzo_def'];?></div>
                                <?php
                                   
				     $prezzo_prodotto = $riga_ordine['prezzo_def'];
                                    $percentuale_di_sconto = $riga_ordine['sconto'];
                                    $sconto = ($prezzo_prodotto * $percentuale_di_sconto) / 100;
                                    $prezzo_scontato = $prezzo_prodotto - $sconto;
                                    $totale_prodotto = $riga_ordine['quantita'] * $prezzo_scontato;
                                    $totale_ordine_ricevuta = $totale_ordine_ricevuta + $totale_prodotto;
                                ?>
                                <div class="carrello_prodotto_sconto"><?php if ($percentuale_di_sconto > 0) { echo $percentuale_di_sconto . " %";}?></div>
                                <div class="carrello_prodotto_totale"><?php echo "&euro; " . number_format($totale_prodotto, 2, ',', '.');?></div>-->
                                               <?php
                echo calcolaprezzo_ordine($riga_ordine['id_prodotto'],$id_ordine);      
                ?>
                                
                            </div>
                            
                            
             <?php } ?>
                            
                            
                            
                            <div id="carrello_totale">
                                <div class="carrello_totale_sn">Subtotale</div>
                                <div class="carrello_totale_ds">&euro; <?php echo number_format($totale_carrello_sopra, 2, ',', '.'); ?></div>
                                <div class="carrello_totale_sn">Spese di spedizione</div>
                                <div class="carrello_totale_ds">&euro; <?php echo number_format($costo_spesa_spedizione, 2, ',', '.'); ?></div>    
                                <?php if ($costo_metodo_di_pagamento > 0) { ?>
                                <div class="carrello_totale_sn">Spese di contrassegno</div>
                                <div class="carrello_totale_ds">&euro; <?php echo number_format($costo_metodo_di_pagamento, 2, ',', '.'); ?></div> 								
								<?php } ?> 
                                <div class="carrello_totale_sn">TOTALE</div>
                                <div class="carrello_totale_ds">
                                	&euro; <?php $nuovo_totale = $totale_carrello_sopra + $costo_spesa_spedizione + $costo_metodo_di_pagamento; 
									echo number_format($nuovo_totale, 2, ',', '.'); ?>
                                </div>
                           </div>
                            
                     <div id="carrello_action_sn"><div id="continua_lo_shopping"><a href="http://www.sekurbox.com/<?php echo $lingua;?>/prodotti.html"><?php echo $continua_shopping; ?></a></div></div>       
                    </div> 
	        
           </div>
        <div class="row">
			<?php include 'include/footer.php'; ?>
        </div>                 
    </div>
</div>
<div id="freccia_su">
	<a href="/#" class="scrolltotop"><img src="http://www.sekurbox.com/images/freccia_su.png" /></a>
</div> 
</body>
</html>                   	

                   
                           	