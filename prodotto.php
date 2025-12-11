<?php

include("inc_config.php");

//PRENDO I DATI DELLA CATEGORIA
$db->query("SELECT bag_prodotti.*,
            bag_prodotti.id AS id_prodotto,
            bag_scat.nome_".$lng." AS nome_scat,
            bag_scat.id AS id_scat,    
            bag_scat.id_categoria AS id_categoria,    
            bag_marche.nome_".$lng." AS nome_marca,
            bag_marche.immagine AS img_marca ,
            bag_marche.id  AS id_marca   
            FROM
            bag_prodotti,bag_scat,bag_marche
            WHERE bag_prodotti.id_sottocategoria=bag_scat.id
            AND bag_prodotti.id_marca=bag_marche.id
            AND bag_prodotti.id='".$_REQUEST['id_prodotto']."' 
          ");
$list = $db->single();

//CONTROLLO SE ESISTE
if ($db->rowCount() == 0) {
    
            header("HTTP/1.0 404 Not Found");
            header("Location: ".BASE_URL."404.php");
            
}else{

    if(isset($_REQUEST['seo']) AND seo_url($list['nome_'.$lng]) !=$_REQUEST['seo']){
        
           header("HTTP/1.0 404 Not Found");
           header("Location: ".BASE_URL."404.php");
                                                                        }
    }

    
$db->query("SELECT * FROM bag_categorie
            WHERE bag_categorie.id='".$list['id_categoria']."'
         ");
$listcat = $db->single();  

$categoria=$list['id_categoria'];  
$scat=$list['id_scat'];

    
$title_it=$title_en=ucfirst(strtolower($list['nome_'.$lng]))." | Sekurbox.com";

if($list['description_'.$lng]!=''){${"description_".$lng}=$list['description_'.$lng];} else{
$description_it="Acquista l'articolo ".$list['nome_'.$lng]." ad un prezzo imbattibile. Consulta tutte le offerte in  ".$list['nome_scat'].", e scopri altri prodotti";
$description_en="Buy ".$list['nome_'.$lng]." at best price. See all offers in  ".$list['nome_scat'].", and discover other products";
}

  //GESTIONE PREZZI IN FUNZIONE DEL TIPO UTENTE
if(isset($_SESSION['tipologia']) && $_SESSION['tipologia']=='installatore'){
 $text_prezzo=   '<span class="price" style="display:inline;margin-bottom:5px">&euro; '.number_format($list['prezzo'], 2, '.', '').'</span> &euro;';
 $text_prezzo.= number_format($list['prezzo']-($list['prezzo']/100*$list['sconto_installatore']), 2, '.', '');
}
elseif(isset($_SESSION['tipologia']) && $_SESSION['tipologia']=='rivenditore'){
 $text_prezzo=   '<span class="price" style="display:inline;margin-bottom:5px">&euro; '.number_format($list['prezzo'], 2, '.', '').'</span> &euro;';
 $text_prezzo.= number_format($list['prezzo']-($list['prezzo']/100*$list['sconto_rivenditore']), 2, '.', '');
}
else{
    $text_prezzo= "<span class='price' style='display:inline;margin-bottom:5px'>&euro; ".number_format($list['prezzo'], 2, '.', '')." </span>";
}


include("inc_header.php");
?>


</head>

<body>
 <div class="wrapper-area">
        
    <?php  
    include("inc_menu.php");  
    ?>
        <!-- Header Area End Here -->
        <!-- Inner Page Banner Area Start Here -->
        <div class="inner-page-banner-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcrumb-area">
                            <h1><?=ucfirst(strtolower($list['nome_'.$lng]))?></h1>
                            <ul>
                                <li><a href="<?=BASE_URL.$lng;?>/">Home</a> /</li>
                                <li><a href="<?=BASE_URL.$lng;?>/c_<?=$listcat['id'];?>/<?=seo_url($listcat['nome_'.$lng]);?>"><?=ucfirst(strtolower($listcat['nome_'.$lng]));?></a> /</li>
                                  <li><a href="<?=BASE_URL.$lng;?>/s_<?=$list['id_scat'];?>/<?=seo_url($list['nome_scat']);?>"><?=ucfirst(strtolower($list['nome_scat']));?></a> /</li>
                                <li><?=ucfirst(strtolower($list['nome_'.$lng]));?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Inner Page Banner Area End Here -->
        <!-- Shop Page Area Start Here -->
           <div class="product-details1-area">
            <div class="container">
                <div class="row">
                      <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 col-md-push-3">
                         <div class="inner-shop-details">
                            <div class="product-details-info-area">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="inner-product-details-left">
                                            <div class="tab-content">
                                                
                                        <?php 

                                       $db->query("SELECT bag_image.*
                                                   FROM bag_image
                                                   WHERE bag_image.id_prodotto='".$list['id']."'
                                                  ");
                                       $image = $db->resultset();
                                       $cont=0;
                                       foreach ($image as $listim) { 
                                        if (file_exists('./upload/prodotti/'.$listim['immagine'])) { $cont++;  ?> 
                                                
                                                <div class="tab-pane fade <?php if($cont==1) echo ' active in'; ?>" id="related<?=$cont;?>">
                                                    <a href="#" class="zoom ex1"><img alt="single" src="<?=$phpThumbBase;?>?src=upload/prodotti/<?=$listim['immagine'];?>&h=483&w=372&far=1&bg=ffffff" class="img-responsive"></a>
                                                </div>
                                       <?php } }?>         
                                                <div class="tab-pane fade" id="related2">
                                                    <a href="#" class="zoom ex1"><img alt="single" src="<?=BASE_URL;?>img/product/product-details1.jpg" class="img-responsive"></a>
                                                </div>
                                                <div class="tab-pane fade" id="related3">
                                                    <a href="#" class="zoom ex1"><img alt="single" src="<?=BASE_URL;?>img/product/product-details1.jpg" class="img-responsive"></a>
                                                </div>
                                            </div>
                                            <ul>
                                    <?php 

                                       $db->query("SELECT bag_image.*
                                                    FROM bag_image
                                                    WHERE bag_image.id_prodotto='".$list['id']."'
                                                   ");
                                       $image = $db->resultset();
                                       $cont=0;
                                    foreach ($image as $listim) { 
                                        
                                      if (file_exists('./upload/prodotti/'.$listim['immagine'])) { $cont++;  ?> 
                                                <li <?php if($cont==1) echo ' class="active"'; ?> >
                                                    <a href="#related<?=$cont;?>" data-toggle="tab" aria-expanded="false">
                                                    <img alt="related<?=$cont;?>" src="<?=$phpThumbBase;?>?src=upload/prodotti/<?=$listim['immagine'];?>&h=116&w=118&far=1&bg=ffffff" class="img-responsive"></a>
                                                </li>
                                    <?php } } ?>            
                                                
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="inner-product-details-right">
                                            <h3><?=ucfirst(strtolower($list['nome_'.$lng]));?></h3>
<!--                                            <ul>
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            </ul>-->
                                            <p style="margin-bottom:5px;">
                                                             <span style="display:inline"><b><?=$lang['marca'];?>:</b></span> 
                                                            <img class="<?=$list['id_marca'];?>" style="width:120px;" src="<?=BASE_URL;?>upload/marche/<?=$list['img_marca'];?>" /> 
                                                         </p>
                                                         <p style="margin:10px 0px 0px 0px">            
                                            <?php echo $text_prezzo; ?>
                                           </p>    
                                            <p style="margin:10px 0px 0px 0px">
                                               <?=ucfirst(strtolower(strip_tags($list['descrizione_'.$lng])));?>
                                            </p><br />
                                            <div class="product-details-content">
                                                <p><span><?=$lang['codice'];?>:</span> 0010</p>
                                                <p><span><?php if($list['quantita']>0) { ?>
                                                        <span style="color:green;display:inline"><?=$lang['disponibile'];?></span>
                                                        <?php } else{ ?>
                                                         <span style="color:red;display:inline"><?=$lang['non_disponibile'];?></span>
                                                        <?php } ?></span> </p>
                                                <p><span><?=$lang['categoria'];?>:</span> <?=ucfirst(strtolower($list['nome_scat']));?></p>
                                            </div>
                                            <form id="checkout-form">

                                                <ul class="inner-product-details-cart">
                                                    <li>
                                                        <div class="input-group quantity-holder" id="quantity-holder">
                                                            <input type="text" name='quantity' class="form-control quantity-input" id="modal_qty" value="1" placeholder="1">
                                                            <div class="input-group-btn-vertical">
                                                                <button class="btn btn-default quantity-plus" type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                                <button class="btn btn-default quantity-minus" type="button"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php if($list['quantita']>0) { ?>
                                                    <li><a href="javascript:void(null)" id="nel_carrello" for="<?=$list['id_prodotto'];?>"> <?=$lang['add_carrello'];?></a></li>
                                                    <?php } ?>
<!--                                                    <li><a href="#"><i aria-hidden="true" class="fa fa-heart-o"></i></a></li>
                                                    <li><a href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-eye" aria-hidden="true"></i></a></li>-->
                                                </ul>
                                            </form>
                                               <div class="alert alert-success  fade in" id="alert-<?=$list['id_prodotto'];?>" 
                                                style="display:none;margin-top:-20px;position: relative;z-index:2;padding: 6px;line-height: 20px;">
                                               <strong>Prodotto inserito nel carrello!</strong> 
                                               </div>
<!--                                            <ul class="product-details-social">
                                                <li>Share on:</li>
                                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                                <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                                <li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
                                            </ul>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-details-tab-area">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <ul>
                                            <li class="active"><a href="#description" data-toggle="tab" aria-expanded="false"><?= $lang['descrizione'];?></a></li>
                                            <li><a href="#review" data-toggle="tab" aria-expanded="false"><?= $lang['scheda_tecnica'];?></a></li>
<!--                                            <li><a href="#add-tags" data-toggle="tab" aria-expanded="false">ADD TAGS</a></li>-->
                                        </ul>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="tab-content">
                                            <div class="tab-pane fade active in" id="description">
                                                <p> <?=ucfirst(strtolower(strip_tags($list['descrizione_'.$lng])));?></p>
                                            </div>
                                            <div class="tab-pane fade" id="review">
                                                <p>
                                                    <?php  if($list['scheda_tecnica']!=''){ ?>
                                                         <a href="<?=BASE_URL;?>/upload/schede/<?=$list['scheda_tecnica'];?>" target="_blank" >
                                                            <img src="<?=BASE_URL;?>admin/images/filetype/pdf_32.png" style='width:50px;'/>  
                                                          </a>
                                                         <?php } ?>
                                                </p>
                                            </div>
<!--                                            <div class="tab-pane fade" id="add-tags">
                                                <p>Porem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam.</p>
                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="featured-products-area2">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <h2 class="title-carousel"><?=$lang['prodotti_correlati'];?></h2>
                                    </div>
                                </div>
                                <div class="metro-carousel" data-loop="true" data-items="3" data-margin="30" data-autoplay="true" data-autoplay-timeout="10000" data-smart-speed="2000" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="true" data-r-x-small-dots="false" data-r-x-medium="2" data-r-x-medium-nav="true" data-r-x-medium-dots="false" data-r-small="2" data-r-small-nav="true" data-r-small-dots="false" data-r-medium="3" data-r-medium-nav="true" data-r-medium-dots="false" data-r-large="3" data-r-large-nav="true" data-r-large-dots="false">
                                 <?php
                                 
                                 $db->query("SELECT bag_prodotti.*,
                                             bag_prodotti.id AS id_prodotto,
                                             bag_scat.nome_".$lng." AS nome_scat, 
                                             bag_marche.nome_".$lng." AS nome_marca,
                                             bag_marche.id  AS id_marca,    
                                             bag_marche.immagine AS img_marca    
                                             FROM
                                             bag_prodotti,bag_scat,bag_marche
                                             WHERE bag_prodotti.id_sottocategoria=bag_scat.id
                                             AND bag_prodotti.id_marca=bag_marche.id
                                             AND bag_scat.id_categoria='".$listcat['id']."'
                                             AND bag_prodotti.id != '".$list['id_prodotto']."' 
                                             ORDER by posizione
                                           ");
                                    $recordleft = $db->resultset();
                                foreach ($recordleft as $liste) { ?>
                                    
                                    
                                    <div class="product-box1">
                                        <ul class="product-social">
                                            <?php if($liste['quantita']>0) { ?>
                                            <li>
                                               <a href="javascript:void(null)" class='add_carrello' alert-id="<?=$liste['id_prodotto'];?>" for="<?=$liste['id_prodotto'];?>" title="<?=$lang['add_carrello'];?>">
                                                   <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                               </a>
                                            </li>
                                            <?php } ?>
<!--                                            <li><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a></li>-->
                                            <li><a href="<?=BASE_URL.$lng;?>/p_<?=$liste['id_prodotto'];?>/<?=seo_url($liste['nome_'.$lng]);?>">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a></li>
                                        </ul>
                                        <div class="product-img-holder">
                                            <a href="<?=BASE_URL.$lng;?>/p_<?=$liste['id_prodotto'];?>/<?=seo_url($liste['nome_'.$lng]);?>">
                                                <img src="<?=$phpThumbBase;?>?src=upload/prodotti/<?=$liste['immagine'];?>&h=334&w=272&far=1&bg=ffffff" alt="product"></a>
                                        </div>
                                        <div class="product-content-holder">
                                            <h3><a href="<?=BASE_URL.$lng;?>/p_<?=$liste['id_prodotto'];?>/<?=seo_url($liste['nome_'.$lng]);?>">
                                            <?=substr(ucfirst(strtolower($liste['nome_'.$lng])),0,50);?>..</a>
                                            </h3>
                                             <span>
                                             <?php if(isset($_SESSION['tipologia']) && $_SESSION['tipologia']=='installatore'){ ?>
                                             <span>&euro; <?=number_format($liste['prezzo'], 2, '.', '');?></span> &euro;
                                             <?php     
                                             echo number_format($liste['prezzo']-($liste['prezzo']/100*$liste['sconto']), 2, '.', ''); 
                                             }
                                             else{ echo "&euro; ".number_format($liste['prezzo'], 2, '.', ''); } ?></span>
                                         </div>
                                          <div class="alert alert-success  fade in alert-<?=$liste['id_prodotto'];?>" 
                                           style="display:none;margin-top:-20px;position: relative;z-index:2;padding: 6px;line-height: 20px;">
                                           <strong>Prodotto inserito nel carrello!</strong> 
                                        </div>
                                    </div>
                                <?php } ?>    
                                  
                                </div>
                            </div>
                        </div>
          
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 col-md-pull-9">
                        <div class="sidebar hidden-before-tab">
                            <div class="category-menu-area sidebar-section-margin" id="category-menu-area">
          
                            <h2 class="title-sidebar"><?=$lang['categorie_tutte'];?></h2>
                           
                  
                            <ul>
                                
                              <?php
                                                        
                                 $db->query("SELECT *
                                             FROM
                                             bag_categorie
                                             ORDER BY posizione 
                                            ");

                                 $resultc =  $db->resultSet();
                                 foreach ($resultc as $listc) {
                                     
                                        $db->query("SELECT *
                                                    FROM
                                                    bag_scat
                                                    WHERE id_categoria='".$listc['id']."'
                                                    ORDER BY posizione 
                                                   ");

                                        $resultsc =  $db->resultSet();            
                              ?>      
                                
                                <li>
                                          
                                          <a href="<?=BASE_URL.$lng;?>/c_<?=$listc['id'];?>/<?=seo_url($listc['nome_'.$lng]);?>" 
                                             <?php if(isset($categoria)  AND $categoria==$listc['id']){ echo ' style="color:#009392 !important;" '; } ?>  >
                                              <i class="fa  fa-<?=$listc['font_awesome_code'];?>" style='line-height: 12px;'></i> <?=ucfirst(strtolower($listc['nome_'.$lng]));?>
                                             <?php if($db->rowCount($resultsc) >0){ ?>
                                              <span><i class="flaticon-next"></i></span>   
                                            <?php } ?>
                                          </a>
                                              <ul class="dropdown-menu">
                                                <?php    
                                                 foreach ($resultsc as $listsc) { ?>
                                                      <li><a <?php if(isset($scat)  AND $scat==$listsc['id']){ echo ' style="color:#009392 !important;" '; } ?>href="<?=BASE_URL.$lng;?>/s_<?=$listsc['id'];?>/<?=seo_url($listsc['nome_'.$lng]);?>"><?=ucfirst(strtolower($listsc['nome_'.$lng]));?></a></li>
                                                 <?php } ?>     
                                              </ul>
   
                                        </li>
                                        <?php } ?>  
                            </ul>
                        </div>
                
                            <h2 class="title-sidebar"><?=$lang['offerte'];?></h2>
                            <div class="best-products sidebar-section-margin">
                                
                            <?php 

                            $db->query("SELECT bag_prodotti.*,
                                        bag_prodotti.id AS id_prodotto,
                                        bag_scat.nome_".$lng." AS nome_scat, 
                                        bag_marche.nome_".$lng." AS nome_marca,
                                        bag_marche.immagine AS img_marca    
                                        FROM
                                        bag_prodotti,bag_scat,bag_marche
                                        WHERE bag_prodotti.id_sottocategoria=bag_scat.id
                                        AND bag_prodotti.id_marca=bag_marche.id
                                        AND bag_prodotti.offerta='s'
                                        ORDER by RAND()
                                        LIMIT 0,4
                                       ");
                            $recordleft = $db->resultset();
                            foreach ($recordleft as $list) { ?>
                                
                                
                                <div class="media">
                                    <a href="<?=BASE_URL.$lng;?>/p_<?=$list['id_prodotto'];?>/<?=seo_url($list['nome_'.$lng]);?>" class="pull-left">
                                        <img alt="<?=$list['nome_'.$lng];?>" src="<?=$phpThumbBase;?>?src=upload/prodotti/<?=$list['immagine'];?>&h=107&w=107&far=1&bg=ffffff" class="img-responsive">
                                    </a>
                                    <div class="media-body" >
                                        <h3 class="media-heading"><a href="<?=BASE_URL.$lng;?>/p_<?=$list['id_prodotto'];?>/<?=seo_url($list['nome_'.$lng]);?>"><?=substr(ucfirst(strtolower($list['nome_'.$lng])),0,30);?>..</a></h3>
                                        <p>
                                            <?php if(isset($_SESSION['tipologia']) && $_SESSION['tipologia']=='installatore'){ ?>
                                                <span>&euro; <?=number_format($list['prezzo'], 2, '.', '');?></span> &euro;
                                            <?php     
                                            echo number_format($list['prezzo']-($list['prezzo']/100*$list['sconto']), 2, '.', ''); }
                                            else{ echo "&euro; ".number_format($list['prezzo'], 2, '.', ''); } ?>
                                        </p>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>
                            <br /><br />
                            <h2 class="title-sidebar"><?=$lang['ultarrivi'];?></h2>
                            <div class="best-products sidebar-section-margin">
                                
                            <?php 

                            $db->query("SELECT bag_prodotti.*,
                                        bag_prodotti.id AS id_prodotto,
                                        bag_scat.nome_".$lng." AS nome_scat, 
                                        bag_marche.nome_".$lng." AS nome_marca,
                                        bag_marche.immagine AS img_marca    
                                        FROM
                                        bag_prodotti,bag_scat,bag_marche
                                        WHERE bag_prodotti.id_sottocategoria=bag_scat.id
                                        AND bag_prodotti.id_marca=bag_marche.id
                                        AND bag_prodotti.ultimo_arrivo='s'
                                        ORDER by RAND()
                                        LIMIT 0,4
                                       ");
                            $recordleft = $db->resultset();
                            foreach ($recordleft as $list) { ?>
                                
                                
                                <div class="media">
                                    <a href="<?=BASE_URL.$lng;?>/p_<?=$list['id_prodotto'];?>/<?=seo_url($list['nome_'.$lng]);?>" class="pull-left">
                                        <img alt="<?=$list['nome_'.$lng];?>" src="<?=$phpThumbBase;?>?src=upload/prodotti/<?=$list['immagine'];?>&h=107&w=107&far=1&bg=ffffff" class="img-responsive">
                                    </a>
                                    <div class="media-body">
                                        <h3 class="media-heading"><a href="<?=BASE_URL.$lng;?>/p_<?=$list['id_prodotto'];?>/<?=seo_url($list['nome_'.$lng]);?>"><?=substr(ucfirst(strtolower($list['nome_'.$lng])),0,30);?>..</a></h3>
                                        <p>
                                            <?php if(isset($_SESSION['tipologia']) && $_SESSION['tipologia']=='installatore'){ ?>
                                                <span>&euro; <?=number_format($list['prezzo'], 2, '.', '');?></span> &euro;
                                            <?php     
                                            echo number_format($list['prezzo']-($list['prezzo']/100*$list['sconto']), 2, '.', ''); }
                                            else{ echo "&euro; ".number_format($list['prezzo'], 2, '.', ''); } ?>
                                        </p>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>

                          </div>
                    </div>
                   
                </div>
            </div>
        </div>
        <!-- Shop Page Area End Here -->
 <?php  
    include("inc_footer.php");  
     ?>    
    <!-- jquery-->
<!--    <script src="js/vendor/jquery-2.2.4.min.js" type="text/javascript"></script>-->
    <!-- Bootstrap js -->
      <script src="<?=BASE_URL;?>js/select2.min.js" type="text/javascript"></script>
    <script src="<?=BASE_URL;?>js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Owl Cauosel JS -->
    <script src="<?=BASE_URL;?>js/owl.carousel.min.js" type="text/javascript"></script>
    <!-- Meanmenu Js -->
    <script src="<?=BASE_URL;?>js/jquery.meanmenu.min.js" type="text/javascript"></script>
    <!-- WOW JS -->
    <script src="<?=BASE_URL;?>js/wow.min.js" type="text/javascript"></script>
    <!-- Plugins js -->
    <script src="<?=BASE_URL;?>js/plugins.js" type="text/javascript"></script>
    <!-- Countdown js -->
    <script src="<?=BASE_URL;?>js/jquery.countdown.min.js" type="text/javascript"></script>
    <!-- Srollup js -->
    <script src="<?=BASE_URL;?>js/jquery.scrollUp.min.js" type="text/javascript"></script>
    <!-- Actual Js -->
    <script src="<?=BASE_URL;?>js/jquery.actual.min.js" type="text/javascript"></script>
    <!-- Nouislider Js -->
    <script src="<?=BASE_URL;?>vendor/noUiSlider/nouislider.min.js" type="text/javascript"></script>
    <!-- wNumb Js -->
    <script src="<?=BASE_URL;?>js/wNumb.js" type="text/javascript"></script>
    <!-- Custom Js -->
    <script src="<?=BASE_URL;?>js/main.js" type="text/javascript"></script>
    

    
</body>

</html>


