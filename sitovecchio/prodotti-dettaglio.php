<?php 
include 'include/connessione.php';
include "include/lingua.php"; 




$id_prodotto = $_GET['id_prodotto'];

$Risultato=mysql_query("SELECT prodotti.* 
                        FROM prodotti 
                        WHERE prodotti.id_prodotto = '" . mysql_real_escape_string($id_prodotto) . "'", $db); 
								 			
if (!$Risultato)
{
die ("La tabella selezionata non esiste" . mysql_error());
}
$riga_det=mysql_fetch_array($Risultato);
if ($lingua == "it")
{
	$title = $riga_det['title_ita'];
	$description = $riga_det['description_ita'];
}
else
{
	$title = $riga_det['title_eng'];
	$description = $riga_det['description_eng'];
} 

 ?>

    
<?php
include 'include/head.php'; 
include 'include/bytesize.inc.php';
include 'include/leggi_immagine.inc.php';
?>
<script type="text/javascript" src="http://www.sekurbox.com/js/jquery-ui-1.10.3.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://www.sekurbox.com/css/ui-lightness/jquery-ui-1.10.3.custom.min.css">
<link rel="stylesheet" href="http://www.sekurbox.com/css/tabs.css" />   
<script type="text/javascript" src="http://www.sekurbox.com/js/cart.js"></script>  
<script src="http://www.sekurbox.com/js/jquery.flow.1.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $("div#controller").jFlow({
            slides: "#slides",
            width: "810px",
            height: "auto"
        });
    });
</script> 	
</head>
<body>
<div id="contenuto">
	<div id="contenuto2">
    	<div id="top">
			<?php include 'include/top.php'; ?>
        </div>
        <div id="testata">
			<?php include 'include/testata.php'; ?>
        </div>
		<div class="row_top">
        	<div id="titolo_pagina_sn">
                <div id="titolo_pagina">
                    <div id="stile_titolo_pagina"><?php echo $prodotti;?></div>
                    <div id="briciole_di_pane">
                    	<a href="http://www.sekurbox.com/<?php echo $lingua;?>/index.html">Home Page</a> / 
                        <a href="http://www.sekurbox.com/<?php echo $lingua;?>/prodotti.html"><?php echo $prodotti;?></a> / 
                        <?php 	if ($lingua=="it") { echo $riga_det['nome_ita']; } else { echo $riga_det['nome_eng']; }?>
                   </div>
                </div>
            </div>  
            <div id="titolo_pagina_ds">
				<?php include 'include/banner-promozionale.php'; ?>
           </div>      
      	</div>
        <div class="row">
        	<div id="colonna_sn">
				<?php include 'include/menu-prodotti.php'; ?>
            </div>
            <div id="colonna_ds_det">
				<div class="prodotto_dettaglio">
                	<h1><?php if ($lingua=="it") {echo $riga_det['nome_ita'];} else {echo $riga_det['nome_eng']; }?></h1>
                    <span class="prezzo_stile"><?php echo $codice;?>: </span><span class="cod_striscia_prodotto_stile"><?php echo $riga_det['codice'];?></span>   
                </div>
                <div class="prodotto_box_img">
                	<div id="prodotto_box_img_foto">
                		<?php leggi_immagine("images/galleria/prodotti/" . $riga_det['id_prodotto'], 400);?>
                    </div>                  
                </div>
                <div class="prodotto_dettaglio_info">
                    <?php include 'include/action-prodotto.php'; ?>
                </div>
                <div class="row">              
					<?php include 'include/section-prodotto-dettaglio.php'; ?>
        		</div>
                <h2><?php echo $prodotti_correlati;?></h2>
                <div class="row">
                    <?php include 'include/prodotti-correlati.php'; ?>
                </div>            
        	</div>                 
    	</div>
                          
        <div class="row">
			<?php include 'include/footer.php'; ?>
        </div>                 
    </div>
</div>
  <script>
  document.write('<script src=' +
  ('__proto__' in {} ? 'js/vendor/zepto' : 'js/vendor/jquery') +
  '.js><\/script>')
  </script> 
  <script src="http://www.sekurbox.com/js/foundation.min.js"></script>    
  <script>
    $(document).foundation();
  </script>
 <div id="freccia_su">
	<a href="/#" class="scrolltotop"><img src="http://www.sekurbox.com/images/freccia_su.png" /></a>
</div>  
</body>
</html>        