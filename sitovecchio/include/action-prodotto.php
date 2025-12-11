<div class="prodotto_dettaglio_info_disponibilita">
	<?php 
    if ($riga_det['giacenza']==0)
    {
        echo '';
    }
    else if ($riga_det['giacenza']<10)
    {
        echo '<span class="prezzo_stile_det">Disponibilit&agrave;: </span> <span class="disponibilita_rosso_det">Solo ' . $riga_det['giacenza'] . ' disponibili, Affrettati</span>';
    }
    else if (($riga_det['giacenza']>=10) and ($riga_det['giacenza']<=20)) 
    {
        echo '<span class="prezzo_stile_det">Disponibilit&agrave;: </span> <span class="disponibilita_arancio_det">Media</span>';
    }
    else if ($riga_det['giacenza']>20) 
    {
        echo '<span class="prezzo_stile_det">Disponibilit&agrave;: </span> <span class="disponibilita_verde_det">Buona</span>';
    }
    ?>							 
</div>

<!--<div class="prodotto_dettaglio_info_recensioni">
    <div class="stelle">
        <img src="http://www.sekurbox.com/images/stelle.png" />
    </div>    
    <span class="prezzo_stile_det">3 recensioni</span>
</div>-->
<div class="prodotto_dettaglio_info_prezzo">


    
<div class="dettaglio_striscia_prodotto_det">
    
   <?php echo calcolaprezzo($riga_det['id_prodotto'],'','');?>    
<!--    <div class="dettaglio_striscia_prodotto_prezzo_sbarrato_det">
        <span class="prezzo_stile_det">Prezzo: </span>  <span class="prezzo_sbarrato_det">&euro; <?php echo $prezzo_normale;?></span>
    </div>
    <div class="dettaglio_striscia_prodotto_offerta_det">
        <span class="offerta_stile_det">OFFERTA:</span>
    </div>
    <div class="dettaglio_striscia_prodotto_prezzo_det">
        <span class="prezzo_normale_det">                             
        <?php 
            echo "&euro; " . $prezzo_scontato;
        ?>
        </span> 
        <span class="prezzo_stile_det">Iva Inc.</span>
    </div>
    <div class="dettaglio_striscia_prodotto_risparmi_det">
        <div class="dettaglio_striscia_prodotto_risparmi_icona_det"><img src="http://www.sekurbox.com/images/sconto.png" /></div>
        <div class="dettaglio_striscia_prodotto_risparmi_scritta_det"><span class="risparmi_il_det">Risparmi il <?php echo $riga_det['sconto'];?>%</div>
    </div>	-->
</div>

</div>

<div class="prodotto_dettaglio_acquista">
<?php if ($riga_det['giacenza'] > 0 )
{
?>	                    
	<div class="action_acquista">
	<form method="post" action="http://www.sekurbox.com/<?php echo $lingua; ?>/aggiorna-carrello.html">
		<input type="hidden" name="id_prodotto" value="<?php echo $riga_det['id_prodotto']; ?>"/>
		<input type="hidden" name="redirect" value="<?php echo $url;?>"/>
		<?php
			$session = session_id();
			$query_qty = 'SELECT quantita FROM carrelli_temporanei WHERE session = "' . $session . '" AND id_prodotto = "' . $riga_det['id_prodotto'] . '"';
			$Risultato_qty = mysql_query($query_qty, $db) or die(mysql_error($db));
			if (mysql_num_rows($Risultato_qty) > 0) 
			{
				$riga_qty = mysql_fetch_assoc($Risultato_qty);
				extract($riga_qty);			
			} 
			else
			{
				$quantita = 0;
			}
			mysql_free_result($Risultato_qty);
		?>
	<div class="action_acquista_sn">
        <div class="quantity-widget">
            <div class="less">-</div> 
            <input type="text" value="<?php echo $quantita;?>"  class="box_qty" name="quantita" /> 
            <div class="more">+</div>
        </div>
	</div>
    <div class="action_acquista_ds">
    <?php
        if ($quantita > 0) {
            echo '<input type="submit" name="submit" value="' . $cambia_quantita . '" class="input_stile"/>';
        } else {
            echo '<input type="submit" name="submit" value="' . $aggiungi . '" class="input_stile"/>';
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
</div>
