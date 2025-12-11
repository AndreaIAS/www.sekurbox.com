<?php
session_start();
include 'include/auth.inc.php';
require 'include/db.inc.php';
$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
	
	$Risultato=mysql_query("SELECT * FROM prodotti WHERE id_prodotto = '" . $_GET["id_prodotto"] . "'", $db);
	if (!$Risultato)
	{
		die ("La tabella selezionata non esiste" . mysql_error());
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
       <script type='text/javascript' src='js/plugins/ckeditor/ckeditor.js'></script>
  
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
      <div class="row-fluid">
<div class="widget">
                    <div class="head">
                        <div class="icon"><i class="icosg-pencil"></i></div>
                        <?php
						while ($riga=mysql_fetch_array($Risultato))
						{
						?>
                        <h2>Modifica il prodotto <?php echo $riga['nome_ita'];?></h2>
                    </div> 
			<?php 
				$iva_selezionata = $riga['id_iva'];
				$codice_modello_selezionato = $riga['codice_modello'];
				$codice_tessuto_selezionato = $riga['codice_tessuto'];
			?>                                                                          
                    <form id="validate" method="POST" action ="insert/inserisciprodotto.php" onsubmit="javascript:notify('Validation','Form #validate submited');">
                       <div class="block-fluid">
                        <div class="row-form">
                            <div class="span1">Modello:</div>
                            <div class="span3">
                                <select class="select" name="codice_modello" style="width: 100%;">
										<?php
                                        $Risultato3=mysql_query("select * from modelli", $db);
                                        if ($Risultato3){
                                        while($row3 = mysql_fetch_assoc($Risultato3)){
                                        echo "<option ";
                                        if ($codice_modello_selezionato == ($row3['codice_modello']))
                                            {
                                            echo "selected ";
                                            }
                                            echo "value='". $row3['codice_modello'] . "'>" . $row3['nome_modello'] . "</option>n";
                                            }
                                                           }
                                          ?>	
                                </select>                            
                             </div>
                            <div class="span1">Tessuto:</div>
                            <div class="span3">
                                <select class="select" name="codice_tessuto" style="width: 100%;">
										<?php
                                        $Risultato4=mysql_query("select * from tessuti", $db);
                                        if ($Risultato4){
                                        while($row4 = mysql_fetch_assoc($Risultato4)){
                                        echo "<option ";
                                        if ($codice_tessuto_selezionato == ($row4['codice_tessuto']))
                                            {
                                            echo "selected ";
                                            }
                                            echo "value='". $row4['codice_tessuto'] . "'>" . $row4['descrizione_tessuto_ita'] . "</option>n";
                                            }
                                                           }
                                          ?>	
                                </select>                              
                            </div>                            
                            <div class="span1">Giacenza:</div>
                            <div class="span3">
                                <input type="text" class="validate[required]" name="giacenza" value="<?php echo $riga['giacenza'];?>"/>
                                <span class="bottom">Il campo non pu&ograve; essere vuoto</span>
                            </div>                       
                    </div>
                    <div class="head dark">
                        <div class="icon"><i class="icos-pencil2"></i></div>
                        <h2>Informazioni per i motori di ricerca</h2>
                    </div> 
                        <div class="row-form">
                            <div class="span2">Title Italiano</div>
                            <div class="span10">
                                <input type="text" class="validate[maxSize[70]]" maxlength="70" name="title_ita" value="<?php echo $riga['title_ita'];?>"/>
                                <span class="bottom">Il campo non deve superare i 70 caratteri</span>
                            </div>
                        </div>
                        <div class="row-form">
                            <div class="span2">Title Inglese</div>
                            <div class="span10">
                                <input type="text" class="validate[maxSize[70]]" maxlength="70" name="title_eng" value="<?php echo $riga['title_eng'];?>"/>
                                <span class="bottom">Il campo non deve superare i 70 caratteri</span>
                            </div>
                        </div>                        
                        <div class="row-form">
                            <div class="span2">Description Italiano</div>
                            <div class="span10">
                                <input type="text" class="validate[maxSize[150]]" maxlength="150" name="description_ita" value="<?php echo $riga['description_ita'];?>"/>
                                <span class="bottom">Il campo non deve superare i 150 caratteri</span>
                            </div>
                        </div>
                        <div class="row-form">
                            <div class="span2">Description Inglese</div>
                            <div class="span10">
                                <input type="text" class="validate[maxSize[150]]" maxlength="150" name="description_eng" value="<?php echo $riga['description_eng'];?>"/>
                                <span class="bottom">Il campo non deve superare i 150 caratteri</span>
                            </div>
                        </div>
                        <div class="row-form">
                            <div class="span2">Keywords Italiano</div>
                            <div class="span10">
                                <input type="text" class="validate[maxSize[150]]" maxlength="150" name="keywords_ita" value="<?php echo $riga['keywords_ita'];?>"/>
                                <span class="bottom">Il campo non deve superare i 150 caratteri</span>
                            </div>
                        </div>
                        <div class="row-form">
                            <div class="span2">Keywords Inglese</div>
                            <div class="span10">
                                <input type="text" class="validate[maxSize[150]]" maxlength="150" name="keywords_eng" value="<?php echo $riga['keywords_eng'];?>"/>
                                <span class="bottom">Il campo non deve superare i 150 caratteri</span>
                            </div>
                        </div>                         
                        <div class="row-form">
                            <div class="span2">Url:</div>
                            <div class="span10">
                                <input type="text" class="validate[required, maxSize[150]]" maxlength="150" name="url" value="<?php echo $riga['url'];?>"/>
                                <span class="bottom">Il campo non può essere vuoto e non deve superare i 150 caratteri</span>
                            </div>
                        </div>                                               
                    	<div class="head dark">
                        	<div class="icon"><i class="icos-pencil2"></i></div>
                        	<h2>Informazioni sul prodotto</h2>
                    	</div>
                        <div class="row-form">
                            <div class="span2">Nome:</div>
                            <div class="span10">
                                <input type="text" class="validate[required]" name="nome_prodotto" value="<?php echo $riga['nome_prodotto'];?>"/>
                                <span class="bottom">Il campo non può essere vuoto</span>
                            </div>                         
                        </div>                                                                          
                        <div class="row-form">
                            <div class="span1">Prezzo:</div>
                            <div class="span3">
                                <input type="text" name="prezzo" value="<?php echo $riga['prezzo'];?>"/>
                                <span class="bottom">Il campo deve essere numerico </span>
                            </div>
                            <div class="span1">Sconto:</div>
                            <div class="span3">
                                <input type="text" class="validate[custom[integer]" name="sconto" value="<?php echo $riga['sconto'];?>"/>
                                <span class="bottom">Inserire la percentuale di sconto</span>
                            </div>
							<div class="span1">IVA:</div>
                            <div class="span3">
                                <select class="select" name="id_iva" style="width: 100%;">
										<?php
                                        $Risultato3=mysql_query("select * from iva", $db);
                                        if ($Risultato3){
                                        while($row3 = mysql_fetch_assoc($Risultato3)){
                                        echo "<option ";
                                        if ($iva_selezionata == ($row3['id_iva']))
                                            {
                                            echo "selected ";
                                            }
                                            echo "value='". $row3['id_iva'] . "'>" . $row3['iva'] . "%</option>n";
                                            }
                                                           }
                                          ?>	
                                </select>
                            </div>                        
                         </div>         
                        <div class="widget">
                    		<div class="head dark">
                        		<div class="icon"><i class="icos-pencil"></i></div>
                        		<h2>Descrizione Italiana</h2>
                    		</div>
                    		<div class="block-fluid editor">  
                        		<textarea name="descrizione_ita" style="height: 300px;"><?php echo $riga['descrizione_ita'];?></textarea>
                        		<script>
                            		$(document).ready(function(){
                                		var descrizione_ita = CKEDITOR.replace('descrizione_ita');                                
                                		$("#descrizione_ita").click(function(){
                                    		alert(descrizione_ita.getData());
                                		});
                            		});
                        		</script>                        
                    		</div>
                		</div>
                        <div class="widget">
                    		<div class="head dark">
                        		<div class="icon"><i class="icos-pencil"></i></div>
                        		<h2>Descrizione Inglese</h2>
                    		</div>
                    		<div class="block-fluid editor">  
                        		<textarea name="descrizione_eng" style="height: 300px;"><?php echo $riga['descrizione_eng'];?></textarea>
                        		<script>
                            		$(document).ready(function(){
                                		var descrizione_eng = CKEDITOR.replace('descrizione_eng');                                
                                		$("#descrizione_eng").click(function(){
                                    		alert(descrizione_eng.getData());
                                		});
                            		});
                        		</script>                        
                    		</div>
                		</div>  						
                        <div class="row-form">
                            <div class="span2">Disponibile:</div>
                            <div class="span4">                            
                                <input type="radio" class="validate[required]" name="disponibile" value="1" <?php if ($riga['disponibile']==1) {echo "checked";}?>/> SI 
                                <input type="radio" class="validate[required]" name="disponibile" value="0" <?php if ($riga['disponibile']==0) {echo "checked";}?>/> NO
                                <span class="bottom">Scelta obbligatoria</span>
                            </div>
                            <div class="span2">Visibile in Home:</div>
                            <div class="span4">                            
                                <input type="radio" class="validate[required]" name="home_page" value="1" <?php if ($riga['home_page']==1) {echo "checked";}?>/> SI 
                                <input type="radio" class="validate[required]" name="home_page" value="0" <?php if ($riga['home_page']==0) {echo "checked";}?>/> NO
                                <span class="bottom">Scelta obbligatoria</span>
                            </div>                                                 
                        </div>                       
                        <div class="toolbar bottom TAR">
                            <div class="btn-group">
                                <button class="btn btn-primary" type="submit">Salva</button>
                            </div>
                        </div>

                    </div>                
                    </form>
                    <?php } ?>
                </div>
      </div>
   </div>
  
</body>
</html>