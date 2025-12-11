<form id="signupForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div class="form_intestazione"><?php echo $titolo_form_registrazione;?></div>
                             
<div class="form_row">
    <div class="form_row_mezzo">
    </div>
    <div class="form_row_mezzo">
        <?php echo $campi_obbligatori;?><br />
        <?php echo $campi_obbligatori_uno;?>
    </div>
</div>
    <div class="form_row"><label>*<?php echo $tipologia_del_cliente;?></label></div>                             
    <div class="form_row">
        <select class="select" name="id_tipologia_cliente" id="id_tipologia_cliente">
                <?php
                    $Risultato_tipologia_cliente=mysql_query("select * from tipologia_cliente", $db);
                    if ($Risultato_tipologia_cliente){
                        while($riga_tipologia_cliente = mysql_fetch_assoc($Risultato_tipologia_cliente)){
                            $id_tipologia_cliente = $riga_tipologia_cliente['id_tipologia_cliente'];
                            $tipologia_cliente = $riga_tipologia_cliente['tipologia_cliente_it'];
                            echo "<option value='" . $id_tipologia_cliente . "'>" . $tipologia_cliente . "</option>n";
                                    }
                               }
                ?>	
        </select>
    </div>
<div id="codice">                           
    <div class="form_row"><label class="codice_label">Hai un codice azienda? Inseriscilo, altrimenti richiedilo. Puoi inserirlo anche in seguito.</label></div>                       
    <div class="form_row"><input type="text" name="codice_esterno" /></div>
</div>    
<div class="form_row"><label>*Email</label></div>                       
<div class="form_row"><input type="text" name="email" /></div>
<div class="form_row"><label>*Password</label></div>                       
<div class="form_row"><input type="password" name="password" id="password" /></div>
<div class="form_row"><label>*<?php echo $conferma_password;?></label></div>
<div class="form_row"><input type="password" name="confirm_password" /></div>

    <div class="form_row_mezzo">
        <div class="form_row">*<label><?php echo $nome;?></label></div>                       
        <div class="form_row"><input type="text" name="nome" /></div>                        
    </div>
    <div class="form_row_mezzo">
        <div class="form_row">*<label><?php echo $cognome;?></label></div>                       
        <div class="form_row"><input type="text" name="cognome" /></div>                        
    </div>
 <div id="azienda">
    <div class="form_row_mezzo">
        <div class="form_row"><label>*<?php echo $ragione_sociale;?></label></div>                       
        <div class="form_row"><input type="text" name="ragione_sociale" /></div>                        
    </div>
    <div class="form_row_mezzo">
        <div class="form_row"><label>*<?php echo $partita_iva;?></label></div>                       
        <div class="form_row"><input type="text" name="partita_iva" /></div>                        
    </div>
</div>
<div class="form_row"><label>*<?php echo $codice_fiscale;?></label></div>                       
<div class="form_row"><input type="text" name="codice_fiscale" /></div>                 	
<div class="form_row"><label>*<?php echo $nazione;?></label></div>                             
<div class="form_row_mezzo">
    <div class="form_row">
        <select class="select" name="id_nazione" id="id_nazione">
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
 </div>

<div class="form_row_mezzo">
    <div class="form_row"><label>*<?php echo $indirizzo;?></label></div>                       
    <div class="form_row"><input type="text" name="indirizzo" /></div>                        
</div>
<div class="form_row_mezzo">
    <div class="form_row"><label>*<?php echo $comune;?></label></div>                       
    <div class="form_row"><input type="text" name="citta" /></div>                        
</div>                        
<div class="form_row_mezzo">
    <div class="form_row"><label>*<?php echo $cap;?></label></div>                       
    <div class="form_row"><input type="text" name="cap" /></div>                        
</div>
<div class="form_row_mezzo">
    <div class="form_row"><label>Regione</label></div> 
    <div class="form_row">
    	<div id="regione">
            <select class="select" name="id_regione" id="id_regione">
                    <?php
                        $Risultato_regioni=mysql_query("select * from regioni ORDER BY regione ASC", $db);
                        if ($Risultato_regioni){
                            while($riga_regioni = mysql_fetch_assoc($Risultato_regioni)){
                                $id_regione = $riga_regioni['id'];
                                $regione = $riga_regioni['regione'];
                                echo "<option value='" . $id_regione . "'>" . $regione . "</option>";
                                        }
                                   }
                    ?>	
            </select> 
        </div>
    </div>    
</div>
<div id="provincia">
    <div class="form_row_mezzo">
        <div class="form_row"><label>Provincia</label></div>                       
        <div class="form_row">
           <select class="select" name="id_provincia" id="id_provincia">
            <option value=""></option>
                <?php
                    $Risultato_province=mysql_query("select * from province ORDER BY provincia ASC", $db);
                    if ($Risultato_province){
                        while($riga_provincia = mysql_fetch_assoc($Risultato_province)){
                            $id_provincia = $riga_provincia['id'];
                            $provincia = $riga_provincia['provincia'];
                            echo "<option value='" . $id_provincia . "'>" . $provincia . "</option>";
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
<div class="form_row">
   <span class="stile_info_privacy">
		<?php echo $leggi_informativa;?>
    </span>
</div>
<div class="form_row">
    <div class="form_row_piccolo">
        <input type="checkbox" name="agree" />
    </div> 
    <br />
    <div class="form_row_grande">
        <span class="stile_info_privacy">
           <?php echo $acconsento;?>
        </span>
    </div>                        
</div>
<div class="form_row_button">
	<input class="entra" type="submit" value="<?php echo $registrati;?>" name="registrami" />              
</div>
</form>                       
                       
