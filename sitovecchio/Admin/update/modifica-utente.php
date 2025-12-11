<?php
session_start();
include '../include/auth.inc.php';
require '../include/db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

if (!isset($_GET["id"]))
	{
		$Id = "";
	}
	else
	{
		$Id  = $_GET["id"];
	}
	
	$Risultato=mysql_query("SELECT * FROM utenti WHERE id = '$Id'", $db);
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
    
<title><?php include '../include/head.php';?></title>
    
    <link href="../css/stylesheets.css" rel="stylesheet" type="text/css" />      
    <!--[if lt IE 10]>
        <link href="css/ie.css" rel="stylesheet" type="text/css" />
    <![endif]-->        
    
    <script type='text/javascript' src='../js/plugins/jquery/jquery-1.10.2.min.js'></script>
    <script type='text/javascript' src='../js/plugins/jquery/jquery-ui-1.10.1.custom.min.js'></script>
    <script type='text/javascript' src='../js/plugins/jquery/jquery-migrate-1.1.1.min.js'></script>
    
    <script type='text/javascript' src='../js/plugins/jquery/globalize.js'></script>
    <script type='text/javascript' src='../js/plugins/other/excanvas.js'></script>
    
    <script type='text/javascript' src='../js/plugins/other/jquery.mousewheel.min.js'></script>
        
    <script type='text/javascript' src='../js/plugins/bootstrap/bootstrap.min.js'></script>            
    
    <script type='text/javascript' src='../js/plugins/cookies/jquery.cookies.2.2.0.min.js'></script>
    
    <script type='text/javascript' src='../js/plugins/fancybox/jquery.fancybox.pack.js'></script>
    
    <script type='text/javascript' src='../js/plugins/jflot/jquery.flot.js'></script>    
    <script type='text/javascript' src='../js/plugins/jflot/jquery.flot.stack.js'></script>    
    <script type='text/javascript' src='../js/plugins/jflot/jquery.flot.pie.js'></script>
    <script type='text/javascript' src='../js/plugins/jflot/jquery.flot.resize.js'></script>
    
    <script type='text/javascript' src='../js/plugins/epiechart/jquery.easy-pie-chart.js'></script>
    <script type='text/javascript' src='../js/plugins/knob/jquery.knob.js'></script>
        
    <script type='text/javascript' src='../js/plugins/sparklines/jquery.sparkline.min.js'></script>    
    
    <script type='text/javascript' src='../js/plugins/pnotify/jquery.pnotify.min.js'></script>
    
    <script type='text/javascript' src='../js/plugins/fullcalendar/fullcalendar.min.js'></script>        
    
    <script type='text/javascript' src='../js/plugins/datatables/jquery.dataTables.min.js'></script>    
    
    <script type='text/javascript' src='../js/plugins/wookmark/jquery.wookmark.js'></script>        
    
    <script type='text/javascript' src='../js/plugins/jbreadcrumb/jquery.jBreadCrumb.1.1.js'></script>
    
    <script type='text/javascript' src='../js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'></script>
    
    <script type='text/javascript' src="../js/plugins/uniform/jquery.uniform.min.js"></script>
    <script type='text/javascript' src="../js/plugins/select/select2.min.js"></script>
    <script type='text/javascript' src='../js/plugins/tagsinput/jquery.tagsinput.min.js'></script>
    <script type='text/javascript' src='../js/plugins/maskedinput/jquery.maskedinput-1.3.min.js'></script>
    <script type='text/javascript' src='../js/plugins/multiselect/jquery.multi-select.min.js'></script>    
    
    <script type='text/javascript' src='../js/plugins/validationEngine/languages/jquery.validationEngine-en.js'></script>
    <script type='text/javascript' src='../js/plugins/validationEngine/jquery.validationEngine.js'></script>        
    <script type='text/javascript' src='../js/plugins/stepywizard/jquery.stepy.js'></script>
        
    <script type='text/javascript' src='../js/plugins/animatedprogressbar/animated_progressbar.js'></script>
    <script type='text/javascript' src='../js/plugins/hoverintent/jquery.hoverIntent.minified.js'></script>
    
    <script type='text/javascript' src='../js/plugins/media/mediaelement-and-player.min.js'></script>    
    
    <script type='text/javascript' src='../js/plugins/cleditor/jquery.cleditor.js'></script>
    
    <script type='text/javascript' src='../js/plugins/shbrush/XRegExp.js'></script>
    <script type='text/javascript' src='../js/plugins/shbrush/shCore.js'></script>
    <script type='text/javascript' src='../js/plugins/shbrush/shBrushXml.js'></script>
    <script type='text/javascript' src='../js/plugins/shbrush/shBrushJScript.js'></script>
    <script type='text/javascript' src='../js/plugins/shbrush/shBrushCss.js'></script>    
    
    <script type='text/javascript' src='../js/plugins/filetree/jqueryFileTree.js'></script>        
        
    <script type='text/javascript' src='../js/plugins/slidernav/slidernav-min.js'></script>    
    <script type='text/javascript' src='../js/plugins/isotope/jquery.isotope.min.js'></script>    
    <script type='text/javascript' src='../js/plugins/jnotes/jquery-notes_1.0.8_min.js'></script>
    <script type='text/javascript' src='../js/plugins/jcrop/jquery.Jcrop.min.js'></script>
    <script type='text/javascript' src='../js/plugins/ibutton/jquery.ibutton.min.js'></script>

    <script type='text/javascript' src='../js/plugins/scrollup/jquery.scrollUp.min.js'></script>    
    
    <script type='text/javascript' src='../js/plugins.js'></script>
    <script type='text/javascript' src='../js/charts.js'></script>
    <script type='text/javascript' src='../js/actions.js'></script>
       <script type='text/javascript' src='../js/plugins/ckeditor/ckeditor.js'></script>
  
</head>
<body>   
    <div class="header">
		<?php include '../include/header.php';?>   
    </div>
    <?php $page="utenti"; include '../include/menu.php';?> 
    <div class="breadCrumb clearfix">    
        <ul id="breadcrumbs">
			<?php include '../include/breadcrumbs.php';?>
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
                        <h2>Modifica i dati dell'utente "<?php echo $riga['nome'] . " " . $riga['cognome'];?>"</h2>
                    </div> 
						<?php 
						$categoria_selezionata = $riga['id_categoria'];
                        ?>                                                                          
                    <form id="validate" method="POST" action ="modificaarticolo.php?id_m_informa=<?php echo $IdMinforma; ?>" onsubmit="javascript:notify('Validation','Form #validate submited');">
                    <div class="block-fluid">
                    <div class="head dark">
                        <div class="icon"><i class="icos-pencil2"></i></div>
                        <h2>Informazioni per i motori di ricerca</h2>
                    </div>
                    <div class="row-form">
                            <div class="span2">Title Italiano:</div>
                            <div class="span10">
                                <input type="text" class="validate[maxSize[70]]" maxlength="70" name="title_ita" value="<?php echo $riga['title_ita'];?>"/>
                                <span class="bottom">Il campo non deve superare i 70 caratteri</span>
                            </div>
                        </div>
                        <div class="row-form">
                            <div class="span2">Title Inglese:</div>
                            <div class="span10">
                                <input type="text" class="validate[maxSize[70]]" maxlength="70" name="title_eng" value="<?php echo $riga['title_eng'];?>"/>
                                <span class="bottom">Il campo non deve superare i 70 caratteri</span>
                            </div>
                        </div>                       
                        <div class="row-form">
                            <div class="span2">Description Italiano:</div>
                            <div class="span10">
                                <input type="text" class="validate[maxSize[150]]" maxlength="150" name="description_ita" value="<?php echo $riga['description_ita'];?>"/>
                                <span class="bottom">Il campo non deve superare i 150 caratteri</span>
                            </div>
                        </div>
                        <div class="row-form">
                            <div class="span2">Description Inglese:</div>
                            <div class="span10">
                                <input type="text" class="validate[maxSize[150]]" maxlength="150" name="description_eng" value="<?php echo $riga['description_eng'];?>"/>
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
                            <h2>Informazioni</h2>
                        </div>
                         <div class="row-form">
                            <div class="span2">Data di pubblicazione:</div>
                            <div class="span10">
                                <input type="text" class="validate[required,custom[date]]" name="data" value="<?php echo $riga['data'];?>"/>
                                <span class="bottom">Required, date YYYY-MM-DD</span>
                            </div>
                        </div>
						<div class="row-form">
                            <div class="span2">Categoria :</div>
                            <div class="span10">
                                <select class="select" name="id_categoria" style="width: 100%;">
                                        <?php
                                    $Risultato=mysql_query("select * from categoria_marss_informa", $db);
                                    if ($Risultato){
                                    while($row = mysql_fetch_assoc($Risultato)){
                                    echo "<option ";
                                    if ($categoria_selezionata == ($row['id_categoria']))
                                        {
                                        echo "selected ";
                                        }
                                        echo "value='". $row['id_categoria'] . "'>" . $row['categoria_it'] . "</option>n";
                                        }
                                                       }
                                        ?>	
                             	</select>
                            </div>
                        </div>
						
						<div class="row-form">
                            <div class="span2">Autore:</div>
                            <div class="span10">
                                <input type="text" class="validate" name="autore" value="<?php echo $riga['autore'];?>"/>
                                <span class="bottom">Non deve essere vuoto</span>
                            </div>
                        </div>
						<div class="row-form">
                            <div class="span2">Titolo Italiano:</div>
                            <div class="span10">
                                <input type="text" class="validate" name="titolo_ita" value="<?php echo $riga['titolo_ita'];?>"/>
                                <span class="bottom">Non deve essere vuoto</span>
                            </div>
                        </div>
						<div class="row-form">
                            <div class="span2">Titolo Inglese:</div>
                            <div class="span10">
                                <input type="text" class="validate" name="titolo_eng" value="<?php echo $riga['titolo_eng'];?>"/>
                                <span class="bottom">Non deve essere vuoto</span>
                            </div>
                        </div>                        
                		<div class="widget">
                    		<div class="head dark">
                        		<div class="icon"><i class="icos-pencil"></i></div>
                        		<h2>Descrizione italiano</h2>
                    		</div>
                    		<div class="block-fluid editor">  
                        		<textarea name="descrizione_ita" style="height: 300px;"><?php echo $riga['descrizione_ita'];?></textarea>
                        		<script>
                            		$(document).ready(function(){
                                		var descrizione_ita = CKEDITOR.replace('descrizione_ita');                                
                                		$("#submitEditor1").click(function(){
                                    		alert(descrizione_ita.getData());
                                		});
                            		});
                        		</script>                        
                    		</div>
                		</div>
                		<div class="widget">
                    		<div class="head dark">
                        		<div class="icon"><i class="icos-pencil"></i></div>
                        		<h2>Descrizione inglese</h2>
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
                            <div class="span1">Pubblicato:</div>
                            <div class="span5">                            
                                <input type="radio" class="validate[required]" name="pubblicato" value="1" <?php if ($riga['pubblicato'] == '1') {echo"checked";}?> /> SI 
                                <input type="radio" class="validate[required]" name="pubblicato" value="0" <?php if ($riga['pubblicato'] == '0') {echo"checked";}?>/> NO
                                <span class="bottom">Scelta obbligatoria</span>
                            </div>
                           	<div class="span1">Home Page:</div>
                            <div class="span5">                            
                                <input type="radio" class="validate[required]" name="home_page" value="1" <?php if ($riga['home_page'] == '1') {echo"checked";}?>/> SI 
                                <input type="radio" class="validate[required]" name="home_page" value="0" <?php if ($riga['home_page'] == '0') {echo"checked";}?>/> NO
                                <span class="bottom">Scelta obbligatoria</span>
                            </div>
                        </div>
                        <div class="toolbar bottom TAR">
                            <div class="btn-group">
                                <button class="btn btn-primary" type="submit">Salva</button>
                            </div>
                        </div>
 						<?php } ?>
                    </div>                
                    </form>
                </div>
      </div>
   </div>
  
</body>
</html>
