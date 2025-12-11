<?php 
session_start();
require 'include/db.inc.php';
include '../include/leggi_immagine.inc.php'; 

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

function calcolaprezzo_dettordine($id_prodotto,$id_ordine){

                $querytemp = "SELECT * FROM dettaglio_ordine WHERE id_prodotto = '".$id_prodotto."' AND id_ordine='".$id_ordine."' ";
		$resulttemp=mysql_query($querytemp) or die(mysql_error());
                $listtemp=  mysql_fetch_assoc($resulttemp);
                $quantita=$listtemp['quantita'];
                $prezzo=$listtemp['prezzo_def'];
                $sconto_prodotto=$listtemp['sconto'];
   
                $testo_carrello_sopra.='<td>';
              
              

        
        //SE E' LOGGATO E C'E' LO SCONTO PRODOTTO
        if ( $sconto_prodotto > 0){
            
            $sconto= ($prezzo * $sconto_prodotto) / 100;
            $prezzo_scontato = $prezzo - $sconto;
      
                $prezzo_scontato_sop=$prezzo_scontato*$quantita;
                $testo_carrello_sopra.=$sconto_prodotto . ' %</td>';
                $testo_carrello_sopra.='<td>&euro; '  .number_format($prezzo_scontato_sop, 2, ',', '.').'</td>';
       
        } 
        /////////////////////////////////////////////////////////
        //SE E' LOGGATO E NON C'E' LO SCONTO PRODOTTO
        else{
            $oksconto=0;
            
            $prezzo_scontato = $prezzo;
            $sconto=$prezzo;
            
            $queryc="SELECT *
                     FROM ordini
                     WHERE id_ordine='".$id_ordine."' ";
            $resultc=mysql_query($queryc) or die(mysql_error());
            $listc=  mysql_fetch_assoc($resultc);
            
            $sconto_cliente=$listc['sconto_cliente'];
            $sconto_listino=$listc['sconto_listino'];
            
            if($sconto_listino>0){
              
             $sconto= ($prezzo * $sconto_listino) / 100;
             $prezzo_scontato = $prezzo - $sconto;   
             $testo_carrello_sopra.=$sconto_listino.'%';   
             $oksconto=1;
                
            }
            
            if($sconto_cliente>0){
               
             $sconto= ($sconto * $sconto_cliente) / 100;
             $prezzo_scontato = $prezzo_scontato - $sconto;      
             if($sconto_listino>0)  { $testo_carrello_sopra.=' + '.$sconto_cliente.'%</td>';  }
             else{ $testo_carrello_sopra.= $sconto_cliente.'%</td>';}
            
             $oksconto=1;
            }
            
         
          
          
             if($oksconto==1){  
                    
                  $testo_carrello_sopra.='<td>&euro; '  .number_format($prezzo_scontato*$quantita, 2, ',', '.').'</td>';
             
                }
             
             else{
                    
                  $testo_carrello_sopra.='<td>&euro; '  .number_format($prezzo*$quantita, 2, ',', '.').'</td>';
         
             }
  } 
    return $testo_carrello_sopra; 
   
}

$id_ordine = $_GET["id_ordine"];

$query = 'SELECT prodotti.id_prodotto, prodotti.url, prodotti.nome_ita, prodotti.nome_eng,prodotti.codice,
            dettaglio_ordine.id_ordine, dettaglio_ordine.quantita, dettaglio_ordine.id_prodotto, dettaglio_ordine.prezzo_def, dettaglio_ordine.sconto
            FROM prodotti 
            INNER JOIN dettaglio_ordine ON dettaglio_ordine.id_prodotto = prodotti.id_prodotto
            WHERE 
            dettaglio_ordine.id_ordine = "' . mysql_real_escape_string($id_ordine) . '"
            ORDER BY
            dettaglio_ordine.id_prodotto ASC';	
							  	
$query_ordine = "SELECT ordini.*,
                        clienti.*,
                        province.*,
                        nazioni.*,
                        spese_di_spedizione.*,
                        metodi_di_pagamento.*					   
			FROM ordini 
			LEFT JOIN clienti ON ordini.id_cliente = clienti.id_cliente
			LEFT JOIN province ON clienti.id_provincia = province.id
			LEFT JOIN province AS p ON ordini.id_provincia_spedizione = p.id
			LEFT JOIN nazioni ON clienti.id_nazione = nazioni.ID
			LEFT JOIN nazioni AS n ON ordini.id_nazione_spedizione = n.ID			
			LEFT JOIN spese_di_spedizione ON spese_di_spedizione.id_spesa_di_spedizione = ordini.id_spesa_di_spedizione
			LEFT JOIN metodi_di_pagamento ON metodi_di_pagamento.id_metodo_pagamento = ordini.id_metodo_pagamento
			WHERE 
           	        ordini.id_ordine = '" . mysql_real_escape_string($id_ordine) . "'
			ORDER BY ordini.data_ordine DESC";	

$Risultato_ordine = mysql_query($query_ordine, $db) or die (mysql_error($db));					
while ($riga_ordine=mysql_fetch_array($Risultato_ordine))
{									
$data_ordine = date("d-m-Y", strtotime($riga_ordine['data_ordine']));
if ($riga_ordine['id_tipologia_cliente'] == '1')
{
	$data_di_nascita = date("d-m-Y", strtotime($riga_ordine['data_di_nascita']));
	$cliente = "<a href='dettaglio_cliente.php?id_cliente=" . $riga_ordine['id_cliente'] . "'>" . $riga_ordine['nome'] . " " . $riga_ordine['cognome'] . "</a><br />
	Email: " . $riga_ordine['email'] . "<br />
	Data di nascita: " . $data_di_nascita;
}
else
{
	$cliente =  "<a href='dettaglio-cliente.php?id_cliente=" . $riga_ordine['id_cliente'] . "'>" . $riga_ordine['ragione_sociale'] . "</a><br />
	Email: " . $riga_ordine['email'] . "<br />
	Codice Fiscale: " . $riga_ordine['codice_fiscale'] . "<br />
	Partita IVA: " . $riga_ordine['partita_iva'];
}
$subtotale_ordine = $riga_ordine['subtotale'];
$totale_ordine = $riga_ordine['totale'];
$spedizione = $riga_ordine['nome_spesa_di_spedizione_ita'] . '&nbsp;(&euro; ' . $riga_ordine['costo_spesa_spedizione'] . ")";
$pagamento = $riga_ordine['nome_pagamento_ita'] . '&nbsp;(&euro; ' . $riga_ordine['costo_metodo_di_pagamento'] . ')';
if ($riga_ordine['indirizzo_spedizione'] == "")
{
	$dati_spedizione = "Indirizzo: " . $riga_ordine['indirizzo'] . " " . $riga_ordine['cap'] . " " . $riga_ordine['citta'] . " " . $riga_ordine['sigla'] . "<br />
	Telefono fisso: " . $riga_ordine['telefono_fisso'] . "<br />
	Telefono Cellulare: " . $riga_ordine['telefono_cellulare'];
}
else
{
	$dati_spedizione = "Nome: " . $riga_ordine['nome_spedizione'] . "<br />
	Cognome: " . $riga_ordine['cognome_spedizione'] . "<br />
	Indirizzo: " . $riga_ordine['indirizzo_spedizione'] . " " . $riga_ordine['cap_spedizione'] . " " . $riga_ordine['citta_spedizione'] . "<br /> 
	Telefono fisso: " . $riga_ordine['telefono_fisso_spedizione'] . "<br />
	Telefono Cellulare: " . $riga_ordine['telefono_cellulare_spedizione'];
}
$note_corriere = $riga_ordine['note_per_il_corriere'];

}											   
?>	

<!DOCTYPE html>
<html lang="en">
<head>        
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <!--[if gt IE 8]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <![endif]-->        
    
<title><?php include 'include/head.php';?></title>    
    <link href="css/stylesheets.css" rel="stylesheet" type="text/css" />      
    <!--[if lt IE 10]>
        <link href="css/ie.css" rel="stylesheet" type="text/css" />
    <![endif]-->        
    
    <script type='text/javascript' src='js/plugins/jquery/jquery-1.10.2.min.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/jquery-ui-1.10.1.custom.min.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/jquery-migrate-1.1.1.min.js'></script>
    
    <script type='text/javascript' src='js/plugins/jquery/globalize.js'></script>
    <script type='text/javascript' src='js/plugins/other/excanvas.js'></script>
    
    <script type='text/javascript' src='js/plugins/other/jquery.mousewheel.min.js'></script>
        
    <script type='text/javascript' src='js/plugins/bootstrap/bootstrap.min.js'></script>            
    
    <script type='text/javascript' src='js/plugins/cookies/jquery.cookies.2.2.0.min.js'></script>
    
    <script type='text/javascript' src='js/plugins/fancybox/jquery.fancybox.pack.js'></script>
    
    <script type='text/javascript' src='js/plugins/jflot/jquery.flot.js'></script>    
    <script type='text/javascript' src='js/plugins/jflot/jquery.flot.stack.js'></script>    
    <script type='text/javascript' src='js/plugins/jflot/jquery.flot.pie.js'></script>
    <script type='text/javascript' src='js/plugins/jflot/jquery.flot.resize.js'></script>
    
    <script type='text/javascript' src='js/plugins/epiechart/jquery.easy-pie-chart.js'></script>
    <script type='text/javascript' src='js/plugins/knob/jquery.knob.js'></script>
        
    <script type='text/javascript' src='js/plugins/sparklines/jquery.sparkline.min.js'></script>    
    
    <script type='text/javascript' src='js/plugins/pnotify/jquery.pnotify.min.js'></script>
    
    <script type='text/javascript' src='js/plugins/fullcalendar/fullcalendar.min.js'></script>        
    
    <script type='text/javascript' src='js/plugins/datatables/jquery.dataTables.min.js'></script>    
    
    <script type='text/javascript' src='js/plugins/wookmark/jquery.wookmark.js'></script>        
    
    <script type='text/javascript' src='js/plugins/jbreadcrumb/jquery.jBreadCrumb.1.1.js'></script>
    
    <script type='text/javascript' src='js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'></script>
    
    <script type='text/javascript' src="js/plugins/uniform/jquery.uniform.min.js"></script>
    <script type='text/javascript' src="js/plugins/select/select2.min.js"></script>
    <script type='text/javascript' src='js/plugins/tagsinput/jquery.tagsinput.min.js'></script>
    <script type='text/javascript' src='js/plugins/maskedinput/jquery.maskedinput-1.3.min.js'></script>
    <script type='text/javascript' src='js/plugins/multiselect/jquery.multi-select.min.js'></script>    
    
    <script type='text/javascript' src='js/plugins/validationEngine/languages/jquery.validationEngine-en.js'></script>
    <script type='text/javascript' src='js/plugins/validationEngine/jquery.validationEngine.js'></script>        
    <script type='text/javascript' src='js/plugins/stepywizard/jquery.stepy.js'></script>
        
    <script type='text/javascript' src='js/plugins/animatedprogressbar/animated_progressbar.js'></script>
    <script type='text/javascript' src='js/plugins/hoverintent/jquery.hoverIntent.minified.js'></script>
    
    <script type='text/javascript' src='js/plugins/media/mediaelement-and-player.min.js'></script>    
    
    <script type='text/javascript' src='js/plugins/cleditor/jquery.cleditor.js'></script>
    
    <script type='text/javascript' src='js/plugins/shbrush/XRegExp.js'></script>
    <script type='text/javascript' src='js/plugins/shbrush/shCore.js'></script>
    <script type='text/javascript' src='js/plugins/shbrush/shBrushXml.js'></script>
    <script type='text/javascript' src='js/plugins/shbrush/shBrushJScript.js'></script>
    <script type='text/javascript' src='js/plugins/shbrush/shBrushCss.js'></script>    
    
    <script type='text/javascript' src='js/plugins/filetree/jqueryFileTree.js'></script>        
        
    <script type='text/javascript' src='js/plugins/slidernav/slidernav-min.js'></script>    
    <script type='text/javascript' src='js/plugins/isotope/jquery.isotope.min.js'></script>    
    <script type='text/javascript' src='js/plugins/jnotes/jquery-notes_1.0.8_min.js'></script>
    <script type='text/javascript' src='js/plugins/jcrop/jquery.Jcrop.min.js'></script>
    <script type='text/javascript' src='js/plugins/ibutton/jquery.ibutton.min.js'></script>

    <script type='text/javascript' src='js/plugins/scrollup/jquery.scrollUp.min.js'></script>    
    
    <script type='text/javascript' src='js/plugins.js'></script>
    <script type='text/javascript' src='js/charts.js'></script>
    <script type='text/javascript' src='js/actions.js'></script>
<script type="text/javascript">
<!--
 
var stile = "top=10, left=10, width=1080, height=768, status=no, menubar=no, toolbar=no scrollbars=yes";
 
function Popup(apri) 
{
  window.open(apri, "", stile);
}
//-->
</script> 
</head>
<body>   
    <div class="header">
		<?php include 'include/header.php';?>   
    </div>
    <?php $page="ecommerce"; include 'include/menu.php';?> 
    <div class="breadCrumb clearfix">    
        <ul id="breadcrumbs">
			<?php include 'include/breadcrumbs.php';?>
        </ul>        
    </div>
   <div class="content">

        <div class="row-fluid">
                        
            <div class="span12">
                
                <div class="middle">                                         
                    <div class="button tip" title="Print Invoice">
                        <a href="javascript:Popup('dettaglio-ordine_stampa.php?id_ordine=<?php echo $id_ordine;?>')">
                            <span class="icomg-printer"></span>
                            <span class="text">Stampa</span>
                        </a>                    
                    </div>                                          
                </div>
                
                <div class="widget">
                    <div class="block invoice">                       
						<h1>ID ORDINE #<?php echo $id_ordine;?></h1>                        
                        <div class="row-fluid">
                            <div class="span6">
                                <h5>Effettuato da <?php echo $cliente;?></h5>
                                <h4>Da spedire a</h4>
                                <address>
									<?php echo $dati_spedizione;?>
                                    <br>
                                    <?php if ($note_corriere == "") {echo "";} else {echo "Note per il corriere: " . $note_corriere;}?>
                                </address>
                            </div>
                            <div class="span3"></div>
                            <div class="span3">
                                <h4>Dettagli</h4>
                                <p><strong>Data: <?php echo $data_ordine;?></strong><br />
                                   	<strong>Subtotale:</strong> <?php echo $subtotale_ordine;?> &euro; <br />
                                    <strong>Spedito con: </strong> <?php echo $spedizione;?><br />
                            		<strong>Pagato con: </strong> <?php echo $pagamento;?><br />
                                    <strong>Totale:</strong> <?php echo $totale_ordine;?> <em>Euro</em>
                                </p>    
                            </div>
                        </div>
                        <h3>Descrizione ordine</h3>                        
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="10%"></th>
                                    <th width="10%">Codice</th>
                                    <th width="20%">Descrizione</th>
                                    <th width="5%">Prezzo</th>
                                    <th width="5%">Quantità</th>
                                    <th width="10%">Sconto</th>
                                    <th width="10%">Totale</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							
                         
                            
                  $Risultato = mysql_query($query, $db) or die (mysql_error($db));					
		   while ($riga=mysql_fetch_array($Risultato))
							{
                                    $prezzo_prodotto = $riga['prezzo_def'];
                                    $percentuale_di_sconto = $riga['sconto'];
                                    $sconto_prodotto = ($prezzo_prodotto * $percentuale_di_sconto) / 100;
                                    $prezzo_scontato = $prezzo_prodotto - $sconto_prodotto;
                                    $totale_prodotto = $riga['quantita'] * $prezzo_scontato;
                             ?>						
                                <tr>
                                    <td><?php leggi_immagine("../images/miniature/prodotti/" . $riga['id_prodotto'], 60);?></td>
                                	<td><?php echo $riga['codice'];?></td>
                                    <td><?php echo $riga['nome_ita'];?></td>
                                    
                                    
                                    <td><?php echo $riga['prezzo_def'];?> &euro;</td>
                                    <td><?php echo $riga['quantita'];?></td>
                             <?php  echo calcolaprezzo_dettordine($riga['id_prodotto'],$id_ordine);  ?>
                                    
                                    
                                    
                                    
                                </tr>
                     		<?php } ?>                                               
                            </tbody>
                        </table>
                        
                        <div class="row-fluid">
                            <div class="span9"></div>
                            <div class="span3">
                                <div class="total">
                                    <div class="highlight">
                                        <strong><span>Totale:</span> <?php echo $totale_ordine;?> <em>EURO</em></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>
            
        </div>        
        
        
    </div>  
    
</body>
</html> 
    
              

