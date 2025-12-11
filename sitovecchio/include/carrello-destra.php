<div>
<?php
$session = session_id();								 
$query_carrello_sopra = 'SELECT
                prodotti.id_prodotto, prodotti.url, prodotti.nome_ita, prodotti.nome_eng,
		carrelli_temporanei.session, carrelli_temporanei.id_prodotto, carrelli_temporanei.quantita
		FROM prodotti
		JOIN carrelli_temporanei ON carrelli_temporanei.id_prodotto = prodotti.id_prodotto
		WHERE 
		session = "' . mysql_real_escape_string($session) . '" 
		GROUP BY prodotti.id_prodotto
		ORDER BY
		carrelli_temporanei.id_prodotto ASC';	
		
$Risultato_carrello_sopra = mysql_query($query_carrello_sopra, $db) or die (mysql_error($db));
$numero_articoli = mysql_num_rows($Risultato_carrello_sopra);
$nome_host = $_SERVER['HTTP_HOST'];
$nome_pagina = $_SERVER['REQUEST_URI'];

?>	

        
            <div class="intesta_table_cart">
                <div class="intesta_table_cart_prodotto"><?php echo $prodotto;?></div>
                <div class="intesta_table_cart_prezzo"><?php echo $prezzo_unitario;?></div>
                <div class="intesta_table_cart_sconto"><?php echo $sconto;?></div>
                <div class="intesta_table_cart_totale"><?php echo $totale;?></div>
                <div class="intesta_table_cart_delete"></div>
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
                $myNewString=preg_replace('/[^a-z\x20-]+/i','',$riga_carrello_sopra['url']); 
                $myNewString=str_replace(' ','-',$myNewString);
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
            
            ////////////////////////////////////////////////////////////////
        
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
            <div class="cart_open_prodotto_box">
                <div class="cart_open_prodotto">
                    <div class="cart_open_prodotto_img">
						<?php leggi_immagine("images/miniature/prodotti/" . $riga_carrello_sopra['id_prodotto'], 40);?>
					</div>
                    <div class="cart_open_prodotto_titolo">
                        <?php echo "<a href='http://www.sekurbox.com/" . $lingua . "/". $riga_carrello_sopra['id_prodotto'] . "/" . $myNewString .".html'>"; ?>
                            <?php if ($lingua=="it") { echo $riga_carrello_sopra['nome_ita'];} else { echo $riga_carrello_sopra['nome_eng'];}?>
                        </a>
                    </div>
                </div>

                <?php
                echo calcolaprezzo($riga_carrello_sopra['id_prodotto'],'carrello_sopra',$session);      
                ?>
       
                <div class="cart_open_prodotto_delete"><a href="http://www.sekurbox.com/cancella_prodotto.php?id_prodotto=<?php echo $riga_carrello_sopra['id_prodotto'];?>&session=<?php echo $session;?>&redirect=<?php echo $redirect;?>"><img src="http://www.sekurbox.com/images/delete.png" /></a></div>
            </div>
   
            
            <?php  } ?>
            
            <div id="total_cart">
              
                <div class="total_cart_sn"><?php echo $totale_carrello;?></div>
                <div class="total_cart_ds">&euro; <?php echo number_format($totale_carrello_sopra, 2, ',', '.'); ?></div>
            </div>
    
</div>