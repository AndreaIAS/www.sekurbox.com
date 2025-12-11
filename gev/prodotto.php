<?php
include("inc_config.php");

//PRENDO I DATI DELLA MACRO
$db->query("SELECT * FROM bag_articoli
  WHERE bag_articoli.id='".$_REQUEST['id_item']."'
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

  $db->query("SELECT bag_macro.* FROM bag_macro,bag_categorie,bag_scat,bag_articoli
    WHERE
    bag_macro.id=bag_categorie.id_macro
    AND  bag_categorie.id=bag_scat.id_categoria
    AND bag_articoli.id_sottocategoria=bag_scat.id AND bag_articoli.id='".$_REQUEST['id_item']."'

    ");
    $listm = $db->single();

    $db->query("SELECT bag_categorie.* FROM bag_categorie,bag_scat,bag_articoli
      WHERE  bag_categorie.id=bag_scat.id_categoria
      AND bag_articoli.id_sottocategoria=bag_scat.id AND bag_articoli.id='".$_REQUEST['id_item']."'
      ");
      $listcat = $db->single();

      $db->query("SELECT bag_scat.* FROM bag_scat,bag_articoli
        WHERE  bag_articoli.id_sottocategoria=bag_scat.id AND bag_articoli.id='".$_REQUEST['id_item']."'
        ");
        $listscat = $db->single();

        $macrocategoria=$listm['id'];
        $categoria= $listcat['id'];
        $sottocategoria= $listscat['id'];


//        include('./keyword-generator/class.colossal-mind-mb-keyword-generator.php');
//
//        $params['min_word_length'] = 5;  // min length of single words
//        $params['min_word_occur']  = 2;  // min occur of single words
//        $params['ignore'] = array('agrave');
//
//        $params['content'] = strip_tags($list['descrizione']);
//        $keyword = new colossal_mind_mb_keyword_gen($params);

        $title="Gevenit - ".$list['nome'];
        $description="Gevenit - ".strip_tags(substr($list['descrizione'],0,500));
        $keywords="Gevenit ";




        include("inc_header.php");
        /*$leng = strlen($description);
        $f_desc = "";
        for ( $i=0, $j=20; $leng<$j; $i=$i+$j, $j=$j+$j ){
        $f_desc = $f_desc.substr($description,$i,$j)."\r\n";
      }
      $f_desc = $f_desc.substr($description,$i);*/
      ?>
      <meta property="og:url" content="<?php echo BASE_URL;?>item_<?=$list['id']."/".seo_url($list['nome']);?>" >
      <meta property="og:type" content="website" >
      <meta property="og:title" content="<?php echo $title; ?>" >
      <meta property="og:description" content="<?php echo $description; ?>" >
      <meta property="og:image" content="<?=BASE_URL;?>images/img_prod/<?=rawurlencode($list['img1']);?>" >
      <meta property="og:image:width" content="200" >
      <meta property="og:image:height" content="200" >

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
          <ul class="nav-breakcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?=BASE_URL;?>index.php"><span itemprop="name">Home</span></a><meta itemprop="position" content="1" /></li>
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?=BASE_URL;?>mcat_<?=$macrocategoria;?>/<?=seo_url($listm['nome']);?>"><span itemprop="name"><?=$listm['nome'];?></span></a><meta itemprop="position" content="2" /></li>
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?=BASE_URL;?>cat_<?=$categoria;?>/<?=seo_url($listcat['nome']);?>"><span itemprop="name"><?=$listcat['nome'];?></span></a><meta itemprop="position" content="3" /></li>
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?=BASE_URL;?>scat_<?=$sottocategoria;?>/<?=seo_url($listscat['nome']);?>"><span itemprop="name"><?=$listscat['nome'];?></span></a><meta itemprop="position" content="4" /></li>
            <li itemprop="itemListElement"><span><?=$list['nome'];?></span></li>
          </ul>
        </div>
      </section>
      <!-- END BREAKCRUMB -->

      <!-- PRODUCT DETAIL -->
      <section class="product-detail _2 ">
        <div class="container" itemscope itemtype="http://schema.org/Product">

          <div class="row">

            <div class="col-l text-center">

              <div class="product-image">

                <div class="image-block">

                  <a id="view_full_size" class="fancybox" href="<?=BASE_URL;?>images/img_prod/<?=rawurlencode($list['img1']);?>">
                    <img itemprop="image" src="<?=$phpThumbBase;?>?src=images/img_prod/<?=rawurlencode($list['img1']);?>&h=550&w=400&far=1&bg=ffffff" alt="<?=$list['nome']?>" />
                    <span class="view-link"></span>
                  </a>

                </div>

                <div class="view-block">

                  <ul class="thumb_list">

                    <?php   for($i=1;$i<=5;$i++){

                      if($list['img'.$i]!=''){ ?>

                        <li <?php if($i==1) echo 'class="active"';?> for="<?=BASE_URL;?>images/img_prod/<?=$list['img'.$i];?>" data-src="<?=$phpThumbBase;?>?src=images/img_prod/<?=$list['img'.$i];?>&h=550&w=400">
                          <img src="<?=$phpThumbBase;?>?src=images/img_prod/<?=$list['img'.$i];?>&h=90&w=102&far=1&bg=ffffff" alt=""/>
                        </li>
                        <?php } } ?>


                        <!--                                                                        	<li class="active" data-src="images/product/detail/img-1.jpg"><img src="images/product/detail/thumb2/img-1.jpg" alt=""/></li>

                        <li data-src="images/product/detail/img-2.jpg"><img src="images/product/detail/thumb2/img-2.jpg" alt=""/></li>

                        <li data-src="images/product/detail/img-2.jpg"><img src="images/product/detail/thumb2/img-3.jpg" alt=""/></li>

                        <li data-src="images/product/detail/img-4.jpg"><img src="images/product/detail/thumb2/img-4.jpg" alt=""/></li>

                        <li data-src="images/product/detail/img-5.jpg"><img src="images/product/detail/thumb2/img-5.jpg" alt=""/></li>-->

                      </ul>

                    </div>

                    <!--							<div class="share">
                    <span>Share:</span>
                    <a href="#" class="_1"><i class="fa fa-facebook-square"></i></a>
                    <a href="#" class="_2"><i class="fa fa-twitter-square"></i></a>
                    <a href="#" class="_3"><i class="fa fa-pinterest-square"></i></a>
                  </div>-->
                </div>

              </div>

              <div class="col-r">

                <div class="product-text">
                  <h1 class="name"><span itemprop="name"><?=$list['nome'];?></span></h1>



                  <!--							<span class="product_stock">Available in stock</span>-->
                  <?php if($list['disponibile_tra'] !=''){  ?>
                    <div><br /><b>Tempo di consegna:  <?=$list['disponibile_tra'];?></b></div>
                    <?php } ?>


                    <span class="product_sku">Codice gevenit: <span><?=$list['codice'];?></span></span>
                    <span class="product_sku" style="color:red;">Codice mepa: <span><?=$list['codice_mepa'];?></span></span>
                    <span class="product_sku">Codice fornitore: <span><?=$list['codice_fornitore'];?></span></span>
                    <meta itemprop='productID' content='mepa:<?=$list['codice_mepa'];?>'/>


                    <form id="addcar" name="addcar" method="POST" action="<?=BASE_URL;?>carts">

                      <?php if($list['taglia']!='' || $list['colore']!=''){ ?>
                        <div class="hr _1"></div>
                        <?php } ?>

                        <?php if($list['taglia']!=''){ ?>
                          <span class="product_sku" ><b>Taglie disponibili:</b> <span><?=$list['taglia'];?></span></span>
                          <span class="product_sku">Taglia desiderata: </span><input type="text" name="taglia" id="taglia"   title="Taglia" class="input-text" />
                          <?php } ?>

                          <?php if($list['colore']!=''){ ?>
                            <span class="product_sku"><b>Colori disponibili:</b> <span><?=$list['colore'];?></span></span>
                            <span class="product_sku">Colore desiderato: </span><input type="text" name="colore" id="colore"  title="Colore" class="input-text" />
                            <?php } ?>

                            <div class="product_review">

                              <?php if($list['scheda_tecnica']!=''){ ?>
                                <span style="font-size:12px;">Scheda Tecnica:</span>
                                <a href="<?=BASE_URL;?>schede/<?=$list['scheda_tecnica'];?>" class="_1" title="Scheda tecnica" target="_blank">
                                  <img src="<?=BASE_URL;?>images/icona_pdf.gif">
                                </a>&nbsp;&nbsp;
                                <?php } ?>

                                <?php if($list['scheda_sicurezza']!=''){ ?>
                                  <span style="font-size:12px;">Scheda di sicurezza:</span>
                                  <a href="<?=BASE_URL;?>schede/<?=$list['scheda_sicurezza'];?>" class="_1" title="Scheda di sicurezza" target="_blank">
                                    <img src="<?=BASE_URL;?>images/icona_pdf.gif">
                                  </a>
                                  <?php } ?>

                                </div>
                                <div class="hr _1"></div>



                                <div class="price-box" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                  <?php

                                  if($list['prezzo_scontato']>0) { ?>

                                    <input type="hidden" id="price" name="price" value="<?= $list['prezzo_scontato'] ;?>" />
                                    <p class="special-price">
                                      <span class="price">
                                        <span itemprop="price" content="<?=number_format($list['prezzo_scontato'],2,'.','');?>"><?=number_format($list['prezzo_scontato'],2,',','.');?> </span>
                                        <span itemprop="priceCurrency" content="EUR">&euro;</span><span style="font-size:14px;"> IVA ESCLUSA</span>
                                        <link itemprop="availability" href="http://schema.org/InStock" />
                                      </span>
                                      </p>
                                      <p class="old-price">
                                        <span class="price"><?=number_format($list['prezzo'],2,',','.');?> &euro; <span style="font-size:14px;"> IVA ESCLUSA</span></span>
                                      </p>
                                      <?php } else {?>
                                        <input type="hidden" id="price" name="price" value="<?= $list['prezzo'] ;?>" />
                                        <p class="special-price">
                                          <span class="price">
                                          <span itemprop="price" content="<?=number_format($list['prezzo'],2,'.','');?>"><?=number_format($list['prezzo'],2,',','.');?></span>
                                            <span itemprop="priceCurrency" content="EUR">&euro;</span>
                                            <span style="font-size:14px;">IVA ESCLUSA</span>
                                            <link itemprop="availability" href="http://schema.org/InStock" />
                                          </span>
                                        </p>

                                        <?php } ?>

                                      </div>

                                      <div class="short-description" itemprop="description">
                                        <p>
                                          <?=$list['descrizione'];?></p>
                                        </div>



                                        <div style="cursor: pointer">
                                          <img src="<?=BASE_URL;?>images/help28.png" border="0" onclick="
                                          <?php if(isset($_SESSION['user'])) { ?>
                                            $('#formcontatti').slideToggle();$('html, body').animate({scrollTop: $('#formprodotto').position().top }, 2000);$('#nascprod').slideToggle();
                                            <?php } else { ?>
                                              $('#mexs').fadeIn();
                                              // setTimeout(function(){document.location.href = '<?=BASE_URL;?>registrati.php';  },4000);
                                              <?php }  ?>
                                              "/>

                                              &nbsp;&nbsp;<a style="color: #13914a" href="javascript:void(null)" onclick="
                                              <?php if(isset($_SESSION['user'])) { ?>
                                                $('#formcontatti').slideToggle();$('html, body').animate({scrollTop: $('#formprodotto').position().top }, 2000);$('#nascprod').slideToggle();
                                                <?php } else { ?>
                                                  $('#mexs').fadeIn();
                                                  // setTimeout(function(){document.location.href = '<?=BASE_URL;?>registrati.php';  },4000);
                                                  <?php }  ?>

                                                  ">Richiedi informazioni</a><br />

                                                  <div id="mexs" style="color:red;display:none;" >Attenzione, per richiedere informazioni bisogna effettuare il <a href="<?=BASE_URL;?>registrati.php">login</a>. <br />Se non sei ancora registrato,<a href="<?=BASE_URL;?>registrati.php"> registrati</a>.</div>

                                                </div>



                                                <div class="hr _1"></div>


                                                <!--	                      	<div id="attribute" class="attribute clearfix">

                                                <fieldset class="attribute_fieldset">
                                                <label class="attribute_label">Color:</label>
                                                <div class="attribute_list">
                                                <ul class="attribute_color">
                                                <li class="active"><a href="#" class="_1"></a></li>
                                                <li><a href="#" class="_2"></a></li>
                                                <li><a href="#" class="_3"></a></li>
                                                <li><a href="#" class="_4"></a></li>
                                              </ul>
                                            </div>
                                          </fieldset>

                                          <fieldset class="attribute_fieldset">
                                          <label class="attribute_label">Size:</label>
                                          <div class="attribute_list">
                                          <ul class="attribute_size">
                                          <li class="active"><a href="#">S</a></li>
                                          <li><a href="#">M</a></li>
                                          <li><a href="#">L</a></li>
                                          <li><a href="#">XS</a></li>
                                          <li><a href="#">XL</a></li>
                                        </ul>
                                      </div>
                                    </fieldset>

                                  </div>-->

                                  <div class="add-to-box clearfix" id="nascprod">

                                    <div class="input-content">

                                      <label for="qty">Quantità:</label>

                                      <div class="qty-box">

                                        <button class="qty-decrease" id="qty-plus"></button>

                                        <input type="text" name="qty" id="qty" maxlength="12" value="1" title="Qty" class="input-text qty" />

                                        <button class="qty-increase" id="qty-minus"></button>

                                      </div>

                                    </div>



                                    <input type="hidden" id="item" name="item" value="<?= $list['id'];?>" />

                                    <input type="hidden" id="itemdb" name="itemdb" value="<?= $list['id'];?>" />

                                    <input type="hidden" id="codart" name="codart" value="<?=$list['codice'];?>" />

                                    <input type="hidden" id="nome" name="nome" value="<?= $list['nome'] ;?>" />

                                    <input type="hidden" id="returnurl" name="returnurl" value="<?=BASE_URL;?>item_<?=$list['id']."/".seo_url($list['nome']);?>" />

                                    <input type="hidden" id="action" name="action" value="add" />

                                    <input type="hidden" id="imageprod" name="image" value="<?=rawurlencode($list['img1']);?>" />

                                  </form>


                                  <div class="add-to-cart">

                                    <?php

                                    if($list['prezzo_disponibile']=='s'){ ?>
                                      <a href="javascript:void(null)" class="btn btn-10 text-uppercase"
                                      onclick="if($('#colore').length && $('#taglia').length){
                                        $('#item').val('<?=$list['id'];?>'+$('#colore').val()+$('#taglia').val());
                                      } else {$('#item').val('<?=$list['id'];?>'); }
                                      document.addcar.submit();"
                                      >

                                      <i class="fa fa-cart-plus"></i> Acquista</a>
                                      <?php } else {

                                        echo  $list['testo_offerta'];


                                      } ?>

                                    </div>











                                    <!--				                <div class="add-to-user">
                                    <a href="#" class="btn btn-9"><i class="fa fa-heart-o"></i> <span>Add to WishList</span></a>
                                    <a href="#" class="btn btn-9"><i class="fa fa-refresh"></i> <span>Add to Compare</span></a>
                                  </div>-->
                                </div>

                                <div class="form check-out-form" id="formcontatti" style="width:100%;margin-top:30px;padding:0px 30px 30px 30px; border:solid 1px #dedede;display:none;">
                                  <br /><br />
                                  <form class="clearfix mt50" role="form" method="post" action="javascript:void(null)" name="formprodotto" id="formprodotto">
                                    <input type="hidden" name="nomeprodotto" value="<?=$list['nome'];?>" />
                                    <div class="row">
                                      <div class="col-xs-6">
                                        <label>Nome <sup>*</sup></label>
                                        <input type="text" name="name" class="input-text" required>
                                      </div>

                                      <div class="col-xs-12">
                                        <label>Indirizzo Email  <sup>*</sup></label>
                                        <input type="email"  name="email"  class="input-text" required>
                                      </div>

                                      <div class="col-xs-12">
                                        <label>Telefono </label>
                                        <input type="text"  name="telefono"  class="input-text" >
                                      </div>

                                      <div class="col-xs-12" >
                                        <label>Messaggio <sup>*</sup></label>
                                        <textarea  name="messaggio"  class="input-text" style="height: 90px;" required> </textarea>
                                      </div>
                                      <div id="message"></div>
                                      <div class="col-xs-12">
                                        <input type="submit" class="btn btn-13 text-uppercase pull-right" value="Invia">
                                      </div>
                                    </div>
                                  </form>
                                </div>

                              </div>

                            </div>
                          </div>


                        </div>
                      </section>
                      <!-- END PRODUCT DETAIL -->

                      <!-- PRODUCT RELATED -->
                      <section class="product-related">
                        <div class="container">

                          <div class="heading _2">
                            <h2 class="text-uppercase">Prodotti correlati</h2>
                          </div>

                          <div class="related-cn _2">
                            <div class="row">

                              <div id="related-slide" data-custom="0-1,480-2,768-3,992-4,1200-5">

                                <?php


                                $query="SELECT bag_articoli.*
                                FROM
                                bag_articoli
                                INNER JOIN bag_scat ON bag_scat.id=bag_articoli.id_sottocategoria
                                INNER JOIN bag_categorie ON bag_categorie.id=bag_scat.id_categoria
                                INNER JOIN bag_macro ON bag_macro.id=bag_categorie.id_macro AND bag_macro.id='".$macrocategoria."'
                                ORDER BY RAND()
                                LIMIT 0,10 ";


                                $db->query($query);
                                $recordcorr = $db->resultset();
                                foreach ($recordcorr as $value) {

                                  ?>

                                  <!-- GRID ITEM -->
                                  <div class="grid-item _2 ">

                                    <div class="image">

                                      <a href="<?=BASE_URL;?>item_<?=$value['id']."/".seo_url($value['nome']);?>">
                                        <img src="<?=$phpThumbBase;?>?src=images/img_prod/<?=$value['img1'];?>&h=315&w=210&far=1&bg=ffffff" alt="">
                                      </a>

                                      <div class="action">

                                        <div class="add-cart">
                                          <?php if($value['prezzo_disponibile']=='s'){ ?>
                                            <a href="#" class="btn btn-14 add-cart text-uppercase"><i class="fa fa-cart-plus"></i> Acquista</a>
                                            <?php } else {

                                              echo  $value['testo_offerta'];
                                            } ?>


                                          </div>

                                          <div class="group">
                                            <a href="#" class="btn btn-14" style="visibility: hidden"></a>

                                            <a href="<?=BASE_URL;?>item_<?=$value['id']."/".seo_url($value['nome']);?>" class="btn btn-14" title="Vai al prodotto">
                                              <i class="fa fa-eye"></i>
                                            </a>

                                            <a href="#" class="btn btn-14" style="visibility: hidden"></a>
                                          </div>

                                        </div>
                                      </div>

                                      <div class="text">

                                        <h2 class="name">
                                          <a href="<?=BASE_URL;?>item_<?=$value['id']."/".seo_url($value['nome']);?>"><?=$value['nome'];?></a>
                                        </h2>

                                        <div class="price-box">

                                          <p class="special-price">

                                            <?php

                                            if($value['prezzo_disponibile']=='n'){ ?>

                                              <span class="price" style="color:red;">
                                                Prezzo non disponibile
                                              </span>


                                              <?php } else {
                                                if($value['prezzo_scontato']>0) { ?>


                                                  <p class="special-price">
                                                    <span class="price">  <?=number_format($value['prezzo_scontato'],2,',','.');?> &euro;</span>
                                                  </p>

                                                  <p class="old-price">
                                                    <span class="price"><?=number_format($value['prezzo'],2,',','.');?> &euro;</span>
                                                  </p>
                                                  <?php } else {?>

                                                    <p class="special-price">
                                                      <span class="price">  <?=number_format($value['prezzo'],2,',','.');?> &euro;</span>
                                                    </p>

                                                    <?php }

                                                  }?>

                                                </p>

                                              </div>

                                              <!--									<div class="rating">

                                              <span class="star">
                                              <i class="fa fa-star"></i>
                                              <i class="fa fa-star"></i>
                                              <i class="fa fa-star"></i>
                                              <i class="fa fa-star"></i>
                                              <i class="fa fa-star-half"></i>
                                            </span>

                                            3 Review(s)

                                          </div>-->

                                        </div>

                                      </div>
                                      <!-- END GRID ITEM -->
                                      <?php } ?>


                                    </div>

                                  </div>

                                </div>

                              </div>
                            </section>
                            <!-- END PRODUCT RELATED -->



                            <?php
                            include("inc_footer.php");
                            ?>

                            <script>
                            $(document).ready(function() {


                              $("#formprodotto").submit(function () {


                                $.post("<?=BASE_URL;?>loadprodotto.php",$("#formprodotto").serialize(),
                                function(data) {

                                  //Se ci sono errori in fase di registrazione
                                  if(data.errore!='no'){

                                    //  $('#vererr').html('<span style="color:red;">Attenzione campo filtro spam errato. Devi inserire la somma dei due numeri indicati</span>').fadeIn(1000);


                                  }
                                  else {
                                    //                             $('#vererr').html('');
                                    $('#message').html('<span style="color:green;">Mail inviata correttamente. Le risponderemo nel pi&ugrave; breve tempo possibile. Grazie.</span>').fadeIn(1000);

                                    setTimeout(function(){$('#formcontatti').slideUp(); $("#formprodotto").find("input[type=text], textarea").val("");$('#message').html('');$('#nascprod').slideDown();},4000);
                                  }

                                },

                                "json"
                              );

                            }
                          );

                        });
                        </script>
