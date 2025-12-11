<?php 
include 'include/connessione.php';
include "include/lingua.php"; 			
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
include 'include/leggi_immagine.inc.php'; 
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
                    <div id="briciole_di_pane">
                    	<a href="http://www.sekurbox.com/<?php echo $lingua; ?>/index.html">Home Page</a> / <?php echo $carrello; ?>
                    </div>
                </div>
            </div>  
            <div id="titolo_pagina_ds">
				<?php
                               // include 'include/banner-promozionale.php'; 
                                ?>
           </div>           
       </div>      
		<div class="row_content">
				<?php
                    $session = session_id();								 
					$query_carrello_sopra = 'SELECT
					prodotti.id_prodotto, prodotti.url, prodotti.nome_ita, prodotti.nome_eng,
					carrelli_temporanei.session, carrelli_temporanei.id_prodotto, carrelli_temporanei.quantita
					FROM prodotti 
                                        INNER JOIN   carrelli_temporanei ON carrelli_temporanei.id_prodotto = prodotti.id_prodotto
					WHERE 
					session = "' . mysql_real_escape_string($session) . '" 
					GROUP BY prodotti.id_prodotto
					ORDER BY
					carrelli_temporanei.id_prodotto ASC';	
                            
                    $Risultato_carrello_sopra = mysql_query($query_carrello_sopra, $db) or die (mysql_error($db));
                    $numero_articoli = mysql_num_rows($Risultato_carrello_sopra);
                    ?>
                    <div id="carrello">
                        <p><?php if ($numero_articoli==0) {echo $zero_prodotti;} else {echo $hai . " " . $numero_articoli . " " . $prodotti_nel_carrello;}?></p>
                            <div class="intestazione_tab_carrello">
                                <div class="intestazione_tab_carrello_prodotto"><?php echo $prodotto; ?></div>
                                <div class="intestazione_tab_carrello_quantita"><?php echo $quantita_testo; ?></div>
                                <div class="intestazione_tab_carrello_prezzo"><?php echo $prezzo_unitario; ?></div>
                                <div class="intestazione_tab_carrello_sconto"><?php echo $sconto; ?></div>
                                <div class="intestazione_tab_carrello_totale"><?php echo $totale; ?></div>
                                <div class="intestazione_tab_carrello_delete"></div>
                            </div>
                            <?php
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
                            
                            while ($riga_carrello_sopra=mysql_fetch_array($Risultato_carrello_sopra))
                            {
						if ($lingua=="it")
						{
						$myNewString=preg_replace('/[0-9]{4}[a-zA-Z]+/i','', $riga_carrello_sopra['url']); 
						$myNewString=str_replace(' ','-',$myNewString);							
						}
						else
						{
						$myNewString=preg_replace('/[0-9]{4}[a-zA-Z]+/i','', $riga_carrello_sopra['url_eng']); 
						$myNewString=str_replace(' ','-',$myNewString);							
						}
                                                        
							$nome_host = $_SERVER['HTTP_HOST'];
							$nome_pagina = $_SERVER['REQUEST_URI'];
							$redirect = "http://".$nome_host.$nome_pagina;
                                                        $id_prodotto=$riga_carrello_sopra['id_prodotto'];
                                                     
         if(isset($_SESSION['user'])){
        
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

                  //SE NON E' LOGGATO  
                }else{
          
                $query="SELECT *
                        FROM prodotti 
                        WHERE id_prodotto='".$id_prodotto."' ";
                $result=mysql_query($query) or die(mysql_error());
                $list=  mysql_fetch_assoc($result);

                $prezzo=$list['prezzo'];
                $prezzo_scontato = $prezzo;
                

                if ( $list['sconto'] > 0){
                    $sconto = ($prezzo * $list['sconto']) / 100;
                    $prezzo_scontato = $prezzo - $sconto;
                }
 

               }
              // echo  $id_prodotto." - ".$prezzo_scontato." - ".$riga_carrello_sopra['quantita'];

               $totale_carrello_sopra=$totale_carrello_sopra+($prezzo_scontato * $riga_carrello_sopra['quantita']);                                                                         
                                                        
                            ?>
                            <div class="carrello_box_prodotto">
                                <div class="carrello_prodotto">
                                    <div class="carrello_prodotto_img">
										<?php leggi_immagine("images/miniature/prodotti/" . $riga_carrello_sopra['id_prodotto'], 80);?>
                                    </div>
                                    <div class="carrello_prodotto_titolo">
                                        <?php echo "<a href='http://www.sekurbox.com/" . $lingua . "/prodotto". $riga_carrello_sopra['id_prodotto'] . "/" . $myNewString .".html'>"; ?>
                            			<?php if ($lingua=="it") { echo $riga_carrello_sopra['nome_ita'];} else { echo $riga_carrello_sopra['nome_eng'];}?>
                                        </a>
                                    </div>
                                </div>
                                <div class="carrello_prodotto_quantita">
                                <form method="post" action="http://www.sekurbox.com/<?php echo $lingua; ?>/aggiorna-carrello.html">
                                    <input type="hidden" name="id_prodotto" value="<?php echo $riga_carrello_sopra['id_prodotto']; ?>"/>
                                    <input type="hidden" name="redirect" value="<?php echo $url;?>"/>
                                    <input type="text" value="<?php echo $riga_carrello_sopra['quantita'];?>"  class="box_qty" name="quantita" />
                                    <input type="submit" name="submit" value="<?php echo $cambia_quantita;?>" class="cambia_quantita"/>
                                </form> 
                                </div>
                          <?php
                          
                echo calcolaprezzo($riga_carrello_sopra['id_prodotto'],'carrello_principale',$session);      
                ?>
                                
                                
                                
                                <div class="carrello_prodotto_delete"><a href="http://www.sekurbox.com/cancella_prodotto.php?id_prodotto=<?php echo $riga_carrello_sopra['id_prodotto'];?>&session=<?php echo $session;?>&redirect=<?php echo $redirect;?>"><img src="http://www.sekurbox.com/images/delete.png" /></a></div>
                            </div>
                            <?php } ?>
                  
                            <div id="carrello_totale">
                            	                                                                     
                                <div class="carrello_totale_sn"><?php echo $totale_carrello; ?></div>
                                <div class="carrello_totale_ds">&euro; <?php echo number_format($totale_carrello_sopra, 2, ',', '.'); ?></div>
                            </div>
                        <p>
                        <?php echo $testo_contrassegno;?>
                        </p>
                            <div id="carrello_action">
                                <div id="carrello_action_sn"><div id="continua_lo_shopping"><a href="http://www.sekurbox.com/<?php echo $lingua;?>/prodotti.html"><?php echo $continua_shopping; ?></a></div></div>
                                <div id="carrello_action_ds">
									 <?php if ($totale_carrello_sopra > 0) { ?>
                                             <?php if (isset($_SESSION['logged']) && $_SESSION['logged'] == 1) {?>
                                       <div class="vai_alla_cassa">      
                                             	<a href="http://www.sekurbox.com/<?php echo $lingua;?>/cassa-step-2b.html"><?php echo $vai_alla_cassa;?></a>
                                       </div>
                                       <div class="vai_alla_cassa">   
                                                <a href="http://www.sekurbox.com/<?php echo $lingua;?>/salva-preventivo.html">Salva come preventivo</a>
                                       </div>         
                                            <?php } else { ?>
                                            <div class="vai_alla_cassa"> 
                                                <a href="http://www.sekurbox.com/<?php echo $lingua;?>/cassa-step-1.html"><?php echo $vai_alla_cassa;?></a>
                                           </div>     
                                            <?php } ?>
                                    <?php } ?>
                                </div>
                        </div>
                    </div>        	
            </div>
			<?php include 'include/footer.php'; ?>
    </div>
</div>
<div id="freccia_su">
	<a href="/#" class="scrolltotop"><img src="http://www.sekurbox.com/images/freccia_su.png" /></a>
</div>
</body>
</html>        