<?php 
include 'include/connessione.php';
include "include/lingua.php"; 			
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
require 'include/auth.inc.php';
$email = $_SESSION['email'];
$query_user='SELECT 
             clienti.*,
             tipologia_cliente.id_tipologia_cliente, tipologia_cliente.tipologia_cliente_it, tipologia_cliente.tipologia_cliente_eng
	     FROM clienti 
	     INNER JOIN  tipologia_cliente ON tipologia_cliente.id_tipologia_cliente = clienti.id_tipologia_cliente
	     WHERE clienti.id_cliente = "' . mysql_real_escape_string($_SESSION['user']) . '"';
$Risultato_user = mysql_query($query_user, $db) or die (mysql_error($db));
$riga_user=mysql_fetch_assoc($Risultato_user);
	
		$id_tipologia_cliente = $riga_user['id_tipologia_cliente'];
		$profilo_it = $riga_user['tipologia_cliente_it'];
		$profilo_uk = $riga_user['tipologia_cliente_eng'];
		$nome_cliente=$riga_user['nome'];
		$cognome_cliente=$riga_user['cognome'];
                if ($id_tipologia_cliente==1){ $codice_sconto=$riga_user['codice_sconto'];   }
                else  if ($id_tipologia_cliente==2){ $codice_sconto=$riga_user['codice_sconto'];  $codice_per_privato=$riga_user['codice_per_privato'];}
                else  if ($id_tipologia_cliente==3){ $codice_sconto=$riga_user['codice_sconto'];  $codice_per_privato=$riga_user['codice_per_privato']; $codice_per_installatore=$riga_user['codice_per_installatore'];}
		
	
$querypunti="SELECT punti FROM punti WHERE id_cliente='".$riga_user['id_cliente']."' ";
$resultpunti=mysql_query($querypunti);
$listpunti=  mysql_fetch_assoc($resultpunti);
                
include 'include/leggi_immagine.inc.php'; 	
?>
<script type="text/javascript" src="http://www.sekurbox.com/js/jquery.animateNumber.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$(function () {
$('.numero_punti').animateNumber({ number: '<?php echo $listpunti['punti'];?>' },
{duration: 1500}
);
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
                    <div id="stile_titolo_pagina">Area Riservata</div>
                    <div id="briciole_di_pane"><a href="http://www.sekurbox.com/<?php echo $lingua; ?>/index.html">Home Page</a> / Login</div>
                </div>
            </div>  
            <div id="titolo_pagina_ds">
				<?php include 'include/banner-promozionale.php'; ?>
           </div>           
       </div>      
		<div class="row">
        	<div id="colonna_sn">
                <ul class="menu_laterale_case">
                    <?php $pagina="login"; include 'include/menu-sn-area-riservata.php';?>      	
                </ul>            
            </div>
            <div id="colonna_ds">
                <div id="card">
                	<div id="card_sn">
                		<div id="card_img">
                        	<?php 
							if ($id_tipologia_cliente==1)
							{echo '<img src="http://www.sekurbox.com/images/cliente_finale.png" />';}
							else if ($id_tipologia_cliente==2)
							{echo '<img src="http://www.sekurbox.com/images/installatore.png" />';}
							else if ($id_tipologia_cliente==3)
							{echo '<img src="http://www.sekurbox.com/images/venditore.png" />';}
                    		?>
                    	</div>
                        <div id="card_livello">
                        	<?php 
							if ($lingua=="it")
							{
								echo $profilo_it;
							}
							else
							{
								echo $profilo_uk;
							}	
							?>
                        </div>
                        <div id="card_nome">
                        	<?php echo $nome_cliente . " " . $cognome_cliente;?>
                        </div>
                       <?php
                       if ($id_tipologia_cliente==1){  ?>  
                            
                        <div id="card_codice">
                        	<?php echo $codice_scontol;?> <?php echo $codice_sconto; ?>
                            <?php if(trim($codice_sconto)=='') echo "<span style='color:#00989e'> ".$nesscodi."</span>";?> 
                              
                        </div>
                            
                       <?php } ?>    
                        
                        <?php
                       if ($id_tipologia_cliente==2){  ?>  
                            
                        <div id="card_codice">
                        	<?php echo $codice_scontol;?> <?php echo $codice_sconto;?>
                            <?php if(trim($codice_sconto)=='') echo "<span style='color:#00989e'> Nessun codice sconto</span>";?> 
                        </div>
                            <div id="card_codice">
                        	<?php echo $codice_per_privatol;?> <?php echo $codice_per_privato;?>
                        </div>
                            
                       <?php } ?> 
                       
                        <?php
                       if ($id_tipologia_cliente==3){  ?>  
                            
                        <div id="card_codice">
                        	<?php echo $codice_scontol;?> <?php echo $codice_sconto;?>
                            <?php if(trim($codice_sconto)=='') echo "<span style='color:#00989e'> Nessun codice sconto</span>";?> 
                        </div>
                               <div id="card_codice">
                        	<?php echo $codice_per_privatol;?> <?php echo $codice_per_privato;?>
                        </div>
                               <div id="card_codice">
                        	<?php echo $codice_per_installatore;?> <?php echo $codice_per_installatore;?>
                        </div>
                            
                       <?php } ?>      
                            
                    </div>
                    <div id="card_ds">
                    	<div id="card_hai_accumulato">
                        	<?php echo $hai_accumulato;?>
                        </div>
                        <div id="card_numero">
                        	<span class="numero_punti"></span>
                            <span class="punti_testo"><?php echo $punti;?></span>
                        </div>
<!--                        <div id="card_soldi">
                        	<?php echo $accumulato;?>
                        </div>-->
                    </div>	
                </div>
            </div>
      </div>
        <div class="row">
			<?php include 'include/footer.php'; ?>
        </div>               