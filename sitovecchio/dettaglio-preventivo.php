<?php 
include 'include/connessione.php';
require 'include/auth.inc.php';
include "include/lingua.php";
include 'include/leggi_immagine.inc.php'; 	
if ($lingua == "it")
{
$title = "AREA RISERVATA IDM";
$description = "";
}
else
{
$title = "IDM RESTRICTED AREA";
$description = "";
} 
include 'include/head.php';

$id_preventivo = $_GET["id_preventivo"];
	
$query = 'SELECT
          prodotti.id_prodotto, prodotti.url, prodotti.nome_ita, prodotti.nome_eng,
	  dettaglio_preventivo.id_preventivo, dettaglio_preventivo.quantita, dettaglio_preventivo.id_prodotto, dettaglio_preventivo.preventivo_prezzo_def, dettaglio_preventivo.preventivo_sconto_def
	  FROM
	  prodotti
	  JOIN dettaglio_preventivo ON dettaglio_preventivo.id_prodotto = prodotti.id_prodotto
	  WHERE 
	  dettaglio_preventivo.id_preventivo = "' . mysql_real_escape_string($id_preventivo) . '"
	  GROUP BY prodotti.id_prodotto
	  ORDER BY
	  dettaglio_preventivo.id_prodotto ASC';	
					    
$Risultato = mysql_query($query, $db) or die (mysql_error($db));

$queryc="SELECT *
         FROM preventivi
         WHERE id_preventivo='".$id_preventivo."' ";
$resultc=mysql_query($queryc) or die(mysql_error());
$listc=  mysql_fetch_assoc($resultc);
$totalepreven=$listc['totale_preventivo'];

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
                    <div id="briciole_di_pane"><a href="index.php">Home Page</a> / Login</div>
                </div>
            </div>  
            <div id="titolo_pagina_ds">
				<?php include 'include/banner-promozionale.php'; ?>
           </div>           
       </div>      
		<div class="row">
                    <div id="carrello">
<!--                        <p><?php if ($numero_articoli==0) {echo $zero_prodotti;} else {echo $hai . " " . $numero_articoli . " " . $prodotti_nel_carrello;}?></p>-->
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
                            while ($riga_carrello_sopra=mysql_fetch_array($Risultato))
                            {
							if ($lingua=="it")
						{
						$myNewString=preg_replace('/[0-9]{4}[a-zA-Z]+/i','',$riga_carrello_sopra['url']); 
						$myNewString=str_replace(' ','-',$myNewString);							
						}
						else
						{
						$myNewString=preg_replace('/[0-9]{4}[a-zA-Z]+/i','',$riga_carrello_sopra['url_eng']); 
						$myNewString=str_replace(' ','-',$myNewString);							
						}
                                                        
							$nome_host = $_SERVER['HTTP_HOST'];
							$nome_pagina = $_SERVER['REQUEST_URI'];
							$redirect = "http://".$nome_host.$nome_pagina;		
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
<!--                                <form method="post" action="http://www.sekurbox.com/<?php echo $lingua; ?>/aggiorna-carrello.html">
                                    <input type="hidden" name="id_prodotto" value="<?php echo $riga_carrello_sopra['id_prodotto']; ?>"/>
                                    <input type="hidden" name="redirect" value="<?php echo $url;?>"/>
                                    <input type="text" value="<?php echo $riga_carrello_sopra['quantita'];?>"  class="box_qty" name="quantita" />
                                    <input type="submit" name="submit" value="<?php echo $cambia_quantita;?>" class="cambia_quantita"/>
                                </form> -->
                               <?php echo $riga_carrello_sopra['quantita'];?> </div>
                                
                              
                                
<!--                                <div class="carrello_prodotto_prezzo"><?php  echo "&euro; " . $riga_carrello_sopra['preventivo_prezzo_def'];?></div>
                                <?php
                                    $prezzo_carrello_sopra = $riga_carrello_sopra['preventivo_prezzo_def'];
                                    $percentuale_di_sconto_carrello_sopra = $riga_carrello_sopra['preventivo_sconto_def'];
                                    $sconto_carrello_sopra = ($prezzo_carrello_sopra * $percentuale_di_sconto_carrello_sopra) / 100;
                                    $prezzo_scontato_carrello_sopra = $prezzo_carrello_sopra - $sconto_carrello_sopra;
                                    $totale_prodotto_carrello_sopra = $riga_carrello_sopra['quantita'] * $prezzo_scontato_carrello_sopra;
                                    $totale_carrello_sopra = $totale_carrello_sopra + $totale_prodotto_carrello_sopra;
                                ?>
                                <div class="carrello_prodotto_sconto"><?php if ($percentuale_di_sconto_carrello_sopra > 0) { echo $percentuale_di_sconto_carrello_sopra . " %";}?></div>
                                <div class="carrello_prodotto_totale"><?php echo "&euro; " . $totale_prodotto_carrello_sopra;?></div>
                                -->
                                            <?php
                echo calcolaprezzo_preventivo($riga_carrello_sopra['id_prodotto'],$id_preventivo);      
                ?>
                                
                                
<!--                                <div class="carrello_prodotto_delete"><a href="http://www.sekurbox.com/cancella_prodotto.php?id_prodotto=<?php echo $riga_carrello_sopra['id_prodotto'];?>&session=<?php echo $session;?>&redirect=<?php echo $redirect;?>"><img src="http://www.sekurbox.com/images/delete.png" /></a></div>
                        -->    </div>
                            <?php } ?>
                            <div id="carrello_totale">
                                <div class="carrello_totale_sn"><?php echo $totaleprev; ?></div>
                                <div class="carrello_totale_ds">&euro; <?php echo $totalepreven; ?></div>
                            </div>
                        <p>
                        <?php echo $testo_contrassegno;?>
                        </p>
                            <div id="carrello_action">
                                <div id="carrello_action_sn"><div id="continua_lo_shopping"><a href="http://www.sekurbox.com/<?php echo $lingua;?>/index.html"><?php echo $continua_shopping; ?></a></div></div>
                                <div id="carrello_action_ds">
									 <?php if ($totale_carrello_sopra > 0) { ?>
<!--                                        <div id="vai_alla_cassa">
                                             <?php if (isset($_SESSION['logged']) && $_SESSION['logged'] == 1) {?>
                                                <a href="http://www.sekurbox.com/<?php echo $lingua;?>/cassa-step-2b.html"><?php echo $vai_alla_cassa;?></a>
                                                <a href="http://www.sekurbox.com/<?php echo $lingua;?>/salva-preventivo.html">Salva come preventivo</a>
                                            <?php } else { ?>
                                                <a href="http://www.sekurbox.com/<?php echo $lingua;?>/cassa-step-1.html"><?php echo $vai_alla_cassa;?></a>
                                            <?php } ?>
                                        </div>-->
                                    <?php } ?>
                                </div>
                           </div>
                    </div>        	
            </div>
			<?php include 'include/footer.php'; ?>
        </div>                 
    </div>
</div>
<div id="freccia_su">
	<a href="/#" class="scrolltotop"><img src="http://www.sekurbox.com/images/freccia_su.png" /></a>
</div> 
</body>
</html>