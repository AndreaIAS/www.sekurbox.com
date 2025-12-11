<div id="cerca">
<p><?php echo $frase_form_cerca;?></p>
<form id="" method="POST" action ="http://www.sekurbox.com/<?php echo $lingua;?>/prodotti.html">
    <input type="text" name="cerca_prodotto" value="" />
    <input type="submit" value="<?php echo $cerca;?>" class="cerca" />                                                         
</form>
</div>
<?php
// SE IL CLIENTE E' PUGLIESE	
if($_SESSION['id_regione'] == 16)
{	 
$Risultato_menu_prodotti=mysql_query("SELECT 
														 sp.*, cp.*  
														 FROM sezioni_prodotti sp
		                        						 LEFT OUTER JOIN categorie_prodotti AS cp ON sp.id_sezione = cp.id_sezione 
														 ORDER BY sp.posizione, cp.posizione ASC", $db);
}
else
{
// TUTTI GLI ALTRI						
$Risultato_menu_prodotti=mysql_query("SELECT 
														 sp.*, cp.*  
														 FROM sezioni_prodotti sp
		                        						 LEFT OUTER JOIN categorie_prodotti AS cp ON sp.id_sezione = cp.id_sezione
			 							 				 WHERE sp.puglia ='0' AND cp.puglia='0'
														 ORDER BY sp.posizione, cp.posizione ASC", $db);
}
if (!$Risultato_menu_prodotti)
	{
	die ("La tabella selezionata non esiste" . mysql_error());
	}
$sezione = "";
$x=0;
while ($riga_menu_prodotti=mysql_fetch_array($Risultato_menu_prodotti))
{	
?> 

<?php 
	if ($lingua =="it")
	{
	$sezione_lg = $riga_menu_prodotti['nome_sezione_ita'];	
	}
	else
	{
	$sezione_lg = $riga_menu_prodotti['nome_sezione_eng'];	
	}
	if ($sezione != $sezione_lg)
	{
		if($x==0)
		{
			echo '<div class="titolo_menu_laterale">';
			echo '<a href="http://www.sekurbox.com/' . $lingua . '/prodotti' . $riga_menu_prodotti['id_sezione'] . '.html">';
				if ($lingua=="it") { echo $riga_menu_prodotti['nome_sezione_ita']; } else { echo $riga_menu_prodotti['nome_sezione_eng']; }
			echo '</a>';
			echo '</div><ul class="menu_laterale">';
		}
		else 
		{
			echo '</ul>';
			echo '<div class="titolo_menu_laterale">';
			echo '<a href="http://www.sekurbox.com/' . $lingua . '/prodotti' . $riga_menu_prodotti['id_sezione'] . '.html">';
				if ($lingua=="it") { echo $riga_menu_prodotti['nome_sezione_ita']; } else { echo $riga_menu_prodotti['nome_sezione_eng']; }
			echo '</a>';
			echo '</div><ul class="menu_laterale">';
		}
		$x=1;
	}
	echo '<li>';
	echo '<a href="http://www.sekurbox.com/' . $lingua . '/prodotti' . $riga_menu_prodotti['id_sezione'] . "-" . $riga_menu_prodotti['id_categoria'] . '.html">';
	if ($lingua=="it") { echo $riga_menu_prodotti['categoria_ita']; } else { echo $riga_menu_prodotti['categoria_eng']; }
	echo '</a></li>';
	
	if ($lingua=="it") {$sezione = $riga_menu_prodotti['nome_sezione_ita']; } else {$sezione = $riga_menu_prodotti['nome_sezione_eng'];}	
}
echo '</ul>'; 
?>
    