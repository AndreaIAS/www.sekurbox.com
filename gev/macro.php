<?php
include("inc_config.php");

//PRENDO I DATI DELLA MACRO
  $db->query("SELECT * FROM bag_macro
              WHERE bag_macro.id='".$_REQUEST['id_mcat']."'
             ");
  $list = $db->single();

        //CONTROLLO SE ESISTE
        if ($db->rowCount() == 0) {

                    header("HTTP/1.0 404 Not Found");
                    header("Location: ".BASE_URL."404.php");
        }
        else{

                    if(isset($_REQUEST['seo']) AND seo_url($list['nome']) !=$_REQUEST['seo']){

                           header("HTTP/1.0 404 Not Found");
                           header("Location: ".BASE_URL."404.php");
                                                                                        }
            }



$title="Gevenit - ".$list['nome'];


$macrocategoria=$_REQUEST['id_mcat'];
if((!$_REQUEST['offset'])||($_REQUEST['offset'] == "0/")){
  if ($_REQUEST['seo'] == "Detergenti-Professionali") {
    $title = "Detergenti Professionali per la Pulizia Industriale e Domestica. Scegli tra il catalogo Online di Gevenit";
    $description = "Con i Detergenti Professionali risparmi scegliendo la qualità dello store online di Gevenit: Detergenti Disinfettanti, Detergenti per Superfici, Detergenti Igiene Persona";
    $keywords = "Detergenti professionali; detergenti disinfettanti; detergenti per superfici; detergenti igiene persona; detergenti per stoviglie; detergenti per bucato; detergenti per bagno";
  }
}

include("inc_header.php");
?>

</head>
<body class="bg-body boxed">

    <?php
    include("inc_menu.php");
    ?>
  <!-- BREAKCRUMB -->
    <section style="height: 50px;padding-top: 10px;">
	<div class="container" style="cursor:pointer;padding:0px;width: 49%; background-color: red; height: 50px; float: left; margin-left: 1.7%;text-align: center;color:#ffffff;" onclick="window.location.href='<?=BASE_URL;?>contatti.php'">
	    <div class="riv1" >SEI UN RIVENDITORE?</div>
	    <div class="riv2" >Contattaci per Ogni Tua Esigenza.</div>
	</div>

	<div class="container"  onclick="window.location.href='<?=BASE_URL;?>contatti.php'" style="cursor:pointer;padding:0px;background-color:#008a42; margin-left: 3px; height: 50px; float: left; width: 47.5%;text-align: center;color:#ffffff;">
	    <div class="riv1" >SEI UN ENTE PUBBLICO?</div>
	    <div class="riv2" >I Codici Mepa Agevolano la Tua Ricerca.</div>
	</div>
    </section>
    <!-- END BREAKCRUMB -->
      <div style="clear:both"></div>
		<!-- BREAKCRUMB -->
		<section class="breakcrumb bg-grey">
			<div class="container">
				<ul class="nav-breakcrumb ">
					<li><a href="<?=BASE_URL;?>index.php">Home</a></li>
					<li><span><?=$list['nome'];?></span></li>
				</ul>
			</div>
		</section>
		<!-- END BREAKCRUMB -->

		<!-- PRODUCT LIST 2 -->
		<section class="product-list">
			<div class="container">
				<div class="row">
					<div class="col-md-9 col-md-push-3">

						<!-- SUB BANNER -->
					<div class="sub-banner">
							<div class="item">
								<div class="img">
									<a href="#">
										<img src="<?=BASE_URL;?>images/categorie/<?=$list['immagine'];?>" alt="">
									</a>
								</div>
							</div>
            <?php
              if((!$_REQUEST['offset'])||($_REQUEST['offset'] == "0/")){
                if ($_REQUEST['seo'] == "Detergenti-Professionali"){ ?>
                <div class="list-item _2">
                  <div class="heading _3 text-center text-uppercase" >
                    <h1> <b>DETERGENTI PROFESSIONALI</b> </h1>
                  </div>
                  <div class="row text-center seo_banner">
                    <p>
                      <b>Detergenti Professionali: vuoi risparmiare scegliendo la qualità?</b><br />
                      Gevenit srl ti offre una consulenza personalizzata e ti propone una serie di detergenti professionali per ogni tua esigenza.
                      Esistono diverse tipologie di detergenti professionali in base all’utilizzo specifico che se ne deve fare, l’importante è prestare attenzione alla tipologia di superficie da detergere (pulire la superficie di un corpo e asportane tutte le impurità).<br /><br />
                      <b>Cos’è che distingue un detergente professionale da uno di uso comune?</b><br />
                      Vi sono quattro tipologie di detergenti professionali che si classificano per il valore del PH.<br />
                      Ci sono quelli neutri con un PH che corrisponde a 7, quelli a base acida con un PH da 0 a 6 e quelli a base alcalina con un PH da 8 a 14.<br />
                      Un detergente è efficace in base alla qualità e alla quantità di tensioattivi presenti in esso.<br />
                      Ma cosa sono i tensioattivi? Queste sostanze sono costituite da una molecola con duplice funzione: una idrofila (in greco idros sta per acqua) che si unisce all’acqua e una lipofila (in greco lipos sta per grasso) che cattura lo sporco attirandolo a sé. <br />
                      Inoltre alcuni detergenti presentano i cosiddetti “agenti sequestranti” che catturano il calcare e i sali contenuti nell’acqua riducendo al minimo gli aloni in seguito al risciacquo.<br />
                      Con i detergenti professionali di qualità ottimizzi i tempi e risorse e ottieni risultati prima impensabili. Contattaci per una consulenza specifica e personalizzata in base alle tue esigenze!
                    </p>
                  </div>
                </div>
            <?php }} ?>
						</div>
						<!-- END SUB BANNER -->



                                       <?php

                                               if (isset($_POST['sortby'])) { $_SESSION['sortmcat'] = $_POST['sortby'];}
                                               else     {   if(!isset($_SESSION['sortmcat']))  $_SESSION['sortmcat'] = 0;   }


                                               $query="SELECT bag_articoli.*
                                                       FROM
                                                       bag_articoli
                                                       INNER JOIN bag_scat ON bag_scat.id=bag_articoli.id_sottocategoria
                                                       INNER JOIN bag_categorie ON bag_categorie.id=bag_scat.id_categoria
                                                       INNER JOIN bag_macro ON bag_macro.id=bag_categorie.id_macro AND bag_macro.id='".$_REQUEST['id_mcat']."' ";

                                               $db->query($query);
                                               $recordprod = $db->resultset();
                                               $rows = $db->rowCount();

                                                switch ($_SESSION['sortmcat']) {

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


                                               $mynavigator = new navigator($tot_num_rows = $rows, $rec_per_page = $_SESSION['viewpage'],$url=BASE_URL."mcat_".$_REQUEST['id_mcat']."/".$_REQUEST['seo']);
                                               $query.= $mynavigator->sql_limit;
                                               $db->query($query);
                                               $recordprod = $db->resultset();

                                               ?>


					<!-- TOP FILTER -->
						<div class="top-filter clearfix">


							<div class="pull-right">

								<!-- SORT BY -->

                                                                <div class="show-page filter-select pull-left">
							         <form name="form2" id="form2" action="<?=BASE_URL;?>index.php"  method="POST">
										Mostra:
                                                                         <select id="sort" name="viewpage" onchange="form2.submit();">
                                                                         <option value="9" <?php if ($_SESSION['viewpage']=='9') { echo " selected ";} ?>>9</option>
                                                                         <option value="18" <?php if ($_SESSION['viewpage']=='18') { echo " selected ";} ?>>18</option>
                                                                         <option value="27" <?php if ($_SESSION['viewpage']=='27') { echo " selected ";} ?>>27</option>
                                                                         <option value="36" <?php if ($_SESSION['viewpage']=='36') { echo " selected ";} ?>>36</option>
                                                                         <option value="45" <?php  if ($_SESSION['viewpage']=='45') { echo " selected ";} ?>>45</option>
                                                                         </select>
								  </form>
								</div>
								<div class="sort filter-select pull-left">
							         <form name="form1" id="form1" action="<?=BASE_URL;?>mcat_<?=$_REQUEST['id_mcat'];?>/<?=$_REQUEST['seo'];?>"  method="POST" >
										Ordina per:

                                                                         <select id="sort" name="sortby" onchange="form1.submit();">
                                                                         <option value="0" <?php if ($_SESSION['sortmcat']=='0') { echo " selected ";} ?>>Prezzo pi&ugrave; basso</option>
                                                                         <option value="1" <?php if ($_SESSION['sortmcat']=='1') { echo " selected ";} ?>>Prezzo pi&ugrave; alto</option>
                                                                         <option value="2" <?php if ($_SESSION['sortmcat']=='2') { echo " selected ";} ?>>Alfabetico dalla A alla Z</option>
                                                                         <option value="3" <?php if ($_SESSION['sortmcat']=='3') { echo " selected ";} ?>>Alfabetico dalla Z alla A</option>
                                                                         <option value="4" <?php  if ($_SESSION['sortmcat']=='4') { echo " selected ";} ?>>Ultimi inseriti</option>
                                                                         </select>

								</div> </form>

								<!-- END SORT BY -->

								<!-- SHOW PAGE -->
								<div class="show-page filter-select pull-left">
									<?= $mynavigator->html_data;?>

                                                                </div>

							</div>

						</div>
						<!-- END TOP FILTER -->

						<!-- LIST CONTENT -->
						<div class="list-cn">

                                                      <?php
                                                       foreach ($recordprod as $list) {

                                                     ?>
							<!-- ITEM -->
							<div class="list-item  _2" itemscope itemtype="http://schema.org/Product">

								<div class="image">

									<a href="<?=BASE_URL;?>item_<?=$list['id']."/".seo_url($list['nome']);?>"  title="<?=$list['nome'];?>">
										<img itemprop="image" src="<?=$phpThumbBase;?>?src=images/img_prod/<?=$list['img1'];?>&h=300&w=200&far=1&bg=ffffff" alt="">
									</a>

								</div>

								<div class="text">

									<h2 class="name">
										<a href="<?=BASE_URL;?>item_<?=$list['id']."/".seo_url($list['nome']);?>"  title="<?=$list['nome'];?>"><span itemprop="name"><?=$list['nome'];?></span></a>
									</h2>



                                                                     <?php if($list['disponibile_tra'] !=''){  ?>
                                                                     <div style="color:red;"><br />Tempo di consegna:  <?=$list['disponibile_tra'];?></div>
                                                                     <?php } ?>


									<div class="hr _2"></div>

									<div class="sku">
                                                                        <span class="product_sku">Codice gevenit: <span><?=$list['codice'];?></span></span><br />
                                                                        <span class="product_sku" style="color:red; font-size:16px;">Codice mepa: <span><?=$list['codice_mepa'];?></span></span><br />
                                                                        <span class="product_sku">Codice fornitore: <span><?=$list['codice_fornitore'];?></span></span>
                                                                        <meta itemprop="productID" content="mepa:<?=$list['codice_mepa'];?>" />
									</div>

									<div class="desc">
										<p>
										<?=$list['descrizione'];?>...
                    </p>
									</div>

									<div class="group">
 <form id="addcar<?=$list['id'];?>" name="addcar<?=$list['id'];?>" method="POST" action="<?=BASE_URL;?>carts">

                                                  <div class="price-box" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                                                     <?php

                                                                     if($list['prezzo_disponibile']=='n'){ ?>

                                                                      <span class="price" style="color:red;">
                                                                      Prezzo non disponibile
                                                                       </span>


                                                                     <?php } else {
                                                                      if($list['prezzo_scontato']>0) { ?>

                                                                    <input type="hidden" id="price" name="price" value="<?= $list['prezzo_scontato'] ;?>" />
                                                                    <p class="special-price">
                                                                            <span class="price">
                                                                            <span itemprop="price" content="<?=number_format($list['prezzo_scontato'],2,'.','');?>">
                                                                              <?=number_format($list['prezzo_scontato'],2,',','.');?></span>
                                                                            <span itemprop="priceCurrency" content="EUR">&euro;</span>
                                                                            <link itemprop="availability" href="http://schema.org/InStock" />
                                                                            </span>
                                                                    </p>

                                                                    <p class="old-price">
                                                                    <span class="price"><?=number_format($list['prezzo'],2,',','.');?> &euro;</span>
                                                                    </p>
                                                                    <?php } else {?>
                                                                       <input type="hidden" id="price" name="price" value="<?= $list['prezzo'] ;?>" />
                                                                       <p class="special-price">
                                                                            <span class="price">
                                                                              <span itemprop="price" content="<?=number_format($list['prezzo'],2,'.','');?>">
                                                                                <?=number_format($list['prezzo'],2,',','.');?></span>
                                                                              <span itemprop="priceCurrency" content="EUR"></span>
                                                                              <link itemprop="availability" href="http://schema.org/InStock" />
                                                                            </span>
                                                                    </p>

                                                                      <?php }

                                                                                  }?>

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

                                                                                        if($list['prezzo_disponibile']=='s' ){ ?>

                                                                                               <?php if($list['taglia']=='' && $list['colore']=='') { ?>
                                                                                               <a href="javascript:void(null)" class="btn btn-4 text-uppercase" onclick="document.addcar<?=$list['id'];?>.submit();">
                                                                                               <?php } else { ?>
                                                                                                <a href="<?=BASE_URL;?>item_<?=$list['id']."/".seo_url($list['nome']);?>" class="btn btn-16 add-cart text-uppercase" >
                                                                                               <?php } ?>


                                                                                               <i class="fa fa-cart-plus"></i> Acquista</a>


                                                                                                <?php } else {

                                                                                        echo  $list['testo_offerta'];

                                                                                        }  ?>
<!--											<a href="#" class="btn btn-4"><i class="fa fa-heart-o"></i> <span>Add to WishList</span></a>

											<a href="#" class="btn btn-4"><i class="fa fa-refresh"></i> <span>Add to Compare</span></a>-->

										</div>

<!--										<div class="share">
											<span>Share:</span>
											<a href="#" class="_1"><i class="fa fa-facebook-square"></i></a>
											<a href="#" class="_2"><i class="fa fa-twitter-square"></i></a>
											<a href="#" class="_3"><i class="fa fa-pinterest-square"></i></a>
										</div>-->

									</div>

								</div>

							</div>
							<!-- END ITEM -->

                                                       <?php } ?>

						</div>
						<!-- END LIST CONTENT -->

						<!-- BOTTOM LIST -->
						<div class="bottom-list clearfix">
                                                     <div class="show-page filter-select pull-right">
							<?= $mynavigator->html_data;  ;?>
                                                     </div>
						</div>
						<!-- END BOTTOM LIST -->

					</div>

                            <div class="col-md-3 col-md-pull-9">
			           <?php
                                    include("inc_leftside.php");
                                    ?>




						<!-- WIDGET PHOTO SLIDE -->
						<aside class="sidebar widget_photo_slide _3">
                                                    <div class="wrap-sidebar-title">
                                                        <h2 class="sidebar-title">Altri prodotti</h2>
                                                      </div>
							<div class="photo-slide">
								<div id="photo_slide">
                                                                     <?php

                                                                        $db->query("SELECT *
                                                                                   FROM
                                                                                   bag_articoli
                                                                                   ORDER by RAND()
                                                                                   LIMIT 0,5
                                                                                   ");
                                                                       $recordleft = $db->resultset();
                                                                       foreach ($recordleft as $list) {
                                                                       ?>

									<a href="<?=BASE_URL;?>item_<?=$list['id']."/".seo_url($list['nome']);?>">
                                                                            <img src="<?=$phpThumbBase;?>?src=images/img_prod/<?=$list['img1'];?>"  alt="<?=$list['nome'];?>" title="<?=$list['nome'];?>">
                                                                        </a>
								          <?php } ?>
								</div>
							</div>
						</aside>
						<!-- END WIDGET PHOTO SLIDE -->

					</div>
					<!-- END SIDEBAR -->
				</div>
			</div>
		</section>
		<!-- END PRODUCT LIST 2 -->


<?php
include("inc_footer.php");
?>
