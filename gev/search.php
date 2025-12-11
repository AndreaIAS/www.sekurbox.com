<?php
include("inc_config.php");
include("inc_header.php");


?>

</head>
<body class="bg-body boxed">
    
    <?php 
    include("inc_menu.php"); 
    include("inc_slider.php");
    ?>
     
    <!-- BREAKCRUMB -->
<!--		<section class="breakcrumb">
			<div class="container">
				<ul class="nav-breakcrumb ">
					<li><a href="index-2.html">Home</a></li>
					<li><span>Man's</span></li>
				</ul>
			</div>
		</section>-->
		<!-- END BREAKCRUMB -->
     
    
    	<!-- PRODUCT GRID -->
		<section class="product-grid-3">
			<div class="container">
				<div class="row">
                                    <br /> <br />
                                    
                                    
                       <div class="col-md-3">             
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
                              
                            if(isset($_GET['text_search'])){
                             unset($_SESSION['search']);
                             $_SESSION['search'] = strip_tags($_GET['text_search']);
                            }
                           
                           $db->query("SELECT *
                                       FROM  
                                       bag_articoli 
                                       WHERE bag_articoli.nome LIKE '%".mysql_escape_string($_SESSION['search'])."%'
                                       ");
                           $recordprod = $db->resultset();
                           $rows = $db->rowCount();
                           
                           $query="SELECT * FROM  bag_articoli  WHERE bag_articoli.nome LIKE '%".mysql_escape_string($_SESSION['search'])."%' ";
                           
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

                    
                           $mynavigator = new navigator($tot_num_rows = $rows, $rec_per_page = 9,$url=BASE_URL."cerca");
                           $query.= $mynavigator->sql_limit;
                           $db->query($query);
                           $recordprod = $db->resultset();
                           
                           
                           ?>
						<!-- TOP FILTER -->
						<div class="top-filter clearfix">
										
							
							<div class="pull-right">
                                                            <div class="sort filter-select pull-left">
                                                                <b>Parola cercata:</b> <i><?=$_SESSION['search'];?></i>
                                                            </div> 
								<div class="sort filter-select pull-left">
							         <form name="form1" id="form1" action="<?=BASE_URL;?>index.php"  method="POST">   <label for="sort">
										Ordina per:                                                                     
                                                                    
                                                                         <select id="sort" name="sortby" onchange="form1.submit();">
                                                                         <option value="0" <?php if ($_SESSION['sort']=='0') { echo " selected ";} ?>>Prezzo pi&ugrave; basso</option>
                                                                         <option value="1" <?php if ($_SESSION['sort']=='1') { echo " selected ";} ?>>Prezzo pi&ugrave; alto</option>
                                                                         <option value="2" <?php if ($_SESSION['sort']=='2') { echo " selected ";} ?>>Alfabetico dalla A alla Z</option>
                                                                         <option value="3" <?php if ($_SESSION['sort']=='3') { echo " selected ";} ?>>Alfabetico dalla Z alla A</option>
                                                                         <option value="4" <?php  if ($_SESSION['sort']=='4') { echo " selected ";} ?>>Ultimi inseriti</option>
                                                                         </select>	
								    </label>
								</div> </form>
                                                               
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

                                                        <div class="image" style="border:solid 1px grey;height:350px;">
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
                                                                       <?=substr($list['nome'],0,38);?>
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
                                                                                
                                                                                               <a href="javascript:void(null)" class="btn btn-16 add-cart text-uppercase" onclick="document.addcar<?=$list['id'];?>.submit();">
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

	
<!-- FROM THE BLOG -->
		<section class="from-blog _3">
			<div class="container">

				<div class="heading _3 text-center">
					<h2 class="text-uppercase">Dal blog</h2>
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
                                           WHERE id_categoria_articolo='".$value['categoria']."'  ");
                                $recordscat = $db->single();   
                                
                             ?>               
						
						<!-- BLOG ITEM -->
						<div class="col-sm-6 col-md-4">
							<div class="blog-item ">

								<div class="img">
									<a href="<?=BASE_URL;?>blog<?=$value['id_articolo'];?>/<?=$myNewString;?>">
                                                                            <img src="<?=$phpThumbBase;?>?src=galleria/<?=$value['immagine'];?>&w=343&h=210&iar=1" alt="">
                                                                        </a>

									<span class="blog-date"><?=ritornagiorno($value['data']);?> <small><?=substr(ritornamese($value['data']),0,3);?></small></span>
									
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

									<h2><a href="<?=BASE_URL;?>blog<?=$value['id_articolo'];?>/<?=$myNewString;?>"><?=$value['titolo_it'];?></a></h2>

									<p>
									<?=strip_tags(substr($value['articolo_it'],0,150));?>.... </p>

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
