<?php
session_start();
include '../include/auth.inc.php';
require '../include/db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

if (!isset($_GET["id_prodotto"]))
	{
		$IdProdotto = "";
	}
	else
	{
		$IdProdotto = $_GET["id_prodotto"];
	}
	
	$Risultato=mysql_query("SELECT * FROM prodotti WHERE id_prodotto = '$IdProdotto'", $db);

	if (!$Risultato)
	{
		die ("La tabella selezionata non esiste" . mysql_error());
	}
function galleria($cartella) 
		    { 
    if(is_dir($cartella)) {
		    $listaFile = scandir($cartella);
		    $grandezzaarray=sizeof($listaFile);
		    if ($grandezzaarray > 2) { 
		    foreach($listaFile as $value) 
		    { 
		    if($value == '.' || $value == '..'  ) 
		    { 
		    continue; 
		    } 
                    if(stristr($value,'notes')==FALSE) {
		    echo '<img src="'.$cartella.'/'.$value. '" />'; 
                    }
		    }  
		    } else { 
		    echo '<img src="http://www.marss.eu/images/news-no-photo.gif" />'; 
		    } 
		    }	
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
    <?php $page="prodotti"; include '../include/menu.php';?> 
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
                    <h2>Modifica il prodotto <?php echo $riga['codice'];?></h2>
                </div>         
                                                                                
                <div class="block-fluid">
                <div class="head dark">
                <div class="icon"><i class="icos-pencil2"></i></div>
                <h2>Immagine del prodotto</h2>
            </div>
           
           
           <form  id="validate" method="POST" onsubmit="javascript:notify('Validation','Form #validate submited');" enctype="multipart/form-data" action="http://www.sekurbox.com/Admin/salva-miniatura-prodotto.php?id_prodotto=<?php echo $IdProdotto; ?>">
          <div class="row-form">
            <div class="span2">                            
					<?php 
                    galleria("../../images/miniature/prodotti/" . $IdProdotto); 
                    ?>
            </div>          
            <div class="span1">File:</div>
            <div class="span6">                            
                <div class="input-append file">
                    <input type="file" name="foto"/>
                    <input type="text"/>
                </div>                            
            </div>
        </div>
         
        <div class="toolbar bottom TAR">
            <div class="btn-group" style="float:left;">
                <button class="btn btn-primary" s>Salva Imagine</button>
            </div> 
        </div> 
        </form> 
        <div class="toolbar bottom TAR">
            <div class="btn-group" style="float:right;">
               <button class="btn btn-primary" onclick="$('.formcomp').submit();" >Salva</button>
                    </div>
        </div> 
             
                    
                    
                    <form id="validate" class="formcomp" method="POST" action ="modificaprodotto.php?id_prodotto=<?php echo $IdProdotto; ?>" onsubmit="javascript:notify('Validation','Form #validate submited');">
                        <div class="row-form">
                            <div class="span1">Codice:</div>
                            <div class="span3">
                                <input type="text" class="validate[required]" name="codice" value="<?php echo $riga['codice'];?>"/>
                                <span class="bottom">Il campo non pu&ograve; essere vuoto</span>
                            </div>
                            <div class="span1">Posizione:</div>
                            <div class="span3">
                                <input type="text" name="posizione" value="<?php echo $riga['posizione'];?>"/>
                            </div> 
                            <div class="span1">Giacenza:</div>
                            <div class="span3">
                                <input type="text" name="giacenza" value="<?php echo $riga['giacenza'];?>"/>
                            </div>                        
                      </div>
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
                            <div class="span2">Url Italiano:</div>
                            <div class="span10">
                                <input type="text" class="validate[required, maxSize[150]]" maxlength="150" name="url" value="<?php echo $riga['url'];?>"/>
                                <span class="bottom">Il campo non può essere vuoto e non deve superare i 150 caratteri</span>
                            </div>
                        </div>                                               
                        <div class="row-form">
                            <div class="span2">Url Inglese:</div>
                            <div class="span10">
                                <input type="text" class="validate[required, maxSize[150]]" maxlength="150" name="url_eng" value="<?php echo $riga['url_eng'];?>"/>
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
                                <input type="text" class="validate[required]" name="nome_ita" value="<?php echo $riga['nome_ita'];?>"/>
                                <span class="bottom">Il campo non può essere vuoto</span>
                            </div>
                        </div>
                        <div class="row-form">
                            <div class="span2">Nome Inglese:</div>
                            <div class="span10">
                                <input type="text" class="validate[required]" name="nome_eng" value="<?php echo $riga['nome_eng'];?>"/>
                                <span class="bottom">Il campo non può essere vuoto</span>
                            </div>
                        </div>                                    
 						
                        <div class="row-form">
                            <div class="span2">Descrizione Italiano:</div>
                            <div class="span10"><textarea placeholder="Placeholder example" name="descrizione_ita"><?php echo $riga['descrizione_ita'];?></textarea></div>
                        </div>
                        <div class="row-form">
                            <div class="span2">Descrizione Inglese:</div>
                            <div class="span10"><textarea placeholder="Placeholder example" name="descrizione_eng"><?php echo $riga['descrizione_eng'];?></textarea></div>
                        </div>
                        
                        
                            
                        <input type="hidden" name="descrizione_capitolato_ita" value=""/>
                      
                       <input type="hidden"  name="descrizione_capitolato_eng" value="" />
                        
                        
                         <div class="row-form">
                            <div class="span2">Prezzo:</div>
                            <div class="span10">
                                <input type="text" class="validate[required]" name="prezzo" value="<?php echo $riga['prezzo'];?>"/>
                                
                            </div>
                        </div>  
                         <div class="row-form">
                            <div class="span2">Sconto:</div>
                            <div class="span10">
                                <input type="text"  name="sconto" value="<?php echo $riga['sconto'];?>"/>
                               
                            </div>
                        </div> 
                        
                        <div class="row-form">
                            <div class="span1">Pubblicato:</div>
                            <div class="span3">                            
                                <input type="radio" class="validate[required]" name="visible" value="1" <?php if ($riga['visible'] == '1') {echo"checked";}?> /> SI 
                                <input type="radio" class="validate[required]" name="visible" value="0" <?php if ($riga['visible'] == '0') {echo"checked";}?>/> NO
                                <span class="bottom">Scelta obbligatoria</span>
                            </div>
                            <div class="span1">Home</div>
                            <div class="span3">                            
                                <input type="radio" class="validate[required]" name="primo_piano" value="1" <?php if ($riga['primo_piano'] == '1') {echo"checked";}?>/> SI 
                                <input type="radio" class="validate[required]" name="primo_piano" value="0" <?php if ($riga['primo_piano'] == '0') {echo"checked";}?>/> NO
                                <span class="bottom">Scelta obbligatoria</span>
                            </div>
                            <div class="span1">Puglia</div>
                            <div class="span3">                            
                                <input type="radio" class="validate[required]" name="puglia" value="1" <?php if ($riga['puglia'] == '1') {echo"checked";}?>/> SI 
                                <input type="radio" class="validate[required]" name="puglia" value="0" <?php if ($riga['puglia'] == '0') {echo"checked";}?>/> NO
                                <span class="bottom">Scelta obbligatoria</span>
                            </div>                        
                        </div>                                         		
                   	 	<?php } ?>               
                             
                    <div class="toolbar bottom TAR">
                        <div class="btn-group">
                            <button class="btn btn-primary" type="submit">Salva</button>
                        </div>
                    </div>
                </form>
               <div class="head dark">
                    <div class="icon"><i class="icos-pencil2"></i></div>
                    <h2>Sezioni e categorie (Non è necessario salvare)</h2>
                </div>
        	<div class="widget">    
        		<form id="validate" method="POST" action ="http://www.sekurbox.com/Admin/associasezcat.php?id_prodotto=<?php echo $IdProdotto; ?>" onsubmit="javascript:notify('Validation','Form #validate submited');">
            		<div class="accordion">
						<?php
                  /*       $Risultato_menu_prodotti=mysql_query("SELECT 
                                                         sp.*, cp.*, scp.id  
                                                         FROM sezioni_prodotti sp
                                                         INNER JOIN categorie_prodotti AS cp ON sp.id_sezione = cp.id_sezione
                                                         LEFT JOIN sezioni_categorie_prodotti AS scp ON scp.id_categoria = cp.id_categoria AND scp.id_prodotto = '" . mysql_escape_string($IdProdotto) . "'  
                                                         ORDER BY sp.posizione, cp.posizione ASC", $db);
                        if (!$Risultato_menu_prodotti)
                        {
                        die ("La tabella selezionata non esiste" . mysql_error());
                        }
                        $sezione = "";
                        $x=0;
                        while ($riga_menu_prodotti=mysql_fetch_array($Risultato_menu_prodotti))
                        {	
                        if ($sezione != $riga_menu_prodotti['nome_sezione_ita'])
                            {
                                if($x==0)
                                {
                                    echo '<h3>' . $riga_menu_prodotti['nome_sezione_ita'] . '</h3><div>';
                                }
                                else 
                                {
                                    echo '</div>';
                                    echo '<h3>' . $riga_menu_prodotti['nome_sezione_ita'] . '</h3><div>';
                                }
                                $x=1;
                            }
                            if ($riga_menu_prodotti['id'] == "")
                            {
                            echo '<p><input type="checkbox" value="' . $riga_menu_prodotti['id_categoria'] . '" name="id_categoria" id="' . $riga_menu_prodotti['id_categoria'] . '" class="updatececheck" />' . $riga_menu_prodotti['categoria_ita'] . '</p>';
                            }
                            else
                            {
                            echo '<p><input type="checkbox" checked="checked" value="' . $riga_menu_prodotti['id_categoria'] . '" name="id_categoria" id="' . $riga_menu_prodotti['id_categoria'] . '" class="updatececheck" />' . $riga_menu_prodotti['categoria_ita'] . '</p>';
                            }
                            $sezione = $riga_menu_prodotti['nome_sezione_ita'];	
                        }
                        echo '</div>'; */
                        
                        $querymacro="SELECT  * FROM sezioni_prodotti GROUP BY sezioni_prodotti.id_sezione ORDER by posizione";
                        $resultmacro=mysql_query($querymacro) or die(mysql_error());
                        while($listmacro=  mysql_fetch_array($resultmacro)){  ?>
                            
                            <h3><?=$listmacro['nome_sezione_ita'];?></h3>
                            <div>
                            <?php
                            
                            $querycat="SELECT * FROM categorie_prodotti WHERE id_sezione='".$listmacro['id_sezione']."' ORDER by posizione";
                            $resultcat=mysql_query($querycat) or die(mysql_error());
                            while($listcat=mysql_fetch_array($resultcat)){ 
                                
                                $querypro="SELECT COUNT(*) AS totprod FROM sezioni_categorie_prodotti WHERE id_prodotto='".mysql_escape_string($IdProdotto)."' AND  id_categoria='".$listcat['id_categoria']."' ";
                                $resultpro=mysql_query($querypro) or die(mysql_error());
                                $listpro=  mysql_fetch_assoc($resultpro)
                               
                               ?>                         
                                <p><input type="checkbox" <?php if($listpro['totprod']>0){echo "checked='checked'";  } ?> value="<?=$listcat['id_categoria'];?>" name="id_categoria" id="<?=$listcat['id_categoria'];?>" class="updatececheck" />
                                <?=$listcat['categoria_ita'];?>
                                </p>
                                
                                <?php
                                
                                $queryscat="SELECT  * FROM sottocategorie_prodotti WHERE id_categoria='".$listcat['id_categoria']."' ORDER by id_sottocategoria";
                                $resultscat=mysql_query($queryscat) or die(mysql_error());
                                while($listscat=  mysql_fetch_array($resultscat)){ 

                                    $querypros="SELECT * FROM sezioni_sottocategorie_prodotti WHERE id_prodotto='".mysql_escape_string($IdProdotto)."' AND  id_sottocategoria='".$listscat['id_sottocategoria']."' ";
                                    $resultpros=mysql_query($querypros) or die(mysql_error());
                                    $numrowprods=  mysql_num_rows($resultpros);
                                   ?>                         
                                    <p style="padding-left:10px;"><input type="checkbox" <?php if($numrowprods>0){echo "checked='checked'";  } ?> value="<?=$listscat['id_sottocategoria'];?>" name="id_sottocategoria" id="<?=$listscat['id_sottocategoria'];?>" class="updatecechecks" />
                                    <?=$listscat['sottocategoria_ita'];?>
                                    </p>                               
     
                          <?php
                               } 
                          }
                       echo "</div>" ;  
                        }
                        
                        ?>              		
                </form>
                </div>
            </div>
                    </div>
    	</div>
    </div>
      <script>
    $(document).ready(function() {

    $(".updatececheck").change(function(){
    //assegnamo ad una variabile il valore da passare e che ci verrà restituito
    var id_categoria = $(this).prop("id");
    var valore = $(this).prop("checked");
    $.post("http://www.sekurbox.com/Admin/associasezcat.php", {variabile:id_categoria, prodotto:<?php echo $IdProdotto; ?>, stato:valore }, function(data){
    }, "json");
     });
     
    $(".updatecechecks").change(function(){
    //assegnamo ad una variabile il valore da passare e che ci verrà restituito
    var id_sottocategoria = $(this).prop("id");
    var valore = $(this).prop("checked");
    $.post("http://www.sekurbox.com/Admin/associasezscat.php", {variabile:id_sottocategoria, prodotto:<?php echo $IdProdotto; ?>, stato:valore }, function(data){
    }, "json");
    });
    
    });
    </script>
</body>
</html>
