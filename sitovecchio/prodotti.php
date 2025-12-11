<?php 
//error_reporting(E_ALL); ini_set('display_errors', '1');
include 'include/connessione.php';
include "include/lingua.php"; 
include 'include/leggi_immagine.inc.php';
			
if ($lingua == "it")
{
$title = "E-commerce multilevel";
$description = "Scopri tutti i nostri prodotti e le nostre offerte sulla domotica, sicurezza, TVCC e sulla fibra ottica plastica";
}
else
{
$title = "E-commerce multilevel";
$description = "Discover all our products and our offers on home automation, security, CCTV and plastic optical fiber";
} 

include 'include/head.php'; 
include 'include/trim.inc.php';
$titolo_pagina = $prodotti;

// Se la variabile id_sezione � definita allora avvio la query nella tabella Sezioni
if (isset($_GET['id_sezione']))
{
	$id_sezione = $_GET['id_sezione'];
	$Risultato_sezioni=mysql_query("SELECT * FROM sezioni_prodotti WHERE id_sezione = '" . $id_sezione . "'", $db);
	if (!$Risultato_sezioni)
	{
	die ("La tabella selezionata non esiste" . mysql_error());
	}
	$riga_sezioni=mysql_fetch_array($Risultato_sezioni);
	if ($lingua=="it") {$titolo_pagina = $riga_sezioni['nome_sezione_ita'];} else 	{$titolo_pagina = $riga_sezioni['nome_sezione_eng'];}
	if ($lingua=="it") {$nome_sezione_briciole = $riga_sezioni['nome_sezione_ita'];} else {$nome_sezione_briciole = $riga_sezioni['nome_sezione_eng'];}
}
// Se la variabile id_categoria è definita allora avvio la query nella tabella categorie
if (isset($_GET['id_categoria']))
{
	$id_categoria = $_GET['id_categoria'];
	$Risultato_categorie=mysql_query("SELECT * FROM categorie_prodotti WHERE id_categoria = '" . $id_categoria . "'", $db);
	if (!$Risultato_categorie)
	{
	die ("La tabella selezionata non esiste" . mysql_error());
	}
	$riga_categorie=mysql_fetch_array($Risultato_categorie);
	if ($lingua=="it") {$titolo_pagina = $riga_categorie['categoria_ita'];} else {$titolo_pagina = $riga_categorie['categoria_eng'];}
	if ($lingua=="it") {$nome_categoria_briciole = $riga_categorie['categoria_ita'];} else {$nome_categoria_briciole = $riga_categorie['categoria_eng'];}
}


// Se la variabile id_sottocategoria � definita allora avvio la query nella tabella sottocategorie
if (isset($_GET['id_sottocategoria']))
{
	$id_sottocategoria = $_GET['id_sottocategoria'];
	$Risultato_sottocategorie=mysql_query("SELECT * FROM sottocategorie_prodotti WHERE id_sottocategoria = '" . $id_sottocategoria . "'", $db);
	if (!$Risultato_sottocategorie)
	{
	die ("La tabella selezionata non esiste" . mysql_error());
	}
	$riga_sottocategorie=mysql_fetch_array($Risultato_sottocategorie);
	if ($lingua=="it") {$titolo_pagina = $riga_sottocategorie['sottocategoria_ita'];} else {$titolo_pagina = $riga_sottocategorie['sottocategoria_eng'];}
	if ($lingua=="it") {$nome_categoria_briciole = $riga_sottocategorie['sottocategoria_ita'];} else {$nome_categoria_briciole = $riga_categorie['sottocategoria_eng'];}
}


// Se la variabile id_sezione e id_categoria e id_sottocategoria sono definite entrambe eseguo questa query
if (isset($_GET['id_categoria']) and isset($_GET['id_sezione']) and isset($_GET['id_sottocategoria']))
{
// SE IL CLIENTE E' PUGLIESE	
if($_SESSION['id_regione'] == 16)
{
$Risultato=mysql_query("SELECT 
                         p.*, ssp.*  
                         FROM prodotti AS p
                         INNER JOIN sezioni_sottocategorie_prodotti AS ssp ON ssp.id_prodotto = p.id_prodotto AND ssp.id_sottocategoria = '" . mysql_real_escape_string($id_sottocategoria) . "' 
                         WHERE p.visible = '1'
                         GROUP BY p.id_prodotto ORDER BY p.posizione ASC", $db);
}
else
{
// TUTTI GLI ALTRI			
$Risultato=mysql_query("SELECT 
                         p.*, ssp.* 
                         FROM prodotti AS p
                         INNER JOIN sezioni_sottocategorie_prodotti AS ssp ON ssp.id_prodotto = p.id_prodotto AND ssp.id_sottocategoria = '" . mysql_real_escape_string($id_sottocategoria) . "'
                         WHERE p.visible = '1' AND p.puglia ='0'
                         GROUP BY p.id_prodotto ORDER BY p.posizione ASC", $db);

}						
	if (!$Risultato)
	{
	die ("La tabella selezionata non esiste" . mysql_error());
	}
}

// Se la variabile id_sezione e id_categoria sono definite entrambe eseguo questa query
else if (isset($_GET['id_categoria']) and isset($_GET['id_sezione']) )
{
// SE IL CLIENTE E' PUGLIESE	
if($_SESSION['id_regione'] == 16)
{
$Risultato=mysql_query("SELECT 
                         p.*, scp.* 
                         FROM prodotti AS p
                         INNER JOIN sezioni_categorie_prodotti AS scp ON scp.id_prodotto = p.id_prodotto AND scp.id_categoria = '" . mysql_real_escape_string($id_categoria) . "'
                         WHERE p.visible = '1'
                         GROUP BY p.id_prodotto ORDER BY p.posizione ASC", $db);
}
else
{
// TUTTI GLI ALTRI			
$Risultato=mysql_query("SELECT 
                         p.*, scp.*  
                         FROM prodotti AS p
                         INNER JOIN sezioni_categorie_prodotti AS scp ON scp.id_prodotto = p.id_prodotto AND scp.id_categoria = '" . mysql_real_escape_string($id_categoria) . "'
                         WHERE p.visible = '1' AND p.puglia ='0'
                         GROUP BY p.id_prodotto ORDER BY p.posizione ASC", $db);

}						
	if (!$Risultato)
	{
	die ("La tabella selezionata non esiste" . mysql_error());
	}
}
//Solo se � definita id_sezione
else if (isset($_GET['id_sezione']))
{
// SE IL CLIENTE E' PUGLIESE	
if($_SESSION['id_regione'] == 16)
{	
$query="SELECT 
			 p.*, scp.*, cp.* 
			 FROM prodotti AS p
			 INNER JOIN categorie_prodotti AS cp ON cp.id_sezione = '" . mysql_real_escape_string($id_sezione) . "' 
			 INNER JOIN sezioni_categorie_prodotti AS scp ON scp.id_prodotto = p.id_prodotto AND scp.id_categoria = cp.id_categoria
			 WHERE p.visible = '1'
			 GROUP BY p.id_prodotto ORDER BY p.posizione ASC";
}
else
{
// TUTTI GLI ALTRI				
	$query="SELECT 
                 p.*, scp.*, cp.*  
                 FROM prodotti AS p
                 INNER JOIN categorie_prodotti AS cp ON cp.id_sezione = '" . mysql_real_escape_string($id_sezione) . "' 
                 INNER JOIN sezioni_categorie_prodotti AS scp ON scp.id_prodotto = p.id_prodotto AND scp.id_categoria = cp.id_categoria
                 WHERE p.visible = '1' AND p.puglia ='0'
                 GROUP BY p.id_prodotto ORDER BY p.posizione ASC";
}
$Risultato = mysql_query($query, $db) or die(mysql_error($db));
}
//Se la variabile cerca_prodotto � definita
else if (isset($_POST['cerca_prodotto']))
{
// SE IL CLIENTE E' PUGLIESE	
if($_SESSION['id_regione'] == 16)
{	
	$query="SELECT p.*  
			 FROM prodotti AS p
			  WHERE MATCH(p.codice, p.nome_ita, p.nome_eng, p.descrizione_ita, p.descrizione_eng, p.descrizione_capitolato_ita, p.descrizione_capitolato_eng) AGAINST ('" . $_POST['cerca_prodotto'] . "' IN BOOLEAN MODE) AND p.visible='1'";
}
else
{
// TUTTI GLI ALTRI					
$query="SELECT p.* 
         FROM prodotti AS p  
          WHERE MATCH(p.codice, p.nome_ita, p.nome_eng, p.descrizione_ita, p.descrizione_eng, p.descrizione_capitolato_ita, p.descrizione_capitolato_eng) AGAINST ('" . $_POST['cerca_prodotto'] . "' IN BOOLEAN MODE) AND p.visible='1' AND p.puglia ='0'";
}
	$Risultato = mysql_query($query, $db) or die(mysql_error($db));
	if (!$Risultato)
	{
	die ("La tabella selezionata non esiste" . mysql_error());
	}
}
//Pagina Prodotti di Default
else
{
	// SE IL CLIENTE E' PUGLIESE	
if($_SESSION['id_regione'] == 16)
{	
	$query="SELECT p.*
                FROM prodotti AS p
               WHERE p.visible='1' ORDER BY p.posizione ASC";
	$Risultato = mysql_query($query, $db) or die(mysql_error($db));
}
else
{
// TUTTI GLI ALTRI					
$query="SELECT p.* 
        FROM prodotti AS p
       WHERE p.visible='1' AND p.puglia ='0' ORDER BY p.posizione ASC";
        $Risultato = mysql_query($query, $db) or die(mysql_error($db));

}
	if (!$Risultato)
	{
	die ("La tabella selezionata non esiste" . mysql_error());
	}
}
?>
<script type="text/javascript" src="http://www.sekurbox.com/js/cart.js"></script>
</head>
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
                    <div id="stile_titolo_pagina"><?php echo $prodotti;?></div>
                    <div id="briciole_di_pane">
                    <a href="http://www.sekurbox.com/<?php echo $lingua;?>/index.html">Home Page</a> /
					<?php 
							if (isset($_GET['id_sezione']) and isset($_GET['id_categoria'])) 
							{	
								echo "<a href='http://www.sekurbox.com/" . $lingua . "/prodotti.html'>" . $prodotti . "</a>&nbsp;/&nbsp;" . "<a href='http://www.sekurbox.com/" . $lingua . "/prodotti" . $_GET['id_sezione'] . ".html'>" . $nome_sezione_briciole . "</a>&nbsp;/&nbsp;" . $nome_categoria_briciole;
							}
							else if (isset($_GET['id_sezione']))
							{
								echo "<a href='http://www.sekurbox.com/" . $lingua . "/prodotti.html'>" . $prodotti . "</a>&nbsp;/&nbsp;" . $nome_sezione_briciole;								
							}
							else
							{
								echo $prodotti;
							}		
					?>	
                    </div>
                </div>
            </div>  
            <div id="titolo_pagina_ds">
				<?php
                                //include 'include/banner-promozionale.php'; 
                                ?>
           </div>      
      	</div>
        <div id="row">    
        	<div id="colonna_sn">
				<?php include 'include/menu-prodotti.php'; ?>
            </div>
            <div id="colonna_ds">
                <h1><?php echo $titolo_pagina;?></h1>
	                <?php  
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
				?>
                <div class="striscia_prodotto">
                    <div class="foto_striscia_prodotto">
                		<?php leggi_immagine("images/miniature/prodotti/" . $riga['id_prodotto'], 130);?>
                    </div>
                    <div class="info_striscia_prodotto">
                        <div class="cod_striscia_prodotto">
                            <span class="prezzo_stile">Codice: </span><span class="cod_striscia_prodotto_stile"><?php echo $riga['codice'];?></span>   
                            <?php if ($riga['giacenza']==0)
							{
								echo '';
							}
							else if ($riga['giacenza']<10)
							{
							 	echo '<span class="prezzo_stile">Disponibilit&agrave;: </span> <span class="disponibilita_rosso">Solo ' . $riga['giacenza'] . ' disponibili, Affrettati</span>';
							}
							else if (($riga['giacenza']>=10) and ($riga['giacenza']<=20)) 
							{
							 	echo '<span class="prezzo_stile">Disponibilit&agrave;: </span> <span class="disponibilita_arancio">Media</span>';
							}
							else if ($riga['giacenza']>20) 
							{
							 	echo '<span class="prezzo_stile">Disponibilit&agrave;: </span> <span class="disponibilita_verde">Buona</span>';
							}
							?>							 
                        </div>                
                        <div class="titolo_striscia_prodotto">
                            <?php if ($lingua=="it") { echo $riga['nome_ita'];} else { echo $riga['nome_eng'];}?>
                        </div> 
                        <div class="intro_striscia_prodotto">                	
							 <?php
                            	if ($lingua=="it") { echo trim_body(strip_tags($riga['descrizione_ita']));} else { echo trim_body(strip_tags($riga['descrizione_eng']));}
								?>
                        </div> 
                     	<?php if ($riga['giacenza'] > 0 )
                        {
                        ?>	                    
                        <div class="action_acquista">
                            <form id="inviacarrello" method="post" action="http://www.sekurbox.com/<?php echo $lingua; ?>/aggiorna-carrello.html">
                                <input type="hidden" name="id_prodotto" value="<?php echo $riga['id_prodotto']; ?>"/>
                                <input type="hidden" name="redirect" value="<?php echo $url;?>"/>
                            <?php
                                $session = session_id();
                                $query_qty = 'SELECT quantita FROM carrelli_temporanei WHERE session = "' . $session . '" AND id_prodotto = "' . $riga['id_prodotto'] . '"';
                                $Risultato_qty = mysql_query($query_qty, $db) or die(mysql_error($db));
                                if (mysql_num_rows($Risultato_qty) > 0) 
                                {
                                    $riga_qty = mysql_fetch_assoc($Risultato_qty);
                                    extract($riga_qty);	
                                     $quantita =$riga_qty['quantita'] ;
                                     $quantiniziale=$riga_qty['quantita'] ;
                                } 
                                else
                                {
                                    $quantita = 0;
                                    $quantiniziale=1;
                                }
                                mysql_free_result($Risultato_qty); 
                            ?>
                            <div class="action_acquista_sn">
                                <div class="quantity-widget">
                                    <div class="less">-</div> 
                                    <input type="text" value="<?php echo $quantiniziale;?>"  class="box_qty" name="quantita" /> 
                                    <div class="more">+</div>
                                </div>
                            </div>
                            <div class="action_acquista_ds">
							<?php
                                if ($quantita > 0) {
                                    echo '<input type="submit" name="submit" value="'.$cambia_quantita.'" class="input_stile"/>';
                                    
                                } else {
                                    //echo '<input type="submit" name="submit" value="' . $aggiungi . '" class="input_stile"/>';
                                    echo '<button type="submit" name="submit" value="'.$aggiungi.'" style="background-color:transparent"><img src="http://www.sekurbox.com/images/hp_acquistalo_ora.png" /></button>';
                                   // echo '<input type="image"  src="http://www.sekurbox.com/images/hp_acquistalo_ora.png"  >';
                                }
                            ?>
                                    </div>    
                                    </div>
                                </form>
                                <?php 
                                }
                                else
                                {
                                    echo '<div class="non_disponibile">';
										echo $prodotto_non_disponibile;
                                    echo '</div>';	
                                }
                                ?>   
<!--                                <div class="recensioni_box">
                                	<div class="stelle">
                                    	<img src="http://www.sekurbox.com/images/stelle.png" />
                                    </div>    
                                    <span class="prezzo_stile">3 recensioni</span></div>-->
                    </div>
		<?php /*if ($riga['sconto'] > 0 )
                         {							
                            $prezzo = $riga['prezzo_prodotto'];
                            $percentuale_di_sconto = $riga['sconto'];
                            $sconto = ($prezzo * 	$percentuale_di_sconto) / 100;
                            $prezzo_scontato = $prezzo - $sconto;
			    $prezzo_normale=number_format($riga['prezzo_prodotto'], 2, ',', '.');
                       */ ?>                    
                    	<div class="dettaglio_striscia_prodotto">
                        <!--                            
                           <div class="dettaglio_striscia_prodotto_prezzo_sbarrato">
                                <span class="prezzo_stile">Prezzo: </span>  <span class="prezzo_sbarrato">&euro; <?php echo $prezzo_normale;?></span>
                            </div>
                            <div class="dettaglio_striscia_prodotto_offerta">
                                <span class="offerta_stile">OFFERTA:</span>
                            </div>
                            <div class="dettaglio_striscia_prodotto_prezzo">
                                <span class="prezzo_normale">                             
                                <?php 
                                    echo "&euro; " . $prezzo_scontato;
                                ?>
                                </span> 
                                <span class="prezzo_stile">Iva Inc.</span>
                            </div>
                            <div class="dettaglio_striscia_prodotto_risparmi">
                                <div class="dettaglio_striscia_prodotto_risparmi_icona"><img src="http://www.sekurbox.com/images/sconto.png" /></div>
                                <div class="dettaglio_striscia_prodotto_risparmi_scritta"><span class="risparmi_il">Risparmi il <?php echo $riga['sconto'];?>%</div>
                            </div>	
                           -->
                            <?php echo calcolaprezzo($riga['id_prodotto'],'','');?>
                           
                            <div class="dettaglio_striscia_prodotto_dett">
                            <?php
                                echo "<a href='http://www.sekurbox.com/" . $lingua . "/prodotto" . $riga['id_prodotto'] . "/" . $myNewString .".html'>";
                                echo "<img src='http://www.sekurbox.com/images/dettaglio_prodotto_btn_" . $lingua . ".png' />";
                                echo "</a>";
                            ?>                            
                            </div>
                        </div>
                        <?php
			/*}
			else {
			?>
			<div class="dettaglio_striscia_prodotto">
                            <div class="dettaglio_striscia_prodotto_prezzo_sbarrato">
                            </div>
                            <div class="dettaglio_striscia_prodotto_offerta">
                            </div>
                            <div class="dettaglio_striscia_prodotto_prezzo">
                                <span class="prezzo_normale">                             
                                <?php 
				    $prezzo=number_format($riga['prezzo_prodotto'], 2, ',', '.');
                                    echo "&euro; " . $prezzo;
                                ?>
                                </span> 
                                <span class="prezzo_stile">Iva Inc.</span>
                            </div>
                            <div class="dettaglio_striscia_prodotto_risparmi">
                            </div>	
                            <div class="dettaglio_striscia_prodotto_dett">
                            <?php
                                echo "<a href='http://www.sekurbox.com/" . $lingua . "/prodotto" . $riga['id_prodotto'] . "/" . $myNewString .".html'>";
                                echo "<img src='http://www.sekurbox.com/images/dettaglio_prodotto_btn_" . $lingua . ".png' />";
                                echo "</a>";
                            ?>                            
                            </div>
                    	</div>
                       <?php } */
                       
                       
                       ?>
                        			            
                </div>
				<?php } ?>
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