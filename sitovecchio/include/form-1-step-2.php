<div class="form_intestazione"><?php echo $ituoi_dati_per_completare_ordine;?></div>
<div class="form_row"><label><?php echo $privato_azienda;?></label></div>                             
<div class="form_row">
    <div class="form_row_mezzo">
    <select class="select" name="id_tipo_cliente" id="id_tipo_cliente">
            <?php
                $Risultato_tipo_cliente=mysql_query("select * from tipo_cliente", $db);
                if ($Risultato_tipo_cliente){
                    while($riga_tipo_cliente = mysql_fetch_assoc($Risultato_tipo_cliente)){
                        $id_tipo_cliente = $riga_tipo_cliente['id_tipo_cliente'];
                        $tipo_cliente = $riga_tipo_cliente['tipo_cliente'];
                        echo "<option value='" . $id_tipo_cliente . "'>" . $tipo_cliente . "</option>n";
                                }
                           }
            ?>	
    </select>  
    </div>
    <div class="form_row_mezzo">
        <?php echo $campi_obbligatori;?><br />
        <?php echo $campi_obbligatori_uno;?>
    </div>
</div>    
<div class="form_row"><label>Email</label></div>                       
<div class="form_row"><input type="text" name="email" /></div>
<div id="privato">
    <div class="form_row_mezzo">
        <div class="form_row"><label><?php echo $nome;?></label></div>                       
        <div class="form_row"><input type="text" name="nome" /></div>                        
    </div>
    <div class="form_row_mezzo">
        <div class="form_row"><label><?php echo $cognome;?></label></div>                       
        <div class="form_row"><input type="text" name="cognome" /></div>                        
    </div>
    <div class="form_row"><label><?php echo $data_nascita;?></label></div>                       
    <div class="form_row"><input type="text" name="data_di_nascita" /></div>
</div>
 <div id="azienda">
    <div class="form_row_mezzo">
        <div class="form_row"><label><?php echo $ragione_sociale;?></label></div>                       
        <div class="form_row"><input type="text" name="ragione_sociale" /></div>                        
    </div>
    <div class="form_row_mezzo">
        <div class="form_row"><label><?php echo $partita_iva;?></label></div>                       
        <div class="form_row"><input type="text" name="partita_iva" /></div>                        
    </div>
    <div class="form_row"><label><?php echo $codice_fiscale;?></label></div>                       
    <div class="form_row"><input type="text" name="codice_fiscale" /></div>
</div>                 	
<div class="form_row"><label><?php echo $nazione;?></label></div>                             
<div class="form_row">
    <select class="select" name="id_nazione" id="nazione">
        <?php
            $Risultato_nazioni=mysql_query("select * from nazioni", $db);
            if ($Risultato_nazioni){
                while($riga_nazione = mysql_fetch_assoc($Risultato_nazioni)){
                    $id_nazione = $riga_nazione['ID'];
                    echo "<option ";
                    if ($id_nazione == 106)
                        {
                        echo "selected ";
                        }
                        echo "value='". $id_nazione . "'>" . $riga_nazione['Nazione'] . "</option>n";
                        }
                                       }
        ?>	
    </select> 
</div>
<div class="form_row_mezzo">
    <div class="form_row"><label><?php echo $indirizzo;?></label></div>                       
    <div class="form_row"><input type="text" name="indirizzo" /></div>                        
</div>
<div class="form_row_mezzo">
    <div class="form_row"><label><?php echo $comune;?></label></div>                       
    <div class="form_row"><input type="text" name="citta" /></div>                        
</div>                        
<div class="form_row_mezzo">
    <div class="form_row"><label><?php echo $cap;?></label></div>                       
    <div class="form_row"><input type="text" name="cap" /></div>                        
</div>
<div id="provincia">
    <div class="form_row_mezzo">
        <div class="form_row"><label><?php echo $provincia_testo;?></label></div>                       
        <div class="form_row">
           <select class="select" name="id_provincia">
            <option value=""></option>
                <?php
                    $Risultato_province=mysql_query("select * from province ORDER BY provincia ASC", $db);
                    if ($Risultato_province){
                        while($riga_provincia = mysql_fetch_assoc($Risultato_province)){
                            $id_provincia = $riga_provincia['id'];
                            $provincia = $riga_provincia['provincia'];
                            echo "<option value='" . $id_provincia . "'>" . $provincia . "</option>n";
                                    }
                               }
                ?>	
            </select>
        </div>                        
    </div>
</div>
<div class="form_row_mezzo">
    <div class="form_row"><label><?php echo $telefono_fisso;?></label></div>                       
    <div class="form_row"><input type="text" name="telefono_fisso" /></div>                        
</div>
<div class="form_row_mezzo">
    <div class="form_row"><label><?php echo $telefono_cellulare;?></label></div>                       
    <div class="form_row"><input type="text" name="telefono_cellulare" /></div>                        
</div>
<div class="form_row"><label><?php echo $note_per_il_corriere;?></label></div>                       
<div class="form_row"><textarea name="note_per_il_corriere"></textarea></div>   
<div class="form_row">
   <span class="stile_info_privacy">
		<?php echo $leggi_informativa;?>
    </span>
</div>
<div class="form_row">
    <div class="form_row_piccolo">
        <input type="checkbox" name="privacy_ok" />
    </div>                       
    <div class="form_row_grande">
        <span class="stile_info_privacy">
           <?php echo $acconsento;?>
        </span>
    </div>                        
</div>                     
<div class="form_row">
    <div class="form_row_piccolo">
        <input type="checkbox" id="altra_spedizione" name="altra_spedizione" />
    </div>                       
    <div class="form_row_grande">
        <span class="stile_indirizzo_diverso">
            <?php echo $consegna_indirizzo_diverso;?>
        </span>
    </div>                        
</div>                         
