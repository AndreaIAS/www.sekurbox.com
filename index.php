<?php
include("inc_config.php");

$title_it="Sekurbox.com: ip controller, domotica, sicurezza, TVCC e tanto altro.";
$description_it="Azienda specializzata nella vendita di prodotti per domotica, automazione, sicurezza, TVCC. Offerte vantaggiose e prezzi bassi.";

$title_en="Sekurbox.com: ip controller,domotic,security,TVCC and more other.";
$description_en="Specialized company in the sale of products for home automation, automation, security,TVCC. Advantageous offers and low prices.";

include("inc_header.php");

?>
<?php if(isset($_REQUEST['offset'])){ ?>
<link rel="canonical" href="https://www.sekurbox.com/">
<?php } ?>
<style>
/*    .alert {
	  position: fixed;
  top: 50%;
  left: 50%;
    z-index:1;
}
    */
</style>
</head>

<body>
    

 <div class="wrapper-area">
        
    <?php  
    
    include("inc_menu.php");  
    include("inc_slider.php");
    
    ?>
        
     <!-- Services1 Area Start Here -->
        <div class="services1-area">
            <div class="container">
                <div class="row">
                    
                    
                    <?php 
                    $cont_prod=0;
                            $db->query("SELECT bag_prodotti.*,
                                        bag_prodotti.id AS id_prodotto,
                                        bag_scat.nome_".$lng." AS nome_scat, 
                                        bag_marche.nome_".$lng." AS nome_marca,
                                        bag_marche.immagine AS img_marca    
                                        FROM
                                        bag_prodotti,bag_scat,bag_marche
                                        WHERE bag_prodotti.id_sottocategoria=bag_scat.id
                                        AND bag_prodotti.id_marca=bag_marche.id
                                        ORDER by bag_prodotti.posizione
                                        LIMIT 0,3
                                       ");
                           $recordleft = $db->resultset();
                           foreach ($recordleft as $list) { $cont_prod++; ?>
                    
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                       
                        <div class="services-area-box" style="cursor:pointer;" onclick="location.href='<?=BASE_URL.$lng;?>/p_<?=$list['id_prodotto'];?>/<?=seo_url($list['nome_'.$lng]);?>'; ">
                         
                            <div class="media">
                                <a class="pull-left" href="#" style="padding-right: 32px;">
                                 <img src="<?=$phpThumbBase;?>?src=upload/prodotti/<?=$list['immagine'];?>" style="width:118px;" alt="services" class="img-responsive img_din"> 
                                </a>
                                <div class="media-body">
                                    <div style="height:45px;" class="media-body-title"> <?=$list['nome_'.$lng];?></div>
                                    <h3 style="height:45px;"><img style="width:120px;" src="<?=BASE_URL;?>upload/marche/<?=$list['img_marca'];?>" /> </h3>
                                    <p style="height:35px;font-size: 14px;"><i>#<?=$list['nome_scat'];?></i></p>
<!--                                <a href="#" class="btn-shop-now"><?=$lang['acquista'];?><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>-->
                                </div>
                            </div>
                          
                        </div>
                            
                    </div>
                    
                           <?php } ?>
                    
                </div>
            </div>
        </div>
        <!-- Services1 Area End Here -->
        <!-- Product Area Start Here -->
        <div class="product-area">
            <div class="container" id="home-isotope">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="isotop-classes-tab myisotop1">
                           
                            <a href="#" data-filter=".offerte" class="current"><?=$lang['offerte'];?></a>
                             <a href="#" data-filter=".ultimi-arrivi" ><?=$lang['ultarrivi'];?></a>
                            <a href="#" data-filter=".piu-venduti"><?=$lang['piuvenduti'];?></a>
                        </div>
                    </div>
                </div>
                <div class="row featuredContainer">
                    
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
                        foreach ($recordleft as $list) { $cont_prod++; 
                        
                        //GESTIONE PREZZI IN FUNZIONE DEL TIPO UTENTE
                                if(isset($_SESSION['tipologia']) && $_SESSION['tipologia']=='installatore'){
                                 $text_prezzo=   '<span><span >&euro; '.number_format($list['prezzo'], 2, '.', '').'</span> &euro;';
                                 $text_prezzo.= number_format($list['prezzo']-($list['prezzo']/100*$list['sconto_installatore']), 2, '.', '')."</span>";
                                }
                                elseif(isset($_SESSION['tipologia']) && $_SESSION['tipologia']=='rivenditore'){
                                 $text_prezzo=   '<span><span >&euro; '.number_format($list['prezzo'], 2, '.', '').'</span> &euro;';
                                 $text_prezzo.= number_format($list['prezzo']-($list['prezzo']/100*$list['sconto_rivenditore']), 2, '.', '');
                                }
                                else{
                                    $text_prezzo= "<span class='price' style='display:inline;'>&euro; ".number_format($list['prezzo'], 2, '.', '')." </span></span>";
                                }
                                
                        ?>
                    
                    
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 offerte">
                        <div class="product-box1">
                            <ul class="product-social">
                                <?php if($list['quantita']>0) { ?>
                                <li><a href="javascript:void(null)" class='add_carrello' alert-id="<?=$cont_prod;?>" for="<?=$list['id_prodotto'];?>" title="<?=$lang['add_carrello'];?>">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i></a></li>
                                <?php } ?>         
<!--                                <li><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a></li>-->
                                <li><a href="javascript:void(null)" title="<?=$lang['dettagli'];?>" data-toggle="modal" data-target="#myModal"  data-id="<?= $list['id_prodotto']; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                            </ul>
                            <div class="product-img-holder">
                                <a href="#"><img src="<?=$phpThumbBase;?>?src=upload/prodotti/<?=$list['immagine'];?>&h=334&w=272&far=1&bg=ffffff" alt="<?=$list['nome_'.$lng];?>"></a>
                            </div>
                            <div class="alert alert-success  fade in alert-<?=$cont_prod;?>" 
                               style="display:none;margin-top:-20px;position: relative;z-index:2;padding: 6px;line-height: 20px;">
                               <strong>Prodotto inserito nel carrello!</strong> 
                            </div>
                            <div class="product-content-holder">
                                <h3><a href="javascript:void(null)"><?=substr(ucfirst(strtolower($list['nome_'.$lng])),0,50);?>..</a></h3>
                               
                              <?php echo $text_prezzo; ?>
                               
                            </div>
                        </div>

                    </div>

                        <?php } 

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
                        foreach ($recordleft as $list) { $cont_prod++; 
                        
                       //GESTIONE PREZZI IN FUNZIONE DEL TIPO UTENTE
                                if(isset($_SESSION['tipologia']) && $_SESSION['tipologia']=='installatore'){
                                 $text_prezzo=   '<span><span >&euro; '.number_format($list['prezzo'], 2, '.', '').'</span> &euro;';
                                 $text_prezzo.= number_format($list['prezzo']-($list['prezzo']/100*$list['sconto_installatore']), 2, '.', '')."</span>";
                                }
                                elseif(isset($_SESSION['tipologia']) && $_SESSION['tipologia']=='rivenditore'){
                                 $text_prezzo=   '<span><span >&euro; '.number_format($list['prezzo'], 2, '.', '').'</span> &euro;';
                                 $text_prezzo.= number_format($list['prezzo']-($list['prezzo']/100*$list['sconto_rivenditore']), 2, '.', '');
                                }
                                else{
                                    $text_prezzo= "<span class='price' style='display:inline;'>&euro; ".number_format($list['prezzo'], 2, '.', '')." </span></span>";
                                }
                                
                        ?>
                    
                    
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 ultimi-arrivi">
                        <div class="product-box1">
                            <ul class="product-social">
                                <?php if($list['quantita']>0) { ?>
                                <li><a href="javascript:void(null)" class='add_carrello' alert-id="<?=$cont_prod;?>" for="<?=$list['id_prodotto'];?>" title="<?=$lang['add_carrello'];?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></li>
                                <?php } ?>    <!--   <li><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a></li>-->
                                <li><a href="javascript:void(null)" title="<?=$lang['dettagli'];?>" data-toggle="modal" data-target="#myModal"  data-id="<?= $list['id_prodotto']; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                            </ul>
                            <div class="product-img-holder">
                                <a href="javascript:void(null)"><img src="<?=$phpThumbBase;?>?src=upload/prodotti/<?=$list['immagine'];?>&h=334&w=272&far=1&bg=ffffff" alt="product"></a>
                            </div>
                             <div class="alert alert-success  fade in alert-<?=$cont_prod;?>" id="" 
                               style="display:none;margin-top:-20px;position: relative;z-index:2;padding: 6px;line-height: 20px;">
                               <strong>Prodotto inserito nel carrello!</strong> 
                            </div>
                            <div class="product-content-holder">
                                <h3><a href="javascript:void(null)"><?=substr(ucfirst(strtolower($list['nome_'.$lng])),0,50);?>..</a></h3>
                                <?php echo $text_prezzo; ?>
                            </div>
                        </div>
                    </div>

                        <?php }
                    
           
                            $db->query("SELECT bag_prodotti.*,
                                        bag_prodotti.id AS id_prodotto,
                                        bag_scat.nome_".$lng." AS nome_scat, 
                                        bag_marche.nome_".$lng." AS nome_marca,
                                        bag_marche.immagine AS img_marca    
                                        FROM
                                        bag_prodotti,bag_scat,bag_marche
                                        WHERE bag_prodotti.id_sottocategoria=bag_scat.id
                                        AND bag_prodotti.id_marca=bag_marche.id
                                        AND bag_prodotti.piu_venduto='s'
                                        ORDER by RAND()
                                        LIMIT 0,4
                                       ");
                           $recordleft = $db->resultset();
                        foreach ($recordleft as $list) { $cont_prod++; 
                        
                           //GESTIONE PREZZI IN FUNZIONE DEL TIPO UTENTE
                                if(isset($_SESSION['tipologia']) && $_SESSION['tipologia']=='installatore'){
                                 $text_prezzo=   '<span><span >&euro; '.number_format($list['prezzo'], 2, '.', '').'</span> &euro;';
                                 $text_prezzo.= number_format($list['prezzo']-($list['prezzo']/100*$list['sconto_installatore']), 2, '.', '')."</span>";
                                }
                                elseif(isset($_SESSION['tipologia']) && $_SESSION['tipologia']=='rivenditore'){
                                 $text_prezzo=   '<span><span >&euro; '.number_format($list['prezzo'], 2, '.', '').'</span> &euro;';
                                 $text_prezzo.= number_format($list['prezzo']-($list['prezzo']/100*$list['sconto_rivenditore']), 2, '.', '');
                                }
                                else{
                                    $text_prezzo= "<span class='price' style='display:inline;'>&euro; ".number_format($list['prezzo'], 2, '.', '')." </span></span>";
                                }
                                
                        ?>
                    
                    
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 piu-venduti">
                        <div class="product-box1">
                            <ul class="product-social">
                                <?php if($list['quantita']>0) { ?>
                                <li>
                                    <a href="javascript:void(null)" class='add_carrello' alert-id="<?=$cont_prod;?>" for="<?=$list['id_prodotto'];?>" title="<?=$lang['add_carrello'];?>">
                                        <i class="fa fa-shopping-cart" aria-hidden="true" ></i>
                                    </a>
                                </li>
                                <?php } ?>
<!--                                <li><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a></li>-->
                                <li><a href="javascript:void(null)" title="<?=$lang['dettagli'];?>" data-toggle="modal" data-target="#myModal"  data-id="<?= $list['id_prodotto']; ?>">
                                        <i class="fa fa-eye" aria-hidden="true"></i></a></li>
                            </ul>
                            <div class="product-img-holder">
                                <a href="javascript:void(null)"><img src="<?=$phpThumbBase;?>?src=upload/prodotti/<?=$list['immagine'];?>&h=334&w=272&far=1&bg=ffffff" alt="<?=ucfirst(strtolower($list['nome_'.$lng]));?>"></a>
                            </div>
                             <div class="alert alert-success  fade in alert-<?=$cont_prod;?>"
                               style="display:none;margin-top:-20px;position: relative;z-index:2;padding: 6px;line-height: 20px;">
                               <strong>Prodotto inserito nel carrello!</strong> 
                            </div>
                            <div class="product-content-holder">
                                <h3><a href="javascript:void(null)"><?=substr(ucfirst(strtolower($list['nome_'.$lng])),0,50);?>..</a></h3>
                                <?php echo $text_prezzo; ?>
                            </div>
                        </div>
                    </div>

                        <?php } ?>
       
                </div>
            </div>
        </div>
        <!-- Product Area End Here -->
        <!-- Offer Area 1 Start Here -->
<!--        <div class="offer-area1 hidden-after-desk">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="brand-area-box-l">
                            <span>Winter Collections</span>
                            <h1>50% Off</h1>
                            <p>Sale Going On</p>
                            <a href="#" class="btn-shop-now-fill">Shop Now</a>
                        </div>
                    </div>
                    <div id="countdown"></div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="brand-area-box-r">
                            <a href="#"><img src="img/offer.png" alt="offer"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
        <!-- Offer Area 1 End Here -->
        <!-- Best Seller Area Start Here -->
        <div class="best-seller-area padding-top-0-after-desk">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h2 class="title-carousel"><?=$lang['altri_prodotti'];?></h2>
                    </div>
                </div>
                <div class="metro-carousel" data-loop="true" data-items="3" data-margin="15" data-autoplay="false" data-autoplay-timeout="10000" data-smart-speed="2000" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="true" data-r-x-small-dots="false" data-r-x-medium="2" data-r-x-medium-nav="true" data-r-x-medium-dots="false" data-r-small="2" data-r-small-nav="true" data-r-small-dots="false" data-r-medium="2" data-r-medium-nav="true" data-r-medium-dots="false" data-r-large="3" data-r-large-nav="true" data-r-large-dots="false">
                    <div class="best-seller-box">
 
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
                                        ORDER by RAND()
                                        
                                       ");
                           $recordleft = $db->resultset();
                           $tot_prod=$db->rowCount($recordleft);
                         
                           $cont=0;
                        foreach ($recordleft as $list) { $cont++;  $cont_prod++; 
                           
                               //GESTIONE PREZZI IN FUNZIONE DEL TIPO UTENTE
                                if(isset($_SESSION['tipologia']) && $_SESSION['tipologia']=='installatore'){
                                 $text_prezzo=   '<span><span >&euro; '.number_format($list['prezzo'], 2, '.', '').'</span> &euro;';
                                 $text_prezzo.= number_format($list['prezzo']-($list['prezzo']/100*$list['sconto_installatore']), 2, '.', '')."</span>";
                                }
                                elseif(isset($_SESSION['tipologia']) && $_SESSION['tipologia']=='rivenditore'){
                                 $text_prezzo=   '<span><span >&euro; '.number_format($list['prezzo'], 2, '.', '').'</span> &euro;';
                                 $text_prezzo.= number_format($list['prezzo']-($list['prezzo']/100*$list['sconto_rivenditore']), 2, '.', '');
                                }
                                else{
                                    $text_prezzo= "<span class='price' style='display:inline;'>&euro; ".number_format($list['prezzo'], 2, '.', '')." </span></span>";
                                }
                                
                        ?>
                        
                        <div class="media">
                            <a href="javascript:void(null)" class="pull-left">
                                <img alt="<?=ucfirst(strtolower($list['nome_'.$lng]));?>" src="<?=$phpThumbBase;?>?src=upload/prodotti/<?=$list['immagine'];?>&h=134&w=146&far=1&bg=ffffff" class="img-responsive">
                            </a>
                            <div class="media-body">
                                <div class="best-seller-box-content">
                                    <h3><a href="javascript:void(null)"><?=ucfirst(strtolower($list['nome_'.$lng]));?></a></h3>
                                  <?php echo $text_prezzo; ?>
                               
                                </div>
                                <ul class="best-seller-box-cart">
                                    <?php if($list['quantita']>0) { ?>
                                    <li><a href="javascript:void(null)" class="add_carrello"  alert-id="<?=$cont_prod;?>" for="<?=$list['id_prodotto'];?>" title="<?=$lang['add_carrello'];?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></li>
                                    <?php } ?>
<!--                                    <li><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a></li>-->
                                    <li><a href="javascript:void(null)"  title="<?=$lang['dettagli'];?>" data-toggle="modal" data-target="#myModal"  data-id="<?= $list['id_prodotto']; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                                </ul>
                            <div class="alert alert-success  fade in alert-<?=$cont_prod;?>" 
                               style="display:none;margin-top:4px;position: relative;z-index:2;padding: 6px;line-height: 20px;">
                               <strong>Prodotto inserito nel carrello!</strong> 
                            </div>
                            </div>
                              
                        </div>
                       
                        <?php
                        
                         if($tot_prod == $cont){ echo "</div>";}
                        elseif(($cont % 3) == 0 && $tot_prod != $cont){ echo "</div><div class='best-seller-box'>";}
                        
                                      } 
                       
                        
                        ?>
           
           
                 
                </div>
            </div>
        </div>
        <!-- Best Seller Area End Here -->
        <!-- Advantage Area Start Here -->
        <div class="advantage1-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="advantage-area-box">
                            <div class="media">
                                <a class="pull-left" href="#">
                                    <i class="flaticon-truck"></i>
                                </a>
                                <div class="media-body">
                                    <h3>FREE SHIPPING</h3>
                                    <p>On All Orders</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="advantage-area-box">
                            <div class="media">
                                <a class="pull-left" href="#">
                                    <i class="flaticon-headphones"></i>
                                </a>
                                <div class="media-body">
                                    <h3>24/7 SERVICE</h3>
                                    <p>Get Help When You Need</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="advantage-area-box">
                            <div class="media">
                                <a class="pull-left" href="#">
                                    <i class="flaticon-reload"></i>
                                </a>
                                <div class="media-body">
                                    <h3>100% MONEY BACK</h3>
                                    <p>Within 30 Day Guarantee</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Advantage Area End Here -->    
        
        
            
    <?php  
    include("inc_footer.php");  
     ?>    
        

 </div>
    
    <!-- Modal Dialog Box Start Here-->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-body">
        <div class="fetched-data"></div> 
            </div>
            <div class="modal-footer">
                <a href="#" class="btn-services-shop-now" data-dismiss="modal"><?=$lang['chiudi'];?></a>
            </div>
        </div>
    </div>
    <!-- Modal Dialog Box End Here-->
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->

    <!-- Bootstrap js -->
    <script src="<?=BASE_URL;?>js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Owl Cauosel JS -->
    <script src="<?=BASE_URL;?>js/owl.carousel.min.js" type="text/javascript"></script>
    <!-- Nivo slider js -->
    <script src="<?=BASE_URL;?>lib/custom-slider/js/jquery.nivo.slider.js" type="text/javascript"></script>
    <script src="<?=BASE_URL;?>lib/custom-slider/home.js" type="text/javascript"></script>
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
    <!-- Isotope js -->
    <script src="<?=BASE_URL;?>js/isotope.pkgd.min.js" type="text/javascript"></script>
    <!-- Custom Js -->

    <script src="<?=BASE_URL;?>js/main.js" type="text/javascript"></script>
    

    <?php include("script_condivisi.php"); ?>
    
   
</body>

</html>
