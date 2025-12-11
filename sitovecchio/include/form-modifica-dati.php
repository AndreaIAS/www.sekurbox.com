<?php

	$id_tipologia_cliente = $riga_user['id_tipologia_cliente'];
	$id_cliente = $riga_user['id_cliente'];
	$id_nazione = $riga_user['id_nazione'];
	$id_provincia = $riga_user['id_provincia'];
        
?>
<form id="signupForm" method="post" action="http://www.sekurbox.com/modificadati.php?id_cliente=<?php echo $id_cliente; ?>&lingua=<?php echo $lingua; ?>">
<div class="form_intestazione"><?php echo $titolo_form_registrazione;?></div>
    
<?php
        $Risultato_tipo_cliente=mysql_query("select * from tipologia_cliente WHERE id_tipologia_cliente='".$riga_user['id_tipologia_cliente']."' ", $db);
        $riga_tipo_cliente = mysql_fetch_assoc($Risultato_tipo_cliente);
        ?>
<div class="form_row">
    <div class="form_row_mezzo">
 <b><?php echo $tiput;?>:</b>  <?php echo  $riga_tipo_cliente['tipologia_cliente_it']   ;?>
</div>
    <div class="form_row_mezzo">
        <?php echo $campi_obbligatori; ?><br />
        <?php echo $campi_obbligatori_uno; ?>
    </div>
</div> 

<div id="codice">                           
    <div class="form_row"><label class="codice_label"><?php echo $haiuncod;?></label></div>                       
    <div class="form_row"><input type="text" name="codice_esterno" value="<?php echo $riga_user['codice_sconto'];?>" /></div>
</div>
    <?php if ($id_tipologia_cliente==2 OR $id_tipologia_cliente==3){ ?>
    <div class="form_row"><label><?php echo $codice_per_privatol;?></label></div>                 
    <div class="form_row"><input type="text" value="<?php echo $riga_user['codice_per_privato'];?>" disabled   /></div>
    <?php } ?>
     <?php if ($id_tipologia_cliente==3){ ?>
    <div class="form_row"><label><?php echo $codice_per_installatorl;?></label></div>  
    <div class="form_row"><input type="text"  value="<?php echo $riga_user['codice_per_installatore'];?>" disabled /></div>
     <?php } ?>

<div class="form_row"><label>*Email</label></div>                       
<div class="form_row"><input type="text" name="email" value="<?php echo $riga_user['email'];?>" /></div>
<div class="form_row"><label>*Password</label></div>                       
<div class="form_row"><input type="password" name="password" id="password" value="<?php echo $riga_user['password'];?>" /></div>
<div class="form_row"><label>*<?php echo $conferma_password;?></label></div>
<div class="form_row"><input type="password" name="confirm_password" /></div>
<div id="privato">
    <div class="form_row_mezzo">
        <div class="form_row">*<label><?php echo $nome;?></label></div>                       
        <div class="form_row"><input type="text" name="nome" value="<?php echo $riga_user['nome'];?>" /></div>                        
    </div>
    <div class="form_row_mezzo">
        <div class="form_row">*<label><?php echo $cognome;?></label></div>                       
        <div class="form_row"><input type="text" name="cognome" value="<?php echo $riga_user['cognome'];?>" /></div>                        
    </div>
    
</div>
 <div id="azienda">
    <div class="form_row_mezzo">
        <div class="form_row"><label>*<?php echo $ragione_sociale;?></label></div>                       
        <div class="form_row"><input type="text" name="ragione_sociale" value="<?php echo $riga_user['ragione_sociale'];?>" /></div>                        
    </div>
    <div class="form_row_mezzo">
        <div class="form_row"><label>*<?php echo $partita_iva;?></label></div>                       
        <div class="form_row"><input type="text" name="partita_iva" value="<?php echo $riga_user['partita_iva'];?>" /></div>                        
    </div>
    <div class="form_row"><label>*<?php echo $codice_fiscale;?></label></div>                       
    <div class="form_row"><input type="text" name="codice_fiscale" value="<?php echo $riga_user['codice_fiscale'];?>" /></div>
</div>                 	
<div class="form_row"><label>*<?php echo $nazione;?></label></div>                             
<div class="form_row">
   <select class="select" name="id_nazione" id="nazione">
    <?php
        $Risultato=mysql_query("select * from nazioni", $db);
        if ($Risultato){
        while($row = mysql_fetch_assoc($Risultato)){
        echo "<option ";
        if ($id_nazione == ($row['ID']))
        {
        echo "selected ";
        }
        echo "value='". $row['ID'] . "'>" . $row['Nazione'] . "</option>n";
        }
        }
        ?>	                    
</select> 
</div>
<div class="form_row_mezzo">
    <div class="form_row"><label>*<?php echo $indirizzo;?></label></div>                       
    <div class="form_row"><input type="text" name="indirizzo" value="<?php echo $riga_user['indirizzo'];?>" /></div>                        
</div>
<div class="form_row_mezzo">
    <div class="form_row"><label>*<?php echo $comune;?></label></div>                       
    <div class="form_row"><input type="text" name="citta" value="<?php echo $riga_user['citta'];?>" /></div>                        
</div>                        
<div class="form_row_mezzo">
    <div class="form_row"><label>*<?php echo $cap;?></label></div>                       
    <div class="form_row"><input type="text" name="cap" value="<?php echo $riga_user['cap'];?>" /></div>                        
</div>
<div class="form_row_mezzo">
    <div class="form_row"><label>Regione</label></div> 
    <div class="form_row">
    	<div id="regione">
            <select class="select" name="id_regione" id="id_regione">
                    <?php
                        $Risultato_regioni=mysql_query("select * from regioni ORDER BY regione ASC", $db);
                        if ($Risultato_regioni){
                            while($riga_regioni = mysql_fetch_array($Risultato_regioni)){
                                $id_regione = $riga_regioni['id'];
                                $regione = $riga_regioni['regione'];
                                echo "<option ";
                                 if ($id_regione == ($riga_regioni['id'])) {echo "selected='selected' ";}
                                
                                echo " value='" . $id_regione . "'>" . $regione . "</option>";
                                        }
                                   }
                    ?>	
            </select> 
        </div>
    </div>    
</div>
<div id="provincia">
    <div class="form_row_mezzo">
        <div class="form_row"><label>*Provincia</label></div>                       
        <div class="form_row">
           <select class="select" name="id_provincia" id="id_provincia">
            <option value=""></option>
                <?php
                $Risultato_province=mysql_query("select * from province", $db);
                if ($Risultato_province){
                while($riga_provincia = mysql_fetch_array($Risultato_province)){
                echo "<option ";
                if ($id_provincia == ($riga_provincia['id']))
                {
                echo "selected='selected' ";
                }
                echo " value='". $riga_provincia['id'] . "'>" . $riga_provincia['provincia'] . "</option>";
                }
                }
                ?>	                         
            </select>
        </div>                        
    </div>
</div>
<div class="form_row_mezzo">
    <div class="form_row"><label><?php echo $telefono_fisso;?></label></div>                       
    <div class="form_row"><input type="text" name="telefono_fisso" value="<?php echo $riga_user['telefono_fisso'];?>" /></div>                        
</div>
<div class="form_row_mezzo">
    <div class="form_row"><label><?php echo $telefono_cellulare;?></label></div>                       
    <div class="form_row"><input type="text" name="telefono_cellulare" value="<?php echo $riga_user['telefono_cellulare'];?>" /></div>                        
</div> 
<div class="form_row_button">
	<input class="entra" type="submit" value="<?php echo $modifica;?>" name="modifica" />              
</div>
</form>
                      
                       
