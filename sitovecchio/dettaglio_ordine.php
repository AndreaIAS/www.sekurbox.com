<?php 
include 'include/connessione.php';
require 'include/auth.inc.php';
include "include/lingua.php";
include 'include/leggi_immagine.inc.php'; 	


if ($lingua == "it")
{
$title = "AREA RISERVATA SEKURBOX";
$description = "";
}
else
{
$title = "SEKURBOX RESTRICTED AREA";
$description = "";
} 
include 'include/head.php';



function calcolaprezzo_dettordine($id_prodotto,$id_ordine){

                $querytemp = "SELECT * FROM dettaglio_ordine WHERE id_prodotto = '".$id_prodotto."' AND id_ordine='".$id_ordine."' ";
		$resulttemp=mysql_query($querytemp) or die(mysql_error());
                $listtemp=  mysql_fetch_assoc($resulttemp);
                $quantita=$listtemp['quantita'];
                $prezzo=$listtemp['prezzo_def'];
                $sconto_prodotto=$listtemp['sconto'];
              
                $testo_carrello_sopra='<td>'.$quantita . " x &euro; " . number_format($prezzo, 2, ',', '.').'</td>';
                $testo_carrello_sopra.='<td>';
              
              

        
        //SE E' LOGGATO E C'E' LO SCONTO PRODOTTO
        if ( $sconto_prodotto > 0){
            
            $sconto= ($prezzo * $sconto_prodotto) / 100;
            $prezzo_scontato = $prezzo - $sconto;
      
                $prezzo_scontato_sop=$prezzo_scontato*$quantita;
                $testo_carrello_sopra.=$sconto_prodotto . ' %</td>';
                $testo_carrello_sopra.='<td>&euro; '  .number_format($prezzo_scontato_sop, 2, ',', '.').'</td>';
       
        } 
        /////////////////////////////////////////////////////////
        //SE E' LOGGATO E NON C'E' LO SCONTO PRODOTTO
        else{
            $oksconto=0;
            
            $prezzo_scontato = $prezzo;
            $sconto=$prezzo;
            
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
             if($sconto_listino>0)  { $testo_carrello_sopra.=' + '.$sconto_cliente.'%</td>';  }
             else{ $testo_carrello_sopra.= $sconto_cliente.'%</td>';}
            
             $oksconto=1;
            }
            
         
          
          
             if($oksconto==1){  
                    
                  $testo_carrello_sopra.='<td>&euro; '  .number_format($prezzo_scontato*$quantita, 2, ',', '.').'</td>';
             
                }
             
             else{
                    
                  $testo_carrello_sopra.='<td>&euro; '  .number_format($prezzo*$quantita, 2, ',', '.').'</td>';
         
             }
  } 
    return $testo_carrello_sopra; 
   
}


$id_ordine = $_GET["id_ordine"];
	
$query = 'SELECT prodotti.id_prodotto, prodotti.url, prodotti.nome_ita, prodotti.nome_eng,
            dettaglio_ordine.id_ordine, dettaglio_ordine.quantita, dettaglio_ordine.id_prodotto, dettaglio_ordine.prezzo_def, dettaglio_ordine.sconto
            FROM prodotti 
            INNER JOIN dettaglio_ordine ON dettaglio_ordine.id_prodotto = prodotti.id_prodotto
            WHERE 
            dettaglio_ordine.id_ordine = "' . mysql_real_escape_string($id_ordine) . '"
            ORDER BY
            dettaglio_ordine.id_prodotto ASC';	

//echo $query ;
					    
$Risultato = mysql_query($query, $db) or die (mysql_error($db));

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
                    <div id="stile_titolo_pagina">Login</div>
                    <div id="briciole_di_pane"><a href="http://www.sekurbox.com/<?php echo $lingua; ?>/index.html">Home Page</a> / Login</div>
                </div>
            </div>  
            <div id="titolo_pagina_ds">
				<?php include 'include/banner-promozionale.php'; ?>
           </div>           
       </div>      
		<div class="row">
        	<div id="colonna_sn">
                <ul class="menu_laterale_case">
                    <?php $pagina="login"; include 'include/menu-sn.php';?>      	
                </ul>            
            </div>
            <div id="colonna_ds">               
                    <h2>I tuoi ordini</h2>           
                   <table class="stile_tabella">                        
                        <thead>
                            <tr>
                            	<th class='titolotabella'></th>
                                <th class='titolotabella'><?php echo $prodotto; ?></th>
                                <th class='titolotabella'><?php echo $prezzo_unitario; ?></th>
                                <th class='titolotabella'><?php echo $sconto; ?></th>
                                <th class='titolotabella'><?php echo $totale; ?></th>
                            </tr>
                        </thead>
                        <tbody>
						<?php
							$odd = true;
							while ($riga=mysql_fetch_array($Risultato))
			 				{
                         if ($lingua=="it")
						{
						$myNewString=preg_replace('/[0-9]{4}[a-zA-Z]+/i','',$riga['url']); 
						$myNewString=str_replace(' ','-',$myNewString);							
						}
						else
						{
						$myNewString=preg_replace('/[0-9]{4}[a-zA-Z]+/i','',$riga['url_eng']); 
						$myNewString=str_replace(' ','-',$myNewString);							
						}								
								if ($odd) {
								echo "<tr class='odd'>";
								} else {
								echo "<tr class='even'>";
								}	
							?>
                                    <td>
				   <?php leggi_immagine("images/miniature/prodotti/" . $riga['id_prodotto'], 60);?>
                                    </td>
                                    <td>
                                    <?php echo "<a href='http://www.sekurbox.com/" . $lingua . "/prodotto". $riga['id_prodotto'] . "/" . $myNewString .".html'>"; ?>
                                        	<?php if ($lingua=="it") { echo $riga['nome_ita']; } else { echo $riga['nome_eng'];}?></a>
                                    </td>

                                    <?php  echo calcolaprezzo_dettordine($riga['id_prodotto'],$id_ordine);  ?>
                               </tr>
                              <?php $odd = !$odd; }?>                              
                            </tbody>
                        </table>
						<?php
							$Risultato_ordine=mysql_query("SELECT 
																clienti.id_cliente, clienti.email,
																ordini.*,
																province.*,
																nazioni.*,
																spese_di_spedizione.*,
													   			metodi_di_pagamento.*
																FROM ordini 
																JOIN clienti ON clienti.id_cliente = ordini.id_cliente
																LEFT JOIN province ON province.id = ordini.id_provincia_spedizione
																LEFT JOIN nazioni ON nazioni.ID = ordini.id_nazione_spedizione
																LEFT JOIN spese_di_spedizione ON spese_di_spedizione.id_spesa_di_spedizione = ordini.id_spesa_di_spedizione
																LEFT JOIN metodi_di_pagamento ON metodi_di_pagamento.id_metodo_pagamento = ordini.id_metodo_pagamento
																WHERE clienti.email = '" . mysql_real_escape_string($_SESSION['email']) . "' AND ordini.id_ordine = '" . mysql_real_escape_string($id_ordine) . "' ORDER BY data_ordine DESC", $db);
							while ($riga_ordine=mysql_fetch_array($Risultato_ordine))
                            {								
                        ?>   
                        <ul class="dati_utente">
                        	<li><strong>Id ordine: </strong> <?php echo $riga_ordine['id_ordine'];?></li>
                        	<li><strong>Data ordine: </strong><?php $data_ordine = date("d-m-Y", strtotime($riga_ordine['data_ordine'])); echo $data_ordine;?></li>
                        	<li><strong>Subtotale: </strong> <?php echo $riga_ordine['subtotale'];?></li>
                            <li><strong>Spedito con: </strong><br /> <?php echo $riga_ordine['nome_spesa_di_spedizione_ita'] . '&nbsp;(&euro; ' . $riga_ordine['costo_spesa_spedizione'] . ")";?></li>
                            <li><strong>Pagato con: </strong><br /> <?php echo $riga_ordine['nome_pagamento_ita'] . '&nbsp;(&euro; ' . $riga_ordine['costo_metodo_di_pagamento'] . ')';?></li>
                        	<li><strong>Totale: </strong> <?php echo $riga_ordine['totale'];?></li>
                            <?php if ($riga_ordine['note_per_il_corriere'] =="") { echo "";} else { echo "<li><strong>Note per il corriere: </strong><br />" . $riga_ordine['note_per_il_corriere'] . "</li>";}?>
                        </ul>
                        <ul class="dati_utente">
                        	<?php if ($riga_ordine['nome_spedizione'] =="") { echo "";} else { echo "<li><strong>Nome dell'altro destinatario: </strong><br />" . $riga_ordine['nome_spedizione'] . "</li>";}?>
                        	<?php if ($riga_ordine['cognome_spedizione'] =="") { echo "";} else { echo "<li><strong>Cognome dell'altro destinatario: </strong><br />" . $riga_ordine['cognome_spedizione'] . "</li>";}?>
                            <?php if ($riga_ordine['indirizzo_spedizione'] =="") { echo "";} else { echo "<li><strong>Indirizzo dell'altro destinatario: </strong><br />" . $riga_ordine['indirizzo_spedizione'] . "</li>";}?>
                           <?php if ($riga_ordine['id_nazione_spedizione'] =="" or $riga_ordine['id_nazione_spedizione'] ==0) { echo "";} else { echo "<li><strong>Nazione dell'altro destinatario: </strong><br />" . $riga_ordine['Nazione'] . "</li>";}?> 
                           <?php if ($riga_ordine['id_provincia_spedizione'] =="" or $riga_ordine['id_provincia_spedizione'] ==0) { echo "";} else { echo "<li><strong>Provincia dell'altro destinatario: </strong><br />" . $riga_ordine['provincia'] . "</li>";}?>
                        	<?php if ($riga_ordine['citta_spedizione'] =="") { echo "";} else { echo "<li><strong>Citt&agrave; dell'altro destinatario: </strong><br />" . $riga_ordine['citta_spedizione'] . "</li>";}?>
                            <?php if ($riga_ordine['cap_spedizione'] =="") { echo "";} else { echo "<li><strong>Cap dell'altro destinatario: </strong><br />" . $riga_ordine['cap_spedizione'] . "</li>";}?>
                            <?php if ($riga_ordine['telefono_fisso_spedizione'] =="") { echo "";} else { echo "<li><strong>Telefono fisso dell'altro destinatario: </strong><br />" . $riga_ordine['telefono_fisso_spedizione'] . "</li>";}?>
                           <?php if ($riga_ordine['telefono_fisso_spedizione'] =="") { echo "";} else { echo "<li><strong>Cellulare dell'altro destinatario: </strong><br />" . $riga_ordine['telefono_cellulare_spedizione'] . "</li>";}?>
                        </ul>                        
					<?php } ?>                
                        <p><a href="http://www.sekurbox.com/<?php echo $lingua;?>/ordini.html">Mostrami tutti gli ordini</a></p>
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