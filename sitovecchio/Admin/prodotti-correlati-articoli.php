<?php
session_start();
include 'include/auth.inc.php';
require 'include/db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$id_articolo = $_GET["id_articolo"];
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
		    echo '<img src="'.$cartella.'/'.$value. '" width="100" />'; 
		    }  
		    } else { 
		    echo '<img src="img/nofoto.gif" />'; 
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
    <?php $page="contenuti"; include 'include/menu.php';?> 
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
                        <h2>Inserisci prodotti impiegati</h2>
                    </div>                                               
                    <form id="validate" method="POST" onsubmit="javascript:notify('Validation','Form #validate submited');" action="insert/inseriscinuovoprodottocorrelato-articolo.php?id_articolo=<?php echo $id_articolo;?>">
                    <div class="block-fluid">
                      <div class="row-form">
                        <div class="span2">Prodotto:</div>
                        <div class="span10">
						<select class="select" name="id_prodotto_correlato" style="width: 100%;">
						<?php								
							$Risultato_select_prodotti=mysql_query("SELECT p.id_prodotto, p.nome_ita 
																FROM prodotti AS p 
																WHERE p.id_prodotto NOT IN (SELECT ac.id_prodotto_correlato FROM prodotti_articoli_correlati AS ac WHERE ac.id_prodotto_correlato = p.id_prodotto AND ac.id_articolo = '" . $id_articolo . "')
																GROUP BY p.id_prodotto", $db);	
							
                            if ($Risultato_select_prodotti){
                                while($riga_select_prodotti = mysql_fetch_assoc($Risultato_select_prodotti)){
                                    $id_prodotto_correlato = $riga_select_prodotti['id_prodotto'];
                                    $nome_ita = $riga_select_prodotti['nome_ita'];
                                    echo "<option value='" . $id_prodotto_correlato . "'>" . $nome_ita . "</option>n";
                                            }
                                       }
                        ?>	
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
                    <div class="head">
                        <div class="icon"><i class="icon-retweet"></i></div>
                        <h2>Prodotti correlati alla Faq</h2>
                    </div>
<div class="block-fluid">
						<table class="table" cellpadding="0" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="30%"></th>
                                    <th width="10%">Codice</th>
                                    <th width="50%">Nome</th>
                                     <th width="10%">Elimina</th>

                                </tr>
                            </thead>
                            <tbody>
                            <?php
							$Risultato=mysql_query("SELECT * FROM 
																prodotti AS p 
																INNER JOIN 
																prodotti_articoli_correlati AS ac 
																ON p.id_prodotto = ac.id_prodotto_correlato AND ac.id_articolo = $id_articolo 
																GROUP BY ac.id DESC", $db);
							if (!$Risultato)
							{
							die ("La tabella selezionata non esiste" . mysql_error());
							}
							while ($riga=mysql_fetch_array($Risultato))
			 				{
							?>
                                <tr>
                                    <td>
                                        <div class="image">
                                        	<?php 
												$id_prodotto = $riga['id_prodotto'];
												galleria("../images/miniature/prodotti/" . $id_prodotto); 
											?>
                                        </div>
                        			</td>
                                    <td><?php echo $riga['codice'];?></td>
                                    <td><?php echo $riga['nome_ita'];?></td>
                                    <td class="TAC">
                                        <a href="#bModal" role="button" class="btn deletemodal" id="<?php echo $riga['id'];?>" data-toggle="modal"><span class="icon-trash"></span></a>
                                    </td>                                  
                                </tr>
                              <?php }?>                              
                            </tbody>
                        </table>                     
                    </div> 
                    
                </div>
      </div>
   </div>
                                              <!-- Bootrstrap modal -->
        <div id="bModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Elimina questo prodotto correlato</h3>
            </div>
            <div class="modal-body">
                <p>Vuoi eliminare definitivamente questo prodotto correlato?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning delete" id="" data-dismiss="modal" aria-hidden="true">Si lo voglio eliminare</button> 
                <button class="btn" data-dismiss="modal" aria-hidden="true">No</button>            
            </div>
        </div>  
  <script>
  $(".deletemodal").click(function(){
	  var id = $(this).attr("id");
	  $(".delete").attr("id",id);
	  //alert($(".delete").attr("id"));
	  });
	  
  $(".delete").click(function(){
	  var id = $(this).attr("id");
	  location.href = "delete/cancella_prodotto_articolo.php?id="+id;
	  });
  </script>    
</body>
</html>
