<?php
session_start();
ini_set('session.cookie_lifetime' , '3600');
include 'include/auth.inc.php';
require 'include/db.inc.php';

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

function galleria($cartella, $dim) 
		    {
			if (is_dir($cartella)) {

		    $listaFile = scandir($cartella);
		    $grandezzaarray=sizeof($listaFile);
		    if ($grandezzaarray > 2) { 
		    	foreach($listaFile as $value) 
		    	{ 
					if($value == '.' || $value == '..' || substr($value, 0, 1)=="." || substr($value, 0, 1)=="_")
		    		{ 
		    		continue; 
		    	} 
		   			 echo '<img src="http://www.sekurbox.com/'.$cartella.'/'.$value. '" class="flex" width="' . $dim . '" />'; 
		    }  
		    } else { 
		    echo '<img src="http://www.sekurbox.com/images/news-no-photo.gif" width="80" />'; 
		    } 
					} 	
else { 
		    echo '<img src="http://www.sekurbox.com/images/news-no-photo.gif" width="80" />'; 
		    } 
	
		    }		

                    
// Se la variabile id_sezione e id_categoria e id_sottocategoria sono definite entrambe eseguo questa query
if (isset($_GET['id_categoria']) and isset($_GET['id_sezione']) and isset($_GET['id_sottocategoria']))
{                   
    
$id_sezione = $_GET['id_sezione']; 	
$id_categoria = $_GET['id_categoria'];
$id_sottocategoria = $_GET['id_sottocategoria']; 
$Risultato=mysql_query("SELECT 
                         p.*, ssp.*  
                         FROM prodotti AS p
                         INNER JOIN sezioni_sottocategorie_prodotti AS ssp ON ssp.id_prodotto = p.id_prodotto AND ssp.id_sottocategoria = '" . mysql_escape_string($id_sottocategoria) . "'
                         GROUP BY p.id_prodotto ORDER BY p.posizione ASC", $db);
						
	if (!$Risultato)
	{
	die ("La tabella selezionata non esiste" . mysql_error());
	} 

    
// Se la variabile id_sezione e id_categoria sono definite entrambe eseguo questa query
}else if (isset($_GET['id_categoria']) and isset($_GET['id_sezione']))
{
$id_sezione = $_GET['id_sezione']; 	
$id_categoria = $_GET['id_categoria']; 	
$Risultato=mysql_query("SELECT 
                         p.*, scp.*  
                         FROM prodotti AS p
                         INNER JOIN sezioni_categorie_prodotti AS scp ON scp.id_prodotto = p.id_prodotto AND scp.id_categoria = '" . mysql_escape_string($id_categoria) . "'
                         GROUP BY p.id_prodotto ORDER BY p.posizione ASC", $db);
						
	if (!$Risultato)
	{
	die ("La tabella selezionata non esiste" . mysql_error());
	}
}
//Solo se è definita id_sezione
else if (isset($_GET['id_sezione']))
{
$id_sezione = $_GET['id_sezione']; 	
$query="SELECT 
         p.*, scp.*, cp.*  
         FROM prodotti AS p
         INNER JOIN categorie_prodotti AS cp ON cp.id_sezione = '" . mysql_escape_string($id_sezione) . "' 
         INNER JOIN sezioni_categorie_prodotti AS scp ON scp.id_prodotto = p.id_prodotto AND scp.id_categoria = cp.id_categoria
         GROUP BY p.id_prodotto ORDER BY p.posizione ASC";
				
$Risultato = mysql_query($query, $db) or die(mysql_error($db));
}
//Pagina Prodotti di Default
else
{
	$query="SELECT 
                p.*  
                FROM prodotti AS p
                GROUP BY p.id_prodotto ORDER BY p.posizione ASC";
				
$Risultato = mysql_query($query, $db) or die(mysql_error($db));
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
    <?php $page="prodotti"; include 'include/menu.php';?> 
    <div class="breadCrumb clearfix">    
        <ul id="breadcrumbs">
			<?php include 'include/breadcrumbs.php';?>
        </ul>        
    </div>
    
    <div class="content">                         

               <div class="widget">
                <div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2>Sono presenti <?php echo $tot_records;?> prodotti nel database</h2>                       
                </div>                
                    <div class="block-fluid">
                        <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="10%"></th>
                                    <th width="10%">Codice</th>
                                    <th width="30%">Nome</th>
                                    <th width="5%">Posizione</th>
                                    <th width="10%">Prezzo</th>
                                    <th width="10%">Sconto</th>
                                    <th width="5%" class="TAC">Correlati</th>
                                    <th width="5%" class="TAC">Visibile</th>
                                    <th width="5%" class="TAC">Primo Piano</th>
                                    <th width="5%" class="TAC">Puglia</th>
                                    <th width="5%" class="TAC">Appl.</th>
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
                                    <td>
                                        <div class="image">
                                        	<?php 
												$id_prodotto = $riga['id_prodotto'];
												galleria("../images/miniature/prodotti/" . $id_prodotto, 80); 
											?>
                                        </div>
                        			</td>
                                    <td><?php echo $riga['codice'];?></td>
                                    <td><?php echo $riga['nome_ita'];?></td>
				    <td>
				    <?php echo $riga['posizione'];?>
                                        <div id="inserisci_risultato"><a href="#" onclick="visualizza('<?php echo $riga['id_prodotto']; ?>'); return false">Mod. posizione</a></div>
                                            <div id="<?php echo $riga['id_prodotto']; ?>" style="display:none">
                                                <form id="form" name="form" method="post" action="update/modificaposizione-prodotti.php?id_prodotto=<?php echo $riga['id_prodotto']; ?>">
                                                <input type="text" name="posizione" value="<?php echo $riga['posizione'];?>" maxlength="5" />
                                                <input type="submit" name="submits" class="btn" value="Ok" />
                                                </form>
                                            </div>
                                    </td>    
                                    <td><?php echo $riga['prezzo'];?> &euro;</td> 
                                    <td><?php echo $riga['sconto'];?> %</td>
                                     <td class="TAC">
                                    <?php echo "<a href='prodotti-correlati.php?id_prodotto=" . $riga['id_prodotto']. "'><span class='icon-retweet'></span></a>"; ?> 
                                    </td>
                                    <td class="TAC">
                                    <?php 
									if ($IdProdotto <> $riga['id_prodotto'])
										{
											if ($riga['visible'] == 0)
											{
											echo "<span class='label label-important'>NO</span><br /><a href='visible/rendi_visibile_prodotto.php?id_prodotto=" . $riga['id_prodotto']. "'><span class='icon-ok'></span></a>";			  
											}
											else
											{
											echo "<span class='label label-info'>SI</span><br /><a href='visible/non_rendere_visibile_prodotto.php?id_prodotto=" . $riga['id_prodotto']. "'><span class='icon-remove'></span></a>";	
											}
										}
									?> 
                                    </td>                                     
                                    <td class="TAC">
                                    <?php 
									if ($IdProdotto <> $riga['id_prodotto'])
										{
											if ($riga['primo_piano'] == 0)
											{
											echo "<span class='label label-important'>NO</span><br /><a href='visible/attiva_primo_piano_prodotto.php?id_prodotto=" . $riga['id_prodotto']. "'><span class='icon-ok'></span></a>";			  
											}
											else
											{
											echo "<span class='label label-info'>SI</span><br /><a href='visible/disattiva_primo_piano_prodotto.php?id_prodotto=" . $riga['id_prodotto']. "'><span class='icon-remove'></span></a>";	
											}
										}
									?> 
                                    </td>   
                                    <td class="TAC">
                                    <?php 
									if ($IdProdotto <> $riga['id_prodotto'])
										{
											if ($riga['puglia'] == 0)
											{
											echo "<span class='label label-important'>NO</span><br /><a href='visible/prodotto_solo_puglia.php?id_prodotto=" . $riga['id_prodotto']. "'><span class='icon-ok'></span></a>";			  
											}
											else
											{
											echo "<span class='label label-info'>SI</span><br /><a href='visible/prodotto_tutti.php?id_prodotto=" . $riga['id_prodotto']. "'><span class='icon-remove'></span></a>";	
											}
										}
									?> 
                                    </td>                                    
                                    <td class="TAC">
                                    <?php echo "<a href='immagine-prodotto-applicazione.php?id_prodotto=" . $riga['id_prodotto']. "'><span class='icon-wrench'></span></a>"; ?> 
                                    </td>                                    
                                    <td class="TAC">
                                    <?php echo "<a href='update/modifica_prodotto.php?id_prodotto=" . $riga['id_prodotto']. "'><span class='icon-pencil'></span></a>"; ?>  
                                    </td>
                                    <td class="TAC">
                                        <a href="#bModal" role="button" class="btn deletemodal" id="<?php echo $riga['id_prodotto'];?>" data-toggle="modal"><span class="icon-trash"></span></a>
                                    </td>                                   
                                </tr>
                              <?php }?>                              
                            </tbody>
                        </table>                     
                    </div> 
                    <div class="row-fluid">          
            </div>
          </div>
        </div>
        
        
    </div>   
                                            <!-- Bootrstrap modal -->
        <div id="bModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Elimina questo prodotto</h3>
            </div>
            <div class="modal-body">
                <p>Vuoi eliminare definitivamente questo prodotto?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning delete" id="" data-dismiss="modal" aria-hidden="true">Si lo voglio eliminare</button> 
                <button class="btn" data-dismiss="modal" aria-hidden="true">No</button>            
            </div>
        </div>
  <script type="text/javascript" language="javascript">
    function visualizza(id){
      if (document.getElementById){
        if(document.getElementById(id).style.display == 'none'){
          document.getElementById(id).style.display = 'block';
        }else{
          document.getElementById(id).style.display = 'none';
        }
      }
    }
    </script>         
  <script>
  $(".deletemodal").click(function(){
	  var id = $(this).attr("id");
	  $(".delete").attr("id",id);
	  //alert($(".delete").attr("id"));
	  });
	  
  $(".delete").click(function(){
	  var id = $(this).attr("id");
	  location.href = "delete/cancella_prodotto.php?id="+id;
	  });
  </script>   
</body>
</html>
