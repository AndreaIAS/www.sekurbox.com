<div class="form_intestazione"><?php echo $indirizzo_di_spedizione;?></div>
<div class="form_row_mezzo">
    <div class="form_row"><label><?php echo $nome;?></label></div>                       
    <div class="form_row"><input type="text" name="nome_spedizione" /></div>                        
</div>
<div class="form_row_mezzo">
    <div class="form_row"><label><?php echo $cognome;?></label></div>                       
    <div class="form_row"><input type="text" name="cognome_spedizione" /></div>                        
</div>                 	
<div class="form_row"><label><?php echo $nazione;?></label></div>                             
<div class="form_row">
    <select class="select" name="id_nazione_spedizione">
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
    <div class="form_row"><input type="text" name="indirizzo_spedizione" /></div>                        
</div>
<div class="form_row_mezzo">
    <div class="form_row"><label><?php echo $comune;?></label></div>                       
    <div class="form_row"><input type="text" name="citta_spedizione" /></div>                        
</div>                        
<div class="form_row_mezzo">
    <div class="form_row"><label><?php echo $cap;?></label></div>                       
    <div class="form_row"><input type="text" name="cap_spedizione" /></div>                        
</div>
<div class="form_row_mezzo">
    <div class="form_row"><label><?php echo $provincia_testo;?></label></div>                       
    <div class="form_row">
       <select class="select" name="id_provincia_spedizione">
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
<div class="form_row_mezzo">
    <div class="form_row"><label><?php echo $telefono_fisso;?></label></div>                       
    <div class="form_row"><input type="text" name="telefono_fisso_spedizione" /></div>                        
</div>
<div class="form_row_mezzo">
    <div class="form_row"><label><?php echo $telefono_cellulare;?></label></div>                       
    <div class="form_row"><input type="text" name="telefono_cellulare_spedizione" /></div>                        
</div>
