<?php echo $_POST['altra_spedizione'];?>
<div class="form_intestazione"><?php echo $spedizione_e_pagamento;?></div>
<div class="form_row"><strong><?php echo $metodo_spedizione;?></strong></div>
<?php 
$query_spese_spedizione="select * from spese_di_spedizione";
$Risultato_spese_spedizione = mysql_query($query_spese_spedizione, $db) or die (mysql_error($db));
while ($riga_spese_spedizione=mysql_fetch_array($Risultato_spese_spedizione))
{
echo'	
<div class="form_row">
    <div class="form_row_piccolo">
        <input type="radio" name="id_spesa_di_spedizione" value="' . $riga_spese_spedizione['id_spesa_di_spedizione'] . '"/>
    </div>                       
    <div class="form_row_grande">
        <span class="stile_pagamenti_spedizioni">
            ' . $riga_spese_spedizione['nome_spesa_di_spedizione_ita'] . '&nbsp;(&euro; ' . $riga_spese_spedizione['costo_spesa_spedizione'] . ')
        </span>
    </div>                        
</div>
';
}
?>
<div class="form_row"><strong><?php echo $metodo_pagamento;?></strong></div>
<?php 
$query_metodi_pagamento="select * from metodi_di_pagamento where id_metodo_pagamento != '2'";
$Risultato_metodi_pagamento = mysql_query($query_metodi_pagamento, $db) or die (mysql_error($db));
while ($riga_metodi_pagamento=mysql_fetch_array($Risultato_metodi_pagamento))
{
echo'	
<div class="form_row">
    <div class="form_row_piccolo">
        <input type="radio" name="id_metodo_pagamento" value="' . $riga_metodi_pagamento['id_metodo_pagamento'] . '"/>
    </div>                       
    <div class="form_row_grande">
        <span class="stile_pagamenti_spedizioni">
            ' . $riga_metodi_pagamento['nome_pagamento_ita'] . '&nbsp;(&euro; ' . $riga_metodi_pagamento['costo_metodo_di_pagamento'] . ')
        </span>
    </div>                        
</div>
';
}
?>
<input type="hidden" name="id_tipologia_cliente" value="<?php echo htmlspecialchars($_POST['id_tipologia_cliente']);?>"/>   
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_POST['email']);?>"/>      
<input type="hidden" name="nome" value="<?php echo htmlspecialchars($_POST['nome']);?>"/>      
<input type="hidden" name="cognome" value="<?php echo htmlspecialchars($_POST['cognome']);?>"/>      
<input type="hidden" name="data_di_nascita" value="<?php echo htmlspecialchars($_POST['data_di_nascita']);?>"/>      
<input type="hidden" name="codice_fiscale" value="<?php echo htmlspecialchars($_POST['codice_fiscale']);?>"/>      
<input type="hidden" name="ragione_sociale" value="<?php echo htmlspecialchars($_POST['ragione_sociale']);?>"/>      
<input type="hidden" name="partita_iva" value="<?php echo htmlspecialchars($_POST['partita_iva']);?>"/>      
<input type="hidden" name="indirizzo" value="<?php echo htmlspecialchars($_POST['indirizzo']);?>"/>      
<input type="hidden" name="citta" value="<?php echo htmlspecialchars($_POST['citta']);?>"/>      
<input type="hidden" name="id_provincia" value="<?php echo htmlspecialchars($_POST['id_provincia']);?>"/>
<input type="hidden" name="id_nazione" value="<?php echo htmlspecialchars($_POST['id_nazione']);?>"/>
<input type="hidden" name="cap" value="<?php echo htmlspecialchars($_POST['cap']);?>"/>
<input type="hidden" name="telefono_fisso" value="<?php echo htmlspecialchars($_POST['telefono_fisso']);?>"/>
<input type="hidden" name="telefono_cellulare" value="<?php echo htmlspecialchars($_POST['telefono_cellulare']);?>"/>
<input type="hidden" name="note_per_il_corriere" value="<?php echo htmlspecialchars($_POST['note_per_il_corriere']);?>"/>
<?php
 if (isset($_POST['altra_spedizione'])) {
?>	 
<input type="hidden" name="nome_spedizione" value="<?php echo htmlspecialchars($_POST['nome_spedizione']);?>"/> 
<input type="hidden" name="cognome_spedizione" value="<?php echo htmlspecialchars($_POST['cognome_spedizione']);?>"/> 
<input type="hidden" name="id_nazione_spedizione" value="<?php echo htmlspecialchars($_POST['id_nazione_spedizione']);?>"/> 
<input type="hidden" name="indirizzo_spedizione" value="<?php echo htmlspecialchars($_POST['indirizzo_spedizione']);?>"/> 
<input type="hidden" name="citta_spedizione" value="<?php echo htmlspecialchars($_POST['citta_spedizione']);?>"/> 
<input type="hidden" name="cap_spedizione" value="<?php echo htmlspecialchars($_POST['cap_spedizione']);?>"/> 
<input type="hidden" name="id_provincia_spedizione" value="<?php echo htmlspecialchars($_POST['id_provincia_spedizione']);?>"/> 
<input type="hidden" name="telefono_fisso_spedizione" value="<?php echo htmlspecialchars($_POST['telefono_fisso_spedizione']);?>"/> 
<input type="hidden" name="telefono_cellulare_spedizione" value="<?php echo htmlspecialchars($_POST['telefono_cellulare_spedizione']);?>"/> 
<?php } ?>	                      
