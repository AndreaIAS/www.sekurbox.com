<?php
session_start();
include 'include/auth.inc.php';
require 'include/db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

if (!isset($_GET["id_categoria"]))
	{
		$IdCategoria = "";
	}
	else
	{
		$IdCategoria = $_GET["id_categoria"];
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
    
</head>
<body>
<?php
		// esecuzione prima query
		$Risultato=mysql_query("SELECT * FROM sottocategorie_prodotti AS sp INNER JOIN categorie_prodotti AS cp ON sp.id_categoria = cp.id_categoria ORDER BY sp.id_sottocategoria DESC", $db);
		$tot_records = mysql_num_rows($Risultato);		
		if (!$Risultato)
		{
		die ("La tabella selezionata non esiste" . mysql_error());
		}
?>          
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
                    <h2><?php echo $tot_records;?> Sottocategorie presenti nel database</h2>                       
                </div>                
                    <div class="block-fluid">
<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="10%">Categoria</th>
                                    <th width="40%">Nome Italiano</th>
                                    <th width="40%">Nome Inglese</th>
                                    <th width="5%" class="TAC">Modifica</th>
                                    <th width="5%" class="TAC">Elimina</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							while ($riga=mysql_fetch_array($Risultato))
			 				{
							?>
                                <tr>
                                    <td><?php echo $riga['categoria_ita'];?></td>
                                    <td><?php echo $riga['sottocategoria_ita'];?></td>
                                    <td><?php echo $riga['sottocategoria_eng'];?></td>
                                    <td class="TAC">
<?php echo "<a href='update/modifica_sottocategoria.php?id_sottocategoria=" . $riga['id_sottocategoria']. "'><span class='icon-pencil'></span></a>"; ?>
                                    </td>
<td class="TAC">
<a href="#bModal" role="button" class="btn deletemodal" id="<?php echo $riga['id_sottocategoria'];?>" data-toggle="modal"><span class="icon-trash"></span></a>
<!-- Bootrstrap modal -->
        <div id="bModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Elimina questa sottocategoria prodotto</h3>
            </div>
            <div class="modal-body">
                <p>Vuoi eliminare definitivamente questa sottocategoria prodotto?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning delete" id="" data-dismiss="modal" aria-hidden="true">Si lo voglio eliminare</button> 
                <button class="btn" data-dismiss="modal" aria-hidden="true">No</button>            
            </div>
        </div>            
                                    </td>                                     
                                </tr>
                                <? } ?>
                                                           
                            </tbody>
                        </table>                     
                    </div> 
          </div>
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
	  location.href = "delete/cancella_sottocategoria_prodotto.php?id="+id;
	  });
  </script>     
</body>
</html>
