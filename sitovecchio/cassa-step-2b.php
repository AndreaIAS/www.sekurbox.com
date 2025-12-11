<?php 
include 'include/connessione.php';
include "include/lingua.php"; 


include 'include/leggi_immagine.inc.php';
if ($lingua == "it")
{
$title = "";
$description = "";
}
else
{
$title = "";
$description = "";
} 
include 'include/head.php'; 

if(!isset($_SESSION['user'])){ header("Location: http://www.sekurbox.com/".$lingua."/cassa-step-1.html");}

$query = "SELECT  clienti.*, 
         tipologia_cliente.id_tipologia_cliente, tipologia_cliente.tipologia_cliente_it, 
         nazioni.ID, nazioni.Nazione,
         province.id, province.provincia, province.sigla
         FROM  clienti
         LEFT JOIN tipologia_cliente ON clienti.id_tipologia_cliente = tipologia_cliente.id_tipologia_cliente
         LEFT JOIN nazioni ON clienti.id_nazione = nazioni.ID							 
         LEFT JOIN province ON clienti.id_provincia = province.id
         WHERE clienti.email= '" . $_SESSION['email'] . "'";
	$Risultato = mysql_query($query, $db) or die (mysql_error($db));
	$riga=mysql_fetch_assoc($Risultato);
		
		// DATI CLIENTE REGISTRATO
		$id_cliente_extract = $riga['id_cliente'];
		$id_tipologia_cliente_extract = $riga['id_tipologia_cliente'];
		$email_extract = $riga['email'];
		$nome_extract = $riga['nome'];
		$cognome_extract = $riga['cognome'];
		$data_di_nascita_extract = $riga['data_di_nascita'];
		$codice_fiscale_extract = $riga['codice_fiscale'];     
		$ragione_sociale_extract = $riga['ragione_sociale'];     
		$partita_iva_extract = $riga['partita_iva'];      
		$indirizzo_extract = $riga['indirizzo'];      
		$citta_extract = $riga['citta'];      
		$provincia_extract = $riga['sigla'];
		$nazione_extract = $riga['Nazione'];
		$cap_extract = $riga['cap'];
		$telefono_fisso_extract = $riga['telefono_fisso'];
		$telefono_cellulare_extract = $riga['telefono_cellulare'];
									 
?>	

<script src="http://www.rosaorlando.com/js/jquery.validate.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){

	$("#compare").hide();
	$("#altra_spedizione").click(function(){
	$("#compare").toggle();
	});		
});	
</script>
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
                    <div id="stile_titolo_pagina"><?php echo $carrello;?></div>
                    <div id="briciole_di_pane"><a href="http://www.sekurbox.com/<?php echo $lingua; ?>/index.html">Home Page</a> / <?php echo $carrello;?></div>
                </div>
            </div>  
            <div id="titolo_pagina_ds">
				<?php include 'include/banner-promozionale.php'; ?>
           </div>           
       </div>      
		<div class="row_content">
				<div class="box_step_cassa">
                	<div class="box_step_cassa_acceso"><?php echo $step_1;?></div>
                	<div class="box_step_cassa_spento"><?php echo $step_2;?></div>
                	<div class="box_step_cassa_spento"><?php echo $step_3;?></div>
                </div>
                <form id="signupForm" method="post" name='form' action="http://www.sekurbox.com/<?php echo $lingua;?>/cassa-step-3.html">
                <div id="colonna_sn_form">

                    <div class="form">
                    <div class="form_intestazione"><?php echo $ituoi_dati_per_completare_ordine;?></div>
                        <ul class="dati_utente">
                            <?php if ($id_tipologia_cliente_extract == '1')
									   { if($riga['codice_sconto']!='') echo "<li><strong>Codice Sconto:</strong> " . $riga['codice_sconto'] . "</li>";
									    	echo "
											<li><strong>Email:</strong> " . $email_extract . "</li>
											<li><strong>Nome:</strong> " . $nome_extract . "</li>
											<li><strong>Cognome:</strong> " . $cognome_extract . "</li>
											<li><strong>Data di nascita:</strong> " . $data_di_nascita_extract . "</li>
											<li><strong>Codice Fiscale:</strong> " . $codice_fiscale_extract . "</li>
											<li><strong>Indirizzo:</strong> " . $indirizzo_extract . " " . $cap_extract . " " . $citta_extract . " (" . $provincia_extract . ") - " . $nazione_extract . " </li>
											<li><strong>Telefono fisso:</strong> " . $telefono_fisso_extract . "</li>
											<li><strong>Telefono cellulare:</strong> " . $telefono_cellulare_extract . "</li>";
									    }
										else if ($id_tipologia_cliente_extract == '2' or $id_tipologia_cliente_extract == '3')
										{
                                                                                    
                                                                                if($riga['codice_sconto']!='' AND $id_tipologia_cliente_extract == '2' ) echo "<li><strong>Codice Sconto:</strong> " . $riga['codice_sconto'] . "</li>";    
									    	echo "							
											<li><strong>Email:</strong> " . $email_extract . "</li>
											<li><strong>Nome:</strong> " . $nome_extract . "</li>
											<li><strong>Cognome:</strong> " . $cognome_extract . "</li>
											<li><strong>Codice Fiscale:</strong> " . $codice_fiscale_extract . "</li>
											<li><strong>Ragione Sociale:</strong> " . $ragione_sociale_extract . "</li>
											<li><strong>Partita Iva:</strong> " . $partita_iva_extract . "</li>
											<li><strong>Indirizzo:</strong> " . $indirizzo_extract . " " . $cap_extract . " " . $citta_extract . " (" . $provincia_extract . ") - " . $nazione_extract . " </li>
											<li><strong>Telefono fisso:</strong> " . $telefono_fisso_extract . "</li>
											<li><strong>Telefono cellulare:</strong> " . $telefono_cellulare_extract . "</li>";										
										}
							?>			
                        </ul>
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
                    </div>
                    <div id="compare">
                        <div class="form">
                            <?php include 'include/form-2-step-2.php'; ?>
                        </div>
                    </div>
                </div>
                <div id="carrello_ds_fix">                              
                    <div id="carrello_ds">
                        <div id="carrello_ds_intestazione"><?php echo $il_tuo_carrello;?></div>
                        <?php include 'include/carrello-destra.php'; ?>
                        <div style="clear:both"></div>
                        <div id="carrello_ds_action">
                            <div id="continua"><input type="submit" value="<?php echo $continua;?>" name="continua" class="continua_step" /></div>
                        </div>
                    </div>
                </div>
               </form>		
           </div>
        <div class="row">
			<?php include 'include/footer.php'; ?>
        </div>                 
    </div>
</div>
</body>
</html> 