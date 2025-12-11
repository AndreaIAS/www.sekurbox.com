
<div id="chart_mobile_visible" >
<a href="<?=BASE_URL;?>carts" rel="nofollow" style="position: fixed;top:16px;left:70%;z-index:99999">                                            
<i class="fa fa-shopping-cart" style="color: #727272;font-size: 30px;" aria-hidden="true"></i>
<span> (<?=$cart->itemcount;?>)</span>
</a>
</div>


<header>
    
 <?php
    $arr_url=explode("/",$_SERVER['REQUEST_URI']);
    $pezzi=count($arr_url);

 ?>

    <div 
        
    <?php 
        if($arr_url[$pezzi-1]=='index.php' OR $arr_url[$pezzi-1]==''){ echo ' class="header-area-style1" '; }
        else { echo ' class="header-area-style3" '; }
      
    ?> 
     
     id="sticker">
        <div class="header-top">
            <div class="header-top-inner-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <div class="header-contact">
                                <ul>
<!--                                    <li><i class="fa fa-phone" aria-hidden="true"></i><a href="+1234567890"> + 123 456 7890</a></li>-->
                                    <li><i class="fa fa-envelope" aria-hidden="true"></i><a href="mailto:info@sekurbox.com"> info@sekurbox.com</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="account-wishlist">
                                <ul>
                                  <?php if(!isset($_SESSION['user_site'])) { ?>    
                                              <li><a href="<?=BASE_URL;?>registrati.php"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp; Login</a></li>
                                              <li><a href="<?=BASE_URL;?>registrati.php"><i class="fa fa-user" aria-hidden="true"></i> &nbsp;<?=$lang['registrazione'];?></a></li>
                                  <?php } else { ?> 
                                              <li><a href="<?=BASE_URL;?>registrati.php"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;<?=$_SESSION['nome'];?></a></li>
                                   <?php } ?>      

                                    
                                    <?php if($lng=='it') { ?>                 
                                        <li> 
                                         <a id="it_lang" class="tooltip_new" style="cursor:pointer" href="<?=BASE_URL;?>en/">
                                          <img  src="<?=BASE_URL;?>img/united-kingdom.png" style="margin-top:-1px;cursor:pointer;" />&nbsp;ENGLISH
                                         </a> 
                                        <div id="data_it_lang" style="display:none;">CLICK TO CHANGE LANGUAGE TO ENGLISH</div>   
                                        </li>
                                     <?php } if($lng=='en') { ?>
                                         <li> 
                                             <a id="it_eng" class="tooltip_new"  style="cursor:pointer"  href="<?=BASE_URL;?>it/">
                                                 <img   src="<?=BASE_URL;?>img/italy.png" style="margin-top:-1px;cursor:pointer;" />&nbsp;ITALIANO</a> 
                                          <div id="data_it_eng" style="display:none;">CLICCA PER IL SITO IN ITALIANO</div>  
                                         </li>
                                    <?php } ?>
<!--                                    <li><a href="wishlist.html"><i class="fa fa-heart-o" aria-hidden="true"></i> Wishlist</a></li>
                                    <li><a href="#"><i class="fa fa-usd" aria-hidden="true"></i> USD</a></li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-top-inner-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="logo-area">
                                <a href="<?=BASE_URL;?><?=$lng;?>/"><img class="img-responsive" src="<?=BASE_URL;?>img/logo1.png" alt="logo"></a>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                            <div class="search-area">
                                <form name="ricerca" method="POST" action="<?=BASE_URL.$lng;?>/elenco-prodotti" >
                                <div class="input-group" id="adv-search">
                                    <input type="text" class="form-control" name="testo_ricerca" id="input_top_ricerca" placeholder="<?=$lang['cerca'];?>" />
                                    <input type="hidden" value="" name="id_categoria_search" id="id_categoria_search" />
                                    <div class="input-group-btn">
                                        <div class="btn-group" role="group">
                                            <div class="dropdown dropdown-lg">
                                                <button type="button" class="btn btn-metro dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span><?=$lang['categorie_tutte'];?></span>
                                                    <i class="fa fa-caret-up" aria-hidden="true"></i>
                                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                                    <ul class="sidenav-nav">
                                                        <?php          
                                                             $db->query("SELECT *
                                                                         FROM
                                                                         bag_categorie
                                                                         ORDER BY posizione
                                                                        ");

                                                             $resultc =  $db->resultSet();
                                                             foreach ($resultc as $listc) {
                                                        ?>      
                                                           <li>
                                                               <a style="display: inherit;padding: 5px 5px;" 
                                                                onclick="$('#id_categoria_search').val('<?=$listc['id'];?>');" href="javascript:void(null);">
                                                                    <i class="fa  fa-<?=$listc['font_awesome_code'];?>"></i> <?=$listc['nome_'.$lng];?>
                                                               </a>
                                                           </li>
                                                        
                                                        <?php } ?>
                                                           

                                                    </ul>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-metro-search"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                       
                                        </div>
                                    </div>
                                    
                                </div>
                                </form>     
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <ul class="header-cart-area">
                                <li>
                                    <div class="cart-area">
                                        <a href="javascript:void(null)"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                            <span>
                                                <?=$cart->itemcount;?>
                                            </span>
                                        </a>
                                        <ul>
                                             <?php   
                                             
                                             $totalecarr=0;
                                                foreach($cart->get_contents() as $item) { 
                                                
                                                 //PRENDO IL TOTALE CARELLO
                                                 $totalecarr=$totalecarr+($item['subtotal']); 
     
                                                 ?>
                                            <li id="cart_list_<?=$item['id'];?>">
                                                <div class="cart-single-product">
                                                    <div class="media">
                                                        <div class="pull-left cart-product-img">
                                                            <a href="<?=BASE_URL;?>p_<?=$item['id'];?>/<?=seo_url($item['info']['nome']);?>">
                                                                 <?php if(trim($item['info']['image'])=='Invalid file type.') $immagine="noimage.jpg" ; else $immagine=$item['info']['image']; ?>
                                                                <img class="img-responsive" alt="product" src="<?=$phpThumbBase;?>?src=upload/prodotti/<?=$immagine;?>&h=134&w=146&far=1&bg=ffffff">
                                                            </a>
                                                        </div>
                                                        <div class="media-body cart-content">
                                                            <ul>
                                                                <li>
                                                                    <h2><a href="#"><?=$item['info']['nome'];?></a></h2>
                                                                    <h3><span><?=$lang['codice'];?>:</span> <?=$item['info']['codice'];?></h3>
                                                                </li>
                                                                <li>
                                                                    <p>X <?=$item['qty'];?></p>
                                                                </li>
                                                                <li>
                                                                    <p><?=number_format($item['subtotal'],2,',','.');?> &euro;</p>
                                                                </li>
                                                                <li>
                                                                    <a class="trash prod_trash" href="javascript:void(null)" for="<?=$item['id'];?>" title="<?=$lang['del_from_cart'];?>">
                                                                        <i class="fa fa-trash-o"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                             <?php } ?>
                                         
                                            <li>
                                                <span><span> <?=$lang['imponibile'];?></span></span><span><?=number_format($totalecarr,2,',','.');?> &euro;</span>
<!--                                                <span><span>Discount</span></span><span>$30</span>-->
                                                <span><span><?=$lang['iva'];?></span></span><span><?=number_format(($totalecarr/100)*22,2,',','.');?> &euro;</span>
                                                <span><span><?=$lang['totale'];?></span></span><span><?=number_format((($totalecarr/100)*22)+$totalecarr,2,',','.');?> &euro;</span>
                                            </li>
                                            <li>
                                                 <ul class="checkout">
                                                    <li><a href="<?=BASE_URL;?>carts" class="btn-checkout" rel="nofollow"><i class="fa fa-shopping-cart" aria-hidden="true"></i><?=$lang['carrello'];?></a></li>
                                                    <li><a href="<?=BASE_URL;?>carrello1.php" class="btn-checkout" rel="nofollow"><i class="fa fa-share" aria-hidden="true"></i><?=$lang['cassa'];?></a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="additional-menu-area" id="additional-menu-area">
                                        <div id="mySidenav" class="sidenav">
                                            <a href="#" class="closebtn">×</a>
                                            <div class="sidenav-search">
                                                <div class="input-group stylish-input-group">
                                                    <input type="text" placeholder="<?=$lang['cerca'];?>" class="form-control">
                                                    <span class="input-group-addon">
                                                                                                        <button type="submit">
                                                                                                            <span class="glyphicon glyphicon-search"></span>
                                                    </button>
                                                    </span>
                                                </div>
                                            </div>

                                            <h3 class="ctg-name-title"><?=$lang['categorie_tutte'];?></h3>
                                            <ul class="sidenav-nav">
                                                <?php
                                                        
                                                             $db->query("SELECT *
                                                                         FROM
                                                                         bag_categorie
                                                                         ORDER BY posizione
                                                                        ");

                                                             $resultc =  $db->resultSet();
                                                             foreach ($resultc as $listc) {
                                                        ?>      
                                                            <li>
                                                                <a  href="<?=BASE_URL.$lng;?>/c_<?=$listc['id'];?>/<?=seo_url($listc['nome_'.$lng]);?>">
                                                                   <i class="fa  fa-<?=$listc['font_awesome_code'];?>"></i> <?=$listc['nome_'.$lng];?>
                                                                </a>
                                                            </li>
                                                        
                                                        <?php } ?>
                                     
                                            </ul>
                                            <!-- times-->
                                        </div>
<!--                                        <span class="side-menu-open side-menu-trigger"><i class="fa fa-bars" aria-hidden="true"></i></span>-->
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        
                        <?php 
                          if($arr_url[$pezzi-1]=='index.php' OR $arr_url[$pezzi-1]==''){ echo ' <h2 class="category-menu-title close-on-tab"><a href="#"><i class="fa fa-bars" aria-hidden="true"></i></a>'.$lang['categorie_tutte'].'</h2> '; }
                        ?> 

                        <div class="logo-area">
                            <a href="<?=BASE_URL;?><?=$lng;?>/">
                                <img class="img-responsive" src="<?=BASE_URL;?>img/logo1.png" alt="logo">
                                
                            </a>
                        </div>
                        <?php 
                          if($arr_url[$pezzi-1]!='index.php' AND $arr_url[$pezzi-1]!=''){ ?>
                              
                         <div class="category-menu-area" id="category-menu-area">
                                    <h2 class="category-menu-title"><a href="#"><i class="fa fa-bars" aria-hidden="true"></i></a><?=$lang['categorie_tutte'];?></h2>
                                    <ul class="category-menu-area-inner">
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
                                                     $numscat=$db->rowCount($resultsc);
   
                                        ?>      
                                        <li>
                                          
                                          <a href="<?=BASE_URL.$lng;?>/c_<?=$listc['id'];?>/<?=seo_url($listc['nome_'.$lng]);?>">
                                              <i class="fa  fa-<?=$listc['font_awesome_code'];?>" style='line-height: 12px;'></i> <?=$listc['nome_'.$lng];?>
                                             <?php if($db->rowCount($resultsc) >0){ ?>
                                              <span><i class="flaticon-next"></i></span>   
                                            <?php } ?>
                                          </a>
                                            <?php if($numscat > 0 ){ ?>
                                              <ul class="dropdown-menu">
                                                <?php    
                                                 foreach ($resultsc as $listsc) { ?>
                                                      <li><a href="<?=BASE_URL.$lng;?>/s_<?=$listsc['id'];?>/<?=seo_url($listsc['nome_'.$lng]);?>"><?=$listsc['nome_'.$lng];?></a></li>
                                                 <?php } ?>     
                                              </ul>
                                            <?php } ?>
                                        </li>
                                        <?php } ?>
                                        
                                      
                                    </ul>
                                </div>
                      <?php   } ?> 
                              
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="main-menu-area">
                            <nav>
                                <ul>
                                    <li class="active"><a href="<?=BASE_URL.$lng;?>/">HOME</a></li>
                                    <li><a href="<?=BASE_URL.$lng;?>/elenco-prodotti"><?=$lang['prodotti'];?></a></li>
                                    <li id="item_count">
                                        <a href="<?=BASE_URL;?>carts" rel="nofollow"><?=$lang['carrello'];?> 
                                            <i class="fa fa-shopping-cart" style="color: #009392;font-size: 24px;margin-top:-10px;" aria-hidden="true"></i>
                                            <span >
                                                (<?=$cart->itemcount;?>)
                                            </span>
                                        </a>
                                       
                                    </li>
                                    <li><a href="<?=BASE_URL.$lng;?>/guida-acquisto"><?=$lang['guida_acquisto'];?></a></li>
                                    <li><a href="<?=BASE_URL.$lng;?>/contatti"><?=$lang['contattaci'];?></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu Area Start Here -->
            

            
            <div class="mobile-menu-area">
                
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">  
                          
                         
                            <div class="mobile-menu">
                                
                   
                                
                                
                                
                                <nav id="dropdown">
                                  
                                    <ul>
                                        
                                         <li><a href="javascript:void(null)"><?=$lang['categorie_tutte'];?></a>  
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
                                          
                                          <a href="<?=BASE_URL.$lng;?>/c_<?=$listc['id'];?>/<?=seo_url($listc['nome_'.$lng]);?>">
                                              <i class="fa  fa-<?=$listc['font_awesome_code'];?>" style='line-height: 12px;'></i> <?=$listc['nome_'.$lng];?>
                                          </a>
                                            
                                                <?php
                                                  if($db->rowCount($resultsc) >0){ ?>
                                                  <ul>
													 <?php foreach ($resultsc as $listsc) { ?>
														  <li><a href="<?=BASE_URL.$lng;?>/s_<?=$listsc['id'];?>/<?=seo_url($listsc['nome_'.$lng]);?>"><?=$listsc['nome_'.$lng];?></a></li>
													 <?php } ?> 
                                                  </ul>
											    <?php } ?>
                                             
   
                                        </li>
                                        <?php } ?>
                                        
                                      
                                    </ul>
                                        
                                        <li class="active"><a href="<?=BASE_URL;?>">HOME</a></li>
                                        <li><a href="<?=BASE_URL.$lng;?>/elenco-prodotti"><?=$lang['prodotti'];?></a></li>
                                        <li id="car_mob_count"><a href="<?=BASE_URL;?>carts" rel="nofollow"><?=$lang['carrello'];?>
                                            
                                            <i class="fa fa-shopping-cart" style="color: #727272;font-size: 24px;" aria-hidden="true"></i>
                                            <span >
                                                (<?=$cart->itemcount;?>)
                                            </span>
                                            </a> </li>
                                        <li><a href="<?=BASE_URL;?>guida-acquisto"><?=$lang['guida_acquisto'];?></a></li>
                                        <li><a href="<?=BASE_URL;?>contatti"><?=$lang['contattaci'];?></a></li>
                                        <li><a href="#">Account</a>  
                                        <ul>
                                             <?php if(!isset($_SESSION['user_site'])) { ?>    
                                                      <li><a href="<?=BASE_URL;?>registrati.php"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp; Login</a></li>
                                                      <li><a href="<?=BASE_URL;?>registrati.php"><i class="fa fa-user" aria-hidden="true"></i> &nbsp;Registrati</a></li>
                                             <?php } else { ?>  
                                                       <li><a href="<?=BASE_URL;?>registrati.php"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp; Login</a></li>  
                                             <?php } ?>          
                                        </ul> 
                                       </li>    
                                    <?php if($lng=='it') { ?>                 
                                    <li> 
                                     <a  href="<?=BASE_URL;?>en/">
                                      <img  style="cursor:pointer"src="<?=BASE_URL;?>img/united-kingdom.png" style="margin-top:-2px;cursor:pointer;" />&nbsp;&nbsp;ENGLISH
                                      <spans style="font-size:10px;"><i>(CLICK TO CHANGE LANGUAGE TO ENGLISH)</i></span></a> 
                                    <div id="data_it_lang_m" style="display:none;">CLICK TO CHANGE LANGUAGE TO ENGLISH</div>   
                                    </li>
                                     <?php } if($lng=='en') { ?>
                                     <li > 
                                         <a   href="<?=BASE_URL;?>it/">
                                             <img   src="<?=BASE_URL;?>img/italy.png" style="margin-top:-2px;cursor:pointer;" />&nbsp;&nbsp;ITALIANO
                                             <spans style="font-size:10px;"><i>(CLICCA PER IL SITO IN ITALIANO)</i></span></a> 
                                     </li>
                                    <?php } ?>
    
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu Area End Here -->
        </div>
    </div>
     
    
    
</header>
 
<!--    <div class="mean-container-m">
    <nav class="mean-nav-2">
        <ul style="display:block;">
                                         <ul>
                                       <?php
                                                        
                                             $db->query("SELECT *
                                                         FROM
                                                         bag_categorie
                                                         ORDER BY posizione
                                                        ");

                                             $resultc =  $db->resultSet();
                                             foreach ($resultc as $listc) {
        
                                        ?>      
                                        <li>
                                          
                                          <a href="<?=BASE_URL.$lng;?>/c_<?=$listc['id'];?>/<?=seo_url($listc['nome_'.$lng]);?>">
                                              <i class="fa  fa-<?=$listc['font_awesome_code'];?>" style='line-height: 12px;'></i>&nbsp;&nbsp;&nbsp; <?=$listc['nome_'.$lng];?>
                                          </a>
    
                                        </li>
                                        <?php } ?>
                                        
                                      
                                    </ul>
                                             </nav>
    </div>-->