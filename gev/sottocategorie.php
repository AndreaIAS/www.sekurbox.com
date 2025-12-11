<?php
include("inc_config.php");

//PRENDO I DATI DELLA MACRO
  $db->query("SELECT * FROM bag_scat
              WHERE bag_scat.id='".$_REQUEST['id_scat']."'
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

  $db->query("SELECT bag_macro.* FROM bag_macro,bag_categorie,bag_scat
              WHERE bag_macro.id=bag_categorie.id_macro
              AND bag_categorie.id=bag_scat.id_categoria AND bag_scat.id='".$_REQUEST['id_scat']."'
             ");
  $listm = $db->single();

 $db->query("SELECT bag_categorie.* FROM bag_categorie,bag_scat
              WHERE  bag_categorie.id=bag_scat.id_categoria AND bag_scat.id='".$_REQUEST['id_scat']."'
             ");
  $listcat = $db->single();

  $title="Gevenit - ".$list['nome'];
  $macrocategoria=$listm['id'];
  $categoria= $listcat['id'];
  $sottocategoria=$_REQUEST['id_scat'];

  if((!$_REQUEST['offset'])||($_REQUEST['offset'] == "0/")){
    if ($_REQUEST['seo'] == "Dispenser-Sapone") {
      $title = "Scegli tra i Dispenser per Sapone Liquido dello Store Online di Gevenit";
      $description = "Confronta i modelli di Dispenser di Sapone liquido che Gevenit ti propone per la tua casa o azienda o ufficio: da parete manuale, automatico con sensore infrarosso e luce a led o per box doccia";
      $keywords = "dispenser sapone; dispenser di sapone liquido; dispenser sapone liquido; dosatori sapone; Gevenit";
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
                                        <li><a href="<?=BASE_URL;?>mcat_<?=$listm['id'];?>/<?=seo_url($listm['nome']);?>"><?=$listm['nome'];?></a></li>
                                        <li><a href="<?=BASE_URL;?>cat_<?=$listcat['id'];?>/<?=seo_url($listcat['nome']);?>"><?=$listcat['nome'];?></a></li>
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
            <div class="sub-banner" style="margin-top:10px;">
							<div class="item">
								<div class="img">
									<a href="#">
										<img src="<?=BASE_URL;?>images/categorie/<?=$listm['immagine'];?>" alt="">
									</a>
								</div>
							</div>
              <!-- < ?php //if((!$_REQUEST['offset'])||($_REQUEST['offset'] == "0/")){ if ($_REQUEST['seo'] == "Dispenser-Sapone"){ }} ?>-->
						</div>
						<!-- END SUB BANNER -->



                                       <?php

                                               if (isset($_POST['sortby'])) { $_SESSION['sortscat'] = $_POST['sortby'];}
                                               else     {   if(!isset($_SESSION['sortscat']))  $_SESSION['sortscat'] = 0;   }


                                               $query="SELECT bag_articoli.*
                                                       FROM
                                                       bag_articoli
                                                       INNER JOIN bag_scat ON bag_scat.id=bag_articoli.id_sottocategoria  AND bag_scat.id='".$_REQUEST['id_scat']."' ";


                                               $db->query($query);
                                               $recordprod = $db->resultset();
                                               $rows = $db->rowCount();

                                                switch ($_SESSION['sortscat']) {

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


                                               $mynavigator = new navigator($tot_num_rows = $rows, $rec_per_page = $_SESSION['viewpage'],$url=BASE_URL."scat_".$_REQUEST['id_scat']."/".$_REQUEST['seo']);
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
							         <form name="form1" id="form1" action="<?=BASE_URL;?>scat_<?=$_REQUEST['id_scat'];?>/<?=$_REQUEST['seo'];?>"  method="POST">
										Ordina per:
                                                                         <select id="sort" name="sortby" onchange="form1.submit();">
                                                                         <option value="0" <?php if ($_SESSION['sortscat']=='0') { echo " selected ";} ?>>Prezzo pi&ugrave; basso</option>
                                                                         <option value="1" <?php if ($_SESSION['sortscat']=='1') { echo " selected ";} ?>>Prezzo pi&ugrave; alto</option>
                                                                         <option value="2" <?php if ($_SESSION['sortscat']=='2') { echo " selected ";} ?>>Alfabetico dalla A alla Z</option>
                                                                         <option value="3" <?php if ($_SESSION['sortscat']=='3') { echo " selected ";} ?>>Alfabetico dalla Z alla A</option>
                                                                         <option value="4" <?php  if ($_SESSION['sortscat']=='4') { echo " selected ";} ?>>Ultimi inseriti</option>
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

									<div class="desc" itemprop="description">
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
                                                                              <span itemprop="price" content="<?=number_format($list['prezzo'],2,'.','');?>"><?=number_format($list['prezzo'],2,',','.');?></span>
                                                                              <span itemprop="priceCurrency" content="EUR">&euro;</span>
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

                                                                                        if($list['prezzo_disponibile']=='s'){ ?>

                                                                                        <?php if($list['taglia']=='' && $list['colore']=='') { ?>
                                                                                               <a href="javascript:void(null)" class="btn btn-4 text-uppercase" onclick="document.addcar<?=$list['id'];?>.submit();">
                                                                                               <?php } else { ?>
                                                                                                <a href="<?=BASE_URL;?>item_<?=$list['id']."/".seo_url($list['nome']);?>" class="btn btn-16 add-cart text-uppercase" >
                                                                                               <?php } ?>


                                                                                        <i class="fa fa-cart-plus"></i>
                                                                                            Acquista
                                                                                        </a>
                                                                                        <?php } else {

                                                                                        echo  $list['testo_offerta'];

                                                                                         } ?>
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
            <?php
            if((!$_REQUEST['offset'])||($_REQUEST['offset'] == "0/")){
              if ($_REQUEST['seo'] == "Dispenser-Sapone"){
              ?>
              <div class="list-item _2">
                <div class="heading _3 text-center text-uppercase" >
                  <h1> <b>DISPENSER SAPONE</b> </h1>
                </div>
                <style>
                .lista {font-size:18px; margin-left: 30px; margin-right: 50px;}
                .lista li{ padding-left: 30px; paddig-right: 30px;}</style>

                <div class="row text-center seo_banner">
                  <p>
                    <b>Come funziona un Dispenser di Sapone?</b><br>
                    Nella parte superiore vi &egrave; sempre un serbatoio in gomma,
                    in vetro o in acciaio che contiene il detergente professionale che sceglierete.<br>
                    Nella parte inferiore invece &egrave; collocata una leva che
                    alla pressione fa confluire il sapone in una cannula e lo rilascia
                    direttamente sulle nostre mani.<br><br>
                    <b>A cosa servono i Dispenser di Sapone?</b><br>
                    Il <b>Dispenser</b> di <b>sapone liquido professionale</b>,
                    che sia <b>da parete</b> manuale, <b>automatico con sensore
                    infrarosso</b> e luce a led o <b>per</b> box <b>doccia</b>,
                    consente prima di tutto di <b>evitare</b> inutili <b>sprechi</b>
                    di risorse.<br>
                    Inoltre i dispenser di sapone sono la migliore arma per
                    prevenire e combattere l'insorgere di fastidiose infezioni.<br><br>
                    <b>Perché è importante utilizzare il Dispenser di Sapone nei luoghi pubblici?</b><br>
                    Nelle aziende, ospedali, case e in tutti i luoghi pubblici
                    dove transita una mole considerevole di persone è fondamentale
                    la presenza dei dispenser di sapone, così come tutti quegli
                    accessori che permettono di lavarci le mani e di usare i servizi
                    eliminando quasi del tutto il contatto della nostra epidermide con
                    le superfici che toccano tutti.
                  </p>
                  <p>
                    <b>Quante e quali sono le tipologie di Dispenser di Sapone?</b><br>
                    Ci sono 5 tipologie di Dispenser di Sapone ed ora ne analizzeremo le differenze.
                    <ol class="text-left lista">
                      <li><b>Dispenser di Sapone Liquido a Riempimento.</b><br>Sono quelli
                        più usati di solito si applicano sulla parete adiacente
                        al lavabo in sospensione. Sono tante le colorazioni e le
                        capienze disponibili per il sapone liquido.</li><br>
                      <li><b>Dispenser di Sapone Liquido ad Appoggio.</b><br>Sono quelli
                        che abbiamo di solito nelle nostre case. Sceglietene uno
                        semplice o dalle linee moderne, comunque in ogni caso
                        daranno un tocco di eleganza al vostro bagno.</li><br>
                      <li><b>Dispenser di Sapone Liquido a Riempimento con Leva.</b><br>
                        Si trovano soprattutto nelle aziende ospedaliere e sanitarie
                        in genere, la leva è l’unica superficie che sarà a contatto
                        con la nostra pelle. Di solito sono costruiti in acciaio,
                        essendo un materiale facilmente lavabile ed igienizzabile.</li><br>
                      <li><b>Dispenser di Sapone Automatico con Fotocellula.</b><br>
                        Questa è la tipologia di Dispenser di Sapone più innovativa.
                        Una fotocellula molto simile a quelle applicate ad alcuni
                        lavabo per dosare il flusso d’acqua, avverte la presenza
                        della nostra mano nella parte inferiore del dispenser e da
                        il via in modo automatico all’erogazione del sapone necessario
                        per detergere le nostre mani.</li><br>
                      <li><b>Dispenser di Soluzioni Igienizzanti Idro-Alcoliche.</b><br>
                        Sono quei dispenser che oltre al detergente o sapone erogano
                        anche un gel antisettico. Anche questo tipo di dispenser si
                        trova in alcune aziende ospedaliere e strutture sanitarie in
                        quanto permette di pulire e sanificare le mani in un unico lavaggio.</li>
                    </ol>
                  </p>
                  <p><b>Perché acquistare un Dispenser di Sapone?</b><br>
                    Se tenete alla vostra igiene, a quella dei vostri clienti e
                    dipendenti o delle persone che transitano nei luoghi pubblici,
                    vi consigliamo di acquistare un Dispenser.<br>L’igiene delle mani
                    è la prima regola, evitare che la nostra pelle venga a contatto
                    con le superfici esposte e toccate da tutti è la seconda!
                    Inoltre ridurrete gli sprechi, perché i dispenser erogano solo
                    la quantità di sapone necessaria per un lavaggio.<br><br>
                    Quindi se volete evitare di contrarre infezioni e parassiti
                    scegliete subito<br> il Dispenser di Sapone adatto a voi!</p>
                </div>
              </div>
            <?php }}?>
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
