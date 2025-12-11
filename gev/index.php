<?php

include("inc_config.php");

$title="GEVENIT s.r.l. | Prodotti e Attrezzature Online per la Pulizia: Detergenti, Lavapavimenti Industriale, Lavasciuga Pavimenti, Dispenser Sapone.";
$description="Azienda leader specializzata nella pulizia professionale, civile e industriale. Proponiamo i migliori prodotti tra: DETERGENTI, LAVAPAVIMENTI INDUSTRIALE, TESSUTO NON TESSUTO, DISPENSER SAPONE, CONTENITORI RACCOLTA DIFFERENZIATA, LAVASCIUGA PAVIMENTI.";
$keywords="Gevenit s.r.l.; detergenti industriali; detergenti professionali; pulizia industriale; prodotti pulizia; detergenti; lavapavimenti; lavasciuga pavimenti; tessuto non tessuto; dispenser sapone, carrello hotel, linea cortesia hotel, contenitori raccolta differenziata.";

include("inc_header.php");
?>
<?php if(isset($_REQUEST['offset'])){ ?>
<link rel="canonical" href="http://www.gevenit.com/">
<?php } ?>
</head>
<body class="bg-body boxed">
        <!-- LOADING -->
	<div class="loading-container" id="loading">
            <div class="loading-inner">
                <span class="loading-1"></span>
                <span class="loading-2"></span>
                <span class="loading-3"></span>
            </div>
	</div>
	<!-- END LOADING -->
    <?php
    include("inc_menu.php");

    ?>

  <!-- BREAKCRUMB -->
    <section style="height: 50px;padding-top: 10px;">
	<div class="container" style="cursor:pointer;padding:0px;width: 49%; background-color: red; height: 50px; float: left; margin-left: 1.7%;text-align: center;color:#ffffff;" onClick="window.location.href='<?=BASE_URL;?>contatti.php'">
	    <div class="riv1" >SEI UN RIVENDITORE?</div>
	    <div class="riv2" >Contattaci per Ogni Tua Esigenza.</div>
	</div>

	<div class="container"  onclick="window.location.href='<?=BASE_URL;?>contatti.php'" style="cursor:pointer;padding:0px;background-color:#008a42; margin-left: 3px; height: 50px; float: left; width: 47.5%;text-align: center;color:#ffffff;">
	    <div class="riv1" >SEI UN ENTE PUBBLICO?</div>
	    <div class="riv2" >I Codici Mepa Agevolano la Tua Ricerca.</div>
	</div>
    </section>
    <!-- END BREAKCRUMB -->

    <?php
    include("inc_slider.php");
    ?>
<!--<div><script>
  (function() {
    var cx = '004134790093363653019:wrtii7mdfbw';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<gcse:search></gcse:search></div>
    	<!-- PRODUCT GRID -->
		<section class="product-grid-3">
		    <div class="container">
                        <div class="row">
                             <br /><br />

                        <div class="col-md-3">

			    <h1 style="margin-top:0px;"> GEVENIT </h1>
                            <?php
                            include("inc_leftside.php");
                            ?>


                            <!-- WIDGET PHOTO SLIDE -->
                            <aside class="sidebar widget_photo_slide _3">
                                <div class="wrap-sidebar-title">
                                   <h2 class="sidebar-title">Ultimi arrivi</h2>
                                </div>
                            <div class="photo-slide">
                            <div id="photo_slide">
                            <?php

                            $db->query("SELECT *
                                        FROM
                                        bag_articoli
                                        ORDER by bag_articoli.data_insert DESC
                                        LIMIT 0,5
                                       ");
                           $recordleft = $db->resultset();
                           foreach ($recordleft as $list) {
                           ?>

			    <a href="<?=BASE_URL;?>item_<?=$list['id']."/".seo_url($list['nome']);?>">
                              <img src="<?=$phpThumbBase;?>?src=images/img_prod/<?=$list['img1'];?>&h=300&w=277&far=1&bg=ffffff" alt="<?=$list['nome'];?>" title="<?=$list['nome'];?>">
                            </a>
                            <?php } ?>

		            </div>
			    </div>
                            </aside>
                            <!-- END WIDGET PHOTO SLIDE -->

                        </div>
                          <!-- END SIDEBAR -->

                                    <div class="col-md-9">

						<!-- SUB BANNER -->
<!--						<div class="sub-banner no-margin">
							<div class="item">
								<div class="img">
									<a href="#">
										<img src="images/banner/img-6.jpg" alt="">
									</a>
								</div>
							</div>
						</div>-->
						<!-- END SUB BANNER -->

                           <?php

                           if (isset($_POST['sortby'])) { $_SESSION['sort'] = $_POST['sortby'];}
                           else     {   if(!isset($_SESSION['sort']))  $_SESSION['sort'] = 0;   }



                           $db->query("SELECT *
                                       FROM
                                       bag_articoli
                                       ");
                           $recordprod = $db->resultset();
                           $rows = $db->rowCount();

                           $query="SELECT * FROM  bag_articoli ";

                            switch ($_SESSION['sort']) {

                                    case 0:
                                         $query.=" ORDER BY bag_articoli.prezzo ASC ";
                                        break;
                                    case 1:
                                         $query.=" ORDER BY bag_articoli.prezzo DESC ";
                                        break;
                                     case 2:
                                         $query.=" ORDER BY bag_articoli.nome";
                                        break;
                                    case 3:
                                        $query.=" ORDER BY bag_articoli.nome DESC ";
                                        break;
                                    case 4:
                                        $query.="ORDER BY bag_articoli.data_insert DESC ";
                                        break;
                                    default:
                                        $query.="ORDER BY bag_articoli.prezzo ASC ";
                                        break;
                                }


                           $mynavigator = new navigator($tot_num_rows=$rows, $rec_per_page=$_SESSION['viewpage'], $url=substr(BASE_URL,0,-1));
                           $query.= $mynavigator->sql_limit;
                           $db->query($query);
                           $recordprod = $db->resultset();

                           ?>
						<!-- TOP FILTER -->
						<div class="top-filter clearfix">


							<div class="pull-right">

                                                            <!-- SHOW PAGE -->

								<div class="show-page filter-select pull-left">
							         <form name="form2" id="form2" action="<?=BASE_URL;?>index.php"  method="POST">
										Mostra:
                                                                         <select id="sort" name="viewpage" onChange="form2.submit();">
                                                                         <option value="9" <?php if ($_SESSION['viewpage']=='9') { echo " selected ";} ?>>9</option>
                                                                         <option value="18" <?php if ($_SESSION['viewpage']=='18') { echo " selected ";} ?>>18</option>
                                                                         <option value="27" <?php if ($_SESSION['viewpage']=='27') { echo " selected ";} ?>>27</option>
                                                                         <option value="36" <?php if ($_SESSION['viewpage']=='36') { echo " selected ";} ?>>36</option>
                                                                         <option value="45" <?php  if ($_SESSION['viewpage']=='45') { echo " selected ";} ?>>45</option>
                                                                         </select>
								  </form>
								</div>

								<!-- SORT BY -->

								<div class="sort filter-select pull-left">
							         <form name="form1" id="form1" action="<?=BASE_URL;?>index.php"  method="POST">

										Ordina per:

                                                                         <select id="sort" name="sortby" onChange="form1.submit();">
                                                                         <option value="0" <?php if ($_SESSION['sort']=='0') { echo " selected ";} ?>>Prezzo pi&ugrave; basso</option>
                                                                         <option value="1" <?php if ($_SESSION['sort']=='1') { echo " selected ";} ?>>Prezzo pi&ugrave; alto</option>
                                                                         <option value="2" <?php if ($_SESSION['sort']=='2') { echo " selected ";} ?>>Alfabetico dalla A alla Z</option>
                                                                         <option value="3" <?php if ($_SESSION['sort']=='3') { echo " selected ";} ?>>Alfabetico dalla Z alla A</option>
                                                                         <option value="4" <?php  if ($_SESSION['sort']=='4') { echo " selected ";} ?>>Ultimi inseriti</option>
                                                                         </select>
								  </form>
								</div>

								<!-- END SORT BY -->

								<!-- SHOW PAGE -->
								<div class="show-page filter-select pull-left">
									<?= $mynavigator->html_data;?>

                                                                </div>

							</div>

						</div>
						<!-- END TOP FILTER -->

						<!-- GRID CONTENT -->
						<div class="grid-cn-3">
							<div class="row">

                          <?php
                           foreach ($recordprod as $list) {

                         ?>
                                            <div class="col-xs-6 col-md-6 col-lg-4">
                                                    <!-- GRID ITEM -->
                                                    <div class="grid-item _3">

                                                        <div class="image" style="border:solid 1px grey;">
                                                                     <a href="<?=BASE_URL;?>item_<?=$list['id']."/".seo_url($list['nome']);?>"  title="<?=$list['nome'];?>">
                                                                            <img src="<?=$phpThumbBase;?>?src=images/img_prod/<?=$list['img1'];?>&h=300&w=277&far=1&bg=ffffff" alt="" >
                                                                    </a>
                                                            	<div class="rating-view">



<!--                                                                    <div><?=substr(strip_tags($list['descrizione']),0,350);?>...<br /></div>-->
                                                                      <div class="view-r">
                                                                        <br /><br /><a href="<?=BASE_URL;?>item_<?=$list['id']."/".seo_url($list['nome']);?>" class="btn btn-16" title="Vedi dettagli"><i class="fa fa-eye"></i></a>
                                                                    </div>
								</div>

                                                            </div>
                                                            <div class="text">
                                                                    <h2 class="name">
                                                                       <a href="<?=BASE_URL;?>item_<?=$list['id']."/".seo_url($list['nome']);?>">
                                                                       <?=strtolower(substr($list['nome'],0,32));?>
                                                                       <?php if(strlen($list['nome'])>31) echo ".."; ?>
                                                                       </a>
                                                                    </h2>

                            <form id="addcar<?=$list['id'];?>" name="addcar<?=$list['id'];?>" method="POST" action="<?=BASE_URL;?>carts">

                                                                    <div class="price-box">
                                                                            <p class="special-price">


                                                                     <?php

                                                                     if($list['prezzo_disponibile']=='n'){ ?>

                                                                      <span class="price" style="color:red;">
                                                                      Prezzo non disponibile
                                                                       </span>


                                                                     <?php } else {

                                                                         if($list['prezzo_scontato']>0) { ?>
                                                                       <input type="hidden" id="price" name="price" value="<?= $list['prezzo_scontato'] ;?>" />
                                                                       <span class="price">
                                                                       <?=number_format($list['prezzo_scontato'],2,',','.');?> &euro;
                                                                       </span>
                                                                        &nbsp;
                                                                       <span class="price">
                                                                       <strike><?=number_format($list['prezzo'],2,',','.');?> &euro;</strike>
                                                                       </span>

                                                                     <?php } else {?>

                                                                       <input type="hidden" id="price" name="price" value="<?= $list['prezzo'] ;?>" />
                                                                       <span class="price">
                                                                       <?=number_format($list['prezzo'],2,',','.');?> &euro;
                                                                       </span>

                                                                      <?php }

                                                                      }?>


                                                                            </p>
                                                                     </div>

         <input type="hidden" name="qty" id="qty" value="1" />

         <input type="hidden" id="item" name="item" value="<?= $list['id'] ;?>" />

         <input type="hidden" id="itemdb" name="itemdb" value="<?= $list['id'];?>" />

         <input type="hidden" id="codart" name="codart" value="<?=$list['codice'];?>" />

         <input type="hidden" id="nome" name="nome" value="<?= $list['nome'] ;?>" />

         <input type="hidden" id="returnurl" name="returnurl" value="<?=BASE_URL;?>item_<?=$list['id']."/".seo_url($list['nome']);?>" />

         <input type="hidden" id="action" name="action" value="add" />

         <input type="hidden" id="imageprod" name="image" value="<?=$list['img1'];?>" />

</form>
                                                                            <div class="action">
                                                                                <?php



                                                                                if($list['prezzo_disponibile']=='s'){ ?>

                                                                               <?php if($list['taglia']=='' && $list['colore']=='') { ?>
                                                                               <a href="javascript:void(null)" class="btn btn-16 add-cart text-uppercase" onClick="document.addcar<?=$list['id'];?>.submit();">
                                                                               <?php } else { ?>
                                                                                <a href="<?=BASE_URL;?>item_<?=$list['id']."/".seo_url($list['nome']);?>" class="btn btn-16 add-cart text-uppercase" >
                                                                               <?php } ?>
                                                                                   <i class="fa fa-cart-plus"></i> <span>Aggiungi al carrello</span>
                                                                               </a>


                                                                                 <?php } else {

                                                                                    echo  $list['testo_offerta'];
                                                                                    } ?>

                                                                            </div>

                                                            </div>

                                                    </div>
                                                    <!-- END GRID ITEM -->

                                                 </div>
 <?php } ?>



							</div>
						</div>
						<!-- END GRID CONTENT -->

						<!-- BOTTOM LIST -->
						<div class="bottom-list clearfix">
                                                     <div class="show-page filter-select pull-right">
							<?= $mynavigator->html_data;  ;?>
                                                     </div>
						</div>
						<!-- END BOTTOM LIST -->

					</div>


				</div>
			</div>
		</section>
		<!-- END PRODUCT LIST -->

		<!-- INTRO -->
    <section class="from-blog _3">
			<div class="container">
				<div class="heading _3 text-center text-uppercase" >
					<h2> GEVENIT: SHOP ONLINE PER LA PULIZIA PROFESSIONALE, INDUSTRIALE E DOMESTICA </h2>
				</div>
  			<div class="row text-center seo_banner">
					<p>
            Stai cercando <b>attrezzature, macchinari e prodotti per la pulizia professionale, industriale e domestica?</b><br>
						<b>Gevenit srl</b> è il tuo <b>negozio online</b> di fiducia per la <b>pulizia professionale!</b><br><br>
						<b>Gevenit srl</b> seleziona per te i <b>prodotti e macchinari più innovativi</b> sul mercato per offrirti il meglio:
            <b>lavasciuga pavimenti, accessori da bagno, dispenser sapone e detergenti professionali</b> di qualità,
            <b>dispositivi di protezione individuale, attrezzature e Linea Cortesia per Hotel e Benessere,
           	prodotti e strumenti per la sanificazione e disinfestazione!</b><br><br>
						Affidati agli specialisti del pulito di Gevenit srl! Perché <b>l’igiene è un valore</b> ma, prima di tutto, <b>una necessità!</b>
					</p>
      	</div>
      </div>
    </section>
			<!-- END INTRO -->

<!-- FROM THE BLOG -->
		<section class="from-blog _3">
			<div class="container">

				<div class="heading _3 text-center">
					<h2 class="text-uppercase">Dal blog di GEVENIT</h2>
				</div>

				<div class="from-blog-cn _3">

			<div class="row">

                            <?php

                           $db->query("SELECT DISTINCT articoli.*
                                       FROM
                                       articoli
                                       WHERE visible='s'
                                       ORDER BY RAND()
                                       LIMIT 0,3
                                       ");
                           $recordtot = $db->resultset();
                           foreach ($recordtot as $value) {

                               $myNewString=seo_url($value['url']);




                               $db->query("SELECT COUNT(*) AS totcom
                                           FROM commenti
                                           WHERE id_news='".$value['id_articolo']."'

                                           ");
                               $recordc= $db->single();


                               $db->query("SELECT  *  FROM  categorie_articoli
                                           WHERE id_categoria_articolo='".$value['categoria']."' ");
                                $recordscat = $db->single();

                             ?>

						<!-- BLOG ITEM -->
						<div class="col-sm-6 col-md-4">
							<div class="blog-item ">

								<div class="img">
									<a href="<?=BASE_URL;?>blog<?=$value['id_articolo'];?>/<?=$myNewString;?>">
                                                                            <img src="<?=$phpThumbBase;?>?src=galleria/<?=$value['immagine'];?>&w=343&h=210&iar=1" alt="">
                                                                        </a>

<!--									<span class="blog-date"><?=ritornagiorno($value['data']);?> <small><?=substr(ritornamese($value['data']),0,3);?></small></span>-->

								</div>

								<div class="text">

									<ul class="blog-meta">
										<li>
											<a href="#">
<!--												<img src="images/user/img-1.jpg" alt="" />-->
												Da <span><?=$value['autore'];?></span>
											</a>
										</li>
										<li>
											<a href="#">
												<span><?=$recordc['totcom'];?> </span> Commenti
											</a>
										</li>
<!--										<li>
											<a href="#">
												<span>16</span> Likes
											</a>
										</li>-->
									</ul>

									<h4><a href="<?=BASE_URL;?>blog<?=$value['id_articolo'];?>/<?=$myNewString;?>"><?=$value['titolo_it'];?></a></h4>

									<p>
									<?=substr(strip_tags($value['articolo_it']),0,170);?>.... </p>

								</div>

							</div>
						</div>
						<!-- END BLOG ITEM -->
                           <?php } ?>
					</div>

				</div>
			</div>
		</section>
		<!-- END FROM THE BLOG -->

<?php
include("inc_footer.php");
?>
