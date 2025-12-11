<?php 
session_start();
require 'include/db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$id_cliente = $_GET["id_cliente"];


$query = "SELECT  clienti.*,clienti.id_tipologia_cliente AS tipcli,
         tipologia_cliente.id_tipologia_cliente, tipologia_cliente.tipologia_cliente_it,
         nazioni.ID, nazioni.Nazione,
         regioni.id, regioni.cod_regione, regioni.regione,
         province.id, province.provincia, province.sigla
         FROM  clienti
         INNER JOIN tipologia_cliente ON clienti.id_tipologia_cliente = tipologia_cliente.id_tipologia_cliente
         LEFT JOIN nazioni ON clienti.id_nazione = nazioni.ID
         LEFT JOIN regioni ON clienti.id_regione = regioni.id
         LEFT JOIN province ON clienti.id_provincia = province.id
         WHERE clienti.id_cliente= '" . $id_cliente . "'";	   
$Risultato = mysql_query($query, $db) or die (mysql_error($db));
  $riga=mysql_fetch_assoc($Risultato);
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
    
    <script src="http://www.sekurbox.com/js/jquery.validate.min.js" type="text/javascript"></script>
    <script>
$().ready(function() {

	// validate signup form on keyup and submit
	$("#validatesconto").validate({
		rules: {
                    
                        codice_esterno: {
                            
                        remote: {url:"http://www.sekurbox.com/include/verificacodicesconto.php"  ,
                                 type: "post",
                                 data:{tipologia:'<?php echo $riga['tipcli'];?>' }
                                }
                        }
			
		},
		messages: {
                         codice_esterno: {
			
				remote: "<?php echo 'Codice sconto inesistente';?>"
			}
		}
	});
});
</script>
    
</head>
<body>
    
        <div class="header">
		<?php include 'include/header.php';?>   
    </div>
    <?php $page="clienti"; include 'include/menu.php';?> 
    <div class="breadCrumb clearfix">    
        <ul id="breadcrumbs">
			<?php include 'include/breadcrumbs.php';?>
        </ul>        
    </div>
    
    <div class="content">   
        
        <div class="row-fluid typography">
    
            <div class="widget">
                
                <div class="block">
                    <h4>Dettaglio cliente</h4>
                    <div class="row-fluid">
                        <div class="span12">
                            <ul>
                            <?php
                           
                                    	
                                            echo "
                                            <li><strong>Tipo cliente:</strong> " . $riga['tipologia_cliente_it'] . "</li>
                                            <li><strong>Password:</strong> " . $riga['password'] . "</li>
                                            <li><strong>Email:</strong> " . $riga['email'] . "</li>
                                            <li><strong>Nome:</strong> " . $riga['nome'] . "&nbsp;" . $riga['cognome'] . "</li>
                                            <li><strong>Data di Nascita:</strong> " . $riga['data_di_nascita'] . "</li>
                                            <li><strong>Codice Fiscale:</strong> " . $riga['codice_fiscale'] . "</li>
                                            <li><strong>Ragione Sociale:</strong> " . $riga['ragione_sociale'] . "</li>
                                            <li><strong>Partita Iva:</strong> " . $riga['partita_iva'] . "</li>
                                            <li><strong>Indirizzo:</strong> " . $riga['indirizzo'] . "</li>
                                            <li><strong>Citt&agrave;:</strong> " . $riga['citta'] . "</li>
                                            <li><strong>CAP:</strong> " . $riga['cap'] . "</li>
                                            <li><strong>Provincia:</strong> " . $riga['provincia'] . "</li>
                                            <li><strong>Regione:</strong> " . $riga['regione'] . "</li>
                                            <li><strong>Nazione:</strong> " . $riga['Nazione'] . "</li>
                                            <li><strong>Telefono Fisso:</strong> " . $riga['telefono_fisso'] . "</li>
                                            <li><strong>Telefono Cellulare:</strong> " . $riga['telefono_cellulare'] . "</li>
                                            <li><strong>Codice Sconto:</strong> " . $riga['codice_sconto'] . "</li>
                                            <li><strong>Codice per Privato:</strong> " . $riga['codice_per_privato'] . "</li>
                                            <li><strong>Codice per Installatore:</strong> " . $riga['codice_per_installatore'] . "</li>
                                            ";
                                    	?>
			
										
                            </ul>
                        </div>
                	</div>
	
                    <?php
                    
                     $queryp = "SELECT  *
                               FROM  punti
                               WHERE id_cliente= '" . $id_cliente . "'";	   
                    $Risultatop = mysql_query($queryp, $db) or die (mysql_error($db));
                    $rigap=mysql_fetch_assoc($Risultatop);
                    
                    
                    
                    ?>
                    
                    
                           <div class="head">
                        <div class="icon"><i class="icosg-plus1"></i></div>
                        <h2>Punti totali  <?php echo $rigap['punti'];?></h2>
                    </div>                                               
                    <form id="validate" method="POST" onsubmit="javascript:notify('Validation','Form #validate submited');" action="insert/associasconto.php?id_cliente=<?php echo $id_cliente;?>">
                    <div class="block-fluid">
                      <div class="row-form"> 
                        <div class="span2">Sottrai punti:</div> 
                        <div class="span1">
                            <input type="text"  name="punti" value="0" style="width:50px;"/>
                        	
                        </div>
                     </div>
                        <div class="toolbar bottom TAR">
                            <div class="btn-group">
                                <button class="btn btn-primary" type="submit">Salva</button>
                            </div>
                        </div>                     
                     </div>
                     </form> 
                    
						
                     <div class="head">
                        <div class="icon"><i class="icosg-plus1"></i></div>
                        <h2>Associa uno sconto al cliente</h2>
                    </div>                                               
                    <form id="validate" method="POST" onsubmit="javascript:notify('Validation','Form #validate submited');" action="insert/associasconto.php?id_cliente=<?php echo $id_cliente;?>">
                    <div class="block-fluid">
                      <div class="row-form">
                        <div class="span2">Sconto:</div> 
                        <div class="span1">
                        	<input type="text"  name="sconto_cliente" value="<?php echo $riga['sconto'];?>" style="width:50px;"/>%
                                
                        </div>
                     </div>
                        <div class="toolbar bottom TAR">
                            <div class="btn-group">
                                <button class="btn btn-primary" type="submit">Salva</button>
                            </div>
                        </div>                     
                     </div>
                     </form>   
                    
                    
                       <div class="head">
                        <div class="icon"><i class="icosg-plus1"></i></div>
                        <h2>Codice sconto</h2>
                    </div>                                               
                    <form id="validatesconto" method="POST"  action="insert/associasconto.php?id_cliente=<?php echo $id_cliente;?>">
                    <div class="block-fluid">
                      <div class="row-form">
                        <div class="span2">Codice sconto:</div> 
                        <div class="span2">
                        	<input type="text" id="codice_sconto" name="codice_esterno" value="<?php echo $riga['codice_sconto'];?>" />
                                
                        </div>
                     </div>
                        <div class="toolbar bottom TAR">
                            <div class="btn-group">
                                <button class="btn btn-primary" type="submit">Salva</button>
                            </div>
                        </div>                     
                     </div>
                     </form>  
                    
                    
                         <div class="head">
                        <div class="icon"><i class="icosg-plus1"></i></div>
                        <h2>Attivato</h2>
                    </div>                                               
                    <form id="validate" method="POST" onsubmit="javascript:notify('Validation','Form #validate submited');" action="insert/associasconto.php?id_cliente=<?php echo $id_cliente;?>">
                    <div class="block-fluid">
                      <div class="row-form">
                        <div class="span2">Attivato:</div> 
                        <div class="span1">
                            
                            <select name="attivo">
                                <option value="si" <?php if($riga['attivo']=='si') echo 'selected="selected"'; ?>> SI </option>
                                <option value="no" <?php if($riga['attivo']=='no') echo 'selected="selected"'; ?>> NO </option>   
                            </select>
                        	
                        </div>
                     </div>
                        <div class="toolbar bottom TAR">
                            <div class="btn-group">
                                <button class="btn btn-primary" type="submit">Salva</button>
                            </div>
                        </div>                     
                     </div>
                     </form>  
				                                     
                    <div class="clearfix"></div>
                	<div class="row-fluid">    
                        <div class="span12">
                        <p><a href="clienti.php">Ritorna alla pagina clienti</a></p>
                        </div>
                   </div>     
            </div>            
                 
        </div>
        
    </div>  
     
    
</body>
</html>
