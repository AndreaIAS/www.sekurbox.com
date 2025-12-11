<?php 
include 'include/connessione.php';
include "include/lingua.php"; 			
if ($lingua == "it")
{
$title = "E-commerce multilevel";
$description = "Scopri tutti i nostri prodotti e le nostre offerte sulla domotica, sicurezza, TVCC e sulla fibra ottica plastica";
}
else
{
$title = "E-commerce multilevel";
$description = "Discover all our products and our offers on home automation, security, CCTV and plastic optical fiber";
} 
include 'include/head.php'; 
include 'include/leggi_immagine.inc.php';
?>
<script type="text/javascript" src="http://www.sekurbox.com/js/cart.js"></script>
    <script src="http://www.sekurbox.com/js/responsiveslides.min.js"></script>
    <script>
        $(document).ready(function(){
        $(function () {
          $("#slider1").responsiveSlides({
            auto: true,
            pager: false,
            nav: true,
            speed: 500,
            namespace: "centered-btns"
          });
        });	
        });	
    </script>
    <link rel="stylesheet" href="http://www.sekurbox.com/css/responsiveslides.css">
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
	
        <div id="row">    
        	<div id="colonna_sn">
				<?php include 'include/menu-prodotti.php'; ?>
            </div>
            <div id="colonna_ds">
          		<div id="hp_colonna_sn">
                	<div id="hp_offerte_titolo">Offerte</div>
                    <div id="hp_box_offerte">
                     <div class="rslides_container">
                        <ul class="rslides" id="slider1">
                            <?php 
                            $query=mysql_query("SELECT * FROM slider WHERE id=1", $db);
                            $result=  mysql_fetch_assoc($query);
                            for ($i=1;$i<=4;$i++){ 
                                if($result['img'.$i]!=''){?>
                            <li><a href="<?=$result['link'.$i];?>">
                                    <img src="http://www.sekurbox.com/images/home/it/<?=$result['img'.$i];?>" alt="" style="width:556px;height:296px;" >
                                </a>
                            </li>
                            <?php }} ?>
                            
                     	</ul>
                    </div>                    
                    </div>
                </div>
				<div id="hp_colonna_ds">
                	<div class="hp_colonna_ds_baner">
                            
                    	<img src="http://www.sekurbox.com/images/hp_icona_newsletter.png" />
                        <a href="http://www.sekurbox.com/<?php echo $lingua; ?>/iscriviti-alla-newsletter.html" style="text-decoration:none;"> 
                           <div class="hp_colonna_ds_baner_testo">
                            
                        	Vuoi ricevere Sconti e Promozioni?<br />
                            ISCRIVITI ALLA NEWSLETTER
                            
                        </div></a>
                    </div>
<!--                	<div class="hp_colonna_ds_baner">
                    	<img src="http://www.sekurbox.com/images/hp_icona_newsletter.png" />
                        <div class="hp_colonna_ds_baner_testo">
                        	<?php echo $spedgrat;?>
                        </div>                    
                    </div>                
                	<div class="hp_colonna_ds_baner">
                    	<img src="http://www.sekurbox.com/images/hp_icona_spedizione.png" />
                        <div class="hp_colonna_ds_baner_testo">
                        	<?php echo $spedgrat;?>
                        </div>
                    </div>                -->
               </div>
               <div id="hp_riga_banner">
               		<div id="hp_banner_sn">
                    	<div class="hp_titolo_banner">I nostri servizi</div>
                        <ul class="hp_lista_banner">
                        	<li>Consegne veloci</li>
                            <li>Pagamenti comodi e sicuri</li>
                            <li>Reso garantito</li>
                        </ul>
                    </div>
               		<div id="hp_banner_centro">
                    	<div class="hp_titolo_banner">Raccolta punti</div>
                        <div class="hp_testo_banner">
                            Sei un Installatore 
                            o un Venditore di prodotti 
                            riguardanti la domotica 
                            o la videosorveglianza?<br />
                            <a href="http://www.sekurbox.com">scopri come guadagnare punti</a>
						</div>
                    </div>
               		<div id="hp_banner_ds">
                    	<div class="hp_titolo_banner">Maggiori quantità</div>
                        <div class="hp_testo_banner">
                            Hai bisogno di un maggiore quantitativo? Vuoi uno sconto per un ordine di entit&agrave; maggiore?<br />
                            <a href="http://www.sekurbox.com/<?php echo $lingua; ?>/richiedi-preventivo.html">richiedi un preventivo</a>
						</div>
                    </div>
               </div>
               <div id="hp_novita_titolo">Novit&agrave;</div>
			   <?php include 'include/hp-novita.php'; ?>
               <div id="hp_ipiuvenduti_titolo">I pi&ugrave; venduti</div>
			   <?php include 'include/hp-ipiuvenduti.php'; ?>
        </div>
        <div class="row">
			<?php include 'include/footer.php'; ?>
        </div>                 
    </div>
</div>
<div id="freccia_su">
	<a href="/#" class="scrolltotop"><img src="http://www.sekurbox.com/images/freccia_su.png" /></a>
</div> 
</body>
</html>        