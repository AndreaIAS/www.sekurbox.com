<?php
session_start();
ini_set('session.cookie_lifetime' , '3600');
include 'include/auth.inc.php';
require 'include/db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
$IdProdotto = $_GET["id_prodotto"];			
$Risultato_prodotti=mysql_query("SELECT * FROM prodotti WHERE id_prodotto = '$IdProdotto'", $db);
	if (!$Risultato_prodotti)
	    {
		die ("La tabella selezionata non esiste" . mysql_error());
	    }
    	while ($riga_prodotto=mysql_fetch_array($Risultato_prodotti))
	    {	
		$nome_prodotto= $riga_prodotto['nome_ita'];
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
                <div class="icon"><i class="icosg-plus1"></i></div>
                <h2>Associa sezione e categoria al prodotto <?php echo $nome_prodotto; ?></h2>
            </div>                                               
     	</div>
     </div>
	<form id="validate" method="POST" action ="associasezcat.php?id_prodotto=<?php echo $IdProdotto; ?>" onsubmit="javascript:notify('Validation','Form #validate submited');">
 	<div class="row-fluid">
   		<div class="span12">
			<div class="widget">                      
            	<div class="accordion">
				<?php
				$Risultato_menu_prodotti=mysql_query("SELECT 
														 sp.*, cp.*, scp.id  
														 FROM sezioni_prodotti sp
		                        						 INNER JOIN categorie_prodotti AS cp ON sp.id_sezione = cp.id_sezione
														 LEFT JOIN sezioni_categorie_prodotti AS scp ON scp.id_categoria = cp.id_categoria AND scp.id_prodotto = '" . mysql_real_escape_string($IdProdotto) . "'  
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
				echo '</div>'; 
				?>              		

                    </div>
      
      </div>                
                    </form>
                </div>
      </div>
		<script>
        $(document).ready(function() {
        $(".updatececheck").change(function(){
        //assegnamo ad una variabile il valore da passare e che ci verrà restituito
		var id_categoria = $(this).prop("id");
		var valore = $(this).prop("checked");
        $.post("associasezcat.php", {variabile:id_categoria, prodotto:<?php echo $IdProdotto; ?>, stato:valore }, function(data){
        }, "json");
        });
        
        });
        </script>        
</body>
</html>
