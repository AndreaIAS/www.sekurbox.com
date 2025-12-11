       <!-- Slider Area Start Here -->
        <div class="slider-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <div class="category-menu-area close-on-tab" id="category-menu-area">
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
                                              <?php if(isset($categoria)  AND $categoria==$listc['id']){ echo ' style="color:#009392 !important;" '; } ?> >
                                              <i class="fa  fa-<?=$listc['font_awesome_code'];?>" style='line-height: 12px;'></i> <?=$listc['nome_'.$lng];?>
                                             <?php if($db->rowCount($resultsc) >0){ ?>
                                              <span><i class="flaticon-next"></i></span>   
                                            <?php } ?>
                                          </a>
                                              <ul class="dropdown-menu">
                                                <?php    
                                                 foreach ($resultsc as $listsc) { ?>
                                                      <li><a href="<?=BASE_URL.$lng;?>/s_<?=$listsc['id'];?>/<?=seo_url($listsc['nome_'.$lng]);?>"
                                                             <?php if(isset($scat)  AND $scat==$listsc['id']){ echo ' style="color:#009392 !important;" '; } ?>
                                                             ><?=$listsc['nome_'.$lng];?></a></li>
                                                 <?php } ?>     
                                              </ul>
   
                                        </li>
                                        <?php } ?>  
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        <div class="main-slider1">
                            <div class="bend niceties preview-2">
                                <div id="ensign-nivoslider-2" class="slides">
                                    
                                    <?php

                                      $db->query("SELECT slider_home.*
                                                  FROM 
                                                  slider_home
                                                  ");

                                      $list =  $db->single();
                                      for ($i=1;$i<=5;$i++) {
                                         if($list['img'.$i]!='') {
                                     ?>
                                    <a href="<?=$list['link_img'.$i];?>">
                                     <img src="<?=BASE_URL;?>upload/slider/<?=$list['img'.$i];?>" alt="" title="" />
                                    </a>
                                      <?php } } ?>
                                   
                                </div>
                                <!-- direction 1 -->
<!--                                <div id="slider-direction-1" class="slider-direction">
                                    <div class="slider-content t-lfl s-tb slider-1">
                                        <div class="title-container s-tb-c">
                                            <h2>Collection</h2>
                                            <h2 class="title1">2016</h2>
                                            <h3 class="title3">Summer Dress</h3>
                                            <p>Simply dummy text of the printing and typesetting industrstandard dummy since.</p>
                                            <a href="#" class="btn-shop-now-fill-slider">View Collections</a>
                                        </div>
                                    </div>
                                     layer 1 
                                    <div class="layer-1-1">
                                        <img src="img/slider-1/layer-1.png" alt="" />
                                    </div>
                                </div>-->
                                <!-- direction 2 -->
<!--                                <div id="slider-direction-2" class="t-cn slider-direction">
                                     layer 1 
                                    <div class="layer-1">
                                        <img src="img/slider-1/layer2-4.png" alt="" />
                                    </div>
                                     layer 2 
                                    <div class="layer-2">
                                        <img src="img/slider-1/layer2-5.png" alt="" />
                                    </div>
                                     layer 3 
                                    <div class="layer-3">
                                        <img src="img/slider-1/layer2-6.png" alt="" />
                                    </div>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Slider Area End Here -->