<?php 
include 'include/connessione.php';
require 'include/auth.inc.php';
include "include/lingua.php";
include 'include/leggi_immagine.inc.php'; 			
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
$Risultato=mysql_query("SELECT 
									clienti.id_cliente, clienti.email,
									ordini.*,
									spese_di_spedizione.*,
									metodi_di_pagamento.*
									FROM ordini 
									JOIN clienti ON clienti.id_cliente = ordini.id_cliente
									INNER JOIN spese_di_spedizione ON spese_di_spedizione.id_spesa_di_spedizione = ordini.id_spesa_di_spedizione
									INNER JOIN metodi_di_pagamento ON metodi_di_pagamento.id_metodo_pagamento = ordini.id_metodo_pagamento									
									WHERE clienti.email = '" . mysql_real_escape_string($_SESSION['email']) . "' ORDER BY data_ordine DESC", $db);		    
if (!$Risultato)
{
die ("La tabella selezionata non esiste" . mysql_error());
}
$tot_records = mysql_num_rows($Risultato);		
?>
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
                    <div id="stile_titolo_pagina">Login</div>
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
                    <h2>I tuoi ordini</h2>           
                   <table class="stile_tabella">                        
                        <thead>
                            <tr>
                                <th class='titolotabella'>Id</th>
                                <th class='titolotabella'>Data</th>
                                <th class='titolotabella'>Spedito con</th>
                                 <th class='titolotabella'>Pagato con</th>
                                <th class='titolotabella'>Subtotale</th>
                                <th class='titolotabella'>Totale</th>
                                <th class='titolotabella'>Pagamento</th>
                                <th class='titolotabella'>Spedizione</th>
                                <th class='titolotabella'>Dettaglio</th>
                            </tr>
                        </thead>
                        <tbody>
						<?php
							$odd = true;
							while ($riga=mysql_fetch_array($Risultato))
			 				{
								if ($odd) {
								echo "<tr class='odd'>";
								} else {
								echo "<tr class='even'>";
								}	
							?>
                                    <td><?php echo $riga['id_ordine'];?></td>
                                    <?php $data_ordine = date("d-m-Y", strtotime($riga['data_ordine']));?>
                                    <td><?php echo $data_ordine;?></td>
                                    <td><?php echo $riga['nome_spesa_di_spedizione_ita'] . '&nbsp;(&euro; ' . $riga['costo_spesa_spedizione'] . ")";?></td>
                                    <td><?php echo $riga['nome_pagamento_ita'] . '&nbsp;(&euro; ' . $riga['costo_metodo_di_pagamento'] . ')';?></td>
                                    <td><?php echo $riga['subtotale'];?></td>
                                    <td><?php echo $riga['totale'];?></td>
                                    <td class="TAC">
                                    <?php 
											if ($riga['pagato'] == 0)
											{
											echo "<span class='alert_rosso'>Da pagare</span>";			  
											}
											else
											{
											echo "<span class='alert_verde'>Pagamento ricevuto</span>";	
											}
									?> 
                                    </td>   
                                    <td class="TAC">
                                    <?php 
											if ($riga['spedito'] == 0)
											{
											echo "<span class='alert_rosso'>Ordine da spedire</span>";			  
											}
											else
											{
											echo "<span class='alert_verde'>Ordine spedito</span>";	
											}
									?> 
                                    </td> 
                                     <td class="TAC">
                                    <?php echo "<a href='http://www.sekurbox.com/" . $lingua . "/dettaglio-ordine-" . $riga['id_ordine'] . ".html'><img src='http://www.sekurbox.com/images/dettaglio_ordini.png' /></a>"; ?> 
                                    </td>                                  
                               </tr>
                              <?php $odd = !$odd; }?>                              
                            </tbody>
                        </table>
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