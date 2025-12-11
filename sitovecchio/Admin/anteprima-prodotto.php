<?php 
session_start();
require 'include/db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$id_prodotto = $_GET["id_prodotto"];

function galleria($cartella) 
		    { 
		    $listaFile = scandir($cartella);
		    $grandezzaarray=sizeof($listaFile);
		    if ($grandezzaarray > 2) { 
		    foreach($listaFile as $value) 
		    { 
		    if($value == '.' || $value == '..') 
		    { 
		    continue; 
		    } 
		    echo '<img src="'.$cartella.'/'.$value. '" width="400" />'; 
		    }  
		    } else { 
		    echo '<img src="img/nofoto.gif" />'; 
		    } 
		    }	

$Risultato=mysql_query("SELECT * FROM prodotti WHERE id_prodotto = '$id_prodotto'", $db);
	if (!$Risultato)
	    {
		die ("La tabella selezionata non esiste" . mysql_error());
	    }
    	while ($riga=mysql_fetch_array($Risultato))
	    {					
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
    
</head>
<body>
    
        <div class="header">
		<?php include 'include/header.php';?>   
    </div>
    <?php $page="prodotti"; include 'include/menu.php';?> 
    <div class="breadCrumb clearfix">    
        <ul id="breadcrumbs">
			<?php include 'include/breadcrumbs.php';?>
        </ul>        
    </div>
    
    <div class="content">   
        
        <div class="row-fluid typography">
    
            <div class="widget">
                
                <div class="block">
                    <h4><?php echo $riga['title_ita'] . " (Cod. " . $riga['codice'] . ")"; ?></h4>
                    <div class="row-fluid">
                        <div class="span12">
                                            <?php 
												$id_prodotto = $riga['id_prodotto'];
												galleria("../images/galleria/prodotti/" . $id_prodotto); 
											?>
                            <ul>
                                <li><strong>Codice :</strong> <?php echo $riga['codice'];?></li>
                                <li><strong>Title in Italiano per i motori di ricerca :</strong> <?php echo $riga['title_ita'];?></li>
                                <li><strong>Title in Inglese per i motori di ricerca :</strong> <?php echo $riga['title_eng'];?></li>
                                <li><strong>Description in Italiano per i motori di ricerca :</strong> <?php echo $riga['description_ita'];?></li>
                                <li><strong>Description in Inglese per i motori di ricerca :</strong> <?php echo $riga['description_eng'];?></li>
                                <li><strong>Nome del prodotto in Italiano :</strong> <?php echo $riga['nome_ita'];?></li>
                                <li><strong>Nome del prodotto in Inglese :</strong> <?php echo $riga['nome_eng'];?></li>
                                <li><strong>Prezzo :</strong> <?php echo $riga['prezzo'];?></li>
                            </ul>
                        </div>
                	</div>
                    <div class="row-fluid">
                        <div class="span12">
                        	<h6>Descrizione italiano</h6>
                            <p>
                            <?php echo $riga['descrizione_ita'];?>
                            </p>
                        </div>
                    </div>
                    <div class="row-fluid">    
                        <div class="span12">
                        	<h6>Descrizione inglese</h6>
                            <p>
                            <?php echo $riga['descrizione_eng'];?>
                            </p>
                        </div>                        
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                        	<h6>Descrizione capitolato italiano</h6>
                            <p>
                            <?php echo $riga['descrizione_capitolato_ita'];?>
                            </p>
                        </div>
                    </div>
                    <div class="row-fluid">    
                        <div class="span12">
                        	<h6>Descrizione capitolato inglese</h6>
                            <p>
                            <?php echo $riga['descrizione_capitolato_eng'];?>
                            </p>
                        </div>                        
                    </div>                    
                    <div class="clearfix"></div>
                	<div class="row-fluid">    
                        <div class="span12">
                        <p><a href="prodotti.php">Ritorna alla pagina prodotti</a> | <a href="update/modifica_prodotto.php?id_prodotto=<?php echo $id_prodotto;?>">Modifica questo prodotto</a></p>
                        </div>
                   </div>     
            </div>            
                 
        </div>
        
    </div>  
  					<?php } ?>
     
    
</body>
</html>
