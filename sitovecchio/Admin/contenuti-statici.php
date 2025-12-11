<?php
session_start();
include 'include/auth.inc.php';
require 'include/db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

if (!isset($_GET["id_contenuto_statico"]))
	{
		$IdContenutoStatico = "";
	}
	else
	{
		$IdContenutoStatico  = $_GET["id_contenuto_statico"];
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
  <?php
		// esecuzione prima query
		$Risultato=mysql_query("SELECT * FROM  contenuti_statici ORDER BY id_contenuto_statico DESC", $db);
		$res_count = mysql_num_rows($Risultato);
		// numero totale di records
		$tot_records = $res_count;
		// risultati per pagina(secondo parametro di LIMIT)
		$per_page = 70;
		// numero totale di pagine
		$tot_pages = ceil($tot_records / $per_page);
		// pagina corrente
		$current_page = (!$_GET['page']) ? 1 : (int)$_GET['page'];
		// primo parametro di LIMIT
		$primo = ($current_page - 1) * $per_page;
		// esecuzione seconda query con LIMIT					
		$Risultato=mysql_query("SELECT * FROM contenuti_statici ORDER BY id_contenuto_statico DESC LIMIT $primo, $per_page", $db);		    
		if (!$Risultato)
		{
		die ("La tabella selezionata non esiste" . mysql_error());
		}
?>               
        <div class="widget">
                <div class="head">
                    <h2>Sono presenti <?php echo $tot_records;?> contenuti statici nel database</h2>  
                </div>                
                    <div class="block-fluid">
						<table class="table" cellpadding="0" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="90%">Pagina</th>
                                    <th width="10%" class="TAC">Modifica</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							while ($riga=mysql_fetch_array($Risultato))
			 				{
							?>
                                <tr>
                                    <td><?php echo $riga['titolo_ita'];?></td>                                                                       
                                    <td class="TAC">
                                    <?php echo "<a href='update/modifica-contenuto-statico.php?id_contenuto_statico=" . $riga['id_contenuto_statico']. "'><span class='icon-pencil'></span></a>"; ?>  
                                    </td>                                  
                                </tr>
                              <?php }?>                              
                            </tbody>
                        </table>                     
                    </div> 
                    <div class="row-fluid">

            <div class="pagination pagination-centered pagination-mini">
                <ul>
                <?php
				for($i = 1; $i <= $tot_pages; $i++) {
				if($i == $current_page) {
				$paginazione .= "<li class='disabled'><a href='#'>" . $i . "</a></li>";
				} else {
				$paginazione .= "<li><a href=\"?page=$i\">$i</a></li>";
				}
				}
				$paginazione;
				echo $paginazione;
			    ?>                           
                </ul>
            </div>          
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
	  location.href = "delete/cancella_leggi_e_norme.php?id="+id;
	  });
  </script>   
</body>
</html>
