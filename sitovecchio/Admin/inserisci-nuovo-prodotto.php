<?php
session_start();
ini_set('session.cookie_lifetime' , '3600');
include 'include/auth.inc.php';
require 'include/db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
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
                        <div class="icon"><i class="icosg-plus1"></i></div>
                        <h2>Inserisci un nuovo prodotto</h2>
                    </div>                                               
                    <form id="validate" method="POST" action ="insert/inserisciprodotto.php" onsubmit="javascript:notify('Validation','Form #validate submited');">
                    <div class="block-fluid">
                        <div class="row-form">
                            <div class="span1">Codice:</div>
                            <div class="span3">
                                <input type="text" class="validate[required]" name="codice"/>
                                <span class="bottom">Il campo non pu&ograve; essere vuoto</span>
                            </div>
                            <div class="span1">Posizione:</div>
                            <div class="span3">
                                <input type="text" name="posizione"/>
                            </div>  
                            <div class="span1">Giacenza:</div>
                            <div class="span3">
                                <input type="text" name="giacenza"/>
                            </div>                        
                    </div>
                    <div class="head dark">
                        <div class="icon"><i class="icos-pencil2"></i></div>
                        <h2>Informazioni per i motori di ricerca</h2>
                    </div> 
                        <div class="row-form">
                            <div class="span2">Title Italiano:</div>
                            <div class="span10">
                                <input type="text" class="validate[maxSize[70]]" maxlength="70" name="title_ita"/>
                                <span class="bottom">Il campo non deve superare i 70 caratteri</span>
                            </div>
                        </div>
                        <div class="row-form">
                            <div class="span2">Title Inglese:</div>
                            <div class="span10">
                                <input type="text" class="validate[maxSize[70]]" maxlength="70" name="title_eng"/>
                                <span class="bottom">Il campo non deve superare i 70 caratteri</span>
                            </div>
                        </div>                       
                        <div class="row-form">
                            <div class="span2">Description Italiano:</div>
                            <div class="span10">
                                <input type="text" class="validate[maxSize[150]]" maxlength="150" name="description_ita"/>
                                <span class="bottom">Il campo non deve superare i 150 caratteri</span>
                            </div>
                        </div>
                        <div class="row-form">
                            <div class="span2">Description Inglese:</div>
                            <div class="span10">
                                <input type="text" class="validate[maxSize[150]]" maxlength="150" name="description_eng"/>
                                <span class="bottom">Il campo non deve superare i 150 caratteri</span>
                            </div>
                        </div> 
                        <div class="row-form">
                            <div class="span2">Url Italiano:</div>
                            <div class="span10">
                                <input type="text" class="validate[required, maxSize[150]]" maxlength="150" name="url"/>
                                <span class="bottom">Il campo non può essere vuoto e non deve superare i 150 caratteri</span>
                            </div>
                        </div> 
                        <div class="row-form">
                            <div class="span2">Url Inglese:</div>
                            <div class="span10">
                                <input type="text" class="validate[required, maxSize[150]]" maxlength="150" name="url_eng"/>
                                <span class="bottom">Il campo non può essere vuoto e non deve superare i 150 caratteri</span>
                            </div>
                        </div>                                                                      
                    	<div class="head dark">
                        	<div class="icon"><i class="icos-pencil2"></i></div>
                        	<h2>Informazioni sul prodotto</h2>
                    	</div>                                             
                        <div class="row-form">
                            <div class="span2">Nome Italiano:</div>
                            <div class="span10">
                                <input type="text" class="validate[required]" name="nome_ita"/>
                                <span class="bottom">Il campo non può essere vuoto</span>
                            </div>
                        </div>
                        <div class="row-form">
                            <div class="span2">Nome Inglese:</div>
                            <div class="span10">
                                <input type="text" class="validate[required]" name="nome_eng"/>
                                <span class="bottom">Il campo non può essere vuoto</span>
                            </div>
                        </div>                                   
                        <div class="row-form">
                            <div class="span2">Descrizione Italiano:</div>
                            <div class="span10"><textarea placeholder="Placeholder example" name="descrizione_ita"></textarea></div>
                        </div>
                        <div class="row-form">
                            <div class="span2">Descrizione Inglese:</div>
                            <div class="span10"><textarea placeholder="Placeholder example" name="descrizione_eng"></textarea></div>
                        </div>
                     <input type="hidden" name="descrizione_capitolato_ita" value=""/>
                      
                       <input type="hidden"  name="descrizione_capitolato_eng" value="" />
                       
                          <div class="row-form">
                            <div class="span2">Prezzo:</div>
                            <div class="span10">
                                <input type="text" class="validate[required]" name="prezzo" value="0"/>
                                
                            </div>
                        </div>  
                         <div class="row-form">
                            <div class="span2">Sconto:</div>
                            <div class="span10">
                                <input type="text"  name="sconto" value="0"/>
                               
                            </div>
                        </div>  
                        
 			<div class="row-form">
                            <div class="span1">Pubblicato:</div>
                            <div class="span3">                            
                                <input type="radio" class="validate[required]" name="visible" value="1"/> SI 
                                <input type="radio" class="validate[required]" name="visible" value="0"/> NO
                                <span class="bottom">Scelta obbligatoria</span>
                            </div>
                           	<div class="span1">Home:</div>
                            <div class="span3">                            
                                <input type="radio" class="validate[required]" name="primo_piano" value="1"/> SI 
                                <input type="radio" class="validate[required]" name="primo_piano" value="0"/> NO
                                <span class="bottom">Scelta obbligatoria</span>
                            </div>
                           	<div class="span1">Puglia:</div>
                            <div class="span3">                            
                                <input type="radio" class="validate[required]" name="puglia" value="1"/> SI 
                                <input type="radio" class="validate[required]" name="puglia" value="0"/> NO
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
                </div>
      </div>
   </div>
  
</body>
</html>
