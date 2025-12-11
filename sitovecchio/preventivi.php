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
$query="SELECT 
			clienti.id_cliente, clienti.email,
			preventivi.*
			FROM preventivi 
			JOIN clienti ON clienti.id_cliente = preventivi.id_cliente
			WHERE clienti.email = '" . mysql_real_escape_string($_SESSION['email']) . "' 
			ORDER BY preventivi.data_preventivo DESC";		    
$Risultato = mysql_query($query, $db) or die (mysql_error($db));
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
                    <div id="briciole_di_pane"><a href="index.php">Home Page</a> / Login</div>
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
                                <th class='titolotabella'>Totale</th>
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
                                    <td><?php echo $riga['id_preventivo'];?></td>
                                    <?php $data_ordine = date("d-m-Y", strtotime($riga['data_preventivo']));?>
                                    <td><?php echo $data_ordine;?></td>
                                    <td><?php echo $riga['totale_preventivo'];?></td>
                                     <td class="TAC">
                                    <?php echo "<a href='http://www.sekurbox.com/" . $lingua . "/dettaglio-preventivo-" . $riga['id_preventivo'] . ".html'><img src='http://www.sekurbox.com/images/dettaglio_ordini.png' /></a>"; ?> 
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