<?php
session_start();
include 'include/auth.inc.php';
require 'include/db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$id_listino = $_GET["id_listino"];

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
									 
		$Risultato=mysql_query("SELECT 
									 prodotti.id_prodotto AS id_prodotto_listino, prodotti.codice, prodotti.nome_ita,
									 listini_dettaglio.id, listini_dettaglio.id_listino, listini_dettaglio.id_prodotto, listini_dettaglio.prezzo_prodotto, listini_dettaglio.sconto
									 FROM prodotti
									 LEFT JOIN listini_dettaglio 
									 ON listini_dettaglio.id_prodotto = prodotti.id_prodotto AND listini_dettaglio.id_listino = '" . mysql_real_escape_string($id_listino) . "'
									 ORDER BY prodotti.codice ASC
									 ", $db);
		$tot_records = mysql_num_rows($Risultato);
		if (!$Risultato)
		{
		die ("La tabella selezionata non esiste" . mysql_error());
		}
?>                   
    <div class="header">
		<?php include 'include/header.php';?>   
    </div>
    <?php $page="ecommerce"; include 'include/menu.php';?> 
    <div class="breadCrumb clearfix">    
        <ul id="breadcrumbs">
			<?php include 'include/breadcrumbs.php';?>
        </ul>        
    </div>
    
    <div class="content">            
        
      <div class="row-fluid">
            
        <div class="widget">
                <div class="head">
                    <h2><?php echo $tot_records;?> prodotti presenti in questo listino</h2>                       
                </div>                
                    <div class="block-fluid">
					<table cellpadding="0" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="10%">Codice Prodotto</th>
                                    <th width="70%">Prodotto</th>
                                    <th width="10%" class="TAC">Prezzo</th>
                                    <th width="10%" class="TAC">Sconto</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							while ($riga=mysql_fetch_array($Risultato))
			 				{
							?>
                                <tr>
                                    <td><?php echo $riga['codice'];?></td>                                
                                    <td><?php echo $riga['nome_ita'];?></td>
                                    <td>
										<?php if ($riga['prezzo_prodotto']=="") {?>
                                                <form id="form" name="form" method="post" action="insert/inserisciprezzo.php?id_listino=<?php echo $id_listino; ?>&id_prodotto=<?php echo $riga['id_prodotto_listino']; ?>">
                                                <input type="text" name="prezzo_prodotto" value="<?php echo $riga['prezzo_prodotto'];?>" maxlength="8" />
                                                <input type="submit" name="submits" class="btn btn-primary" value="Inserisci prezzo" />
                                                </form>
                                        <?php } else { ?>
										<?php echo $riga['prezzo_prodotto'];?>
                                        <div id="inserisci_prezzo"><a href="#" onclick="visualizza_form_prezzo('prezzo_<?php echo $riga['id']; ?>'); return false">Mod. Prezzo</a></div>
                                            <div id="prezzo_<?php echo $riga['id']; ?>" style="display:none">
                                                <form id="form" name="form" method="post" action="update/modificaprezzo.php?id=<?php echo $riga['id']; ?>&id_listino=<?php echo $id_listino; ?>">
                                                <input type="text" name="prezzo_prodotto" value="<?php echo $riga['prezzo_prodotto'];?>" maxlength="8" />
                                                <input type="submit" name="submits" class="btn btn-primary" value="Ok" />
                                                </form>
                                            </div>                                        
                                        <?php } ?>
                                    </td>
                                    <td>
										<?php if ($riga['sconto']=="") {?>
                                                <form id="form1" name="form1" method="post" action="insert/inseriscisconto.php?id_listino=<?php echo $id_listino; ?>&id_prodotto=<?php echo $riga['id_prodotto_listino']; ?>">
                                                <input type="text" name="sconto" value="<?php echo $riga['sconto'];?>" maxlength="3" />
                                                <input type="submit" name="submits" class="btn btn-primary" value="Inserisci sconto" />
                                                </form>
                                        <?php } else { ?>
										<?php echo $riga['sconto'];?>
                                        <div id="inserisci_sconto"><a href="#" onclick="visualizza_form_sconto('sconto_<?php echo $riga['id']; ?>'); return false">Mod. Sconto</a></div>
                                            <div id="sconto_<?php echo $riga['id']; ?>" style="display:none">
                                                <form id="form1" name="form1" method="post" action="update/modificasconto.php?id=<?php echo $riga['id']; ?>&id_listino=<?php echo $id_listino; ?>">
                                                <input type="text" name="sconto" value="<?php echo $riga['sconto'];?>" maxlength="3" />
                                                <input type="submit" name="submits" class="btn btn-primary" value="Ok" />
                                                </form>
                                            </div>                                        
                                        <?php } ?>
                                    </td>                                
                               </tr>
                            <?php } ?>                                
                            </tbody>
                        </table>                     
                    </div> 
          </div>
        </div>
        
        
    </div>
    <script type="text/javascript" language="javascript">
    function visualizza_form_prezzo(id){
      if (document.getElementById){
        if(document.getElementById(id).style.display == 'none'){
          document.getElementById(id).style.display = 'block';
        }else{
          document.getElementById(id).style.display = 'none';
        }
      }
    }
	    function visualizza_form_sconto(id){
      if (document.getElementById){
        if(document.getElementById(id).style.display == 'none'){
          document.getElementById(id).style.display = 'block';
        }else{
          document.getElementById(id).style.display = 'none';
        }
      }
    }
    </script>      
</body>
</html>
